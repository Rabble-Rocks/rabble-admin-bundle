<?php

namespace Rabble\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SearchPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $searchManagerDef = $container->findDefinition('rabble_admin.search.search_manager');
        foreach ($container->findTaggedServiceIds('rabble_admin.search_provider') as $id => $tags) {
            $searchManagerDef->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
