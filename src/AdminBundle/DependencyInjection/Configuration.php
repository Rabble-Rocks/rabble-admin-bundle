<?php

namespace Rabble\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('rabble_admin');
        $root = $builder->getRootNode();
        $root
            ->children()
            ->arrayNode('enabled_locales')
            ->prototype('scalar')->end()
            ->defaultValue([])
            ->end()
        ;

        return $builder;
    }
}
