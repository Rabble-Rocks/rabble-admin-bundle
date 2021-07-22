<?php

namespace Rabble\AdminBundle\Ui;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class AbstractUiComponent implements UiInterface
{
    protected array $options;
    protected static string $template;
    protected array $templateParams;

    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureLocalOptions($resolver);
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(Environment $twig): string
    {
        $templateParams = $this->options;
        if (isset($this->templateParams)) {
            $templateParams = $this->templateParams;
        }
        $template = $this->options['template'] ?? static::$template;

        return $twig->render($template, $templateParams);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
    }

    final protected function configureLocalOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('template', null);
        $resolver->setAllowedTypes('template', ['null', 'string']);
    }
}
