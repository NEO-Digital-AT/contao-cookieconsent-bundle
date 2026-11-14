<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Neo\CookieconsentBundle\Catalog\ServiceTemplate;

/**
 * A service as the banner shows it: the record of the back end with the
 * values of its template filled in where the record leaves them empty.
 */
final class Service
{
    /**
     * @param array<string, string> $cookies name => duration (code of Durations or free text)
     * @param list<string>          $hosts   hosts of a service without template (blocking, scan)
     * @param array<string, array{title?: string, purpose?: string}> $translations name and purpose per language
     */
    public function __construct(
        public readonly int $id,
        public readonly string $key,
        public readonly string $name,
        public readonly string $category,
        public readonly string $provider,
        public readonly string $purpose,
        public readonly string $purposeCode,
        public readonly string $transfer,
        public readonly string $privacyUrl,
        public readonly array $cookies,
        public readonly string $loader,
        public readonly array $hosts,
        public readonly ServiceTemplate|null $template,
        public readonly array $translations = [],
    ) {
    }

    /** Name in a language: own translation, otherwise the name. */
    public function nameIn(string $language): string
    {
        return trim((string) ($this->translations[$language]['title'] ?? '')) ?: $this->name;
    }

    /** Own purpose in a language: translation, otherwise the purpose field ('' = template text). */
    public function purposeIn(string $language): string
    {
        return trim((string) ($this->translations[$language]['purpose'] ?? '')) ?: $this->purpose;
    }

    public function needsConsent(): bool
    {
        return 'necessary' !== $this->category;
    }
}
