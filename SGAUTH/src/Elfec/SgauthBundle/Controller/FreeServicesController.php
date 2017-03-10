<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:55 PM
 */

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

class FreeServicesController extends BaseController
{
    /**
     * Obtener Aplicaciones Paginados
     * formato de respuesta pagiandos
     * rows  : listas de objetos segun lo paginado, success : false o true  , total cantidad de registros encontrados
     * formato de envio
     * start : desde donde empieza, limit : cantidad para mostrar , dir : Ordenamiento ASC o DESC , sort Ordenar por la propiedad (Propiedad de alguna columna a ordenar ) ,
     * contiene : para buscar text libre ,
     * para filtros de datos enviar
     * propiedad de la tabla : valor , operador = AND o OR por defecto esta AND
     * por ejemplo para periodos quiero filtrar todos los periodos con etapa a REGIMEN y nro resolucion LL tengo que enviar
     * etapa : REGIMEN , nro_resolucion : lL
     * @Rest\Get("/aplicaciones/aplicaciones")
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Aplicaciones Paginado",
     *   output = "Array",
     *   authentication = false,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getAplicacionesRestFreeAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.aplicaciones_service');
        $array = $request->query;
        $result = $servicio->obtenerAplicacionesPaginados($paginacion, $array);
        return $result;
    }

    /**
     * @param Request $request
     * @Rest\Get("/areas")
     * @return ResultPaginacion
     */
    public function getAreasSinAutenticacionAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.areas_service');
        $array = $request->query;
        $result = $servicio->obtenerAreasPaginados($paginacion, $array, false);
        return $result;
    }

    /**
     * @Rest\Post("/areas/{nomArea}")
     * @param $nomArea
     * @return RespuestaSP
     */
    public function getAreaPorNombreAction($nomArea){
        $servicio = $this->get('sgauthbundle.areas_service');
        return $servicio->obtenerAreaPorNombre($nomArea,false);
    }

    /**
     * @param Request $request
     * @Rest\Get("/usuarios/AD")
     * @return ResultPaginacion
     */
    public function getUsuariosADAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $array = $request->query;
        $result = $servicio->obtenerUsuariosActiveDirectory($paginacion, $array, false);
        return $result;
    }
}