<?php

declare(strict_types=1);

namespace Neo\CookieconsentBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Neo\BasicBundle\NeoBasicBundle;
use Neo\CookieconsentBundle\NeoCookieconsentBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;

/**
 * Contao Manager plugin: registers the bundle (after the Basic bundle, which
 * provides the menu group "neo") and its endpoint for the proof of consent.
 */
class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(NeoCookieconsentBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, NeoBasicBundle::class]),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel): ?RouteCollection
    {
        $file = __DIR__.'/../../config/routes.yaml';

        return $resolver->resolve($file)->load($file);
    }
}
