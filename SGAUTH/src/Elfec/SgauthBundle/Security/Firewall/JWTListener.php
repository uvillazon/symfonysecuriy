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

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
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
//        $encoder = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE0ODA1MTg1NTUsIm1lbnUiOlt7InRpdHVsbyI6IkFkbWluaXN0cmFjaW9uIiwiaWNvbmNscyI6ImFkbWluX21pbiIsImhyZWYiOiIiLCJpZCI6IjEwMCIsInRvb2x0aXAiOiJtb2R1bG8gZGUgYWRtaW5pc3RyYWNpb24iLCJzdWJtZW51IjpbeyJ0aXR1bG8iOiJBZG0uIFVzdWFyaW8iLCJpY29uY2xzIjoidXNlcl9pY29uIiwiaHJlZiI6IkFwcC5jb250cm9sbGVyLlVzdWFyaW9zLlVzdWFyaW9zIiwiaWQiOiIxMDEiLCJ0b29sdGlwIjoibW9kdWxvIGRlIGFkbWluc2l0cmFjaW9uIGRlIHVzdWFyaW8iLCJzdWJtZW51IjpudWxsLCJib3RvbmVzIjpbeyJpZF9ib3RvbiI6IjEiLCJub21icmUiOiJDcmVhciIsInRvb2x0aXAiOiJDcmVhY2lvbiBkZSBVc3VhcmlvICIsImlkX2l0ZW0iOiJidG5fY3JlYXJVc3VhcmlvIiwiZXN0aWxvIjpudWxsLCJhY2Npb24iOiJjcmVhciIsImljb25vIjoidXNlcl9hZGQiLCJvcmRlbiI6IjEiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6ZmFsc2V9LHsiaWRfYm90b24iOiIyIiwibm9tYnJlIjoiRWRpdGFyIiwidG9vbHRpcCI6IkVkaWNpb24gZGUgVXN1YXJpbyAiLCJpZF9pdGVtIjoiYnRuX2VkaXRhclVzdWFyaW8iLCJlc3RpbG8iOm51bGwsImFjY2lvbiI6ImVkaXRhciIsImljb25vIjoidXNlcl9lZGl0Iiwib3JkZW4iOiIyIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9LHsiaWRfYm90b24iOiI3Iiwibm9tYnJlIjoiQWdyZWdhcjxicj5Vc3IgYSBBcHAiLCJ0b29sdGlwIjoiQWdyZWdhciBVc3VhcmlvIGEgVW5qYSBBcGxpY2FjaW9uIENvbiB1biBQZXJmaWwgRGV0ZXJtaW5hZG9cclxuIiwiaWRfaXRlbSI6ImJ0bl9Vc3JBcHAiLCJlc3RpbG8iOm51bGwsImFjY2lvbiI6InVzckFwcCIsImljb25vIjoidXNlcl9hZGQiLCJvcmRlbiI6IjMiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6dHJ1ZX1dfSx7InRpdHVsbyI6IkFkbS4gQXBsaWNhY2lvbmVzIiwiaWNvbmNscyI6InVzZXJfYWljb24iLCJocmVmIjoiQXBwLmNvbnRyb2xsZXIuQXBsaWNhY2lvbmVzLkFwbGljYWNpb25lcyIsImlkIjoiMTAyIiwidG9vbHRpcCI6Im1vZHVsbyBkZSBhZG1pbmlzdHJhY2lvbiBkZSBhcGxpY2FjaW9uZXMiLCJzdWJtZW51IjpudWxsLCJib3RvbmVzIjpbeyJpZF9ib3RvbiI6IjEwIiwibm9tYnJlIjoiQ1JFQV95IiwidG9vbHRpcCI6IlRFU1QgSEgiLCJpZF9pdGVtIjoiSURfWCIsImVzdGlsbyI6IkVTVF9YIiwiYWNjaW9uIjoiY3JlYXIiLCJpY29ubyI6InVzZXJfZWRpdCIsIm9yZGVuIjoiMTAiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6dHJ1ZX1dfSx7InRpdHVsbyI6IkFkbS5QZXJmaWxlcyIsImljb25jbHMiOm51bGwsImhyZWYiOiJBcHAuY29udHJvbGxlci5QZXJmaWxlcy5QZXJmaWxlcyIsImlkIjoiMTAzIiwidG9vbHRpcCI6Ik1vZHVsbyBkZSBQZXJmaWxlcyIsInN1Ym1lbnUiOm51bGwsImJvdG9uZXMiOlt7ImlkX2JvdG9uIjoiMjgiLCJub21icmUiOiJDcmVhciBQZXJmaWwiLCJ0b29sdGlwIjoiQ1JFQUNJT04gREUgUEVSRklMIiwiaWRfaXRlbSI6ImJ0bl9jcmVhclBlcmZpbCIsImVzdGlsbyI6IiIsImFjY2lvbiI6IiIsImljb25vIjoiYm9tYiIsIm9yZGVuIjoiMSIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjpmYWxzZX0seyJpZF9ib3RvbiI6IjI5Iiwibm9tYnJlIjoiRWRpdGFyIFBlcmZpbCIsInRvb2x0aXAiOiJFRElDSU9OIERFIFBFUkZJTCIsImlkX2l0ZW0iOiJidG5fZWRpdGFyUGVyZmlsIiwiZXN0aWxvIjoiIiwiYWNjaW9uIjoiIiwiaWNvbm8iOiJiaW4iLCJvcmRlbiI6IjIiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6dHJ1ZX0seyJpZF9ib3RvbiI6IjMyIiwibm9tYnJlIjoiQWRtLiBPcGNpb25lcyIsInRvb2x0aXAiOiJBRE1JTklTVFJBQ0lPTiBERSBPUENJT05FUyIsImlkX2l0ZW0iOiIiLCJlc3RpbG8iOiIiLCJhY2Npb24iOiIiLCJpY29ubyI6ImFkbWluX21pbl8zMiIsIm9yZGVuIjoiMyIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjpmYWxzZSwic3ViQm90b25lcyI6W3siaWRfYm90b24iOiIzMCIsIm5vbWJyZSI6ImFncmVnYXIgb3BjaW9uIiwidG9vbHRpcCI6IkFHUkVHQVIgT1BDSU9OIEEgVU4gUEVSRklMICIsImlkX2l0ZW0iOiJidG5fYWdyZWdhck9wY2lvbiIsImVzdGlsbyI6IiIsImFjY2lvbiI6IiIsImljb25vIjoiYWRtaW5fbWluXzMyIiwib3JkZW4iOiIzIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9LHsiaWRfYm90b24iOiIzMSIsIm5vbWJyZSI6IlF1aXRhciBPcGNpb24iLCJ0b29sdGlwIjoiUVVJVEFSIE9QQ0lPTiBBIFBFUkZJTCIsImlkX2l0ZW0iOiJidG5fcXVpdGFyT3BjaW9uIiwiZXN0aWxvIjoiIiwiYWNjaW9uIjoiIiwiaWNvbm8iOiJ6b29tIiwib3JkZW4iOiI0IiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9XX0seyJpZF9ib3RvbiI6IjMzIiwibm9tYnJlIjoiQWRtLiBCb3RvbmVzIiwidG9vbHRpcCI6IkFETUlOSVNUUkFDSU9OIERFIEJPVE9ORVMiLCJpZF9pdGVtIjoiIiwiZXN0aWxvIjoiIiwiYWNjaW9uIjoiIiwiaWNvbm8iOiJidWciLCJvcmRlbiI6IjQiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6ZmFsc2UsInN1YkJvdG9uZXMiOlt7ImlkX2JvdG9uIjoiMzQiLCJub21icmUiOiJBZ3JlZ2FyIEJvdG9uIiwidG9vbHRpcCI6IkFHUkVHQVIgQk9UT04gQSBVTiBQRVJGSUwiLCJpZF9pdGVtIjoiYnRuX2FncmVnYXJCb3RvbiIsImVzdGlsbyI6IiIsImFjY2lvbiI6IiIsImljb25vIjoiY2FrZSIsIm9yZGVuIjoiMSIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjp0cnVlfSx7ImlkX2JvdG9uIjoiMzUiLCJub21icmUiOiJRdWl0YXIgQm90b24iLCJ0b29sdGlwIjoiUVVJVEFSIEJPVE9OIERFIFBFUkZJTCIsImlkX2l0ZW0iOiJidG5fcXVpdGFyQm90b24iLCJlc3RpbG8iOiIiLCJhY2Npb24iOiIiLCJpY29ubyI6ImJveCIsIm9yZGVuIjoiMiIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjp0cnVlfV19XX1dLCJib3RvbmVzIjpbXX0seyJ0aXR1bG8iOiJPcGNpb25lcyBkZSBNZW51IiwiaWNvbmNscyI6InVzZXJfYWRkIiwiaHJlZiI6bnVsbCwiaWQiOiIxMDQiLCJ0b29sdGlwIjoiQWRtaW5pc3RyYWNpb24gZGUgT3BjaW9uZXMgZGUgbWVudSIsInN1Ym1lbnUiOlt7InRpdHVsbyI6IkFkbSBPcGNpb25lcyBkZSBNZW51IiwiaWNvbmNscyI6InVzZXJfYWRkIiwiaHJlZiI6IkFwcC5jb250cm9sbGVyLk9wY2lvbmVzLk9wY2lvbmVzIiwiaWQiOiIxMDUiLCJ0b29sdGlwIjoiQWRtLiBNZW51IGRlIG9wY2lvbmVzIFBvciBBcGxpY2FjaW9uZXMiLCJzdWJtZW51IjpudWxsLCJib3RvbmVzIjpbeyJpZF9ib3RvbiI6IjExIiwibm9tYnJlIjoiQ3JlYXI8YnI-T3BjaW9uIiwidG9vbHRpcCI6IkNyZWNpb24gZGUgT3BjaW9uZXMgZGUgTWVudSIsImlkX2l0ZW0iOiJidG5fY3JlYXJPcGNpb24iLCJlc3RpbG8iOm51bGwsImFjY2lvbiI6ImNyZWFyIiwiaWNvbm8iOiJ1c2VyX2FkZCIsIm9yZGVuIjoiMSIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjpmYWxzZX0seyJpZF9ib3RvbiI6IjEyIiwibm9tYnJlIjoiRWRpdGFyPGJyPk9wY2lvbiIsInRvb2x0aXAiOiJFZGljaW9uIGRlIE9wY2lvbmVzIiwiaWRfaXRlbSI6ImJ0bl9lZGl0YXJPcGNpb24iLCJlc3RpbG8iOiIiLCJhY2Npb24iOiJlZGl0YXIiLCJpY29ubyI6InByb2plY3RfMjAxM18yNHgyNCIsIm9yZGVuIjoiMiIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjp0cnVlfSx7ImlkX2JvdG9uIjoiMTMiLCJub21icmUiOiJDcmVhcjxicj5Cb3RvbiIsInRvb2x0aXAiOiJDcmVhY2lvbiBkZSBib3RvbiIsImlkX2l0ZW0iOiJidG5fY3JlYXJCb3RvbiIsImVzdGlsbyI6IiIsImFjY2lvbiI6ImNyZWFyIiwiaWNvbm8iOiJhZG1pbl9taW5fMzIiLCJvcmRlbiI6IjMiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6dHJ1ZX0seyJpZF9ib3RvbiI6IjE0Iiwibm9tYnJlIjoiRWRpdGFyPGJyPkJvdG9uMjIyMjIiLCJ0b29sdGlwIjoiRWRpdGFyIGJvdG9uIiwiaWRfaXRlbSI6ImJ0bl9lZGl0YXJCb3RvbiIsImVzdGlsbyI6IiIsImFjY2lvbiI6ImVkaXRhciIsImljb25vIjoidXNlcl9lZGl0Iiwib3JkZW4iOiI0IiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9XX1dLCJib3RvbmVzIjpbXX1dLCJ1c3VhcmlvIjp7ImxvZ2luIjoicG9zdGdyZXMiLCJub21icmUiOiJhZG1pbnNpdHJhZG9yIGRlIGJhc2UgZGUgZGF0b3MiLCJwZXJmaWwiOiJBRE1JTklTVFJBRE9SIERFIFNJU1RFTUEiLCJpZF9wZXJmaWwiOiIzIiwiaWRfdXN1YXJpbyI6IjEiLCJlbWFpbCI6InViYWxkby52aWxsYXpvbkBlbGZlYy5ibyIsImVzdGFkbyI6IkFDVElWTyIsImFwbGljYWNpb24iOiJTSVNURU1BIERFIEFVVEVOVElDQUNJT04iLCJjb2RpZ29BcHAiOiJTR0FVVEgiLCJpZF9hcGxpYyI6IjIifSwia2V5IjoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LkltVjVTakJsV0VGcFQybEtTMVl4VVdsTVEwcG9Za2RqYVU5cFNrbFZla2t4VG1sS09TNWxlVXByV1cwMWFHSlhWV2xQYVVwb1pGaFNiR0p1VW5CWk1rWnFZVmM1ZFVscGQybGtXRTVzWTJsSk5rbHVRblpqTTFKdVkyMVdla2xwZDJsalIwWjZZek5rZG1OdFVXbFBhVXAzWWpOT01Gb3pTbXhqZVVselNXMW9kbU16VVdsUGFVcHNZa2RhYzFsdFVYZE5VMGx6U1c1Q2RtTnVVV2xQYVVreFRrUk5lVWxwZDJsYVNFcHdaRzFXZVVscWIybGpSMUoyV0ROQ2JtTXpSbk5KYmpBdWJXTk9Za1k0VUd0b0xVSlFVMFl6TTJveFNHaEpiRWhmVkdaVGRFdDRPVUpNUkRJMGRHUkJNRWhMVlNJLlRFcmhLTUtsbmY5SjRHRmg5Y0thSUUwTnc0eUprSlZHZWktdW10aDg5VVUifQ.Lup_uuU_giP7xTd7JdjPv3IYPBzN1R9o19dp6rFVX9A";
        $encoder = str_replace("Bearer ", "", $request->headers->get('Authorization'));
        if (empty($encoder)) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            $event->setResponse($response);
        } else {
            try {
//            $encoder = str_replace("Bearer ", "", $request->headers->get('Authorization'));

                $decoded = JWT::decode($encoder, $this->secret, array('HS256'));
//                var_dump($decoded);die();
//                var_dump($decoded);
                $token = new JWTUserToken();
                $token->setRawToken($decoded);
                $this->container->set("JWTToken", $token);
//                var_dump($decoded->usuario->login);die();
                $this->container->set("JWTUser", $decoded->usuario);
                $keydecoded = JWT::decode(JWT::decode($decoded->key, $this->secret, array('HS256')), $this->secret, array('HS256'));
                $this->container->set("JWTTokenPostgres", $keydecoded);
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
                return;
            } catch (\Exception $a) {
                if ($a->getMessage() === "Expired token") {
                    $response->setContent($a->getMessage());
                    $response->setStatusCode(Response::HTTP_FORBIDDEN);
                    $event->setResponse($response);
                } else {
                    var_dump($encoder);
                    $response->setContent($a->getMessage());
//                var_dump($a->getMessage());
                    $response->setStatusCode(Response::HTTP_FAILED_DEPENDENCY);
                    $event->setResponse($response);
                }
            }
        }
    }

    public function setContainer(Container $container = null)
    {
        $this->container = $container;
    }
}