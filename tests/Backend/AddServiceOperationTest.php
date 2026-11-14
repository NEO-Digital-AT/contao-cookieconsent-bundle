<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Backend;

use Contao\CoreBundle\Csrf\ContaoCsrfTokenManager;
use Contao\CoreBundle\Exception\RedirectResponseException;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\System;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Cache\PageCacheTags;
use Neo\CookieconsentBundle\Backend\AddServiceOperation;
use Neo\CookieconsentBundle\Backend\RequestInput;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceFactory;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

/** The link another extension puts into the back end: only with a valid request token. */
#[CoversClass(AddServiceOperation::class)]
final class AddServiceOperationTest extends TestCase
{
    private const TOKEN = 'valid-request-token';

    private Connection $db;

    private RequestStack $requests;

    /** @var list<list<string>> */
    private array $invalidated = [];

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(ServiceRepository::TABLE);
        TestDatabase::addPages($this->db, [['type' => 'root', 'language' => 'en']]);
        $this->requests = new RequestStack();

        $tokens = $this->createMock(ContaoCsrfTokenManager::class);
        $tokens->method('isTokenValid')->willReturnCallback(static fn (CsrfToken $t): bool => 'contao_csrf_token' === $t->getId() && self::TOKEN === $t->getValue());
        $tokens->method('getDefaultTokenValue')->willReturn('next-token');

        $scope = $this->createMock(ScopeMatcher::class);
        $scope->method('isBackendRequest')->willReturn(true);

        $container = new Container();
        $container->set('contao.csrf.token_manager', $tokens);
        $container->set('contao.routing.scope_matcher', $scope);
        $container->set('request_stack', $this->requests);
        $container->setParameter('contao.csrf_token_name', 'contao_csrf_token');
        System::setContainer($container);

        // The language file of the table counts as loaded; the messages are set here.
        $files = new \ReflectionProperty(System::class, 'arrLanguageFiles');
        $files->setValue(null, [ServiceRepository::TABLE => ['en' => true]] + (array) $files->getValue());
        $GLOBALS['TL_LANG'][ServiceRepository::TABLE] = ['add_exists' => 'Listed already.', 'add_done' => 'Service added.'];
        $GLOBALS['TL_LANGUAGE'] = 'en';
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TL_LANG'][ServiceRepository::TABLE], $GLOBALS['TL_LANGUAGE']);
        System::setContainer(new Container());
    }

    public function testWithoutAValidTokenNothingIsAdded(): void
    {
        foreach (['', 'forged-token'] as $token) {
            $this->assertSame('https://www.example.com/contao?do=neo_cookieconsent', $this->call(['template' => 'ai-chat', 'category' => 'functional', 'rt' => $token]));
        }

        $this->assertSame(0, (int) $this->db->fetchOne('SELECT COUNT(*) FROM '.ServiceRepository::TABLE));
        $this->assertSame([], $this->invalidated);
    }

    public function testAnUnknownTemplateAddsNothing(): void
    {
        $this->assertSame('https://www.example.com/contao?do=neo_cookieconsent', $this->call(['template' => 'unknown', 'rt' => self::TOKEN]));
        $this->assertSame(0, (int) $this->db->fetchOne('SELECT COUNT(*) FROM '.ServiceRepository::TABLE));
    }

    public function testTheServiceIsAddedInTheCategoryOfTheLinkAndOpened(): void
    {
        $location = $this->call(['template' => 'ai-chat', 'category' => 'statistics', 'rt' => self::TOKEN]);
        $row = $this->db->fetchAssociative('SELECT * FROM '.ServiceRepository::TABLE);

        $this->assertSame('https://www.example.com/contao?do=neo_cookieconsent&act=edit&id='.$row['id'].'&rt=next-token', $location);
        $this->assertSame(['ai-chat', 'statistics', '1', 'AI chat assistant'], [$row['template'], $row['category'], $row['published'], $row['title']]);
        $this->assertSame([['contao.db.'.ServiceRepository::TABLE]], $this->invalidated, 'cached pages ask for the new service');
        $this->assertSame(['Service added.'], $this->requests->getSession()->getFlashBag()->get('contao.BE.confirm'));
    }

    public function testNecessaryIsNoCategoryALinkCanChoose(): void
    {
        $this->call(['template' => 'youtube', 'category' => 'necessary', 'rt' => self::TOKEN]);

        $this->assertSame('functional', $this->db->fetchOne('SELECT category FROM '.ServiceRepository::TABLE));
    }

    public function testAListedTemplateIsOpenedInsteadOfAddedTwice(): void
    {
        $this->db->insert(ServiceRepository::TABLE, ['tstamp' => 1, 'template' => 'ai-chat', 'published' => '']);

        $location = $this->call(['template' => 'ai-chat', 'rt' => self::TOKEN]);

        $this->assertSame('https://www.example.com/contao?do=neo_cookieconsent&act=edit&id=1&rt=next-token', $location);
        $this->assertSame(1, (int) $this->db->fetchOne('SELECT COUNT(*) FROM '.ServiceRepository::TABLE));
        $this->assertSame(['Listed already.'], $this->requests->getSession()->getFlashBag()->get('contao.BE.info'));
    }

    /** @param array<string, string> $query */
    private function call(array $query): string
    {
        $request = new Request($query);
        $request->setSession(new Session(new MockArraySessionStorage()));
        $this->requests->push($request);

        $router = $this->createMock(UrlGeneratorInterface::class);
        $router->method('generate')->willReturnCallback(static fn (string $route, array $parameters): string => 'https://www.example.com/contao?'.http_build_query($parameters));

        $tags = new class($this->invalidated) {
            /** @param list<list<string>> $calls */
            public function __construct(private array &$calls)
            {
            }

            /** @param list<string> $tags */
            public function invalidateTags(array $tags): void
            {
                $this->calls[] = $tags;
            }
        };
        $services = new Container();
        $services->set('tag_manager', $tags);

        $operation = new AddServiceOperation(new ServiceCatalog(), new ServiceFactory($this->db, new Texts($this->db, Translations::translator())), $this->db, new RequestInput($this->requests), $router, new PageCacheTags($services));

        try {
            $operation();
        } catch (RedirectResponseException $e) {
            return (string) $e->getResponse()->headers->get('Location');
        }

        $this->fail('The operation always redirects.');
    }
}
