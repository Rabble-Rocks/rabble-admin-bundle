<?php

namespace Rabble\AdminBundle\Ui\Panel;

use Rabble\AdminBundle\Ui\AbstractUiComponent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Tab extends AbstractUiComponent
{
    protected static $template = '@RabbleAdmin/Ui/Panel/tab.html.twig';

    public function getLabel(): string
    {
        return $this->options['label'];
    }

    public function setLabel(string $label): void
    {
        $this->options['label'] = $label;
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
        $resolver->setRequired(['label', 'content']);
        $resolver->setAllowedTypes('label', ['string']);
        $resolver->setAllowedTypes('content', ['string']);
    }
}
