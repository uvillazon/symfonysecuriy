<?php

namespace Elfec\SgauthBundle\Controller;

use Elfec\SgauthBundle\Model\ResultPaginacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ItemsController extends BaseController
{

    /**
     * Obtener  Listas Items Paginados
     * formato de respuesta pagiandos
     * rows  : listas de objetos segun lo paginado, success : false o true  , total cantidad de registros encontrados
     * formato de envio
     * start : desde donde empieza, limit : cantidad para mostrar , dir : Ordenamiento ASC o DESC , sort Ordenar por la propiedad (Propiedad de alguna columna a ordenar ) ,
     * contiene : para buscar text libre ,
     * para filtros de datos enviar
     * propiedad de la tabla : valor , operador = AND o OR por defecto esta AND
     * por ejemplo para periodos quiero filtrar todos los periodos con etapa a REGIMEN y nro resolucion LL tengo que enviar
     * etapa : REGIMEN , nro_resolucion : lL
     * @Rest\Get("/listas/items")
     * @ApiDoc(
     *   resource = true,
     *   description = "Listas Items Paginados",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     *
     */
    public function getListasItemsAction(Request $request)
    {
        $Usertoken = $this->container->get("JWTUser");
        $id_aplic = $Usertoken->id_aplic;
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $array = $request->query;
        $result = $servicio->obtenerItemsPorListaV1($paginacion, $array, $id_aplic);
//        $result = $servicio->obtenerItemsPorLista($paginacion, $array, $id_aplic);
        return $result;
    }

    /**
     * Obtener  Listas Items Rel por padre y aplicaccion Paginados
     * formato de respuesta pagiandos
     * rows  : listas de objetos segun lo paginado, success : false o true  , total cantidad de registros encontrados
     * formato de envio
     * start : desde donde empieza, limit : cantidad para mostrar , dir : Ordenamiento ASC o DESC , sort Ordenar por la propiedad (Propiedad de alguna columna a ordenar ) ,
     * contiene : para buscar text libre ,
     * para filtros de datos enviar
     * propiedad de la tabla : valor , operador = AND o OR por defecto esta AND
     * por ejemplo para periodos quiero filtrar todos los periodos con etapa a REGIMEN y nro resolucion LL tengo que enviar
     * etapa : REGIMEN , nro_resolucion : lL
     * @Rest\Get("/listas/items_rel")
     * @ApiDoc(
     *   resource = true,
     *   description = "Listas Items Rel por padre y aplicaccion ",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     *
     */
    public function getListasItemsRelAction(Request $request)
    {
        $Usertoken = $this->container->get("JWTUser");
        $id_aplic = $Usertoken->id_aplic;
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $array = $request->query;
        $result = $servicio->obtenerItemsRelPorPadre($paginacion, $array, $id_aplic);
        return $result;
    }

    /**
     * Obtener  Usuarios Paginados Por Aplicacion es necesario enviar el token para identificar que aplicacion es
     * formato de respuesta pagiandos
     * rows  : listas de objetos segun lo paginado, success : false o true  , total cantidad de registros encontrados
     * formato de envio
     * start : desde donde empieza, limit : cantidad para mostrar , dir : Ordenamiento ASC o DESC , sort Ordenar por la propiedad (Propiedad de alguna columna a ordenar ) ,
     * contiene : para buscar text libre ,
     * para filtros de datos enviar
     * propiedad de la tabla : valor , operador = AND o OR por defecto esta AND
     * por ejemplo para periodos quiero filtrar todos los periodos con etapa a REGIMEN y nro resolucion LL tengo que enviar
     * etapa : REGIMEN , nro_resolucion : lL
     * @Rest\Get("/usuarios/usuarios")
     * @ApiDoc(
     *   resource = true,
     *   description = "Listas  Usuarios Paginados Por Aplicacion",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     *
     */
    public function getUsuariosAplicacionAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $id_aplic = $Usertoken->id_aplic;
        $array = $request->query;
//        var_dump()
        $array->set("id_aplic", $id_aplic);
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $result = $servicio->obtenerUsuariosPorAplicacionPaginados($paginacion, $array);
        return $result;
    }

    /**
     * @param Request $request
     * @Rest\Get("/unidades_solicitantes")
     * @return ResultPaginacion
     */
    public function getUnidadSolicitantesAction(Request $request)
    {

        $array = array(
            array(
                "unidad" => "UNIDAD DE LABORATORIO",
                "id_unidad" => "1"),
            array(
                "unidad" => "UNIDAD DE LLVV",
                "id_unidad" => "2"),
            array(
                "unidad" => "TECNOLOGIA",
                "id_unidad" => "3")
        );

        return new ResultPaginacion($array, 3, "proceso ejecutado correctamente");

    }

    /**
     * @Rest\Get("/directorios/grupos")
     * @ApiDoc(
     *   resource = true,
     *   description = "Listas  Usuarios Paginados Por Aplicacion",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     *
     */
    public function getGrupoDirectoriosAction(Request $request)
    {


        $Usertoken = $this->container->get("JWTUser");
        $id_aplic = $Usertoken->id_aplic;
        $array = $request->query;
        $array->set("id_aplic", $id_aplic);
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.directorios_service');
        $result = $servicio->obtenerGruposPaginados($paginacion, $array, false);
        return $result;
    }


}
