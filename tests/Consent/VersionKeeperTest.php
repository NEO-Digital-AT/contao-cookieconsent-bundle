<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Consent;

use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\VersionKeeper;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VersionKeeper::class)]
final class VersionKeeperTest extends TestCase
{
    private Connection $db;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(Settings::TABLE, ServiceRepository::TABLE);
    }

    public function testTheFirstVersionIsOne(): void
    {
        $this->assertSame(1, $this->current());
        $this->assertSame(1, $this->current(), 'nothing changed');
    }

    public function testAnyChangeVisitorsReadAsksAgain(): void
    {
        $this->assertSame(1, $this->current());

        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'ga4']);
        $this->assertSame(2, $this->current());
        $this->assertSame(2, $this->current());

        $this->db->update(ServiceRepository::TABLE, ['category' => 'marketing'], ['template' => 'ga4']);
        $this->assertSame(3, $this->current());

        $this->db->update(ServiceRepository::TABLE, ['published' => ''], ['template' => 'ga4']);
        $this->assertSame(4, $this->current(), 'a service removed');
    }

    public function testAnUpdatedInstallationKeepsItsNumber(): void
    {
        // Settings saved before the version was computed (no hash yet): the number stays.
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'version' => 5, 'version_hash' => '']);

        $this->assertSame(5, $this->current());
        $this->assertNotSame('', (string) $this->db->fetchOne('SELECT version_hash FROM '.Settings::TABLE));
    }

    private function current(): int
    {
        // New objects each time, as in a new request.
        return (new VersionKeeper(new Settings($this->db), new ServiceRepository($this->db, new ServiceCatalog())))->current();
    }
}
