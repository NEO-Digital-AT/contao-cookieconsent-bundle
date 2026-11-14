<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Scan;

use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Neo\BasicBundle\Cache\PageCacheTags;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceFactory;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Scan\Scanner;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\Mailer\MailerInterface;

/**
 * What the scan finds in a page. Reading the pages of the website (run()) needs
 * Contao's page models and is not covered here.
 */
#[CoversClass(Scanner::class)]
final class ScannerTest extends TestCase
{
    public function testKnownServicesWithTheirIds(): void
    {
        $hits = $this->detect('<head><script async src="https://www.googletagmanager.com/gtag/js?id=G-ABC123DEF4"></script>'
            .'<script>window.dataLayer=window.dataLayer||[];gtag("config","G-ABC123DEF4");</script></head>'
            .'<body><noscript><img src="https://www.facebook.com/tr?id=1234567890123&ev=PageView"></noscript></body>');

        $this->assertContains(['template' => 'ga4', 'host' => '', 'id' => 'G-ABC123DEF4', 'blocked' => false], $hits);
        $this->assertContains(['template' => 'meta-pixel', 'host' => '', 'id' => '1234567890123', 'blocked' => false], $hits);
        $this->assertSame([], array_filter($hits, static fn (array $h): bool => '' === $h['template']), 'no unknown host');
    }

    public function testWhatTheBannerHoldsBackCountsAsBlocked(): void
    {
        $hits = $this->detect('<script type="text/plain" data-ncc-service="hotjar" data-ncc-category="statistics" src="https://static.hotjar.com/c/hotjar-1.js"></script>'
            .'<link rel="ncc-stylesheet" data-ncc-href="https://fonts.googleapis.com/css2?family=Inter&amp;display=swap" data-ncc-service="google-fonts">'
            .'<div class="ncc-embed" data-ncc-embed><p>Load</p><template><iframe src="https://www.youtube.com/embed/abc"></iframe></template></div>'
            .'<iframe src="https://player.vimeo.com/video/1"></iframe>');

        $this->assertSame([
            ['template' => 'hotjar', 'host' => '', 'id' => '', 'blocked' => true],
            ['template' => 'youtube', 'host' => '', 'id' => '', 'blocked' => true],
            ['template' => 'vimeo', 'host' => '', 'id' => '', 'blocked' => false],
            ['template' => 'google-fonts', 'host' => '', 'id' => '', 'blocked' => true],
        ], $hits);
    }

    public function testUnknownHostsOfScriptsAndIframes(): void
    {
        $hits = $this->detect('<script src="//cdn.widget.example.com/w.js"></script><script src="/files/app.js"></script>'
            .'<iframe src="https://booking.example.org/frame"></iframe><link rel="stylesheet" href="https://css.example.net/a.css">'
            .'<script type="application/ld+json">{"a":"https://json.example.com/"}</script>');

        $this->assertSame([
            ['template' => '', 'host' => 'cdn.widget.example.com', 'id' => '', 'blocked' => false],
            ['template' => '', 'host' => 'booking.example.org', 'id' => '', 'blocked' => false],
        ], $hits);
    }

    public function testTheOwnConfigurationOfTheBannerIsNoFinding(): void
    {
        $loader = (new ServiceCatalog())->get('ga4')->loaderFor('G-ABC123DEF4');
        $hits = $this->detect('<script type="application/json" id="ncc-config">'.json_encode(['loaders' => [['html' => $loader]]]).'</script>'
            .'<script id="ncc-head">window.cookieConsent={}</script>');

        $this->assertSame([], $hits);
    }

    public function testAServiceThatAsksItselfIsNotReportedAsLoose(): void
    {
        $this->assertSame([['template' => 'ai-chat', 'host' => '', 'id' => '', 'blocked' => true]], $this->detect('<div data-nsa-config="{}"></div>'));
    }

    /** @return list<array{template: string, host: string, id: string, blocked: bool}> */
    private function detect(string $html): array
    {
        $db = TestDatabase::create();
        $catalog = new ServiceCatalog();
        $texts = new Texts($db, Translations::translator());

        $scanner = new Scanner(
            new MockHttpClient(),
            $db,
            $catalog,
            new ServiceRepository($db, $catalog),
            new Settings($db),
            $texts,
            $this->createMock(ContentUrlGenerator::class),
            $this->createMock(MailerInterface::class),
            new NullLogger(),
            new PageCacheTags($this->createMock(ContainerInterface::class)),
            new ServiceFactory($db, $texts),
        );

        return $scanner->detect($html);
    }
}
