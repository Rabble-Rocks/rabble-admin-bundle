<?php

namespace Rabble\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SystemTrayPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $systemTrayDefinition = $container->findDefinition('rabble_admin.system_tray');
        foreach ($container->findTaggedServiceIds('rabble_admin.system_tray_item') as $id => $tags) {
            $systemTrayDefinition->addMethodCall('addItem', [new Reference($id)]);
        }
    }
}
