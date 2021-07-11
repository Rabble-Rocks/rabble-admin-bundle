<?php

namespace Rabble\AdminBundle\Routing;

use Rabble\AdminBundle\Routing\Event\RoutingEvent;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class AdminRouteLoader extends Loader
{
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function load($resource, string $type = null)
    {
        $routes = new RouteCollection();
        $event = $this->eventDispatcher->dispatch(new RoutingEvent(), 'rabble_admin.routing.load');
        foreach ($event->getResources() as $type => $resources) {
            foreach ($resources as $resource) {
                $routes->addCollection($this->import($resource, $type));
            }
        }

        return $routes;
    }

    public function supports($resource, string $type = null)
    {
        return 'rabble_admin' === $type;
    }
}
