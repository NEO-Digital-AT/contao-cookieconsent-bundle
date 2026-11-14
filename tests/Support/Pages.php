<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Support;

use Contao\PageModel;
use PHPUnit\Framework\TestCase;

/** Page models as Contao hands them to the front end, without a database. */
final class Pages
{
    /** @param array<string, mixed> $properties */
    public static function page(TestCase $test, array $properties): PageModel
    {
        $page = (new \ReflectionMethod($test, 'createMock'))->invoke($test, PageModel::class);
        $page->method('__get')->willReturnCallback(static fn (string $key): mixed => $properties[$key] ?? null);
        $page->method('__isset')->willReturnCallback(static fn (string $key): bool => isset($properties[$key]));
        $page->method('loadDetails')->willReturnSelf();

        return $page;
    }
}
