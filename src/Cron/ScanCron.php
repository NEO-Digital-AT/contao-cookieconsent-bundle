<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Cron;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCronJob;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Scan\Scanner;
use Psr\Log\LoggerInterface;

/** The daily scan of the pages, if switched on in the settings. */
#[AsCronJob('daily')]
final class ScanCron
{
    public function __construct(
        private readonly Scanner $scanner,
        private readonly Settings $settings,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function __invoke(): void
    {
        if (!$this->settings->flag('active') || !$this->settings->flag('scan')) {
            return;
        }

        try {
            $this->scanner->run();
        } catch (\Throwable $e) {
            $this->logger->error('Cookie consent scan failed: '.$e->getMessage());
        }
    }
}
