<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Cron;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCronJob;
use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Controller\LogController;

/** Deletes entries of the proof of consent after the period set in the back end. */
#[AsCronJob('daily')]
final class PurgeLogCron
{
    public function __construct(
        private readonly Connection $db,
        private readonly Settings $settings,
    ) {
    }

    public function __invoke(): void
    {
        $days = max(30, (int) $this->settings->get('log_days'));
        $this->db->executeStatement('DELETE FROM '.LogController::TABLE.' WHERE tstamp < ?', [time() - $days * 86400]);
    }
}
