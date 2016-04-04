<?php

namespace Elfec\SgauthBundle\Controller;

use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Date;

class TokenController extends BaseController
{

    /**
     * Obtencion de Token como parametros se tiene que enviar
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener ass Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getTokenAction(Request $request)
    {
        $servicio = $this->get('sgauthbundle.autenticacion_service');
        $array = $request->query;
        $header = $request->headers;
        $result = $servicio->generarTokenPorUsuarioApp($array, $header);
//        $result = $servicio->generarTokenPorUsuarioApp($array,$header);
        return $result;
//        var_dump($request->query);
//        $paginacion = $this->obtenerPaginacion($request);
//        $servicio= $this->get('sgauthbundle.autenticacion_service');
//        $array = $request->query;
////        var_dump($servicio);die();
//        $result = $servicio->generarTokenPorUsuarioApp($paginacion , $array);
//        return $result;
    }

    /**
     * Obtencion de Token como parametros se tiene que enviar {codigoApp : codigo de aplicacion
     * username : usuario
     * password : password}
     * }
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Token",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function postTokenAction(Request $request)
    {
        $servicio = $this->get('sgauthbundle.autenticacion_service');
        $array = $request->query;
        $array1 = $request->request->all();
        $array->set("codigoApp", $array1["codigoApp"]);
        $array->set("usuario", $array1['username']);
        $array->set("password", $array1['password']);
        $header = $request->headers;
        $result = $servicio->generarTokenPorUsuarioApp($array, $header);
        return $result;
    }

    /**
     * Recuperacion de Password
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Token",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function postRecuperacionAction(Request $request)
    {
        $servicio = $this->get('sgauthbundle.recuperacion_service');
        $data = $request->request->all();
        $header = $request->headers;
//        var_dump($header->get('user-agent'));
//        var_dump($request->getClientIp());
        $data["ip_solic"] = $request->getClientIp();
        $data["cliente_solic"] = $header->get('user-agent');
        try {
            $result = $servicio->guardarRecuperacionCnt($data);
        }
        catch(\Exception $e){
            var_dump($e->getMessage());
        }
            return $result;
    }

    /**
     * Recuperacion de Password
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Token",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function postCambiar_passwordAction(Request $request)
    {
        $servicio = $this->get('sgauthbundle.recuperacion_service');
        $data = $request->request->all();
        $result = $servicio->cambiar_password($data);
        return $result;
    }
}
