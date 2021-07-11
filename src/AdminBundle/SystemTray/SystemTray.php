<?php

namespace Rabble\AdminBundle\SystemTray;

/**
 * Contains a collection of system tray items to render in the system tray.
 */
class SystemTray implements SystemTrayInterface
{
    /** @var SystemTrayItemInterface[] */
    private array $items = [];

    public function addItem(SystemTrayItemInterface $item): void
    {
        if (!isset($this->items[$item->getWeight()])) {
            $this->items[$item->getWeight()] = [];
        }
        $this->items[$item->getWeight()][] = $item;
    }

    public function render(): string
    {
        ksort($this->items);
        $str = '';
        foreach ($this->items as $items) {
            foreach ($items as $item) {
                $str .= $item->render();
            }
        }

        return $str;
    }
}
