<?php

namespace Rabble\AdminBundle\Ui;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Webmozart\Assert\Assert;

abstract class AbstractUiComponent implements UiInterface
{
    protected $options;
    protected static $template;
    protected $templateParams;

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
        if (is_array($this->templateParams)) {
            $templateParams = $this->templateParams;
        }
        $template = $this->options['template'] ?? static::$template;
        Assert::notNull($template, 'Expected UI component to have a template property or option that is not null.');

        return $twig->render($template, $templateParams);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
    }

    private function configureLocalOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('template', null);
        $resolver->setAllowedTypes('template', ['null', 'string']);
    }
}
