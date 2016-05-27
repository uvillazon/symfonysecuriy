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
    protected $jwtManager;
    protected $dispatcher;
    protected $userIdentityField;

    public function __construct(UserProviderInterface $userProvider, $cacheDir) {
//        var_dump($cacheDir);die();
        $this->userProvider = $userProvider;
        $this->cacheDir = $cacheDir;
    }
//    public function __construct(UserProviderInterface $userProvider, JWTManagerInterface $jwtManager, EventDispatcherInterface $dispatcher)
//    {
//        $this->userProvider      = $userProvider;
//        $this->jwtManager        = $jwtManager;
//        $this->dispatcher        = $dispatcher;
//        $this->userIdentityField = 'username';
//        var_dump($this->jwtManager);die();
//    }

//    /**
//     * {@inheritdoc}
//     */
//    public function authenticate(TokenInterface $token)
//    {
//        var_dump($token);die();
//        if (!($payload = $this->jwtManager->decode($token))) {
//            throw new AuthenticationException('Invalid JWT Token');
//        }
//
//        $user = $this->getUserFromPayload($payload);
//
//        $authToken = new JWTUserToken($user->getRoles());
//        $authToken->setUser($user);
//        $authToken->setRawToken($token->getCredentials());
//
//        $event = new JWTAuthenticatedEvent($payload, $authToken);
//        $this->dispatcher->dispatch(Events::JWT_AUTHENTICATED, $event);
//
//        return $authToken;
//    }

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