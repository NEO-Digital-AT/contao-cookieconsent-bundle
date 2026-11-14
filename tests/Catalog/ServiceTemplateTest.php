<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Catalog;

use Neo\CookieconsentBundle\Catalog\ServiceCatalog;
use Neo\CookieconsentBundle\Catalog\ServiceTemplate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceTemplate::class)]
final class ServiceTemplateTest extends TestCase
{
    public function testLoaderGetsAValidId(): void
    {
        $ga4 = (new ServiceCatalog())->get('ga4');

        $this->assertNotNull($ga4);
        $loader = $ga4->loaderFor('G-ABC123DEF4');

        $this->assertStringContainsString('gtag/js?id=G-ABC123DEF4', $loader);
        $this->assertStringContainsString('gtag("config","G-ABC123DEF4")', $loader);
        $this->assertStringNotContainsString('{id}', $loader);
    }

    /** @return iterable<string, array{string}> */
    public static function invalidIds(): iterable
    {
        yield 'empty' => [''];
        yield 'quote and tag' => ['G-ABC1"></script><script>alert(1)</script>'];
        yield 'lower case' => ['g-abc1234'];
        yield 'wrong prefix' => ['UA-1234567'];
    }

    #[DataProvider('invalidIds')]
    public function testAnInvalidIdGivesNoCode(string $id): void
    {
        $ga4 = (new ServiceCatalog())->get('ga4');

        $this->assertFalse($ga4->validId($id));
        $this->assertSame('', $ga4->loaderFor($id));
    }

    public function testASelfHostedServiceNeedsAnHttpsAddress(): void
    {
        $matomo = (new ServiceCatalog())->get('matomo');

        $this->assertTrue($matomo->needsUrl);
        $this->assertSame('', $matomo->loaderFor('3', ''));
        $this->assertSame('', $matomo->loaderFor('3', 'http://stats.example.com/'));
        $this->assertSame('', $matomo->loaderFor('3', 'javascript:alert(1)'));
        $this->assertSame('', $matomo->loaderFor('3', 'https://stats.example.com/"+alert(1)+"'));
        $this->assertSame('', $matomo->loaderFor('3', 'https://stats.example.com/?a=1'));

        $loader = $matomo->loaderFor('3', 'https://stats.example.com/matomo');
        $this->assertStringContainsString('var u="https://stats.example.com/matomo/"', $loader);
        $this->assertStringContainsString('_paq.push(["setSiteId","3"])', $loader);
    }

    public function testATemplateWithoutLoaderCannotLoad(): void
    {
        $catalog = new ServiceCatalog();

        $this->assertTrue($catalog->get('ga4')->canLoad());
        $this->assertFalse($catalog->get('youtube')->canLoad());
        $this->assertTrue($catalog->get('youtube')->isEmbed());
        $this->assertFalse($catalog->get('ga4')->isEmbed());
        $this->assertSame([], $catalog->get('youtube')->patterns('link'));
    }
}
