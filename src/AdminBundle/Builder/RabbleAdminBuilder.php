<?php

namespace Rabble\AdminBundle\Builder;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class RabbleAdminBuilder implements AdminBuilderInterface
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function build(string $env, InputInterface $input, OutputInterface $output): void
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $output->writeln('Dumping bundles.json file...');
        $application->run(new ArrayInput([
            'command' => 'rabble:admin:dump-bundles',
            '--env' => $input->getOption('env'),
        ]), $output);

        $output->writeln('Creating database...');
        $application->run(new ArrayInput([
            'command' => 'doctrine:database:create',
            '--if-not-exists' => true,
            '--env' => $input->getOption('env'),
        ]), $output);

        $output->writeln("\nUpdating database schema...");
        $application->run(new ArrayInput([
            'command' => 'doctrine:schema:update',
            '--force' => true,
            '--env' => $input->getOption('env'),
        ]), $output);
    }
}
