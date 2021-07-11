<?php

namespace Rabble\AdminBundle\DependencyInjection\Compiler;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AdminBuildersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->setDefinition('rabble_admin.admin_builders', $definition = new Definition(ArrayCollection::class));
        foreach ($container->findTaggedServiceIds('rabble_admin.admin_builder') as $id => $tags) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
