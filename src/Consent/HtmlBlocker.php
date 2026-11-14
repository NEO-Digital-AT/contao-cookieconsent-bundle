<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Catalog\ServiceTemplate;

/**
 * Blocks known services in the HTML of a page until consent:
 *  - scripts (by address or inline code) get type="text/plain" and are run by
 *    the consent script once the visitor agrees;
 *  - stylesheets of web font services get another rel;
 *  - iframes of embedded content become a placeholder with the iframe in a
 *    <template>.
 * Services listed as "necessary", services that ask for consent themselves and
 * anything marked data-ncc-ignore stay untouched.
 */
final class HtmlBlocker
{
    private const JS_TYPES = ['', 'text/javascript', 'application/javascript', 'module'];

    public function __construct(private readonly ServiceCatalog $catalog)
    {
    }

    /**
     * @param array<string, string>     $listed      template key => category of the listed services
     * @param list<Service>             $custom      listed services without template but with hosts
     * @param callable(Service, string): string $placeholder renders the note for embedded content
     *
     * @return array{0: string, 1: int} the page and the number of blocked elements
     */
    public function block(string $html, array $listed, array $custom, bool $scripts, bool $embeds, callable $placeholder): array
    {
        $count = 0;

        if ($scripts) {
            $html = preg_replace_callback('#<script\b([^>]*)>(.*?)</script>#is', function (array $m) use ($listed, $custom, &$count): string {
                $attrs = self::attributes($m[1]);
                $type = strtolower(trim($attrs['type'] ?? ''));

                if (!\in_array($type, self::JS_TYPES, true) || isset($attrs['data-ncc-ignore']) || str_starts_with($attrs['id'] ?? '', 'ncc-')) {
                    return $m[0];
                }

                $match = $this->match('script', $attrs['src'] ?? $m[2], $listed, $custom, isset($attrs['src']));

                if (null === $match) {
                    return $m[0];
                }

                ++$count;
                unset($attrs['type']);
                $extra = 'module' === $type ? ' data-ncc-type="module"' : '';

                return sprintf('<script type="text/plain" data-ncc-service="%s" data-ncc-category="%s"%s%s>%s</script>', $match[0], $match[1], $extra, self::render($attrs), $m[2]);
            }, $html) ?? $html;

            $html = preg_replace_callback('#<link\b([^>]*)>#i', function (array $m) use ($listed, $custom, &$count): string {
                $attrs = self::attributes($m[1]);

                if ('stylesheet' !== strtolower(trim($attrs['rel'] ?? '')) || !isset($attrs['href']) || isset($attrs['data-ncc-ignore'])) {
                    return $m[0];
                }

                $match = $this->match('link', $attrs['href'], $listed, $custom, true);

                if (null === $match) {
                    return $m[0];
                }

                ++$count;
                $href = $attrs['href'];
                unset($attrs['rel'], $attrs['href']);

                // The address as in the source, encoded once: consent.js copies it into href as read.
                return sprintf('<link rel="ncc-stylesheet" data-ncc-href="%s" data-ncc-service="%s" data-ncc-category="%s"%s>', str_replace('"', '&quot;', $href), $match[0], $match[1], self::render($attrs));
            }, $html) ?? $html;
        }

        if ($embeds) {
            $html = preg_replace_callback('#<iframe\b([^>]*)>(.*?)</iframe>#is', function (array $m) use ($listed, $custom, $placeholder, &$count): string {
                $attrs = self::attributes($m[1]);

                if (!isset($attrs['src']) || isset($attrs['data-ncc-ignore'])) {
                    return $m[0];
                }

                $match = $this->match('iframe', $attrs['src'], $listed, $custom, true);

                if (null === $match) {
                    return $m[0];
                }

                ++$count;
                $ratio = '';

                if (ctype_digit($attrs['width'] ?? '') && ctype_digit($attrs['height'] ?? '') && (int) $attrs['height'] > 0) {
                    $ratio = sprintf(' style="aspect-ratio:%d/%d"', (int) $attrs['width'], (int) $attrs['height']);
                }

                return sprintf(
                    '<div class="ncc-embed" data-ncc-embed data-ncc-service="%s" data-ncc-category="%s"%s>%s<template>%s</template></div>',
                    $match[0],
                    $match[1],
                    $ratio,
                    $placeholder($match[2], $match[1]),
                    $m[0],
                );
            }, $html) ?? $html;
        }

        return [$html, $count];
    }

    /**
     * Which service a source belongs to: [consent key, category, service].
     *
     * @param array<string, string> $listed
     * @param list<Service>         $custom
     *
     * @return array{0: string, 1: string, 2: Service}|null
     */
    private function match(string $context, string $value, array $listed, array $custom, bool $isAddress): array|null
    {
        $value = html_entity_decode($value, ENT_QUOTES);

        foreach ($this->catalog->all() as $key => $template) {
            if ($template->selfGated) {
                continue;
            }

            foreach ($template->patterns($context) as $pattern) {
                if (1 === preg_match($pattern, $value)) {
                    $category = $listed[$key] ?? $template->category;

                    return 'necessary' === $category ? null : [$key, $category, $this->service($template, $category)];
                }
            }
        }

        if ($isAddress && 'link' !== $context) {
            $host = strtolower((string) parse_url(str_starts_with($value, '//') ? 'https:'.$value : $value, PHP_URL_HOST));

            foreach ($custom as $service) {
                foreach ($service->hosts as $h) {
                    if ('' !== $host && ($host === $h || str_ends_with($host, '.'.$h))) {
                        return $service->needsConsent() ? [$service->key, $service->category, $service] : null;
                    }
                }
            }
        }

        return null;
    }

    private function service(ServiceTemplate $template, string $category): Service
    {
        return new Service(0, $template->key, $template->name, $category, $template->provider, '', $template->purpose, $template->transfer, $template->privacyUrl, $template->cookies, '', [], $template);
    }

    /** @return array<string, string> */
    public static function attributes(string $source): array
    {
        $attrs = [];
        preg_match_all('#([^\s=/>"\']+)(?:\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+))?#', $source, $m, PREG_SET_ORDER);

        foreach ($m as $a) {
            $value = $a[2] ?? '';

            if ('' !== $value && ('"' === $value[0] || "'" === $value[0])) {
                $value = substr($value, 1, -1);
            }

            $attrs[strtolower($a[1])] = $value;
        }

        return $attrs;
    }

    /** @param array<string, string> $attrs (values as in the source, still encoded) */
    private static function render(array $attrs): string
    {
        $out = '';

        foreach ($attrs as $name => $value) {
            $out .= '' === $value && !\in_array($name, ['src', 'href', 'alt', 'title', 'value'], true) ? ' '.$name : sprintf(' %s="%s"', $name, str_replace('"', '&quot;', $value));
        }

        return $out;
    }
}
