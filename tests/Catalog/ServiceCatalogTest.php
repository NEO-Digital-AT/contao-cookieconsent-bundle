<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Catalog;

use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Catalog\ServiceTemplate;
use Neo\CookieconsentBundle\Consent\HtmlBlocker;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceCatalog::class)]
final class ServiceCatalogTest extends TestCase
{
    /** @return iterable<string, array{ServiceTemplate}> */
    public static function templates(): iterable
    {
        foreach ((new ServiceCatalog())->all() as $key => $template) {
            yield $key => [$template];
        }
    }

    #[DataProvider('templates')]
    public function testTemplateIsComplete(ServiceTemplate $template): void
    {
        $this->assertContains($template->category, ServiceCatalog::CATEGORIES);
        $this->assertNotSame('', $template->name);
        $this->assertNotSame('', $template->provider);

        // Visitors read the purpose, the transfer and the durations in their language.
        $translator = Translations::translator();
        $this->assertTrue($translator->getCatalogue('en')->has('purpose.'.$template->purpose, 'neo_cookieconsent'), 'purpose.'.$template->purpose);

        if ('' !== $template->transfer) {
            $this->assertTrue($translator->getCatalogue('en')->has('transfer.'.$template->transfer, 'neo_cookieconsent'), 'transfer.'.$template->transfer);
        }

        foreach ($template->cookies as $name => $duration) {
            $this->assertMatchesRegularExpression('/^(session|local|15min|30min|1d|30d|90d|6m|13m|1y|2y)$/', $duration, $template->key.' '.$name);
        }

        // A provider of its own (self-hosted) has no policy of another company; all others link to theirs.
        if ('@self' !== $template->provider) {
            $this->assertMatchesRegularExpression('#^https://[a-z0-9.-]+/#', $template->privacyUrl);
        }
    }

    #[DataProvider('templates')]
    public function testPatternsAreValidExpressions(ServiceTemplate $template): void
    {
        $patterns = array_merge(...array_values($template->patterns));
        $this->assertNotSame([], $patterns, 'a template the scan and the blocking cannot recognise');

        foreach ([...$patterns, ...array_filter([$template->idPattern, $template->idFrom])] as $pattern) {
            $this->assertNotFalse(@preg_match($pattern, ''), $template->key.': '.$pattern);
        }
    }

    #[DataProvider('templates')]
    public function testALoaderOnlyTakesACheckedId(ServiceTemplate $template): void
    {
        if (!$template->canLoad()) {
            $this->assertSame('', $template->idPattern.$template->idExample);

            return;
        }

        $this->assertStringContainsString('{id}', $template->loader);
        $this->assertNotSame('', $template->idPattern, 'IDs are checked against the pattern');
        $this->assertTrue($template->validId($template->idExample), $template->idExample);
        $this->assertFalse($template->validId($template->idExample.'"'));
        $this->assertFalse($template->validId('<'.$template->idExample));

        $loader = $template->loaderFor($template->idExample, $template->needsUrl ? 'https://stats.example.com' : '');
        $this->assertStringContainsString($template->idExample, $loader);
        $this->assertStringNotContainsString('{id}', $loader);
        $this->assertStringNotContainsString('{url}', $loader);
    }

    /**
     * What the extension loads itself must be recognised as that service again
     * by the blocking and the scan (patterns), with the same ID (id_from).
     */
    #[DataProvider('templates')]
    public function testOwnLoaderIsRecognised(ServiceTemplate $template): void
    {
        if (!$template->canLoad()) {
            $this->addToAssertionCount(1);

            return;
        }

        $loader = $template->loaderFor($template->idExample, $template->needsUrl ? 'https://stats.example.com' : '');
        $matched = false;

        foreach ($template->patterns('script') as $pattern) {
            preg_match_all('#<script\b([^>]*)>(.*?)</script>#is', $loader, $scripts, PREG_SET_ORDER);

            foreach ($scripts as $script) {
                $value = html_entity_decode(HtmlBlocker::attributes($script[1])['src'] ?? $script[2], ENT_QUOTES);
                $matched = $matched || 1 === preg_match($pattern, $value);
            }
        }

        $this->assertTrue($matched, $template->key.': the loader matches no script pattern');

        if ('' !== $template->idFrom) {
            $this->assertSame(1, preg_match($template->idFrom, $loader, $m), $template->key);
            $this->assertContains($template->idExample, \array_slice($m, 1), $template->key);
        }
    }

    public function testCategoriesComeInTheirOrder(): void
    {
        $grouped = (new ServiceCatalog())->grouped();

        $this->assertSame(['functional', 'statistics', 'marketing'], array_keys($grouped));
        $this->assertSame('Google Analytics 4', $grouped['statistics']['ga4']);

        $names = array_values($grouped['statistics']);
        $sorted = $names;
        natcasesort($sorted);
        $this->assertSame(array_values($sorted), $names);
    }

    public function testGetReturnsNullForAnUnknownKey(): void
    {
        $catalog = new ServiceCatalog();

        $this->assertNull($catalog->get('unknown'));
        $this->assertSame($catalog->get('ga4'), $catalog->get('ga4'));
        $this->assertCount(47, $catalog->all());
    }
}
