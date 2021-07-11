<?php

namespace Rabble\AdminBundle\SystemTray;

interface SystemTrayInterface
{
    public function addItem(SystemTrayItemInterface $item): void;

    public function render(): string;
}
