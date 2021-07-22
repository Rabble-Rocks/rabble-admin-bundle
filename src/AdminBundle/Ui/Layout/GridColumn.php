<?php

namespace Rabble\AdminBundle\Ui\Layout;

use Rabble\AdminBundle\Ui\AbstractUiComponent;
use Rabble\AdminBundle\Ui\UiInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

class GridColumn extends AbstractUiComponent
{
    protected static string $template = '@RabbleAdmin/Ui/Layout/gridColumn.html.twig';

    public function setOption($option, $value): void
    {
        $resolver = new OptionsResolver();
        $this->configureLocalOptions($resolver);
        $this->configureOptions($resolver);
        $options = $this->options;
        $options[$option] = $value;
        $this->options = $resolver->resolve($options);
    }

    public function render(Environment $twig): string
    {
        $this->templateParams = $this->options;
        $this->templateParams['is_string'] = is_string($this->options['content']);

        return parent::render($twig);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attributes' => [],
            'defaultWidth' => 12,
            'extraLargeWidth' => null,
            'largeWidth' => null,
            'mediumWidth' => null,
            'smallWidth' => null,
        ]);
        $widths = array_merge([null], range(1, 12));

        $resolver->setAllowedValues('defaultWidth', range(1, 12));
        $resolver->setAllowedValues('extraLargeWidth', $widths);
        $resolver->setAllowedValues('largeWidth', $widths);
        $resolver->setAllowedValues('mediumWidth', $widths);
        $resolver->setAllowedValues('smallWidth', $widths);

        $resolver->setRequired('content');

        $resolver->setAllowedTypes('content', ['string', UiInterface::class]);
        $resolver->setAllowedTypes('attributes', ['array']);
    }
}
