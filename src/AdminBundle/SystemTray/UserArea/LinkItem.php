<?php

namespace Rabble\AdminBundle\SystemTray\UserArea;

use Twig\Environment;

class LinkItem implements UserAreaItemInterface
{
    private string $label;

    private string $route;

    private array $routeParameters;

    private ?string $icon;

    private ?string $target;

    public function __construct(
        string $label,
        string $route,
        array $routeParameters = [],
        ?string $icon = null,
        ?string $target = null
    ) {
        $this->label = $label;
        $this->route = $route;
        $this->routeParameters = $routeParameters;
        $this->icon = $icon;
        $this->target = $target;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    public function getRouteParameters(): array
    {
        return $this->routeParameters;
    }

    public function setRouteParameters(array $routeParameters): void
    {
        $this->routeParameters = $routeParameters;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): void
    {
        $this->target = $target;
    }

    public function render(Environment $environment): string
    {
        return $environment->render('@RabbleAdmin/SystemTray/UserArea/link.html.twig', [
            'label' => $this->label,
            'route' => $this->route,
            'routeParameters' => $this->routeParameters,
            'icon' => $this->icon,
            'target' => $this->target,
        ]);
    }
}
