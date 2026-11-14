<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Migration;

use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Migration\PrivacyLinksMigration;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PrivacyLinksMigration::class)]
final class PrivacyLinksMigrationTest extends TestCase
{
    public function testNothingToDoBeforeTheTableExists(): void
    {
        $this->assertFalse((new PrivacyLinksMigration(TestDatabase::create()))->shouldRun());
    }

    public function testOnlyTheExactOldAddressesAreReplacedAndOnlyOnce(): void
    {
        $db = TestDatabase::create(ServiceRepository::TABLE);
        $db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'leadfeeder', 'privacy_url' => 'https://www.dealfront.com/privacy-policy/']);
        $db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'typeform', 'privacy_url' => 'https://www.typeform.com/privacy-policy/']);
        $db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'title' => 'Own', 'privacy_url' => 'https://www.dealfront.com/privacy-policy/#section']);
        $db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'leadfeeder', 'privacy_url' => '']);

        $migration = new PrivacyLinksMigration($db);
        $this->assertTrue($migration->shouldRun());

        $result = $migration->run();
        $this->assertTrue($result->isSuccessful());
        $this->assertSame('Replaced 2 privacy links that no longer lead to the policy.', $result->getMessage());

        $this->assertSame(
            ['https://www.leadfeeder.com/privacy/', 'https://www.typeform.com/legal/privacy-policy', 'https://www.dealfront.com/privacy-policy/#section', ''],
            $db->fetchFirstColumn('SELECT privacy_url FROM '.ServiceRepository::TABLE.' ORDER BY id'),
        );
        $this->assertFalse($migration->shouldRun(), 'nothing left after the first run');
    }

    public function testTheNewAddressesAreTheOnesOfTheCatalogue(): void
    {
        $catalogue = array_map(static fn ($t): string => $t->privacyUrl, (new \Neo\CookieconsentBundle\Catalog\ServiceCatalog())->all());

        foreach (PrivacyLinksMigration::MOVED as $old => $new) {
            $this->assertContains($new, $catalogue);
            $this->assertNotContains($old, $catalogue);
        }
    }
}
