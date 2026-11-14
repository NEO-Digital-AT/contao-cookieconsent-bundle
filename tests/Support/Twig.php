<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\Tests\Support;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/** Twig with the templates of this bundle under @Contao, as Contao registers them. */
final class Twig
{
    public static function environment(): Environment
    {
        $loader = new FilesystemLoader();
        $loader->addPath(__DIR__.'/../../contao/templates', 'Contao');

        return new Environment($loader, ['strict_variables' => true]);
    }
}
