<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Consent;

use Neo\CookieconsentBundle\Consent\Texts;
use Neo\CookieconsentBundle\Tests\Support\TestDatabase;
use Neo\CookieconsentBundle\Tests\Support\Translations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Texts::class)]
final class TextsTest extends TestCase
{
    public function testOwnTextsOfALanguageWinOverTheDefaults(): void
    {
        $db = TestDatabase::create(Texts::TABLE);
        $db->insert(Texts::TABLE, ['tstamp' => 1, 'language' => 'de', 'banner_title' => 'Eigener Titel', 'btn_accept' => '  ', 'privacy_page' => 12]);
        $db->insert(Texts::TABLE, ['tstamp' => 0, 'language' => 'fr', 'banner_title' => 'Brouillon']);
        $texts = new Texts($db, Translations::translator());

        $de = $texts->forLanguage('de_AT');
        $this->assertSame('Eigener Titel', $de['banner_title']);
        $this->assertSame($texts->default('btn_accept', 'de'), $de['btn_accept']);
        $this->assertNotSame('Accept all', $de['btn_accept']);
        $this->assertSame(Texts::KEYS, array_keys($de));

        $this->assertNotSame('Brouillon', $texts->forLanguage('fr')['banner_title'], 'a draft of the back end');
        $this->assertSame(['privacy' => 12, 'imprint' => 0], $texts->pages('de'));
        $this->assertSame(['privacy' => 0, 'imprint' => 0], $texts->pages('en'));
    }

    public function testEveryLanguageHasEveryText(): void
    {
        $texts = new Texts(TestDatabase::create(), Translations::translator());

        foreach (Texts::LANGUAGES as $language) {
            foreach ($texts->forLanguage($language) as $key => $text) {
                $this->assertNotSame('text.'.$key, $text, $language.': '.$key);
                $this->assertNotSame('', $text, $language.': '.$key);
            }
        }
    }

    public function testAnotherLanguageFallsBackToEnglish(): void
    {
        $texts = new Texts(TestDatabase::create(), Translations::translator());

        $this->assertSame('Accept all', $texts->forLanguage('sv')['btn_accept']);
        $this->assertSame('AI chat assistant', $texts->trans('name.ai-chat', 'pt-BR'));
    }

    public function testDurationsInWords(): void
    {
        $texts = new Texts(TestDatabase::create(), Translations::translator());

        $this->assertNotSame('2y', $texts->duration('2y', 'en'));
        $this->assertNotSame('duration.2y', $texts->duration('2y', 'en'));
        $this->assertSame('3 weeks', $texts->duration('3 weeks', 'en'), 'free text as entered');
    }

    public function testPrimaryLanguage(): void
    {
        $this->assertSame('de', Texts::primary('de_AT'));
        $this->assertSame('de', Texts::primary('DE-at'));
        $this->assertSame('en', Texts::primary(''));
    }
}
