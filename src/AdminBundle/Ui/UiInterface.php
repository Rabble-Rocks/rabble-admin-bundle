<?php

namespace Rabble\AdminBundle\Ui;

use Twig\Environment;

interface UiInterface
{
    public function render(Environment $twig): string;
}
