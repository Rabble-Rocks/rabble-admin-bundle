<?php

namespace Rabble\AdminBundle\Ui\Panel;

use Rabble\AdminBundle\Ui\AbstractUiComponent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TabbedPanel extends AbstractUiComponent
{
    protected static string $template = '@RabbleAdmin/Ui/Panel/tabbedPanel.html.twig';

    public function getTabs(): array
    {
        return $this->options['tabs'];
    }

    public function setTabs(array $tabs): void
    {
        $this->options['tabs'] = $tabs;
    }

    public function addTab(Tab $tab): void
    {
        $this->options['tabs'][] = $tab;
    }

    public function getContainerClasses(): array
    {
        return $this->options['container_classes'];
    }

    public function setContainerClasses(array $containerClasses): void
    {
        $this->options['container_classes'] = $containerClasses;
    }

    public function addContainerClass(string $class): void
    {
        $this->options['container_classes'][] = $class;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(['tabs']);
        $resolver->setDefault('name', uniqid('tabbed-panel-', false));
        $resolver->setDefault('container_classes', []);
        $resolver->setAllowedTypes('container_classes', ['array']);
        $resolver->setAllowedTypes('tabs', ['array']);
        $resolver->setAllowedTypes('name', ['string']);
    }
}
