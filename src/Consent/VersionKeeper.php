<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

/**
 * The version of what visitors consented to. When anything a visitor reads
 * about the services changes (a service added or removed, another category,
 * provider, purpose, transfer or website), the version goes up and the banner
 * asks every visitor again. No number to raise by hand.
 */
final class VersionKeeper
{
    public function __construct(
        private readonly Settings $settings,
        private readonly ServiceRepository $services,
    ) {
    }

    public function current(): int
    {
        $hash = $this->services->fingerprint();

        if ($hash !== (string) $this->settings->get('version_hash')) {
            $version = '' === (string) $this->settings->get('version_hash') ? max(1, (int) $this->settings->get('version')) : (int) $this->settings->get('version') + 1;
            $this->settings->update(['version' => $version, 'version_hash' => $hash, 'version_at' => time()]);
        }

        return max(1, (int) $this->settings->get('version'));
    }
}
