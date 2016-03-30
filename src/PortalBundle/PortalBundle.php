<?php

namespace PortalBundle;

use PortalBundle\DependencyInjection\OverrideSamlAuthProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PortalBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new OverrideSamlAuthProviderCompilerPass());
    }
}
