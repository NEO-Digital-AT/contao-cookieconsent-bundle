<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Backend;

use Contao\CoreBundle\Intl\Locales;
use Contao\DataContainer;
use Doctrine\DBAL\Connection;
use Neo\CookieconsentBundle\Backend\RequestInput;
use Neo\CookieconsentBundle\Backend\ServiceCallbacks;
use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Consent\ServiceRepository;
use Neo\CookieconsentBundle\Consent\Settings;
use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

#[CoversClass(ServiceCallbacks::class)]
final class ServiceCallbacksTest extends TestCase
{
    private Connection $db;

    private Request $request;

    protected function setUp(): void
    {
        $this->db = TestDatabase::create(ServiceRepository::TABLE, Settings::TABLE);
        TestDatabase::addPages($this->db, [['type' => 'root', 'language' => 'de'], ['type' => 'root', 'language' => 'en-GB']]);
        $this->request = new Request();
        $GLOBALS['TL_LANG'][ServiceRepository::TABLE] = ['id_invalid' => 'Enter an ID like %s.', 'url_required' => 'Enter the HTTPS address.'];
        $GLOBALS['TL_LANGUAGE'] = 'en';
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TL_LANG'][ServiceRepository::TABLE], $GLOBALS['TL_LANGUAGE']);
    }

    public function testTheIdMustHaveTheFormOfTheService(): void
    {
        $this->post(['template' => 'ga4', 'loading' => 'extension']);

        $this->assertSame('G-ABC123DEF4', $this->callbacks()->checkId(' G-ABC123DEF4 ', $this->dc(1)));

        $this->expectExceptionObject(new \RuntimeException('Enter an ID like G-XXXXXXXXXX.'));
        $this->callbacks()->checkId('G-123"><script>', $this->dc(1));
    }

    public function testAnEmptyIdIsRejectedWhenTheExtensionLoadsTheService(): void
    {
        $this->post(['template' => 'ga4', 'loading' => 'extension']);

        $this->expectException(\RuntimeException::class);
        $this->callbacks()->checkId('', $this->dc(1));
    }

    public function testASelfHostedServiceNeedsItsHttpsAddress(): void
    {
        $this->post(['template' => 'matomo', 'loading' => 'extension', 'tracking_url' => 'http://stats.example.com/']);

        $this->expectExceptionObject(new \RuntimeException('Enter the HTTPS address.'));
        $this->callbacks()->checkId('3', $this->dc(1));
    }

    public function testTheIdIsFreeWhenThePageLoadsTheService(): void
    {
        $this->post(['template' => 'ga4', 'loading' => 'page']);
        $this->assertSame('anything', $this->callbacks()->checkId('anything', $this->dc(1)));

        // Not in the form: the stored record decides.
        $this->request->request->replace([]);
        $this->assertSame('anything', $this->callbacks()->checkId('anything', $this->dc(1, ['template' => 'youtube', 'loading' => 'extension'])));
    }

    public function testChoosingATemplateFillsNameCategoryAndLoading(): void
    {
        $id = $this->add(['template' => '']);
        $this->post(['title' => '']);

        $this->assertSame('ga4', $this->callbacks()->applyTemplate('ga4', $this->dc($id)));
        $this->assertSame(['Google Analytics 4', 'statistics', 'extension'], [$this->request->request->get('title'), $this->request->request->get('category'), $this->request->request->get('loading')]);

        $this->post(['title' => 'My videos']);
        $this->callbacks()->applyTemplate('youtube', $this->dc($id));
        $this->assertSame(['My videos', 'functional', 'page'], [$this->request->request->get('title'), $this->request->request->get('category'), $this->request->request->get('loading')], 'an own name stays');
    }

    public function testTheSameTemplateAgainChangesNothing(): void
    {
        $id = $this->add(['template' => 'ga4']);
        $this->post(['title' => '', 'category' => 'marketing']);

        $this->callbacks()->applyTemplate('ga4', $this->dc($id));

        $this->assertSame(['', 'marketing'], [$this->request->request->get('title'), $this->request->request->get('category')]);
    }

    public function testNamesPerLanguageAreStoredAsPlainText(): void
    {
        $id = $this->add(['template' => 'ai-chat']);
        $this->post(['ncc_tr' => [
            'de' => ['title' => '<b>Chat</b>-Hilfe', 'purpose' => ' Beantwortet Fragen. <script>x()</script>'],
            'en' => ['title' => '', 'purpose' => ''],
            'fr' => ['title' => 'Pas une langue du site'],
        ]]);

        $this->callbacks()->saveTranslations($this->dc($id));

        $this->assertSame(['de' => ['title' => 'Chat-Hilfe', 'purpose' => 'Beantwortet Fragen. x()']], unserialize((string) $this->db->fetchOne('SELECT translations FROM '.ServiceRepository::TABLE.' WHERE id = ?', [$id])));
    }

    public function testEmptyTranslationsRemoveTheField(): void
    {
        $id = $this->add(['translations' => serialize(['de' => ['title' => 'Alt', 'purpose' => '']])]);
        $this->post(['ncc_tr' => ['de' => ['title' => '', 'purpose' => '']]]);

        $this->callbacks()->saveTranslations($this->dc($id));

        $this->assertNull($this->db->fetchOne('SELECT translations FROM '.ServiceRepository::TABLE.' WHERE id = ?', [$id]));
    }

    /** @param array<string, mixed> $values */
    private function post(array $values): void
    {
        $this->request->request->replace($values);
    }

    /** @param array<string, mixed> $values */
    private function add(array $values): int
    {
        $this->db->insert(ServiceRepository::TABLE, $values + ['tstamp' => 1]);

        return (int) $this->db->lastInsertId();
    }

    /** @param array<string, mixed>|null $record */
    private function dc(int $id, array|null $record = null): DataContainer
    {
        $dc = $this->createMock(DataContainer::class);
        $dc->method('__get')->willReturnCallback(static fn (string $key): mixed => 'id' === $key ? $id : null);
        $dc->method('getCurrentRecord')->willReturn($record);

        return $dc;
    }

    private function callbacks(): ServiceCallbacks
    {
        $stack = new RequestStack();
        $stack->push($this->request);
        $locales = $this->createMock(Locales::class);
        $locales->method('getLanguages')->willReturn(['de' => 'German', 'en' => 'English', 'fr' => 'French']);

        return new ServiceCallbacks(new ServiceCatalog(), new Settings($this->db), new Texts($this->db, Translations::translator()), $this->db, $this->createMock(Security::class), $locales, new RequestInput($stack));
    }
}
