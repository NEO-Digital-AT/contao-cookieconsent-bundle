<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Consent;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Page\LanguageVersion;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\BannerBuilder;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Consent\VersionKeeper;
use Neo\CookieconsentBundle\Tests\Support\Pages;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[CoversClass(BannerBuilder::class)]
final class BannerBuilderTest extends TestCase
{
    private Connection $db;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(Settings::TABLE, ServiceRepository::TABLE, Texts::TABLE);
    }

    public function testOnlyCategoriesWithAServiceAreOffered(): void
    {
        $this->add(['template' => 'ga4', 'loading' => 'extension', 'tracking_id' => 'G-ABC123DEF4', 'sorting' => 1]);
        $this->add(['template' => 'youtube', 'sorting' => 2]);

        $banner = $this->build();

        $this->assertSame(['necessary', 'functional', 'statistics'], array_column($banner['cats'], 'key'));
        $this->assertSame(['functional', 'statistics'], $banner['config']['cats']);
        $this->assertTrue($banner['has_consent_services']);
        $this->assertSame('en', $banner['language']);
        $this->assertSame(1, $banner['root']);

        // The choice itself is listed with the necessary services.
        $this->assertSame('consent', $banner['cats'][0]['services'][0]['key']);
        $this->assertSame('Cookie settings', $banner['cats'][0]['services'][0]['name']);
        $this->assertSame([['name' => 'ncc-consent', 'duration' => $banner['cats'][0]['services'][0]['cookies'][0]['duration']]], $banner['cats'][0]['services'][0]['cookies']);
    }

    public function testTheFirstLayerNamesEveryServiceAndTheTransfer(): void
    {
        $this->add(['template' => 'ga4', 'sorting' => 1]);
        $this->add(['template' => 'tiktok-pixel', 'sorting' => 2]);
        $this->add(['template' => 'youtube', 'sorting' => 3]);

        $text = $this->build()['banner_text'];

        $this->assertStringContainsString('With your consent we also use: Functional (YouTube); Statistics (Google Analytics 4); Marketing (TikTok Pixel).', $text);
        $this->assertStringContainsString('Data may be transferred to countries outside the EU, including the USA.', $text);
        $this->assertStringNotContainsString('{', $text);
    }

    public function testTransferToTheUsaIsNamed(): void
    {
        $this->add(['template' => 'ga4']);

        $this->assertStringContainsString('Data may be transferred to the USA.', $this->build()['banner_text']);
    }

    public function testWithoutTransferTheTextHasNoGap(): void
    {
        $this->add(['template' => 'matomo']);

        $text = $this->build()['banner_text'];

        $this->assertStringContainsString('Statistics (Matomo). Your consent is voluntary', $text);
        $this->assertDoesNotMatchRegularExpression('/\s{2}/', $text);
    }

    public function testNecessaryServicesNeedNoConsent(): void
    {
        $this->add(['template' => 'google-fonts', 'category' => 'necessary']);

        $banner = $this->build();

        $this->assertFalse($banner['has_consent_services']);
        $this->assertSame([], $banner['config']['cats']);
        $this->assertSame(['consent', 'google-fonts'], array_column($banner['cats'][0]['services'], 'key'));
    }

    public function testOnlyLoadersOfServicesThatNeedConsentGoToTheScript(): void
    {
        $this->add(['template' => 'ga4', 'loading' => 'extension', 'tracking_id' => 'G-ABC123DEF4', 'sorting' => 1]);
        $this->add(['template' => 'gtm', 'loading' => 'extension', 'tracking_id' => 'GTM-ABC123', 'category' => 'necessary', 'sorting' => 2]);
        $this->add(['template' => 'youtube', 'sorting' => 3]);

        $loaders = $this->build()['config']['loaders'];

        $this->assertCount(1, $loaders);
        $this->assertSame(['ga4', 'statistics'], [$loaders[0]['key'], $loaders[0]['cat']]);
        $this->assertStringContainsString('G-ABC123DEF4', $loaders[0]['html']);
    }

    public function testCookiesAreDeletedPerCategory(): void
    {
        $this->add(['template' => 'ga4', 'sorting' => 1]);
        $this->add(['template' => 'google-ads', 'sorting' => 2]);
        $this->add(['template' => 'meta-pixel', 'sorting' => 3]);

        $this->assertSame(
            ['statistics' => ['_ga', '_ga_*'], 'marketing' => ['_gcl_au', 'IDE', 'test_cookie', '_fbp', 'fr']],
            $this->build()['config']['cookies'],
        );
    }

    public function testGoogleConsentModeNeedsAGoogleServiceAndTheSetting(): void
    {
        $this->add(['template' => 'matomo']);
        $this->assertFalse($this->build()['config']['consentMode']);

        $this->add(['template' => 'ga4']);
        $this->assertTrue($this->build()['config']['consentMode']);

        (new Settings($this->db))->update(['consent_mode' => '']);
        $this->assertFalse($this->build()['config']['consentMode']);
    }

    public function testSettingsOfThePosition(): void
    {
        $this->add(['template' => 'ga4']);
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'position' => 'nowhere', 'overlay' => '1', 'log' => '']);

        $banner = $this->build();

        $this->assertSame('bottom', $banner['position'], 'an unknown value falls back to the default');
        $this->assertTrue($banner['overlay']);
        $this->assertTrue($banner['config']['modal']);
        $this->assertSame('', $banner['config']['log'], 'no proof of consent when it is switched off');
    }

    public function testTheProofOfConsentGoesToTheLogRoute(): void
    {
        $this->add(['template' => 'ga4']);

        $this->assertSame('/api/cookieconsent/log', $this->build()['config']['log']);
    }

    public function testServicesOfAnotherWebsiteAreLeftOut(): void
    {
        $this->add(['template' => 'ga4', 'roots' => serialize(['2'])]);

        $this->assertFalse($this->build()['has_consent_services']);
    }

    public function testTheAiChatFollowsTheLanguageOfThePage(): void
    {
        // Saved in the back end in German, with brackets as entities.
        $this->add(['template' => 'ai-chat', 'title' => 'KI-Chat-Assistent']);
        $this->add(['template' => 'youtube', 'title' => 'Videos', 'sorting' => 2]);

        $names = array_column($this->build('en')['cats'][1]['services'], 'name');

        $this->assertSame(['AI chat assistant', 'Videos'], $names);
    }

    public function testAnOwnNameOfTheAiChatStays(): void
    {
        $this->add(['template' => 'ai-chat', 'title' => 'Assistant of the website']);

        $this->assertSame('Assistant of the website', $this->build('de')['cats'][1]['services'][0]['name']);
    }

    public function testTheViewUsesTheTextsOfTheLanguage(): void
    {
        $this->add(['template' => 'matomo', 'purpose' => '']);
        $view = $this->build()['cats'][1]['services'][0];

        $this->assertSame('Matomo', $view['name']);
        $this->assertNotSame('@self', $view['provider']);
        $this->assertSame('Statistics on the use of the website: which pages are visited, how often and for how long.', $view['purpose']);
        $this->assertSame('', $view['transfer']);
        $this->assertSame('', $view['no_cookies']);
        $this->assertSame(['_pk_id.*', '_pk_ses.*'], array_column($view['cookies'], 'name'));
    }

    /** @return array<string, mixed> */
    private function build(string $language = 'en'): array
    {
        $settings = new Settings($this->db);
        $catalog = new ServiceCatalog();
        $services = new ServiceRepository($this->db, $catalog);
        $router = $this->createMock(UrlGeneratorInterface::class);
        $router->method('generate')->with('neo_cookieconsent_log')->willReturn('/api/cookieconsent/log');

        $builder = new BannerBuilder(
            $settings,
            $services,
            new Texts($this->db, Translations::translator()),
            new VersionKeeper($settings, $services),
            $catalog,
            $this->createMock(ContentUrlGenerator::class),
            $router,
            new LanguageVersion($this->db, $this->createStub(ContaoFramework::class)),
        );

        return $builder->build(Pages::page($this, ['rootId' => 1, 'rootLanguage' => $language, 'language' => $language]));
    }

    /**
     * A service as the back end saves it: choosing a template sets its category.
     *
     * @param array<string, mixed> $values
     */
    private function add(array $values): void
    {
        $template = (new ServiceCatalog())->get((string) ($values['template'] ?? ''));
        $this->db->insert(ServiceRepository::TABLE, $values + ['tstamp' => 1700000000, 'category' => $template?->category ?? 'functional']);
    }
}
