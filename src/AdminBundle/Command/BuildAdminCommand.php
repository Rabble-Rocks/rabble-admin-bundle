<?php

namespace Rabble\AdminBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

class BuildAdminCommand extends Command
{
    private const ALLOWED_ENVS = ['dev', 'prod', 'test'];

    protected static $defaultName = 'rabble:admin:build';
    private ArrayCollection $adminBuilders;

    public function __construct(ArrayCollection $adminBuilders)
    {
        $this->adminBuilders = $adminBuilders;
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('environment', InputArgument::OPTIONAL, 'Environment for building', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $input->getArgument('environment') ?? $input->getOption('env');
        Assert::inArray($env, self::ALLOWED_ENVS, 'Invalid environment. Allowed environments: %2$s');
        foreach ($this->adminBuilders as $adminBuilder) {
            $adminBuilder->build($env, $input, $output);
        }

        return 0;
    }
}
