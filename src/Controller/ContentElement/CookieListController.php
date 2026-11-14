<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Neo\CookieconsentBundle\Consent\CookieTable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cookie list for the privacy policy, as a content element. The same tables
 * are available as insert tag {{cookie_consent::table}}.
 */
#[AsContentElement('neo_cookieconsent_list', category: 'neo', template: 'content_element/neo_cookieconsent_list')]
final class CookieListController extends AbstractContentElementController
{
    public function __construct(private readonly CookieTable $table)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $template->set('table', $this->table->render());

        return $template->getResponse();
    }
}
