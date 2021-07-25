<?php

namespace Rabble\AdminBundle\Routing;

use Rabble\AdminBundle\Routing\Event\RoutingEvent;

class RoutingListener
{
    public function onRoutingLoad(RoutingEvent $event)
    {
        $event->addResources('xml', [
            '@RabbleAdminBundle/Resources/config/routing.xml',
            '@FOSJsRoutingBundle/Resources/config/routing/routing.xml',
        ]);
    }
}
