<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Backend;

use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Cache\PageCacheTags;
use Neo\CookieconsentBundle\Backend\RequestInput;
use Neo\CookieconsentBundle\Backend\SettingsCallbacks;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceFactory;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Consent\VersionKeeper;
use Neo\CookieconsentBundle\Scan\Scanner;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;

/** Which settings have no effect, and why (the reasons come from the language file). */
#[CoversClass(SettingsCallbacks::class)]
final class SettingsCallbacksTest extends TestCase
{
    private const TABLE = 'tl_neo_cookieconsent_settings';
    private const BANNER_FIELDS = ['show_on', 'position', 'overlay', 'reopen', 'privacy_page', 'imprint_page', 'block_scripts', 'block_embeds', 'consent_mode', 'log', 'log_days'];

    private Connection $db;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(Settings::TABLE, ServiceRepository::TABLE);
        $GLOBALS['TL_DCA'][self::TABLE]['fields'] = array_fill_keys([...self::BANNER_FIELDS, 'active', 'scan'], ['inputType' => 'checkbox', 'eval' => []]);
        $GLOBALS['TL_DCA'][self::TABLE]['fields']['privacy_page']['inputType'] = 'pageTree';
        $GLOBALS['TL_LANG'][self::TABLE] = ['locked_active' => 'Banner off', 'locked_log' => 'No proof stored', 'locked_consent_mode' => 'No Google service'];
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TL_DCA'][self::TABLE], $GLOBALS['TL_LANG'][self::TABLE], $GLOBALS['TL_CSS']);
    }

    public function testWithTheBannerOffEverySettingOfTheBannerIsLocked(): void
    {
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'active' => '', 'log' => '']);

        $this->callbacks()->lock();

        $this->assertSame(self::BANNER_FIELDS, $this->locked());
        $this->assertSame('Banner off', $GLOBALS['TL_DCA'][self::TABLE]['fields']['log_days']['label'][1], 'one reason, the first one');
        $this->assertArrayNotHasKey('disabled', $GLOBALS['TL_DCA'][self::TABLE]['fields']['privacy_page']['eval'], 'a picker keeps working');
    }

    public function testThePeriodNeedsTheProofOfConsent(): void
    {
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'log' => '']);
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'ga4', 'category' => 'statistics']);

        $this->callbacks()->lock();

        $this->assertSame(['log_days'], $this->locked());
        $this->assertSame('No proof stored', $GLOBALS['TL_DCA'][self::TABLE]['fields']['log_days']['label'][1]);
    }

    public function testConsentModeNeedsAGoogleService(): void
    {
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'matomo', 'category' => 'statistics']);
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'ga4', 'category' => 'statistics', 'published' => '']);

        $this->callbacks()->lock();

        $this->assertSame(['consent_mode'], $this->locked());
        $this->assertSame('No Google service', $GLOBALS['TL_DCA'][self::TABLE]['fields']['consent_mode']['label'][1]);
    }

    public function testNothingIsLockedWhenEverySettingWorks(): void
    {
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'google-ads', 'category' => 'marketing']);

        $this->callbacks()->lock();

        $this->assertSame([], $this->locked());
    }

    /** @return list<string> */
    private function locked(): array
    {
        return array_keys(array_filter($GLOBALS['TL_DCA'][self::TABLE]['fields'], static fn (array $f): bool => str_contains($f['eval']['tl_class'] ?? '', 'ncc-locked')));
    }

    private function callbacks(): SettingsCallbacks
    {
        $settings = new Settings($this->db);
        $catalog = new ServiceCatalog();
        $services = new ServiceRepository($this->db, $catalog);
        $texts = new Texts($this->db, Translations::translator());
        $scanner = new Scanner(new MockHttpClient(), $this->db, $catalog, $services, $settings, $texts, $this->createMock(ContentUrlGenerator::class), $this->createMock(MailerInterface::class), new NullLogger(), new PageCacheTags($this->createMock(ContainerInterface::class)), new ServiceFactory($this->db, $texts));

        return new SettingsCallbacks($settings, new VersionKeeper($settings, $services), $scanner, $services, new RequestInput(new RequestStack()));
    }
}
