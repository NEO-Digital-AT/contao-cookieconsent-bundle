<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Contao\PageModel;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

/**
 * The services and cookies for the privacy policy: one table per category,
 * in the language of the page. Used by the insert tag {{cookie_consent::table}}
 * and the content element "Cookie list"; it always shows what the banner shows.
 */
final class CookieTable
{
    public function __construct(
        private readonly ServiceRepository $services,
        private readonly BannerBuilder $builder,
        private readonly Texts $texts,
        private readonly RequestStack $requestStack,
        private readonly Environment $twig,
    ) {
    }

    public function render(): string
    {
        $page = $this->requestStack->getCurrentRequest()?->attributes->get('pageModel');
        $root = $page instanceof PageModel ? (int) $page->rootId : 0;
        $language = Texts::primary($page instanceof PageModel ? (string) ($page->rootLanguage ?: $page->language) : ($this->requestStack->getCurrentRequest()?->getLocale() ?? 'en'));
        $t = $this->texts->forLanguage($language);
        $services = $this->services->forRoot($root);
        $cats = [];

        foreach (ServiceCatalog::CATEGORIES as $category) {
            $in = array_values(array_filter($services, static fn (Service $s): bool => $s->category === $category));

            if ('necessary' === $category) {
                array_unshift($in, $this->builder->consentService());
            } elseif ([] === $in) {
                continue;
            }

            $cats[] = [
                'key' => $category,
                'label' => $t['cat_'.$category],
                'desc' => $t['cat_'.$category.'_desc'],
                'services' => array_map(fn (Service $s): array => $this->builder->view($s, $language), $in),
            ];
        }

        $labels = [];

        foreach (['service', 'provider', 'purpose', 'cookies', 'transfer', 'change', 'none'] as $key) {
            $labels[$key] = $this->texts->trans('list.'.$key, $language);
        }

        return $this->twig->render('@Contao/cookieconsent/table.html.twig', ['cats' => $cats, 'texts' => $t, 'labels' => $labels]);
    }
}
