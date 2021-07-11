<?php

namespace Rabble\AdminBundle\Ui\Section;

use Rabble\AdminBundle\Ui\AbstractUiComponent;
use Rabble\AdminBundle\Ui\UiInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionRow extends AbstractUiComponent
{
    protected static $template = '@RabbleAdmin/Ui/Section/actionRow.html.twig';

    public function getItems(): array
    {
        return $this->options['items'];
    }

    public function setItems(array $items): void
    {
        $this->options['items'] = $items;
    }

    public function addItem(UiInterface $item): void
    {
        $this->options['items'][] = $item;
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
        $resolver->setDefault('items', []);
        $resolver->setDefault('container_classes', ['mx-auto', 'd-block']);
        $resolver->setAllowedTypes('items', ['array']);
        $resolver->setAllowedTypes('container_classes', ['array']);
    }
}
