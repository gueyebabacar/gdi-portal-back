<?php

namespace SamlSpBundle;

use SamlSpBundle\DependencyInjection\OverrideServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SamlSpBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new OverrideServiceCompilerPass());
    }

    public function getParent()
    {
        return 'AerialShipSamlSPBundle';
    }
}
