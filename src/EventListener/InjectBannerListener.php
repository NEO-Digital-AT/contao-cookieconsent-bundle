<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\PageModel;
use Neo\BasicBundle\Dock\Dock;
use Neo\CookieconsentBundle\Consent\BannerBuilder;
use Neo\CookieconsentBundle\Consent\HtmlBlocker;
use Neo\CookieconsentBundle\Consent\Service;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

/**
 * Adds the banner to every page of the front end and blocks known services in
 * the page until consent. No module in the page layout is needed, so no page
 * is left without the banner.
 */
#[AsEventListener(event: KernelEvents::RESPONSE, priority: -64)]
final class InjectBannerListener
{
    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
        private readonly Settings $settings,
        private readonly ServiceRepository $services,
        private readonly BannerBuilder $builder,
        private readonly HtmlBlocker $blocker,
        private readonly Environment $twig,
        // Buttons at the edge of the screen of NEO Basic; null with a Basic that does not have them yet.
        private readonly Dock|null $dock = null,
    ) {
    }

    public function __invoke(ResponseEvent $event): void
    {
        if (!$this->scopeMatcher->isFrontendMainRequest($event) || !$this->settings->flag('active')) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();
        $page = $request->attributes->get('pageModel');

        if (!$page instanceof PageModel || $response instanceof StreamedResponse || $response instanceof BinaryFileResponse
            || !str_contains((string) $response->headers->get('Content-Type', 'text/html'), 'text/html')) {
            return;
        }

        $html = $response->getContent();

        if (!\is_string($html) || !str_contains($html, '</body>') || str_contains($html, 'id="ncc-config"')) {
            return;
        }

        $page->loadDetails();
        $banner = $this->builder->build($page);

        if (null === $banner) {
            return;
        }

        $root = (int) $page->rootId;
        $custom = array_values(array_filter($this->services->forRoot($root), static fn (Service $s): bool => null === $s->template && [] !== $s->hosts));

        [$html, $blocked] = $this->blocker->block(
            $html,
            $this->services->templateCategories($root),
            $custom,
            $this->settings->flag('block_scripts'),
            $this->settings->flag('block_embeds'),
            fn (Service $service): string => $this->twig->render('@Contao/cookieconsent/embed.html.twig', [
                'service' => $this->builder->view($service, $banner['language']),
                'texts' => $banner['texts'],
            ]),
        );

        if (!$banner['has_consent_services'] && 0 === $blocked) {
            $response->setContent($html);

            return;
        }

        // consent.js and consent.css came with the page assets of Contao (RegisterAssetsListener)
        // or are added here.
        $registered = true === $request->attributes->get(RegisterAssetsListener::ATTRIBUTE);
        $assets = '/bundles/neocookieconsent/';
        $version = substr(md5((string) @filemtime(__DIR__.'/../../public/consent.js').(string) @filemtime(__DIR__.'/../../public/consent.css')), 0, 8);
        $head = $this->twig->render('@Contao/cookieconsent/head.html.twig', ['config' => $banner['config']]);
        $css = $registered ? '' : sprintf('<link rel="stylesheet" href="%sconsent.css?v=%s" data-ncc-ignore>', $assets, $version);
        $body = $this->twig->render('@Contao/cookieconsent/banner.html.twig', $banner)
            .sprintf('<script type="application/json" id="ncc-config">%s</script>', json_encode($banner['config'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
            .($registered ? '' : sprintf('<script src="%sconsent.js?v=%s" defer id="ncc-script"></script>', $assets, $version));

        // The button to reopen takes part in the buttons at the edge of the screen of
        // NEO Basic; its files come with the page assets (RegisterAssetsListener) or
        // are added to the finished page by Basic (DockResponseListener).
        if ('none' !== ($banner['reopen'] ?? 'none')) {
            $this->dock?->register($page);
        }

        // The stub goes first into the head: other scripts may ask for consent before the page is complete.
        $html = preg_replace('#<head\b[^>]*>#i', '$0'.str_replace(['\\', '$'], ['\\\\', '\\$'], $head), $html, 1) ?? $html;
        if ('' !== $css) {
            $html = preg_replace('#</head>#i', str_replace(['\\', '$'], ['\\\\', '\\$'], $css).'</head>', $html, 1) ?? $html;
        }
        $pos = strripos($html, '</body>');
        $html = substr($html, 0, $pos).$body.substr($html, $pos);

        $response->setContent($html);
    }
}
