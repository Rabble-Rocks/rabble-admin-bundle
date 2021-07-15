<?php

namespace Rabble\AdminBundle\DependencyInjection;

use Rabble\AdminBundle\EventListener\RouterContextSubscriber;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class RabbleAdminExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new XmlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');
        $container->setParameter('rabble_admin.locales', $config['enabled_locales']);
        $container->setParameter('rabble_admin.content_locale_key', RouterContextSubscriber::CONTENT_LOCALE_KEY);
    }

    public function prepend(ContainerBuilder $container)
    {
        $this->prependLiipImagine($container);
        $this->prependStofDoctrineExtensions($container);
        $this->prependTwig($container);
    }

    private function prependLiipImagine(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('liip_imagine', [
            'filter_sets' => [
                'rabble_square' => [
                    'quality' => 75,
                    'filters' => [
                        'thumbnail' => [
                            'size' => [200, 200],
                            'mode' => 'outbound',
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function prependStofDoctrineExtensions(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('stof_doctrine_extensions', [
            'orm' => [
                'default' => [
                    'timestampable' => true,
                ],
            ],
        ]);
    }

    private function prependTwig(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('twig', [
            'form_themes' => ['bootstrap_5_layout.html.twig'],
        ]);
    }
}
