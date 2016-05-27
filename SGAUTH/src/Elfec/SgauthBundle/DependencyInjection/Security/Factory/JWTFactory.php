<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 01/07/2015
 * Time: 09:53 AM
 */

namespace Elfec\SgauthBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;


class JWTFactory implements SecurityFactoryInterface
{

    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.jwt.'.$id;
//        var_dump($id);die();
        $container
            ->setDefinition($providerId, new DefinitionDecorator('jwt.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
        ;
//          var_dump($id);die();
        $listenerId = 'security.authentication.listener.jwt.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('jwt.security.authentication.listener'));
        $entryPointId = $defaultEntryPoint;
        return array($providerId, $listenerId, $entryPointId);
    }

    /**
     * Defines the position at which the provider is called.
     * Possible values: pre_auth, form, http, and remember_me.
     *
     * @return string
     */
    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'jwt';
    }

    public function addConfiguration(NodeDefinition $builder)
    {
        // TODO: Implement addConfiguration() method.
    }


}