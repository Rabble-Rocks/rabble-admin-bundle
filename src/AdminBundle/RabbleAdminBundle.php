<?php

namespace Rabble\AdminBundle;

use Rabble\AdminBundle\DependencyInjection\Compiler\AdminBuildersPass;
use Rabble\AdminBundle\DependencyInjection\Compiler\EntityImplementationPass;
use Rabble\AdminBundle\DependencyInjection\Compiler\SearchPass;
use Rabble\AdminBundle\DependencyInjection\Compiler\SystemTrayPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RabbleAdminBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EntityImplementationPass());
        $container->addCompilerPass(new SystemTrayPass());
        $container->addCompilerPass(new SearchPass());
        $container->addCompilerPass(new AdminBuildersPass());
    }
}
