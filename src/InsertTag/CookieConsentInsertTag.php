<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\InsertTag;

use Contao\CoreBundle\DependencyInjection\Attribute\AsInsertTag;
use Contao\CoreBundle\InsertTag\InsertTagResult;
use Contao\CoreBundle\InsertTag\OutputType;
use Contao\CoreBundle\InsertTag\ResolvedInsertTag;
use Contao\CoreBundle\InsertTag\Resolver\InsertTagResolverNestedResolvedInterface;
use Contao\PageModel;
use Neo\CookieconsentBundle\Consent\CookieTable;
use Neo\CookieconsentBundle\Consent\Texts;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Insert tags of the cookie consent:
 *  - {{cookie_consent::settings}} or {{cookie_consent::settings::Own label}}:
 *    a link that opens the cookie settings (e.g. in the footer);
 *  - {{cookie_consent::table}}: the services and cookies for the privacy policy;
 *  - {{cookie_consent::id}}: the consent ID of the visitor (filled in the browser).
 */
#[AsInsertTag('cookie_consent')]
final class CookieConsentInsertTag implements InsertTagResolverNestedResolvedInterface
{
    public function __construct(
        private readonly Texts $texts,
        private readonly CookieTable $table,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function __invoke(ResolvedInsertTag $insertTag): InsertTagResult
    {
        $parameters = $insertTag->getParameters();

        return match (strtolower(trim((string) $parameters->get(0)))) {
            'table' => new InsertTagResult($this->table->render(), OutputType::html),
            'id' => new InsertTagResult('<span data-ncc-id></span>', OutputType::html),
            default => new InsertTagResult(
                sprintf('<a href="#" role="button" aria-haspopup="dialog" class="ncc-settings-link" data-ncc-open>%s</a>', htmlspecialchars(trim((string) $parameters->get(1)) ?: $this->label(), ENT_QUOTES)),
                OutputType::html,
            ),
        };
    }

    private function label(): string
    {
        $page = $this->requestStack->getCurrentRequest()?->attributes->get('pageModel');

        return $this->texts->forLanguage($page instanceof PageModel ? (string) ($page->rootLanguage ?: $page->language) : 'en')['reopen'];
    }
}
