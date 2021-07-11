<?php

namespace Rabble\AdminBundle\Ui\Event;

use Rabble\AdminBundle\Ui\UiInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractUiEvent extends Event
{
    /** @var UiInterface[][] */
    private array $panes = [];

    public function __construct($panes = [])
    {
        foreach ($panes as $name => $namedPanes) {
            if (!is_array($namedPanes)) {
                $this->addPane($namedPanes);
            } else {
                $this->panes[$name] = $namedPanes;
            }
        }
    }

    public function addPane(UiInterface $pane, string $name = 'default'): void
    {
        if (!isset($this->panes[$name])) {
            $this->panes[$name] = [];
        }
        $this->panes[$name][] = $pane;
    }

    /**
     * @return UiInterface[][]
     */
    public function getPanes(): array
    {
        return $this->panes;
    }

    /**
     * @return UiInterface[]
     */
    public function getPanesFlattened(): array
    {
        $panes = [];
        foreach ($this->panes as $namedPanes) {
            foreach ($namedPanes as $pane) {
                $panes[] = $pane;
            }
        }

        return $panes;
    }

    public function clear(): void
    {
        $this->panes = [];
    }
}
