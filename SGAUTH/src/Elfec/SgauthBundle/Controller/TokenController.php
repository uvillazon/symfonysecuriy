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
        $servicio= $this->get('sgauthbundle.autenticacion_service');
        $array = $request->query;
        $header = $request->headers;
        $result = $servicio->generarTokenPorUsuarioApp($array,$header);
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
     * Obtencion de Token como parametros se tiene que enviar
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
        $servicio= $this->get('sgauthbundle.autenticacion_service');
        $array = $request->query;
        $array1 = $request->request->all();
        $array->set("codigoApp",$array1["codigoApp"]);
        $array->set("usuario",$array1['username']);
        $array->set("password",$array1['password']);

//        $array= $request->request->all();
//        var_dump($array);
        $header = $request->headers;
        $result = $servicio->generarTokenPorUsuarioApp($array,$header);
        return $result;
    }
}
