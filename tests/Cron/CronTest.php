<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Cron;

use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Cache\PageCacheTags;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceFactory;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Controller\LogController;
use Neo\CookieconsentBundle\Cron\PurgeLogCron;
use Neo\CookieconsentBundle\Cron\ScanCron;
use Neo\CookieconsentBundle\Scan\Scanner;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\Mailer\MailerInterface;

#[CoversClass(PurgeLogCron::class)]
#[CoversClass(ScanCron::class)]
final class CronTest extends TestCase
{
    private Connection $db;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(Settings::TABLE, LogController::TABLE, ServiceRepository::TABLE, Scanner::FINDINGS);
        TestDatabase::addPages($this->db, []);
    }

    public function testConsentsAreDeletedAfterThePeriodSet(): void
    {
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'log_days' => 90]);
        $this->db->insert(LogController::TABLE, ['tstamp' => time() - 91 * 86400, 'consent_id' => 'old']);
        $this->db->insert(LogController::TABLE, ['tstamp' => time() - 89 * 86400, 'consent_id' => 'kept']);

        (new PurgeLogCron($this->db, new Settings($this->db)))();

        $this->assertSame(['kept'], $this->db->fetchFirstColumn('SELECT consent_id FROM '.LogController::TABLE));
    }

    public function testConsentsAreKeptThirtyDaysAtLeast(): void
    {
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'log_days' => 1]);
        $this->db->insert(LogController::TABLE, ['tstamp' => time() - 29 * 86400, 'consent_id' => 'kept']);
        $this->db->insert(LogController::TABLE, ['tstamp' => time() - 31 * 86400, 'consent_id' => 'old']);

        (new PurgeLogCron($this->db, new Settings($this->db)))();

        $this->assertSame(['kept'], $this->db->fetchFirstColumn('SELECT consent_id FROM '.LogController::TABLE));
    }

    public function testTheDailyScanRunsOnlyWithBannerAndScanSwitchedOn(): void
    {
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'active' => '1', 'scan' => '']);
        $this->scanCron();
        $this->assertSame(0, $this->lastScan());

        $this->db->update(Settings::TABLE, ['active' => '', 'scan' => '1'], ['tstamp' => 1]);
        $this->scanCron();
        $this->assertSame(0, $this->lastScan());

        $this->db->update(Settings::TABLE, ['active' => '1', 'scan' => '1'], ['tstamp' => 1]);
        $this->scanCron();
        $this->assertGreaterThan(0, $this->lastScan());
        $this->assertSame(['pages' => 0, 'found' => 0, 'added' => [], 'unknown' => [], 'errors' => []], array_diff_key(json_decode((string) $this->db->fetchOne('SELECT last_scan_note FROM '.Settings::TABLE), true), ['time' => 0]));
    }

    private function scanCron(): void
    {
        $settings = new Settings($this->db);
        $catalog = new ServiceCatalog();
        $texts = new Texts($this->db, Translations::translator());
        $scanner = new Scanner(new MockHttpClient(), $this->db, $catalog, new ServiceRepository($this->db, $catalog), $settings, $texts, $this->createMock(ContentUrlGenerator::class), $this->createMock(MailerInterface::class), new NullLogger(), new PageCacheTags($this->createMock(ContainerInterface::class)), new ServiceFactory($this->db, $texts));

        (new ScanCron($scanner, $settings, new NullLogger()))();
    }

    private function lastScan(): int
    {
        return (int) $this->db->fetchOne('SELECT last_scan FROM '.Settings::TABLE);
    }
}
