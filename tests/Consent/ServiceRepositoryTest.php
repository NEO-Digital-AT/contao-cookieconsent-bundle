<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Consent;

use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceRepository::class)]
final class ServiceRepositoryTest extends TestCase
{
    private Connection $db;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(ServiceRepository::TABLE);
    }

    public function testOnlyPublishedAndSavedServicesOfTheWebsiteCount(): void
    {
        $this->add(['title' => 'All websites', 'sorting' => 1]);
        $this->add(['title' => 'Website 2', 'roots' => serialize(['2']), 'sorting' => 2]);
        $this->add(['title' => 'Website 3', 'roots' => serialize(['3']), 'sorting' => 3]);
        $this->add(['title' => 'Unpublished', 'published' => '']);
        $this->add(['title' => 'Draft, never saved', 'tstamp' => 0]);

        $this->assertSame(['All websites', 'Website 2'], $this->names($this->repository()->forRoot(2)));
        $this->assertSame(['All websites', 'Website 2', 'Website 3'], $this->names($this->repository()->forRoot(0)));
    }

    public function testEmptyFieldsTakeTheValuesOfTheTemplate(): void
    {
        $id = $this->add(['template' => 'ga4', 'category' => '', 'title' => '']);
        $service = $this->repository()->forRoot(0)[0];

        $this->assertSame($id, $service->id);
        $this->assertSame('ga4', $service->key);
        $this->assertSame('Google Analytics 4', $service->name);
        $this->assertSame('statistics', $service->category);
        $this->assertSame('Google Ireland Limited, Dublin', $service->provider);
        $this->assertSame('', $service->purpose);
        $this->assertSame('analytics', $service->purposeCode);
        $this->assertSame('us', $service->transfer);
        $this->assertSame('https://policies.google.com/privacy', $service->privacyUrl);
        $this->assertSame(['_ga' => '2y', '_ga_*' => '2y'], $service->cookies);
        $this->assertSame('', $service->loader, 'loaded by the page, not by the extension');
    }

    public function testOwnValuesOverrideTheTemplate(): void
    {
        $this->add([
            'template' => 'ga4', 'title' => 'Statistics', 'category' => 'marketing', 'provider' => 'Example Ltd.', 'purpose' => 'Own purpose',
            'transfer' => 'world', 'privacy_url' => 'https://example.com/privacy',
            'cookies' => serialize([['key' => ' own ', 'value' => '1y'], ['key' => '', 'value' => '2y']]),
        ]);
        $service = $this->repository()->forRoot(0)[0];

        $this->assertSame(['Statistics', 'marketing', 'Example Ltd.', 'Own purpose', 'world', 'https://example.com/privacy'], [$service->name, $service->category, $service->provider, $service->purpose, $service->transfer, $service->privacyUrl]);
        $this->assertSame(['own' => '1y'], $service->cookies);
    }

    public function testTheExtensionLoadsATemplateOnlyWithAValidId(): void
    {
        $this->add(['template' => 'ga4', 'loading' => 'extension', 'tracking_id' => ' G-ABC123DEF4 ', 'sorting' => 1]);
        $this->add(['template' => 'gtm', 'loading' => 'extension', 'tracking_id' => 'GTM-"><b>', 'sorting' => 2]);
        [$valid, $invalid] = $this->repository()->forRoot(0);

        $this->assertStringContainsString('gtag/js?id=G-ABC123DEF4', $valid->loader);
        $this->assertSame('', $invalid->loader);
    }

    public function testAServiceWithoutTemplateUsesItsOwnCodeAndHosts(): void
    {
        $id = $this->add([
            'title' => 'Widget', 'loading' => 'extension', 'code' => '<script src="https://widget.example.com/w.js"></script>',
            'hosts' => serialize(['https://Widget.Example.com/path', ' cdn.example.org ', 'not a host', 'localhost', 'javascript:alert(1)']),
        ]);
        $service = $this->repository()->forRoot(0)[0];

        $this->assertSame('c'.$id, $service->key);
        $this->assertNull($service->template);
        $this->assertSame('functional', $service->category);
        $this->assertSame('<script src="https://widget.example.com/w.js"></script>', $service->loader);
        $this->assertSame(['widget.example.com', 'cdn.example.org'], $service->hosts);
    }

    public function testTranslationsNeedALanguageCode(): void
    {
        $this->add(['title' => 'Chat', 'translations' => serialize(['de' => ['title' => ' Chat (de) ', 'purpose' => ''], 'xx-YY' => ['title' => 'no'], 'fr' => 'no'])]);
        $service = $this->repository()->forRoot(0)[0];

        $this->assertSame(['de' => ['title' => 'Chat (de)', 'purpose' => '']], $service->translations);
        $this->assertSame('Chat (de)', $service->nameIn('de'));
        $this->assertSame('Chat', $service->nameIn('fr'));
    }

    public function testTemplateCategoriesForTheBlocking(): void
    {
        $this->add(['template' => 'ga4', 'category' => 'necessary', 'sorting' => 1]);
        $this->add(['template' => 'youtube', 'category' => 'marketing', 'sorting' => 2]);
        $this->add(['title' => 'Own', 'sorting' => 3]);

        $this->assertSame(['ga4' => 'necessary', 'youtube' => 'marketing'], $this->repository()->templateCategories(0));
    }

    public function testTheFingerprintFollowsWhatVisitorsRead(): void
    {
        $first = $this->add(['template' => 'ga4', 'title' => 'A', 'sorting' => 1]);
        $this->add(['template' => 'youtube', 'title' => 'B', 'sorting' => 2]);
        $before = $this->repository()->fingerprint();

        // Order and the ID are not part of what a visitor reads.
        $this->db->update(ServiceRepository::TABLE, ['sorting' => 9, 'tracking_id' => 'G-ABC123DEF4'], ['id' => $first]);
        $this->assertSame($before, $this->repository()->fingerprint());

        foreach (['category' => 'marketing', 'title' => 'A2', 'provider' => 'Example Ltd.', 'purpose' => 'Other', 'transfer' => 'world', 'roots' => serialize(['1']), 'translations' => serialize(['de' => ['title' => 'x']])] as $column => $value) {
            $this->db->update(ServiceRepository::TABLE, [$column => $value], ['id' => $first]);
            $after = $this->repository()->fingerprint();
            $this->assertNotSame($before, $after, $column);
            $before = $after;
        }

        $this->add(['template' => 'vimeo']);
        $this->assertNotSame($before, $this->repository()->fingerprint(), 'a service added');
    }

    public function testRowsAreReadOnceUntilReset(): void
    {
        $repository = $this->repository();
        $this->assertSame([], $repository->forRoot(0));

        $this->add(['title' => 'New']);
        $this->assertSame([], $repository->forRoot(0));

        $repository->reset();
        $this->assertCount(1, $repository->forRoot(0));
    }

    public function testHasTemplateIncludesUnpublishedServices(): void
    {
        $this->add(['template' => 'ga4', 'published' => '']);
        $this->add(['template' => 'gtm', 'tstamp' => 0]);

        $this->assertTrue($this->repository()->hasTemplate('ga4'));
        $this->assertFalse($this->repository()->hasTemplate('gtm'));
        $this->assertFalse($this->repository()->hasTemplate('youtube'));
    }

    public function testWithoutTheTableThereAreNoServices(): void
    {
        $repository = new ServiceRepository(TestDatabase::create(), new ServiceCatalog());

        $this->assertSame([], $repository->forRoot(0));
    }

    private function repository(): ServiceRepository
    {
        return new ServiceRepository($this->db, new ServiceCatalog());
    }

    /** @param array<string, mixed> $values */
    private function add(array $values): int
    {
        $this->db->insert(ServiceRepository::TABLE, $values + ['tstamp' => 1700000000]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * @param list<\Neo\CookieconsentBundle\Consent\Service> $services
     *
     * @return list<string>
     */
    private function names(array $services): array
    {
        return array_map(static fn ($s): string => $s->name, $services);
    }
}
