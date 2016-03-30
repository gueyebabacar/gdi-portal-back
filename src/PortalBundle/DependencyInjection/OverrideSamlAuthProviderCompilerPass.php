<?php

namespace PortalBundle\DependencyInjection;

use PortalBundle\Security\SamlSp\SamlSpAuthenticationProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideSamlAuthProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('security.authentication.provider.aerial_ship_saml_sp');
        $definition->setClass(SamlSpAuthenticationProvider::class);
    }
}
