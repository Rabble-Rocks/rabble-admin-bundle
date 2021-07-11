<?php

namespace Rabble\AdminBundle\Routing\Event;

use Symfony\Contracts\EventDispatcher\Event;

class RoutingEvent extends Event
{
    /** @var string[][] */
    private array $resources = [];

    /**
     * @return string[]
     */
    public function getResources(?string $type = null): array
    {
        if (null !== $type) {
            return $this->resources[$type];
        }

        return $this->resources;
    }

    /**
     * @param string[] $resources
     */
    public function addResources(string $type, array $resources): void
    {
        if (!isset($this->resources[$type])) {
            $this->resources[$type] = [];
        }
        foreach ($resources as $resource) {
            $this->resources[$type][] = $resource;
        }
    }
}
