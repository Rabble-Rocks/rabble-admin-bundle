<?php

namespace Rabble\AdminBundle\Builder;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface AdminBuilderInterface
{
    public function build(string $env, InputInterface $input, OutputInterface $output): void;
}
