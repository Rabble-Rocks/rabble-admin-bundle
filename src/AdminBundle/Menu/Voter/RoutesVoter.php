<?php

namespace Rabble\AdminBundle\Menu\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RoutesVoter implements VoterInterface
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function matchItem(ItemInterface $item): ?bool
    {
        $routes = $item->getExtra('routes', []);
        $request = $this->requestStack->getCurrentRequest();
        if (!is_array($routes) || null === $request || !in_array($request->attributes->get('_route'), $routes, true)) {
            return null;
        }

        return true;
    }
}
