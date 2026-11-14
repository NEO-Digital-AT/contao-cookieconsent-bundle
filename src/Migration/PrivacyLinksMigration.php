<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Consent\ServiceRepository;

/**
 * Privacy links of providers that an earlier catalogue named and that no
 * longer lead to the policy (404, 410, or a general legal page). A service
 * whose own field is empty follows the catalogue anyway; this replaces the
 * link where it was copied into the service, and only where it is exactly
 * the old address. Runs again only when such a link is stored.
 */
final class PrivacyLinksMigration extends AbstractMigration
{
    /** old address => current privacy policy of the same provider */
    public const MOVED = [
        'https://www.dealfront.com/privacy-policy/' => 'https://www.leadfeeder.com/privacy/',
        'https://legal.trustpilot.com/for-everyone/privacy-and-cookie-policy' => 'https://legal.trustpilot.com/for-everyone/end-user-privacy-terms',
        'https://www.provenexpert.com/en-us/privacy/' => 'https://www.provenexpert.com/en-us/privacy-policy/',
        'https://www.typeform.com/privacy-policy/' => 'https://www.typeform.com/legal/privacy-policy',
    ];

    public function __construct(private readonly Connection $db)
    {
    }

    public function getName(): string
    {
        return 'Cookie consent: privacy links of providers that moved their policy';
    }

    public function shouldRun(): bool
    {
        return $this->stored() > 0;
    }

    public function run(): MigrationResult
    {
        $count = 0;

        foreach (self::MOVED as $old => $new) {
            $count += (int) $this->db->update(ServiceRepository::TABLE, ['privacy_url' => $new], ['privacy_url' => $old]);
        }

        return $this->createResult(true, sprintf('Replaced %d privacy links that no longer lead to the policy.', $count));
    }

    private function stored(): int
    {
        $count = 0;

        try {
            foreach (array_keys(self::MOVED) as $old) {
                $count += (int) $this->db->fetchOne('SELECT COUNT(*) FROM '.ServiceRepository::TABLE.' WHERE privacy_url = ?', [$old]);
            }
        } catch (\Throwable) {
            return 0; // table not there yet (before the database update)
        }

        return $count;
    }
}
