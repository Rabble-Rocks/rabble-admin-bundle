<?php

namespace Rabble\AdminBundle\Menu;

use Knp\Menu\ItemInterface;
use Rabble\AdminBundle\Menu\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getRootItem();
        $menu->addChild('dashboard', [
            'label' => 'menu.dashboard',
            'route' => 'rabble_admin_dashboard',
            'extras' => [
                'translation_domain' => 'RabbleAdminBundle',
                'icon' => 'ti-home',
                'icon_color' => 'blue',
            ],
        ]);
        $menu->addChild('settings', [
            'label' => 'menu.settings',
            'uri' => '#',
            'display' => false,
            'extras' => [
                'translation_domain' => 'RabbleAdminBundle',
                'icon' => 'ti-settings',
                'icon_color' => 'grey-600',
                'weight' => 256,
                'routes' => [],
            ],
        ]);
    }

    public function onLateMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getRootItem();
        $children = $menu->getChildren();
        usort($children, function (ItemInterface $a, ItemInterface $b) {
            $weightA = (int) $a->getExtra('weight', 0);
            $weightB = (int) $b->getExtra('weight', 0);
            if ($weightA === $weightB) {
                return 0;
            }

            return $weightA < $weightB ? -1 : 1;
        });
        $menu->reorderChildren(array_map(function (ItemInterface $child) { return $child->getName(); }, $children));
    }
}
