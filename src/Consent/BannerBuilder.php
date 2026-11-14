<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Consent;

use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\PageModel;
use Neo\BasicBundle\Page\LanguageVersion;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Catalog\ServiceTemplate;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Everything the banner of one page needs: texts in the language of the page,
 * the categories with their services, the links and the configuration of the
 * consent script.
 */
final class BannerBuilder
{
    public function __construct(
        private readonly Settings $settings,
        private readonly ServiceRepository $services,
        private readonly Texts $texts,
        private readonly VersionKeeper $version,
        private readonly ServiceCatalog $catalog,
        private readonly ContentUrlGenerator $urls,
        private readonly UrlGeneratorInterface $router,
        private readonly LanguageVersion $languageVersion,
    ) {
    }

    /**
     * @return array<string, mixed>|null null when no service of the website needs consent
     */
    public function build(PageModel $page): array|null
    {
        $root = (int) $page->rootId;
        $language = Texts::primary((string) ($page->rootLanguage ?: $page->language));
        $services = $this->services->forRoot($root);
        $consent = array_filter($services, static fn (Service $s): bool => $s->needsConsent());

        $t = $this->texts->forLanguage($language);
        $pages = $this->texts->pages($language);
        $cats = [];

        foreach (ServiceCatalog::CATEGORIES as $category) {
            $in = array_values(array_filter($services, static fn (Service $s): bool => $s->category === $category));

            if ('necessary' === $category) {
                array_unshift($in, $this->consentService());
            } elseif ([] === $in) {
                continue; // no category without a service behind it
            }

            $cats[] = [
                'key' => $category,
                'label' => $t['cat_'.$category],
                'desc' => $t['cat_'.$category.'_desc'],
                'services' => array_map(fn (Service $s): array => $this->view($s, $language), $in),
            ];
        }

        return [
            'language' => $language,
            'root' => $root,
            'has_consent_services' => [] !== $consent,
            'texts' => $t,
            'banner_text' => $this->bannerText($t['banner_text'], $cats, $consent, $language),
            'cats' => $cats,
            // A page of the language record as chosen; otherwise the page of the
            // settings in the language of this website (linked language versions).
            'privacy_url' => $this->pageUrl($pages['privacy'] ?: $this->languageVersion->in((int) $this->settings->get('privacy_page'), $root)),
            'imprint_url' => $this->pageUrl($pages['imprint'] ?: $this->languageVersion->in((int) $this->settings->get('imprint_page'), $root)),
            'position' => \in_array($position = (string) $this->settings->get('position'), ['bottom', 'top', 'center', 'left', 'right'], true) ? $position : 'bottom',
            'overlay' => $this->settings->flag('overlay'),
            'reopen' => (string) $this->settings->get('reopen'),
            'config' => [
                'v' => $this->version->current(),
                // Categories a visitor can choose; none = no banner of its own (only placeholders).
                'cats' => array_values(array_filter(array_map(static fn (array $c): string => $c['key'], $cats), static fn (string $k): bool => 'necessary' !== $k)),
                'root' => $root,
                'show' => (string) $this->settings->get('show_on'),
                'modal' => $this->settings->flag('overlay'),
                'log' => $this->settings->flag('log') ? $this->router->generate('neo_cookieconsent_log') : '',
                'consentMode' => $this->usesGoogle($services),
                'loaders' => array_values(array_map(
                    static fn (Service $s): array => ['key' => $s->key, 'cat' => $s->category, 'html' => $s->loader],
                    array_filter($consent, static fn (Service $s): bool => '' !== $s->loader),
                )),
                'cookies' => $this->cookiesByCategory($consent),
            ],
        ];
    }

    /** View of a service for the second layer and the cookie list. */
    public function view(Service $service, string $language): array
    {
        $cookies = [];

        foreach ($service->cookies as $name => $duration) {
            $cookies[] = ['name' => $name, 'duration' => $this->texts->duration($duration, $language)];
        }

        return [
            'key' => $service->key,
            'name' => $this->name($service, $language),
            'provider' => '@self' === $service->provider ? $this->texts->trans('provider.self', $language) : $service->provider,
            'purpose' => '' !== $service->purposeIn($language) ? $service->purposeIn($language) : ('' !== $service->purposeCode ? $this->texts->trans('purpose.'.$service->purposeCode, $language) : ''),
            'cookies' => $cookies,
            'no_cookies' => [] === $cookies ? $this->texts->trans('list.no_cookies', $language) : '',
            'transfer' => '' !== $service->transfer ? $this->texts->trans('transfer.'.$service->transfer, $language) : '',
            'privacy_url' => $service->privacyUrl,
            'privacy_label' => $this->texts->trans('list.privacy', $language),
        ];
    }

    /**
     * Name of a service in a language. The AI chat has no brand name: as long as
     * its name is still the default of one of the languages, it follows the page.
     */
    private function name(Service $service, string $language): string
    {
        if (0 === $service->id && 'consent' === $service->key) {
            return $this->texts->trans('name.consent', $language);
        }

        $name = $service->nameIn($language);

        if ('ai-chat' !== $service->template?->key || '' !== trim((string) ($service->translations[$language]['title'] ?? ''))) {
            return $name;
        }

        // Names saved in the back end carry brackets as entities (&#40;).
        $plain = html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        foreach (Texts::LANGUAGES as $code) {
            if ($plain === $this->texts->trans('name.ai-chat', $code)) {
                return $this->texts->trans('name.ai-chat', $language);
            }
        }

        return $name;
    }

    /**
     * The choice of the visitor itself (key ncc-consent in the local storage of
     * the browser): listed with the necessary services.
     */
    public function consentService(): Service
    {
        return new Service(0, 'consent', '', 'necessary', '@self', '', 'consent', '', '', ['ncc-consent' => 'local'], '', [], null);
    }

    /** Placeholder texts of embedded content of a template that is not listed (yet). */
    public function templateService(ServiceTemplate $template): Service
    {
        return new Service(0, $template->key, $template->name, $template->category, $template->provider, '', $template->purpose, $template->transfer, $template->privacyUrl, $template->cookies, '', [], $template);
    }

    /**
     * The first layer names every purpose and service; {services} and {transfer}
     * in an own text are replaced the same way.
     *
     * @param list<array<string, mixed>> $cats
     * @param array<int, Service>        $consent
     */
    private function bannerText(string $text, array $cats, array $consent, string $language): string
    {
        $parts = [];

        foreach ($cats as $cat) {
            if ('necessary' === $cat['key'] || [] === $cat['services']) {
                continue;
            }

            $parts[] = $cat['label'].' ('.implode(', ', array_map(static fn (array $s): string => $s['name'], $cat['services'])).')';
        }

        $transfers = array_unique(array_filter(array_map(static fn (Service $s): string => $s->transfer, $consent)));
        $transfer = '';

        if (\in_array('world', $transfers, true)) {
            $transfer = $this->texts->trans('banner.transfer_world', $language);
        } elseif (\in_array('us', $transfers, true)) {
            $transfer = $this->texts->trans('banner.transfer_us', $language);
        }

        return trim(preg_replace('/\s{2,}/', ' ', strtr($text, ['{services}' => implode('; ', $parts), '{transfer}' => $transfer])) ?? '');
    }

    /** @param list<Service> $services */
    private function usesGoogle(array $services): bool
    {
        if (!$this->settings->flag('consent_mode')) {
            return false;
        }

        foreach ($services as $service) {
            if (null !== $service->template && $service->template->google) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cookie names per category, deleted when a visitor withdraws consent.
     *
     * @param array<int, Service> $services
     *
     * @return array<string, list<string>>
     */
    private function cookiesByCategory(array $services): array
    {
        $map = [];

        foreach ($services as $service) {
            foreach (array_keys($service->cookies) as $name) {
                $map[$service->category][] = (string) $name;
            }
        }

        return array_map(static fn (array $names): array => array_values(array_unique($names)), $map);
    }

    private function pageUrl(int $id): string
    {
        if ($id <= 0 || null === ($page = PageModel::findById($id))) {
            return '';
        }

        try {
            return $this->urls->generate($page);
        } catch (\Throwable) {
            return '';
        }
    }
}
