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
        //        $encoder = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjExNDQ1NTM3NTg5LCJtZW51IjpbeyJ0aXR1bG8iOiJBZG1pbmlzdHJhY2lvbiIsImljb25jbHMiOiJhZG1pbl9taW4iLCJocmVmIjoiIiwiaWQiOiIxMDAiLCJ0b29sdGlwIjoibW9kdWxvIGRlIGFkbWluaXN0cmFjaW9uIiwic3VibWVudSI6W3sidGl0dWxvIjoiQWRtLiBVc3VhcmlvIiwiaWNvbmNscyI6InVzZXJfaWNvbiIsImhyZWYiOiJBcHAuY29udHJvbGxlci5Vc3Vhcmlvcy5Vc3VhcmlvcyIsImlkIjoiMTAxIiwidG9vbHRpcCI6Im1vZHVsbyBkZSBhZG1pbnNpdHJhY2lvbiBkZSB1c3VhcmlvIiwic3VibWVudSI6bnVsbCwiYm90b25lcyI6W3siaWRfYm90b24iOiIxIiwibm9tYnJlIjoiQ3JlYXIiLCJ0b29sdGlwIjoiQ3JlYWNpb24gZGUgVXN1YXJpbyAiLCJpZF9pdGVtIjoiYnRuX2NyZWFyVXN1YXJpbyIsImVzdGlsbyI6bnVsbCwiYWNjaW9uIjoiY3JlYXIiLCJpY29ubyI6InVzZXJfYWRkIiwib3JkZW4iOiIxIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOmZhbHNlfSx7ImlkX2JvdG9uIjoiMiIsIm5vbWJyZSI6IkVkaXRhciIsInRvb2x0aXAiOiJFZGljaW9uIGRlIFVzdWFyaW8gIiwiaWRfaXRlbSI6ImJ0bl9lZGl0YXJVc3VhcmlvIiwiZXN0aWxvIjpudWxsLCJhY2Npb24iOiJlZGl0YXIiLCJpY29ubyI6InVzZXJfZWRpdCIsIm9yZGVuIjoiMiIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjp0cnVlfSx7ImlkX2JvdG9uIjoiNyIsIm5vbWJyZSI6IkFncmVnYXI8YnI-VXNyIGEgQXBwIiwidG9vbHRpcCI6IkFncmVnYXIgVXN1YXJpbyBhIFVuamEgQXBsaWNhY2lvbiBDb24gdW4gUGVyZmlsIERldGVybWluYWRvXHJcbiIsImlkX2l0ZW0iOiJidG5fVXNyQXBwIiwiZXN0aWxvIjpudWxsLCJhY2Npb24iOiJ1c3JBcHAiLCJpY29ubyI6InVzZXJfYWRkIiwib3JkZW4iOiIzIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9XX0seyJ0aXR1bG8iOiJBZG0uIEFwbGljYWNpb25lcyIsImljb25jbHMiOiJ1c2VyX2FpY29uIiwiaHJlZiI6IkFwcC5jb250cm9sbGVyLkFwbGljYWNpb25lcy5BcGxpY2FjaW9uZXMiLCJpZCI6IjEwMiIsInRvb2x0aXAiOiJtb2R1bG8gZGUgYWRtaW5pc3RyYWNpb24gZGUgYXBsaWNhY2lvbmVzIiwic3VibWVudSI6bnVsbCwiYm90b25lcyI6W3siaWRfYm90b24iOiIxMCIsIm5vbWJyZSI6IkNSRUFfeSIsInRvb2x0aXAiOiJURVNUIEhIIiwiaWRfaXRlbSI6IklEX1giLCJlc3RpbG8iOiJFU1RfWCIsImFjY2lvbiI6ImNyZWFyIiwiaWNvbm8iOiJ1c2VyX2VkaXQiLCJvcmRlbiI6IjEwIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOmZhbHNlLCJzdWJCb3RvbmVzIjpbeyJpZF9ib3RvbiI6IjM5Iiwibm9tYnJlIjoidGVzdCIsInRvb2x0aXAiOiIiLCJpZF9pdGVtIjoiIiwiZXN0aWxvIjoiIiwiYWNjaW9uIjoiIiwiaWNvbm8iOiJib3giLCJvcmRlbiI6bnVsbCwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOmZhbHNlfV19XX0seyJ0aXR1bG8iOiJBZG0uUGVyZmlsZXMiLCJpY29uY2xzIjpudWxsLCJocmVmIjoiQXBwLmNvbnRyb2xsZXIuUGVyZmlsZXMuUGVyZmlsZXMiLCJpZCI6IjEwMyIsInRvb2x0aXAiOiJNb2R1bG8gZGUgUGVyZmlsZXMiLCJzdWJtZW51IjpudWxsLCJib3RvbmVzIjpbeyJpZF9ib3RvbiI6IjI4Iiwibm9tYnJlIjoiQ3JlYXIgUGVyZmlsIiwidG9vbHRpcCI6IkNSRUFDSU9OIERFIFBFUkZJTCIsImlkX2l0ZW0iOiJidG5fY3JlYXJQZXJmaWwiLCJlc3RpbG8iOiIiLCJhY2Npb24iOiIiLCJpY29ubyI6ImJvbWIiLCJvcmRlbiI6IjEiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6ZmFsc2V9LHsiaWRfYm90b24iOiIyOSIsIm5vbWJyZSI6IkVkaXRhciBQZXJmaWwiLCJ0b29sdGlwIjoiRURJQ0lPTiBERSBQRVJGSUwiLCJpZF9pdGVtIjoiYnRuX2VkaXRhclBlcmZpbCIsImVzdGlsbyI6IiIsImFjY2lvbiI6IiIsImljb25vIjoiYmluIiwib3JkZW4iOiIyIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9LHsiaWRfYm90b24iOiIzMiIsIm5vbWJyZSI6IkFkbS4gT3BjaW9uZXMiLCJ0b29sdGlwIjoiQURNSU5JU1RSQUNJT04gREUgT1BDSU9ORVMiLCJpZF9pdGVtIjoiIiwiZXN0aWxvIjoiIiwiYWNjaW9uIjoiIiwiaWNvbm8iOiJhZG1pbl9taW5fMzIiLCJvcmRlbiI6IjMiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6ZmFsc2UsInN1YkJvdG9uZXMiOlt7ImlkX2JvdG9uIjoiMzAiLCJub21icmUiOiJhZ3JlZ2FyIG9wY2lvbiIsInRvb2x0aXAiOiJBR1JFR0FSIE9QQ0lPTiBBIFVOIFBFUkZJTCAiLCJpZF9pdGVtIjoiYnRuX2FncmVnYXJPcGNpb24iLCJlc3RpbG8iOiIiLCJhY2Npb24iOiIiLCJpY29ubyI6ImFkbWluX21pbl8zMiIsIm9yZGVuIjoiMyIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjp0cnVlfSx7ImlkX2JvdG9uIjoiMzEiLCJub21icmUiOiJRdWl0YXIgT3BjaW9uIiwidG9vbHRpcCI6IlFVSVRBUiBPUENJT04gQSBQRVJGSUwiLCJpZF9pdGVtIjoiYnRuX3F1aXRhck9wY2lvbiIsImVzdGlsbyI6IiIsImFjY2lvbiI6IiIsImljb25vIjoiem9vbSIsIm9yZGVuIjoiNCIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjp0cnVlfV19LHsiaWRfYm90b24iOiIzMyIsIm5vbWJyZSI6IkFkbS4gQm90b25lcyIsInRvb2x0aXAiOiJBRE1JTklTVFJBQ0lPTiBERSBCT1RPTkVTIiwiaWRfaXRlbSI6IiIsImVzdGlsbyI6IiIsImFjY2lvbiI6IiIsImljb25vIjoiYnVnIiwib3JkZW4iOiI0IiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOmZhbHNlLCJzdWJCb3RvbmVzIjpbeyJpZF9ib3RvbiI6IjM0Iiwibm9tYnJlIjoiQWdyZWdhciBCb3RvbiIsInRvb2x0aXAiOiJBR1JFR0FSIEJPVE9OIEEgVU4gUEVSRklMIiwiaWRfaXRlbSI6ImJ0bl9hZ3JlZ2FyQm90b24iLCJlc3RpbG8iOiIiLCJhY2Npb24iOiIiLCJpY29ubyI6ImNha2UiLCJvcmRlbiI6IjEiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6dHJ1ZX0seyJpZF9ib3RvbiI6IjM1Iiwibm9tYnJlIjoiUXVpdGFyIEJvdG9uIiwidG9vbHRpcCI6IlFVSVRBUiBCT1RPTiBERSBQRVJGSUwiLCJpZF9pdGVtIjoiYnRuX3F1aXRhckJvdG9uIiwiZXN0aWxvIjoiIiwiYWNjaW9uIjoiIiwiaWNvbm8iOiJib3giLCJvcmRlbiI6IjIiLCJlc3RhZG8iOiJBQ1RJVk8iLCJkaXNhYmxlZCI6dHJ1ZX1dfV19XSwiYm90b25lcyI6W119LHsidGl0dWxvIjoiT3BjaW9uZXMgZGUgTWVudSIsImljb25jbHMiOiJ1c2VyX2FkZCIsImhyZWYiOiJzaW4gbGluayIsImlkIjoiMTA0IiwidG9vbHRpcCI6IkFETUlOSVNUUkFDSU9OIERFIE9QIChQUlVFQkEpIiwic3VibWVudSI6W3sidGl0dWxvIjoiQWRtIE9wY2lvbmVzIGRlIE1lbnUiLCJpY29uY2xzIjoidXNlcl9hZGQiLCJocmVmIjoiQXBwLmNvbnRyb2xsZXIuT3BjaW9uZXMuT3BjaW9uZXMiLCJpZCI6IjEwNSIsInRvb2x0aXAiOiJBZG0uIE1lbnUgZGUgb3BjaW9uZXMgUG9yIEFwbGljYWNpb25lcyIsInN1Ym1lbnUiOm51bGwsImJvdG9uZXMiOlt7ImlkX2JvdG9uIjoiMTEiLCJub21icmUiOiJDcmVhcjxicj5PcGNpb24iLCJ0b29sdGlwIjoiQ3JlY2lvbiBkZSBPcGNpb25lcyBkZSBNZW51IiwiaWRfaXRlbSI6ImJ0bl9jcmVhck9wY2lvbiIsImVzdGlsbyI6bnVsbCwiYWNjaW9uIjoiY3JlYXIiLCJpY29ubyI6InVzZXJfYWRkIiwib3JkZW4iOiIxIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOmZhbHNlfSx7ImlkX2JvdG9uIjoiMTIiLCJub21icmUiOiJFZGl0YXI8YnI-T3BjaW9uIiwidG9vbHRpcCI6IkVkaWNpb24gZGUgT3BjaW9uZXMiLCJpZF9pdGVtIjoiYnRuX2VkaXRhck9wY2lvbiIsImVzdGlsbyI6IiIsImFjY2lvbiI6ImVkaXRhciIsImljb25vIjoicHJvamVjdF8yMDEzXzI0eDI0Iiwib3JkZW4iOiIyIiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9LHsiaWRfYm90b24iOiIxMyIsIm5vbWJyZSI6IkNyZWFyPGJyPkJvdG9uIiwidG9vbHRpcCI6IkNyZWFjaW9uIGRlIGJvdG9uIiwiaWRfaXRlbSI6ImJ0bl9jcmVhckJvdG9uIiwiZXN0aWxvIjoiIiwiYWNjaW9uIjoiY3JlYXIiLCJpY29ubyI6ImFkbWluX21pbl8zMiIsIm9yZGVuIjoiMyIsImVzdGFkbyI6IkFDVElWTyIsImRpc2FibGVkIjp0cnVlfSx7ImlkX2JvdG9uIjoiMTQiLCJub21icmUiOiJFZGl0YXI8YnI-Qm90b24iLCJ0b29sdGlwIjoiRWRpdGFyIGJvdG9uIiwiaWRfaXRlbSI6ImJ0bl9lZGl0YXJCb3RvbiIsImVzdGlsbyI6IiIsImFjY2lvbiI6ImVkaXRhciIsImljb25vIjoidXNlcl9lZGl0Iiwib3JkZW4iOiI0IiwiZXN0YWRvIjoiQUNUSVZPIiwiZGlzYWJsZWQiOnRydWV9XX1dLCJib3RvbmVzIjpbXX1dLCJ1c3VhcmlvIjp7ImxvZ2luIjoicG9zdGdyZXMiLCJub21icmUiOiJhZG1pbnNpdHJhZG9yIGRlIGJhc2UgZGUgZGF0b3MiLCJwZXJmaWwiOiJBRE1JTklTVFJBRE9SIERFIFNJU1RFTUEiLCJpZF9wZXJmaWwiOiIzIiwiaWRfdXN1YXJpbyI6IjEiLCJlbWFpbCI6InViYWxkby52aWxsYXpvbkBlbGZlYy5ibyIsImVzdGFkbyI6IkFDVElWTyIsImFwbGljYWNpb24iOiJTSVNURU1BIERFIEFVVEVOVElDQUNJT04iLCJjb2RpZ29BcHAiOiJTR0FVVEgiLCJpZF9hcGxpYyI6IjIifSwia2V5IjoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LkltVjVTakJsV0VGcFQybEtTMVl4VVdsTVEwcG9Za2RqYVU5cFNrbFZla2t4VG1sS09TNWxlVXByV1cwMWFHSlhWV2xQYVVwb1pGaFNiR0p1VW5CWk1rWnFZVmM1ZFVscGQybGtXRTVzWTJsSk5rbHVRblpqTTFKdVkyMVdla2xwZDJsalIwWjZZek5rZG1OdFVXbFBhVXAzWWpOT01Gb3pTbXhqZVVselNXMW9kbU16VVdsUGFVcHNZa2RhYzFsdFVYZE5VMGx6U1c1Q2RtTnVVV2xQYVVreFRrUk5lVWxwZDJsYVNFcHdaRzFXZVVscWIybGpSMUoyV0ROQ2JtTXpSbk5KYmpBdWJXTk9Za1k0VUd0b0xVSlFVMFl6TTJveFNHaEpiRWhmVkdaVGRFdDRPVUpNUkRJMGRHUkJNRWhMVlNJLlRFcmhLTUtsbmY5SjRHRmg5Y0thSUUwTnc0eUprSlZHZWktdW10aDg5VVUifQ._bI6Hv8Dzly4i6mnCafD76r2HY10nR2r0wylh2Uasc4";
        $encoder = str_replace("Bearer ", "", $request->headers->get('Authorization'));
//        var_dump($encoder);
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
//                var_dump($decoded->aplicacion);
                try {
                    $this->container->set("JWTApp", $decoded->aplicacion);
                } catch (\Exception $a) {
                }
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
//                    var_dump($a->getCode());
                    $response->setContent($a->getMessage());
                    $response->setStatusCode(Response::HTTP_FORBIDDEN);
//                    $response->set
                    $event->setResponse($response);
                } else {
//                    var_dump($encoder);
                    $response->setContent($a->getMessage() + " " + $encoder);
//                    var_dump($a->getMessage());
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