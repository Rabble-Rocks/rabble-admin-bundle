<?php

namespace Rabble\AdminBundle\SystemTray;

interface SystemTrayItemInterface
{
    public function render(): string;

    public function getWeight(): int;
}
