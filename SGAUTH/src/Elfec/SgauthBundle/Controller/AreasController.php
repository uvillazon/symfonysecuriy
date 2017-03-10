<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:55 PM
 */

namespace Elfec\SgauthBundle\Controller;

use Elfec\SgauthBundle\Model\RespuestaSP;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class AreasController extends BaseController
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
     * @Rest\Get("/areas")
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Aplicaciones Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getAreasAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.areas_service');
        $array = $request->query;
        $result = $servicio->obtenerAreasPaginados($paginacion, $array);
        return $result;
    }

    /**
     * @param Request $request
     * @Rest\Get("/areas_usuarios")
     * @return ResultPaginacion
     */
    public function getAreasAppAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.areas_service');
        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerAreasUsuarioPaginados($paginacion, $array);
        return $result;
    }
}