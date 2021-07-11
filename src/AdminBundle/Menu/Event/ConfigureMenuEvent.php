<?php

namespace Rabble\AdminBundle\Menu\Event;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\Event;

class ConfigureMenuEvent extends Event
{
    private ItemInterface $rootItem;

    private FactoryInterface $factory;

    private RequestStack $requestStack;

    public function __construct(ItemInterface $rootItem, FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->rootItem = $rootItem;
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    public function getRootItem(): ItemInterface
    {
        return $this->rootItem;
    }

    public function getFactory(): FactoryInterface
    {
        return $this->factory;
    }

    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }
}
