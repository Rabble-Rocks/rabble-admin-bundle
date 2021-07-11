<?php

namespace Rabble\AdminBundle\SystemTray;

use Twig\Environment;

abstract class AbstractSystemTrayItem implements SystemTrayItemInterface
{
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getWeight(): int
    {
        return 0;
    }
}
