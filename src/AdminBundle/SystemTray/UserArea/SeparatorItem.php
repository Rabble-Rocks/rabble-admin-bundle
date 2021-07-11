<?php

namespace Rabble\AdminBundle\SystemTray\UserArea;

use Twig\Environment;

class SeparatorItem implements UserAreaItemInterface
{
    public function render(Environment $environment): string
    {
        return $environment->render('@RabbleAdmin/SystemTray/UserArea/separator.html.twig');
    }
}
