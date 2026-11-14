<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Consent;

use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Settings::class)]
final class SettingsTest extends TestCase
{
    public function testTheBannerWorksBeforeTheTableExists(): void
    {
        $settings = new Settings(TestDatabase::create());

        $this->assertTrue($settings->flag('active'));
        $this->assertTrue($settings->flag('log'));
        $this->assertFalse($settings->flag('overlay'));
        $this->assertSame('bottom', $settings->get('position'));
        $this->assertSame(1095, $settings->get('log_days'));
        $this->assertNull($settings->get('unknown'));
    }

    public function testTheStoredRecordWins(): void
    {
        $db = TestDatabase::create(Settings::TABLE);
        $db->insert(Settings::TABLE, ['tstamp' => 1, 'active' => '', 'position' => 'top']);

        $settings = new Settings($db);

        $this->assertFalse($settings->flag('active'));
        $this->assertSame('top', $settings->get('position'));
    }

    public function testThereIsOneRecordOnly(): void
    {
        $db = TestDatabase::create(Settings::TABLE);
        $settings = new Settings($db);

        $id = $settings->ensureRow();
        $this->assertSame($id, $settings->ensureRow());
        $this->assertSame(1, (int) $db->fetchOne('SELECT COUNT(*) FROM '.Settings::TABLE));

        $settings->update(['position' => 'center']);
        $this->assertSame('center', $settings->get('position'));
        $this->assertSame(1, (int) $db->fetchOne('SELECT COUNT(*) FROM '.Settings::TABLE));
    }
}
