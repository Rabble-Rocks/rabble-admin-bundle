<?php

namespace Rabble\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Rabble\AdminBundle\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class AdminMenuBuilder
{
    private EventDispatcherInterface $eventDispatcher;

    private FactoryInterface $factory;

    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $factory)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->factory = $factory;
    }

    /**
     * Builds the Rabble Admin side menu.
     *
     * @return ItemInterface
     */
    public function buildSideMenu(RequestStack $requestStack)
    {
        $this->eventDispatcher->dispatch(
            new ConfigureMenuEvent(
                $menu = $this->factory->createItem('root', [
                    'childrenAttributes' => [
                        'class' => 'sidebar-menu scrollable pos-r pT-30',
                    ],
                ]),
                $this->factory,
                $requestStack
            ),
            'rabble_admin.menu_configure'
        );

        return $menu;
    }
}
