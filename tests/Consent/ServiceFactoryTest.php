<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Consent;

use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceFactory;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceFactory::class)]
final class ServiceFactoryTest extends TestCase
{
    private Connection $db;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(ServiceRepository::TABLE);
        TestDatabase::addPages($this->db, [
            ['type' => 'root', 'language' => 'de-AT'],
            ['type' => 'root', 'language' => 'en'],
            ['type' => 'regular', 'language' => 'fr'],
        ]);
    }

    public function testAServiceIsListedPublishedAndHeldBackUntilConsent(): void
    {
        $catalog = new ServiceCatalog();
        $factory = $this->factory();

        $first = $factory->create($catalog->get('ga4'), 'statistics', [], 'en', ['tracking_id' => 'G-ABC123DEF4', 'source' => 'scan']);
        $second = $factory->create($catalog->get('youtube'), 'marketing', [3, 5], 'en');

        $row = $this->db->fetchAssociative('SELECT * FROM '.ServiceRepository::TABLE.' WHERE id = ?', [$first]);
        $this->assertSame(['1', 'ga4', 'Google Analytics 4', 'page', 'statistics', 'G-ABC123DEF4', 'scan'], [$row['published'], $row['template'], $row['title'], $row['loading'], $row['category'], $row['tracking_id'], $row['source']]);
        $this->assertNull($row['roots'], 'all websites');
        $this->assertNull($row['translations']);
        $this->assertGreaterThan(0, (int) $row['tstamp']);

        $row = $this->db->fetchAssociative('SELECT * FROM '.ServiceRepository::TABLE.' WHERE id = ?', [$second]);
        $this->assertSame(['3', '5'], unserialize($row['roots']));
        $this->assertSame('marketing', $row['category']);
        $this->assertGreaterThan((int) $this->db->fetchOne('SELECT sorting FROM '.ServiceRepository::TABLE.' WHERE id = ?', [$first]), (int) $row['sorting'], 'appended at the end');

        $listed = (new ServiceRepository($this->db, $catalog))->forRoot(3);
        $this->assertSame(['ga4', 'youtube'], array_map(static fn ($s): string => $s->key, $listed));
    }

    public function testTheAiChatIsNamedInEveryLanguageOfTheWebsites(): void
    {
        $id = $this->factory()->create((new ServiceCatalog())->get('ai-chat'), 'functional', [], 'de');
        $row = $this->db->fetchAssociative('SELECT title, translations FROM '.ServiceRepository::TABLE.' WHERE id = ?', [$id]);

        $this->assertSame('KI-Chat-Assistent', $row['title']);
        $this->assertSame(['de' => ['title' => 'KI-Chat-Assistent', 'purpose' => ''], 'en' => ['title' => 'AI chat assistant', 'purpose' => '']], unserialize($row['translations']));
    }

    public function testOtherTemplatesKeepTheirProperName(): void
    {
        $this->assertSame('Google Analytics 4', $this->factory()->name((new ServiceCatalog())->get('ga4'), 'de'));
    }

    private function factory(): ServiceFactory
    {
        return new ServiceFactory($this->db, new Texts($this->db, Translations::translator()));
    }
}
