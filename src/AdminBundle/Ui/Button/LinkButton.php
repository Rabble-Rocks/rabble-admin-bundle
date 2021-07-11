<?php

namespace Rabble\AdminBundle\Ui\Button;

use Rabble\AdminBundle\Ui\AbstractUiComponent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkButton extends AbstractUiComponent
{
    protected static $template = '@RabbleAdmin/Ui/Button/linkButton.html.twig';

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

    public function getUrl(): string
    {
        return $this->options['url'];
    }

    public function setUrl(string $url): void
    {
        $this->options['url'] = $url;
    }

    public function getLabel(): string
    {
        return $this->options['label'];
    }

    public function setLabel(string $label): void
    {
        $this->options['label'] = $label;
    }

    public function getButtonStyle(): string
    {
        return $this->options['button_style'];
    }

    public function setButtonStyle(string $buttonStyle): void
    {
        $this->options['button_style'] = $buttonStyle;
    }

    public function getButtonSize(): ?string
    {
        return $this->options['button_size'];
    }

    public function setButtonSize(?string $buttonSize): void
    {
        $this->options['button_size'] = $buttonSize;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('attributes', []);
        $resolver->setDefault('button_style', 'info');
        $resolver->setDefault('button_size', null);
        $resolver->setDefault('icon_left', null);
        $resolver->setDefault('icon_right', null);
        $resolver->setDefault('url', '#');
        $resolver->setRequired('label');
        $resolver->setDefault('is_label_html', false);
        $resolver->setAllowedTypes('attributes', ['array']);
        $resolver->setAllowedTypes('button_style', ['string']);
        $resolver->setAllowedTypes('icon_left', ['string', 'null']);
        $resolver->setAllowedTypes('icon_right', ['string', 'null']);
        $resolver->setAllowedValues('button_size', ['sm', 'lg', null]);
        $resolver->setAllowedTypes('url', ['string']);
        $resolver->setAllowedTypes('label', ['string']);
        $resolver->setAllowedTypes('is_label_html', ['bool']);
    }
}
