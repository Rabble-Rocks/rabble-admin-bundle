<?php

namespace Rabble\AdminBundle\Menu\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;

class ChildrenVoter implements VoterInterface
{
    private MatcherInterface $matcher;

    public function __construct(MatcherInterface $matcher)
    {
        $this->matcher = $matcher;
    }

    public function matchItem(ItemInterface $item): ?bool
    {
        if ($item->hasChildren()) {
            foreach ($item->getChildren() as $child) {
                if (true === $this->matcher->isCurrent($child)) {
                    return true;
                }
            }
        }

        return null;
    }
}
