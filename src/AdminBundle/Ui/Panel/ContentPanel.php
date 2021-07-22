<?php

namespace Rabble\AdminBundle\Ui\Panel;

use Rabble\AdminBundle\Ui\AbstractUiComponent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentPanel extends AbstractUiComponent
{
    protected static string $template = '@RabbleAdmin/Ui/Panel/contentPanel.html.twig';

    public function getAttributes(): array
    {
        return $this->options['attributes'];
    }

    public function setAttributes(array $attributes): void
    {
        $this->options['attributes'] = $attributes;
    }

    public function addAttribute($key, $value): void
    {
        $this->options['attributes'][$key] = $value;
    }

    public function getNoContainer(): bool
    {
        return $this->options['no_container'];
    }

    public function setNoContainer(bool $noContainer): void
    {
        $this->options['no_container'] = $noContainer;
    }

    public function getContent(): string
    {
        return $this->options['content'];
    }

    public function setContent(string $content): void
    {
        $this->options['content'] = $content;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('attributes', []);
        $resolver->setDefault('no_container', false);
        $resolver->setRequired(['content']);
        $resolver->setAllowedTypes('attributes', ['array']);
        $resolver->setAllowedTypes('no_container', ['bool']);
        $resolver->setAllowedTypes('content', ['string']);
    }
}
