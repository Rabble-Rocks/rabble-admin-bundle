<?php

namespace Rabble\AdminBundle\DependencyInjection\Compiler;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Reference;

class EntityImplementationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $targetEntityListenerId = 'doctrine.orm.listeners.resolve_target_entity';
        $targetEntityListenerDef = $container->findDefinition($targetEntityListenerId);
        $taggedServices = $container->findTaggedServiceIds('rabble.entity_implementation');

        $entityImplementations = $container->setDefinition('rabble.entity_implementations', new Definition(ArrayCollection::class));

        $prioritizedServices = [];
        foreach ($taggedServices as $id => $tags) {
            $def = $container->findDefinition($id);
            if (!$def->isAbstract()) {
                throw new LogicException('Services tagged with rabble.entity_implementation must be abstract');
            }
            foreach ($tags as $tag) {
                if (!isset($tag['as'])) {
                    throw new LogicException('Services tagged with rabble.entity_implementation should have an \'as\' property');
                }
                $priority = $tag['priority'] ?? 0;
                $prioritizedServices[$priority][] = [
                    'class' => $def->getClass(),
                    'as' => $tag['as'],
                ];
            }
        }
        krsort($prioritizedServices);

        if (!$targetEntityListenerDef->hasTag('doctrine.event_subscriber')) {
            $container->findDefinition('doctrine.dbal.connection.event_manager')->addMethodCall('addEventSubscriber', [new Reference($targetEntityListenerId)]);
        }
        foreach ($prioritizedServices as $services) {
            foreach ($services as $service) {
                $entityImplementations->addMethodCall('set', [$service['as'], $service['class']]);
                $targetEntityListenerDef->addMethodCall('addResolveTargetEntity', [$service['as'], $service['class'], []]);
            }
        }
    }
}
