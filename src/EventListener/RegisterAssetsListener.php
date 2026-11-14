<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Neo\BasicBundle\Dock\Dock;
use Neo\CookieconsentBundle\Consent\BannerBuilder;
use Neo\CookieconsentBundle\Consent\Settings;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Hands consent.js and consent.css to the page assets of Contao, so a page
 * layout with "Combine scripts" puts them into its one script and style file.
 * Pages rendered without a page layout of this kind get the files from
 * InjectBannerListener, which reads the request attribute set here. With the
 * button to reopen, the buttons at the edge of the screen of NEO Basic (dock)
 * come along, which arrange it with the buttons of other extensions.
 */
#[AsHook('generatePage')]
final class RegisterAssetsListener
{
    public const ATTRIBUTE = '_neo_cookieconsent_assets';

    private const PATH = 'bundles/neocookieconsent/';

    public function __construct(
        private readonly Settings $settings,
        private readonly BannerBuilder $builder,
        private readonly RequestStack $requestStack,
        // Buttons at the edge of the screen of NEO Basic; null with a Basic that does not have them yet.
        private readonly Dock|null $dock = null,
    ) {
    }

    public function __invoke(PageModel $page, LayoutModel $layout, PageRegular $pageRegular): void
    {
        $request = $this->requestStack->getMainRequest();

        if (null === $request || !$this->settings->flag('active')) {
            return;
        }

        $page->loadDetails();
        $banner = $this->builder->build($page);

        // Without services that need consent the banner is left out (blocked
        // embeds alone get the files from InjectBannerListener).
        if (null === $banner || !$banner['has_consent_services']) {
            return;
        }

        $GLOBALS['TL_CSS']['neo_cookieconsent'] = self::PATH.'consent.css|all|static'.self::version('consent.css');
        $GLOBALS['TL_JAVASCRIPT']['neo_cookieconsent'] = self::PATH.'consent.js|defer|static'.self::version('consent.js');

        if ('none' !== ($banner['reopen'] ?? 'none')) {
            $this->dock?->register($page);
        }

        $request->attributes->set(self::ATTRIBUTE, true);
    }

    private static function version(string $file): string
    {
        $path = \dirname(__DIR__, 2).'/public/'.$file;

        return is_file($path) ? '|'.filemtime($path) : '';
    }
}
