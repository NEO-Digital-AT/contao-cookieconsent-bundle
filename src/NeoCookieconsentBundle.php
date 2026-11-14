<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class NeoCookieconsentBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
