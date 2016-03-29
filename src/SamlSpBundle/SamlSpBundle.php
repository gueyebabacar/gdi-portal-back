<?php

namespace SamlSpBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SamlSpBundle extends Bundle
{
    public function getParent()
    {
        return 'AerialShipSamlSPBundle';
    }
}
