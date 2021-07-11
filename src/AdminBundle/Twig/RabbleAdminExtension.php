<?php

namespace Rabble\AdminBundle\Twig;

use Rabble\AdminBundle\SystemTray\SystemTrayInterface;
use Rabble\AdminBundle\Ui\UiInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

class RabbleAdminExtension extends AbstractExtension implements GlobalsInterface
{
    private SystemTrayInterface $systemTray;
    private array $locales;

    public function __construct(
        SystemTrayInterface $systemTray,
        array $locales
    ) {
        $this->systemTray = $systemTray;
        $this->locales = $locales;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('rabble_admin_system_tray', [$this, 'systemTray'], ['is_safe' => ['html']]),
            new TwigFunction('rabble_admin_ui', [$this, 'renderUiComponent'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    public function systemTray(): string
    {
        return $this->systemTray->render();
    }

    public function renderUiComponent(Environment $environment, UiInterface $ui): string
    {
        return $ui->render($environment);
    }

    public function getGlobals(): array
    {
        return [
            'rabble_locales' => $this->locales,
        ];
    }
}
