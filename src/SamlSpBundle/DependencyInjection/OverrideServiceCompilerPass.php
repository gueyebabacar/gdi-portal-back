<?php

namespace SamlSpBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideServiceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('security.authentication.provider.aerial_ship_saml_sp');
        $definition->setClass('SamlSpBundle\Security\Core\Authentication\Provider\SamlSpAuthenticationProvider');
    }
}
