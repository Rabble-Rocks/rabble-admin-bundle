<?php

namespace Rabble\AdminBundle\Ui\Layout;

use Rabble\AdminBundle\Ui\AbstractUiComponent;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

class GridRow extends AbstractUiComponent
{
    protected static string $template = '@RabbleAdmin/Ui/Layout/gridRow.html.twig';

    public function addColumn(string $name, GridColumn $column)
    {
        $this->options['columns'][$name] = $column;
    }

    public function getColumn(string $name): GridColumn
    {
        return $this->options['columns'][$name];
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'columns' => [],
            'attributes' => [],
        ]);
        $resolver->setAllowedTypes('columns', ['array']);
        $resolver->setAllowedTypes('attributes', ['array']);
        $resolver->setNormalizer('columns', function (Options $options, array $columns) {
            foreach ($columns as $name => $column) {
                Assert::string($name);
                Assert::isInstanceOf($column, GridColumn::class);
            }

            return $columns;
        });
    }
}
