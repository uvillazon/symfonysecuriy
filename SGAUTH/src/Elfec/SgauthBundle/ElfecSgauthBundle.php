<?php

namespace Elfec\SgauthBundle;

use Elfec\SgauthBundle\DependencyInjection\Security\Factory\JWTFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ElfecSgauthBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);

        $extension = $container->getExtension('security');
//        var_dump($extension);die();
        $extension->addSecurityListenerFactory(new JWTFactory());
    }

}
