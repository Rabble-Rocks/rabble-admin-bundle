<?php

namespace Rabble\AdminBundle\Ui\Event;

use Rabble\AdminBundle\Ui\UiInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractSimpleUiEvent extends Event
{
    private ?UiInterface $pane;

    public function __construct($pane = null)
    {
        $this->pane = $pane;
    }

    public function getPane(): ?UiInterface
    {
        return $this->pane;
    }

    public function setPane(UiInterface $pane): void
    {
        $this->pane = $pane;
    }
}
