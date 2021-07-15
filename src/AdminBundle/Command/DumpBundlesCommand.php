<?php

namespace Rabble\AdminBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class DumpBundlesCommand extends Command
{
    protected static $defaultName = 'rabble:admin:dump-bundles';
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        parent::__construct();
        $this->kernel = $kernel;
    }

    protected function configure()
    {
        $this->addArgument('environment', InputArgument::OPTIONAL, 'Environment for building', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('lol');
        $data = [
            'bundles' => [],
        ];
        foreach ($this->kernel->getBundles() as $bundle) {
            $reflectionClass = new \ReflectionClass($bundle);
            $data['bundles'][$bundle->getName()] = dirname($reflectionClass->getFileName());
            $output->writeln(sprintf('<info>%s</info>', $bundle->getName()));
        }
        $filesystem = new Filesystem();
        $filename = $this->kernel->getProjectDir().DIRECTORY_SEPARATOR.'adminator'.DIRECTORY_SEPARATOR.'bundles.json';
        $filesystem->dumpFile($filename, json_encode($data, JSON_PRETTY_PRINT));

        return 0;
    }
}
