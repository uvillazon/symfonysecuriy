<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 01/07/2015
 * Time: 10:03 AM
 */

namespace Elfec\SgauthBundle\Security\Authentication\Provider;


use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Elfec\SgauthBundle\Security\Authentication\Token\JWTUserToken;
use Symfony\Component\Security\Core\Util\StringUtils;

class JWTProvider implements AuthenticationProviderInterface
{

    private $userProvider;
    private $cacheDir;

    public function __construct(UserProviderInterface $userProvider, $cacheDir) {
        $this->userProvider = $userProvider;
        $this->cacheDir = $cacheDir;
    }


    /**
     * Checks whether this provider supports the given token.
     *
     * @param TokenInterface $token A TokenInterface instance
     *
     * @return bool true if the implementation supports the Token, false otherwise
     */
    public function supports(TokenInterface $token)
    {
        // TODO: Implement supports() method.
    }

    public function authenticate(TokenInterface $token)
    {
        // TODO: Implement authenticate() method.
    }
}