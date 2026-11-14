<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Catalog;

/**
 * A known service: who provides it, what it is for, which cookies it sets, how
 * the extension loads it after consent and how the scan and the blocking
 * recognise it in a page.
 *
 * Patterns are PCRE expressions (with delimiters) per context:
 *  - script: matched against the src of a script, or its inline code;
 *  - iframe: matched against the src of an iframe (embedded content);
 *  - link:   matched against the href of a stylesheet (web fonts);
 *  - html:   matched against the whole page (markers of widgets), scan only.
 */
final class ServiceTemplate
{
    /**
     * @param array<string, string>       $cookies  name => duration code (Durations::CODES)
     * @param array<string, list<string>> $patterns context => regular expressions
     */
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly string $provider,
        public readonly string $category,
        public readonly string $purpose,
        public readonly string $transfer,
        public readonly string $privacyUrl,
        public readonly array $cookies,
        public readonly string $idExample,
        public readonly string $idPattern,
        public readonly bool $needsUrl,
        public readonly string $loader,
        public readonly array $patterns,
        public readonly string $idFrom,
        public readonly bool $google,
        public readonly bool $selfGated,
        // Google tag (gtag.js): links to further domains of the same owner can carry
        // the measurement over (cross-domain measurement, "linker").
        public readonly bool $linker = false,
    ) {
    }

    /** The extension can load it itself (an ID is all it needs). */
    public function canLoad(): bool
    {
        return '' !== $this->loader;
    }

    public function isEmbed(): bool
    {
        return [] !== ($this->patterns['iframe'] ?? []);
    }

    /** @return list<string> */
    public function patterns(string $context): array
    {
        return $this->patterns[$context] ?? [];
    }

    public function validId(string $id): bool
    {
        return '' === $this->idPattern || 1 === preg_match($this->idPattern, $id);
    }

    /**
     * The loader with the ID (and the address of a self-hosted service) filled
     * in. IDs are checked against the pattern, addresses must be HTTPS, domains
     * for cross-domain measurement must be domain names, so nothing but a valid
     * value ends up in the code.
     *
     * @param list<string> $linkerDomains domains for gtag("set", "linker", …); only used when the template supports it
     */
    public function loaderFor(string $id, string $url = '', array $linkerDomains = []): string
    {
        if (!$this->validId($id)) {
            return '';
        }

        if ($this->needsUrl) {
            if (!preg_match('#^https://[a-z0-9.-]+(:\d+)?(/[a-zA-Z0-9._~/-]*)?$#', $url)) {
                return '';
            }

            $url = rtrim($url, '/').'/';
        }

        $linker = '';
        $domains = $this->linker ? self::validDomains($linkerDomains) : [];

        if ([] !== $domains) {
            $linker = 'gtag("set","linker",'.json_encode(['domains' => $domains], JSON_UNESCAPED_SLASHES).');';
        }

        return strtr($this->loader, ['{id}' => $id, '{url}' => $url, '{linker}' => $linker]);
    }

    /**
     * Domain names in lower case, without scheme, path and duplicates; everything
     * else is left out.
     *
     * @param list<string> $values
     *
     * @return list<string>
     */
    public static function validDomains(array $values): array
    {
        $domains = [];

        foreach ($values as $value) {
            $domain = strtolower(trim((string) $value));
            $domain = preg_replace('#^https?://#', '', $domain) ?? '';
            $domain = explode('/', $domain)[0];

            if (preg_match('#^[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*\.[a-z]{2,}$#', $domain)) {
                $domains[$domain] = $domain;
            }
        }

        return array_values($domains);
    }
}
