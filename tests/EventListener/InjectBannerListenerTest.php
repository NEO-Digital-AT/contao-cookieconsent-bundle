<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\EventListener;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Dock\Dock;
use Neo\BasicBundle\Page\LanguageVersion;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\BannerBuilder;
use Neo\CookieconsentBundle\Consent\HtmlBlocker;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Consent\VersionKeeper;
use Neo\CookieconsentBundle\EventListener\InjectBannerListener;
use Neo\CookieconsentBundle\EventListener\RegisterAssetsListener;
use Neo\CookieconsentBundle\Tests\Support\Pages;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use Neo\CookieconsentBundle\Tests\Support\Twig;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[CoversClass(InjectBannerListener::class)]
final class InjectBannerListenerTest extends TestCase
{
    private const PAGE = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Home</title></head><body><main>'
        .'<script async src="https://www.googletagmanager.com/gtag/js?id=G-ABC123DEF4"></script>'
        .'<iframe width="640" height="360" src="https://www.youtube.com/embed/abc"></iframe></main></body></html>';

    private Connection $db;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(Settings::TABLE, ServiceRepository::TABLE, Texts::TABLE);
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'ga4', 'category' => 'statistics']);
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'title' => 'Widget <b>', 'category' => 'marketing', 'loading' => 'extension', 'code' => '<script>alert("</script>")</script>']);
    }

    public function testThePageGetsTheBannerAndWaitsForConsent(): void
    {
        $html = $this->respond(new Response(self::PAGE));

        $this->assertMatchesRegularExpression('#^<!DOCTYPE html><html lang="en"><head><script id="ncc-head">#', $html, 'the stub goes first into the head');
        $this->assertMatchesRegularExpression('#<link rel="stylesheet" href="/bundles/neocookieconsent/consent\.css\?v=[a-f0-9]{8}" data-ncc-ignore></head>#', $html);
        $this->assertMatchesRegularExpression('#<script src="/bundles/neocookieconsent/consent\.js\?v=[a-f0-9]{8}" defer id="ncc-script"></script></body></html>$#', $html);
        $this->assertStringContainsString('<script type="text/plain" data-ncc-service="ga4" data-ncc-category="statistics" async src=', $html);
        $this->assertStringContainsString('<div class="ncc-embed" data-ncc-embed data-ncc-service="youtube" data-ncc-category="functional" style="aspect-ratio:640/360">', $html);
        $this->assertStringContainsString('<template><iframe width="640" height="360" src="https://www.youtube.com/embed/abc"></iframe></template>', $html);
        $this->assertStringNotContainsString('Widget <b>', $html, 'names are escaped');
        $this->assertStringContainsString('Widget &lt;b&gt;', $html);
    }

    public function testTheConfigurationCannotEndItsScriptEarly(): void
    {
        $html = $this->respond(new Response(self::PAGE));

        $this->assertSame(1, preg_match('#<script type="application/json" id="ncc-config">(.*?)</script>#s', $html, $m));
        $this->assertStringNotContainsString('<', $m[1]);

        $config = json_decode($m[1], true);
        $this->assertSame('<script>alert("</script>")</script>', $config['loaders'][0]['html']);
        $this->assertSame(['statistics', 'marketing'], $config['cats'], 'embedded content of a template that is not listed: placeholder only');
        $this->assertSame(1, $config['root']);
    }

    public function testAssetsOfThePageLayoutAreNotAddedTwice(): void
    {
        $request = new Request();
        $request->attributes->set(RegisterAssetsListener::ATTRIBUTE, true);

        $html = $this->respond(new Response(self::PAGE), $request);

        $this->assertStringContainsString('id="ncc-config"', $html);
        $this->assertStringNotContainsString('consent.css', $html);
        $this->assertStringNotContainsString('consent.js', $html);
    }

    /**
     * The button to reopen takes part in the buttons at the edge of the screen
     * of NEO Basic: it carries the attributes of the dock, which arranges it
     * with the buttons of other extensions in the same corner.
     */
    public function testTheButtonToReopenTakesPartInTheDock(): void
    {
        $html = $this->respond(new Response(self::PAGE));

        $this->assertMatchesRegularExpression('#<button type="button" class="ncc-reopen ncc-reopen--left" data-ncc-open data-ncc-reopen data-neo-dock="cookies" data-neo-dock-launcher data-neo-dock-corner="bottom-left" data-neo-dock-order="30" data-neo-dock-label="Cookie settings" aria-label="Cookie settings" title="Cookie settings" hidden>\s*<svg[^>]*aria-hidden="true"[^>]*data-neo-dock-icon>#', $html);
        $this->assertStringNotContainsString('data-ncc-menu', $html, 'the menu is the one of the dock');
    }

    public function testTheButtonToReopenAsksForTheFilesOfTheDock(): void
    {
        if (!class_exists(Dock::class)) {
            $this->markTestSkipped('The installed Basic has no buttons at the edge of the screen yet.');
        }

        $request = new Request();
        $html = $this->respond(new Response(self::PAGE), $request, true, true);

        $this->assertStringContainsString('data-neo-dock="cookies"', $html);
        $this->assertSame(['arrangement' => 'menu', 'label' => 'Settings'], $request->attributes->get(Dock::ATTRIBUTE));

        (new Settings($this->db))->ensureRow();
        $this->db->executeStatement('UPDATE '.Settings::TABLE." SET reopen = 'none'");
        $request = new Request();
        $html = $this->respond(new Response(self::PAGE), $request, true, true);

        $this->assertStringNotContainsString('data-neo-dock', $html);
        $this->assertNull($request->attributes->get(Dock::ATTRIBUTE), 'no button, no dock');
    }

    public function testOnlyHtmlPagesOfTheFrontEndAreChanged(): void
    {
        $json = new JsonResponse(['a' => '</body>']);
        $this->assertSame($json->getContent(), $this->respond($json));

        $fragment = '<div>no body end</div>';
        $this->assertSame($fragment, $this->respond(new Response($fragment)));

        $done = '<html><head></head><body><script type="application/json" id="ncc-config">{}</script></body></html>';
        $this->assertSame($done, $this->respond(new Response($done)), 'not twice');

        $this->assertSame(self::PAGE, $this->respond(new Response(self::PAGE), null, false), 'not in the back end or a sub-request');
    }

    public function testNothingWhenTheBannerIsSwitchedOff(): void
    {
        $this->db->insert(Settings::TABLE, ['tstamp' => 1, 'active' => '']);

        $this->assertSame(self::PAGE, $this->respond(new Response(self::PAGE)));
    }

    public function testAPageWithoutServicesStaysAsItIs(): void
    {
        $this->db->executeStatement('DELETE FROM '.ServiceRepository::TABLE);
        $page = '<html><head></head><body><p>Text</p></body></html>';

        $this->assertSame($page, $this->respond(new Response($page)));
    }

    private function respond(Response $response, Request|null $request = null, bool $frontend = true, bool $dock = false): string
    {
        $request ??= new Request();
        $request->attributes->set('pageModel', Pages::page($this, ['rootId' => 1, 'rootLanguage' => 'en', 'language' => 'en']));

        $settings = new Settings($this->db);
        $catalog = new ServiceCatalog();
        $services = new ServiceRepository($this->db, $catalog);
        $router = $this->createMock(UrlGeneratorInterface::class);
        $router->method('generate')->willReturn('/api/cookieconsent/log');
        $scope = $this->createMock(ScopeMatcher::class);
        $scope->method('isFrontendMainRequest')->willReturn($frontend);
        $builder = new BannerBuilder($settings, $services, new Texts($this->db, Translations::translator()), new VersionKeeper($settings, $services), $catalog, $this->createMock(ContentUrlGenerator::class), $router, new LanguageVersion($this->db, $this->createStub(ContaoFramework::class)));

        $listener = new InjectBannerListener($scope, $settings, $services, $builder, new HtmlBlocker($catalog), Twig::environment(), $dock ? $this->dock($request) : null);
        $listener(new ResponseEvent($this->createMock(HttpKernelInterface::class), $request, HttpKernelInterface::MAIN_REQUEST, $response));

        return (string) $response->getContent();
    }

    private function dock(Request $request): Dock
    {
        $stack = new RequestStack();
        $stack->push($request);
        $translator = $this->createStub(TranslatorInterface::class);
        $translator->method('trans')->willReturnCallback(static fn (string $id): string => 'MSC.neo_dock_settings' === $id ? 'Settings' : $id);

        return new Dock($this->db, $stack, $translator);
    }
}
