<?php

namespace Rabble\AdminBundle\SystemTray\UserArea;

use Twig\Environment;

interface UserAreaItemInterface
{
    public function render(Environment $environment): string;
}
