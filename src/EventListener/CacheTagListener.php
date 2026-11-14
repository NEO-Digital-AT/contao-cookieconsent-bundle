<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\PageModel;
use Neo\BasicBundle\Cache\PageCacheTags;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Tags every page of the front end with the tables of the banner. Contao
 * invalidates these tags when a service, the settings or a text is saved, so a
 * cached page never shows an outdated banner. Runs before the tags are written
 * to the response (priority above 0). PageCacheTags of the Basic bundle uses
 * the cache tag service of the installed Contao version.
 */
#[AsEventListener(event: KernelEvents::RESPONSE, priority: 8)]
final class CacheTagListener
{
    public const TAGS = [
        'contao.db.tl_neo_cookieconsent_service',
        'contao.db.tl_neo_cookieconsent_settings',
        'contao.db.tl_neo_cookieconsent_text',
    ];

    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
        private readonly PageCacheTags $cacheTags,
    ) {
    }

    public function __invoke(ResponseEvent $event): void
    {
        if ($this->scopeMatcher->isFrontendMainRequest($event) && $event->getRequest()->attributes->get('pageModel') instanceof PageModel) {
            $this->cacheTags->tag(self::TAGS);
        }
    }
}
