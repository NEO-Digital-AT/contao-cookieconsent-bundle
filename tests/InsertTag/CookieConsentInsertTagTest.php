<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\InsertTag;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\InsertTag\OutputType;
use Contao\CoreBundle\InsertTag\ResolvedInsertTag;
use Contao\CoreBundle\InsertTag\ResolvedParameters;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Page\LanguageVersion;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\BannerBuilder;
use Neo\CookieconsentBundle\Consent\CookieTable;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Consent\VersionKeeper;
use Neo\CookieconsentBundle\InsertTag\CookieConsentInsertTag;
use Neo\CookieconsentBundle\Tests\Support\Pages;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use Neo\CookieconsentBundle\Tests\Support\Twig;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[CoversClass(CookieConsentInsertTag::class)]
#[CoversClass(CookieTable::class)]
final class CookieConsentInsertTagTest extends TestCase
{
    private Connection $db;

    private RequestStack $requests;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(Settings::TABLE, ServiceRepository::TABLE, Texts::TABLE);
        $this->requests = new RequestStack();
        $request = new Request();
        $request->attributes->set('pageModel', Pages::page($this, ['rootId' => 1, 'rootLanguage' => 'de', 'language' => 'de']));
        $this->requests->push($request);
    }

    public function testTheSettingsLinkInTheLanguageOfThePage(): void
    {
        $this->db->insert(Texts::TABLE, ['tstamp' => 1, 'language' => 'de', 'reopen' => 'Cookie-Einstellungen ändern']);
        $result = $this->resolve('settings');

        $this->assertSame(OutputType::html, $result->getOutputType());
        $this->assertSame('<a href="#" role="button" aria-haspopup="dialog" class="ncc-settings-link" data-ncc-open>Cookie-Einstellungen ändern</a>', $result->getValue());
    }

    public function testAnOwnLabelIsEscaped(): void
    {
        $this->assertSame(
            '<a href="#" role="button" aria-haspopup="dialog" class="ncc-settings-link" data-ncc-open>&lt;img src=x onerror=alert(1)&gt; &quot;Privacy&quot;</a>',
            $this->resolve('settings', '<img src=x onerror=alert(1)> "Privacy"')->getValue(),
        );
    }

    public function testTheConsentIdIsFilledInTheBrowser(): void
    {
        $this->assertSame('<span data-ncc-id></span>', $this->resolve('ID')->getValue());
    }

    public function testTheCookieListShowsWhatTheBannerShows(): void
    {
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'ga4', 'category' => 'statistics']);
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'title' => 'Widget <script>', 'provider' => 'Example "Ltd."', 'category' => 'marketing', 'privacy_url' => 'https://example.com/privacy']);
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'youtube', 'category' => 'functional', 'roots' => serialize(['2'])]);

        $html = $this->resolve('table')->getValue();

        $this->assertSame(3, substr_count($html, '<table class="ncc-table">'), 'necessary, statistics, marketing');
        $this->assertStringContainsString('<code>ncc-consent</code>', $html);
        $this->assertStringContainsString('Google Analytics 4<br><a href="https://policies.google.com/privacy"', $html);
        $this->assertStringContainsString('<code>_ga_*</code>', $html);
        $this->assertStringNotContainsString('YouTube', $html, 'a service of another website');
        $this->assertStringContainsString('Widget &lt;script&gt;', $html);
        $this->assertStringContainsString('Example &quot;Ltd.&quot;', $html);
        $this->assertStringNotContainsString('<script', $html);
    }

    private function resolve(string ...$parameters): \Contao\CoreBundle\InsertTag\InsertTagResult
    {
        $settings = new Settings($this->db);
        $catalog = new ServiceCatalog();
        $services = new ServiceRepository($this->db, $catalog);
        $texts = new Texts($this->db, Translations::translator());
        $builder = new BannerBuilder($settings, $services, $texts, new VersionKeeper($settings, $services), $catalog, $this->createMock(ContentUrlGenerator::class), $this->createMock(UrlGeneratorInterface::class), new LanguageVersion($this->db, $this->createStub(ContaoFramework::class)));
        $table = new CookieTable($services, $builder, $texts, $this->requests, Twig::environment());

        return (new CookieConsentInsertTag($texts, $table, $this->requests))(new ResolvedInsertTag('cookie_consent', new ResolvedParameters($parameters), []));
    }
}
