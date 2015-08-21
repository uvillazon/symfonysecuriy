<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 02/07/2015
 * Time: 08:15 AM
 */

namespace Elfec\SgauthBundle\Security\Firewall;


use Elfec\SgauthBundle\Security\Authentication\Token\JWTUserToken;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Tests\StringableObject;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Elfec\SgauthBundle\Security\Authentication\Token\WsseUserToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


class JWTListener implements ListenerInterface
{
    /**
     * @var $container Container
     */
    protected $container;
    protected $tokenStorage;
    protected $authenticationManager;
    protected $secret = "developmentSessionSecret";

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager )
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {

        $request = $event->getRequest();
        $response = new Response();
//        var_dump($response);die();
        $encoder = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE0NDI2NzQ5ODQsIm1lbnUiOlt7InRpdHVsbyI6IkFkbWluaXN0cmFjaW9uIiwiaWNvbmNscyI6InVzZXJfaWNvbiIsImhyZWYiOiIiLCJpZCI6IjEwMCIsInRvb2x0aXAiOiJtb2R1bG8gZGUgYWRtaW5pc3RyYWNpb24iLCJzdWJtZW51IjpbeyJ0aXR1bG8iOiJBZG0uIFVzdWFyaW8iLCJpY29uY2xzIjoidXNlcl9pY29uIiwiaHJlZiI6IkFwcC5jb250cm9sbGVyLlVzdWFyaW9zLlVzdWFyaW9zIiwiaWQiOiIxMDEiLCJ0b29sdGlwIjoibW9kdWxvIGRlIGFkbWluc2l0cmFjaW9uIGRlIHVzdWFyaW8iLCJzdWJtZW51IjpudWxsfSx7InRpdHVsbyI6IkFkbS4gQXBsaWNhY2lvbmVzIiwiaWNvbmNscyI6InVzZXJfYWljb24iLCJocmVmIjoiYXBwLnZpZXcuYXBsaWNhY2lvbmVzLnByaW5jaXBhbCIsImlkIjoiMTAyIiwidG9vbHRpcCI6Im1vZHVsbyBkZSBhZG1pbmlzdHJhY2lvbiBkZSBhcGxpY2FjaW9uZXMiLCJzdWJtZW51IjpudWxsfSx7InRpdHVsbyI6IkFkbS5QZXJmaWxlcyIsImljb25jbHMiOm51bGwsImhyZWYiOiIgIiwiaWQiOiIxMDMiLCJ0b29sdGlwIjpudWxsLCJzdWJtZW51IjpudWxsfV19XSwidXN1YXJpbyI6eyJsb2dpbiI6InBvc3RncmVzIiwibm9tYnJlIjoiYWRtaW5zaXRyYWRvciBkZSBiYXNlIGRlIGRhdG9zIiwicGVyZmlsIjoiQURNSU5JU1RSQURPUiBERSBTSVNURU1BIiwiaWRfcGVyZmlsIjoiMyIsImlkX3VzdWFyaW8iOiIxIiwiZW1haWwiOiJ1dmlsbGF6b25AZWxmZWMuY29tIiwiZXN0YWRvIjoiQUNUSVZPIiwiYXBsaWNhY2lvbiI6IlNJU1RFTUEgREUgQVVURU5USUNBQ0lPTiIsImNvZGlnb0FwcCI6IlNHQVVUSCIsImlkX2FwbGljIjoiMiJ9LCJrZXkiOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpJVXpJMU5pSjkuSW1WNVNqQmxXRUZwVDJsS1MxWXhVV2xNUTBwb1lrZGphVTlwU2tsVmVra3hUbWxLT1M1bGVVcHJXVzAxYUdKWFZXbFBhVXBvWkZoU2JHSnVVbkJaTWtacVlWYzVkVWxwZDJsa1dFNXNZMmxKTmtsdVFuWmpNMUp1WTIxV2VrbHBkMmxqUjBaNll6TmtkbU50VVdsUGFVcDNZak5PTUZvelNteGplVWx6U1cxb2RtTXpVV2xQYVVwc1lrZGFjMWx0VVhkTlUwbHpTVzVDZG1OdVVXbFBhVWt4VGtSTmVVbHBkMmxhU0Vwd1pHMVdlVWxxYjJsalIxSjJXRE5DYm1NelJuTkpiakF1YldOT1lrWTRVR3RvTFVKUVUwWXpNMm94U0doSmJFaGZWR1pUZEV0NE9VSk1SREkwZEdSQk1FaExWU0kuVEVyaEtNS2xuZjlKNEdGaDljS2FJRTBOdzR5SmtKVkdlaS11bXRoODlVVSJ9.L_0Djzxkuwp68d5R6Mh4_55YQ4l6tDNHaGDPGKNEdGQ";
//        $encoder = str_replace("Bearer ", "", $request->headers->get('Authorization'));
        if(empty($encoder)){
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $event->setResponse($response);
        }
        else {
            try {
//            $encoder = str_replace("Bearer ", "", $request->headers->get('Authorization'));

                $decoded = JWT::decode($encoder, $this->secret, array('HS256'));
//                var_dump($decoded);die();
//                var_dump($decoded);
                $token = new JWTUserToken();
                $token->setRawToken($decoded);
                $this->container->set("JWTToken",$token);
//                var_dump($decoded->usuario->login);die();
                $this->container->set("JWTUser" , $decoded->usuario);
                $keydecoded = JWT::decode(JWT::decode($decoded->key , $this->secret , array('HS256')),$this->secret , array('HS256'));
                $this->container->set("JWTTokenPostgres",$keydecoded);
                //Ccreamos la coneccion
                $coneccion = $this->container->get("database_connection");
                $coneccion->close();

                $refCon = new \ReflectionObject($coneccion);

                $refParams = $refCon->getProperty("_params");
                $refParams->setAccessible("public");

                $params = $refParams->getValue($coneccion);
                $params["dbname"] = $keydecoded->dbname;
                $params["user"] = $keydecoded->user;
                $params["password"] = $keydecoded->password;
                $params["driver"] = $keydecoded->driver;
                $params["host"] = $keydecoded->host;
                $params["port"] = $keydecoded->port;
                $refParams->setAccessible("private");
                $refParams->setValue($coneccion, $params);

                $this->container->get("doctrine")->resetEntityManager("default");
                return ;
            } catch (\ExpiredException $a) {

//                var_dump($a->getMessage());
                $response->setStatusCode(Response::HTTP_FORBIDDEN);
                $event->setResponse($response);
            }
        }
    }
    public function setContainer(Container $container = null){
        $this->container = $container;
    }
}