<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Backend;

use Neo\CookieconsentBundle\Backend\CreditNote;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreditNote::class)]
final class CreditNoteTest extends TestCase
{
    public function testTheNameBecomesTheLink(): void
    {
        $this->assertSame(
            'Cookie banner: NEO Cookie Consent by <a href="https://neo-digital.at" rel="nofollow">NEO Digital</a>',
            CreditNote::html('Cookie banner: NEO Cookie Consent by NEO Digital'),
        );
    }

    public function testTheLinkIsAppendedWhenTheTextDoesNotNameIt(): void
    {
        $this->assertSame('Cookie banner &lt;b&gt; – <a href="https://neo-digital.at" rel="nofollow">NEO Digital</a>', CreditNote::html('Cookie banner <b>'));
    }

    public function testTheNoteEscapesItsTextsAndShowsTheHtmlAsSource(): void
    {
        $html = CreditNote::render('Free <b>with</b> credit', 'As text', 'As HTML', 'Built with NEO Digital');

        $this->assertStringContainsString('<p class="tl_info" style="margin:0 0 10px">Free &lt;b&gt;with&lt;/b&gt; credit</p>', $html);
        $this->assertStringContainsString('Built with <a href="https://neo-digital.at" rel="nofollow noopener" target="_blank" style="text-decoration:underline">NEO Digital</a>', $html);
        $this->assertStringContainsString('Built with &lt;a href=&quot;https://neo-digital.at&quot; rel=&quot;nofollow&quot;&gt;NEO Digital&lt;/a&gt;</pre>', $html);
    }

    public function testTheTextsComeFromTheLanguageFileOfTheTable(): void
    {
        $GLOBALS['TL_LANG']['tl_test'] = ['licence_text' => 'Condition', 'licence_example_label' => 'Text', 'licence_html_label' => 'HTML', 'licence_example' => 'Banner by NEO Digital'];

        try {
            $this->assertSame(CreditNote::render('Condition', 'Text', 'HTML', 'Banner by NEO Digital'), CreditNote::forTable('tl_test'));
        } finally {
            unset($GLOBALS['TL_LANG']['tl_test']);
        }
    }
}
