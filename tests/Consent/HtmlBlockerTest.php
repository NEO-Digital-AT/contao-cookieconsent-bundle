<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Consent;

use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\HtmlBlocker;
use Neo\CookieconsentBundle\Consent\Service;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HtmlBlocker::class)]
final class HtmlBlockerTest extends TestCase
{
    private const GA4 = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-ABC123DEF4"></script>';

    public function testAScriptOfAKnownServiceWaitsForConsent(): void
    {
        [$html, $count] = $this->block(self::GA4);

        $this->assertSame(1, $count);
        $this->assertSame('<script type="text/plain" data-ncc-service="ga4" data-ncc-category="statistics" async src="https://www.googletagmanager.com/gtag/js?id=G-ABC123DEF4"></script>', $html);
    }

    public function testInlineCodeIsRecognisedToo(): void
    {
        [$html, $count] = $this->block('<script>gtag("config", "G-ABC123DEF4");</script>');

        $this->assertSame(1, $count);
        $this->assertSame('<script type="text/plain" data-ncc-service="ga4" data-ncc-category="statistics">gtag("config", "G-ABC123DEF4");</script>', $html);
    }

    public function testAModuleKeepsItsType(): void
    {
        [$html] = $this->block('<script type="module" src="https://static.hotjar.com/c/hotjar-1.js"></script>');

        $this->assertStringContainsString('type="text/plain" data-ncc-service="hotjar" data-ncc-category="statistics" data-ncc-type="module"', $html);
        $this->assertStringNotContainsString(' type="module"', $html);
    }

    public function testScriptsThatAreNoJavaScriptOrMarkedStayUntouched(): void
    {
        $page = '<script type="application/ld+json">{"url":"https://www.googletagmanager.com/gtag/js?id=G-ABC123DEF4"}</script>'
            .'<script data-ncc-ignore src="https://www.googletagmanager.com/gtag/js?id=G-ABC123DEF4"></script>'
            .'<script id="ncc-head">gtag("config","G-ABC123DEF4")</script>'
            .'<script src="/files/app.js"></script>';

        $this->assertSame([$page, 0], $this->block($page));
    }

    public function testAServiceListedAsNecessaryIsNeverBlocked(): void
    {
        $this->assertSame([self::GA4, 0], $this->block(self::GA4, ['ga4' => 'necessary']));
    }

    public function testTheCategoryOfTheBackEndWins(): void
    {
        [$html] = $this->block(self::GA4, ['ga4' => 'marketing']);

        $this->assertStringContainsString('data-ncc-category="marketing"', $html);
    }

    public function testAServiceThatAsksForConsentItselfIsNotHeldBack(): void
    {
        $page = '<div data-nsa-config="{}"></div>';

        $this->assertSame([$page, 0], $this->block($page));
    }

    /** The address stays encoded once: consent.js copies the attribute into href as it reads it. */
    public function testWebFontStylesheetsWaitForConsent(): void
    {
        [$html, $count] = $this->block('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter&amp;display=swap" media="all"><link rel="stylesheet" href="/files/site.css">');

        $this->assertSame(1, $count);
        $this->assertSame('<link rel="ncc-stylesheet" data-ncc-href="https://fonts.googleapis.com/css2?family=Inter&amp;display=swap" data-ncc-service="google-fonts" data-ncc-category="functional" media="all"><link rel="stylesheet" href="/files/site.css">', $html);
    }

    public function testEmbeddedContentBecomesAPlaceholder(): void
    {
        $iframe = '<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/abc" title="Video" allowfullscreen></iframe>';
        $seen = [];

        [$html, $count] = (new HtmlBlocker(new ServiceCatalog()))->block($iframe, [], [], true, true, static function (Service $service, string $category) use (&$seen): string {
            $seen = [$service->key, $service->category, $service->provider, $category];

            return '<p>placeholder</p>';
        });

        $this->assertSame(1, $count);
        $this->assertSame(['youtube', 'functional', 'Google Ireland Limited, Dublin', 'functional'], $seen);
        $this->assertSame('<div class="ncc-embed" data-ncc-embed data-ncc-service="youtube" data-ncc-category="functional" style="aspect-ratio:560/315"><p>placeholder</p><template>'.$iframe.'</template></div>', $html);
    }

    public function testEmbedsAndScriptsAreSwitchedSeparately(): void
    {
        $page = self::GA4.'<iframe src="https://player.vimeo.com/video/1"></iframe>';
        $blocker = new HtmlBlocker(new ServiceCatalog());
        $placeholder = static fn (): string => '';

        [$embedsOnly, $count] = $blocker->block($page, [], [], false, true, $placeholder);
        $this->assertSame(1, $count);
        $this->assertStringStartsWith(self::GA4.'<div class="ncc-embed"', $embedsOnly);

        [$scriptsOnly, $count] = $blocker->block($page, [], [], true, false, $placeholder);
        $this->assertSame(1, $count);
        $this->assertStringEndsWith('<iframe src="https://player.vimeo.com/video/1"></iframe>', $scriptsOnly);
        $this->assertStringContainsString('type="text/plain"', $scriptsOnly);

        $this->assertSame([$page, 0], $blocker->block($page, [], [], false, false, $placeholder));
    }

    public function testOwnServicesAreBlockedByTheirHosts(): void
    {
        $widget = $this->own(7, 'marketing', ['widget.example.com']);
        $page = '<script src="https://cdn.widget.example.com/w.js"></script><script src="//widget.example.com/x.js"></script><script src="https://notwidget.example.com/y.js"></script><iframe src="https://widget.example.com/frame"></iframe>';

        [$html, $count] = (new HtmlBlocker(new ServiceCatalog()))->block($page, [], [$widget], true, true, static fn (): string => '');

        $this->assertSame(3, $count);
        $this->assertSame(2, substr_count($html, 'data-ncc-service="c7" data-ncc-category="marketing"><'.'/script>') + substr_count($html, 'data-ncc-service="c7" data-ncc-category="marketing" src='));
        $this->assertStringContainsString('<script src="https://notwidget.example.com/y.js"></script>', $html);
        $this->assertStringContainsString('<div class="ncc-embed" data-ncc-embed data-ncc-service="c7"', $html);
    }

    public function testAnOwnNecessaryServiceIsNotBlocked(): void
    {
        $page = '<script src="https://widget.example.com/w.js"></script>';

        $this->assertSame([$page, 0], (new HtmlBlocker(new ServiceCatalog()))->block($page, [], [$this->own(8, 'necessary', ['widget.example.com'])], true, true, static fn (): string => ''));
    }

    public function testAttributesAreRead(): void
    {
        $this->assertSame(
            ['async' => '', 'src' => 'https://example.com/a.js?x=1&amp;y=2', 'data-a' => 'single', 'data-b' => 'bare', 'defer' => ''],
            HtmlBlocker::attributes(' async src="https://example.com/a.js?x=1&amp;y=2" data-a=\'single\' DATA-B=bare defer'),
        );
    }

    /**
     * @param array<string, string> $listed
     *
     * @return array{0: string, 1: int}
     */
    private function block(string $html, array $listed = []): array
    {
        return (new HtmlBlocker(new ServiceCatalog()))->block($html, $listed, [], true, true, static fn (): string => '<p>placeholder</p>');
    }

    /** @param list<string> $hosts */
    private function own(int $id, string $category, array $hosts): Service
    {
        return new Service($id, 'c'.$id, 'Widget', $category, 'Example Ltd.', '', '', '', '', [], '', $hosts, null);
    }
}
