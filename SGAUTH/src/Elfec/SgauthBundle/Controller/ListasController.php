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

class ListasController extends BaseController
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
    public function getListasAction(Request $request)
    {
//        var_dump($this->request->query);die();
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerListasPaginados($paginacion, $array);
        return $result;

    }

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
     * @ApiDoc(
     *   resource = true,
     *   description = "Listas Items Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getItemsAction(Request $request)
    {

        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $array = $request->query;
        $result = $servicio->obtenerListasItemsPaginados($paginacion, $array);
        return $result;
    }

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
     * @Rest\Get("/items_rel")
     * @ApiDoc(
     *   resource = true,
     *   description = "Listas Items Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getItemsRelPaginadosAction(Request $request)
    {

        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $array = $request->query;
        $result = $servicio->obtenerListasItemsRelPaginados($paginacion, $array);
        return $result;
    }


    /**
     * Este Metodo Guarda Modelo de Medidor
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Modelo Medidor",
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
    public function postListas_itemsAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.listas_service');
        $result = $servicio->guardarListaItem($data, $login);
        return $result;
    }

    /**
     * Este Metodo Guarda Modelo de Medidor
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Modelo Medidor",
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
    public function postListasAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $result = $servicio->guardarLista($data, $login);
        return $result;

    }

    /**
     * Este Metodo Guarda Modelo de Medidor
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Modelo Medidor",
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
    public function postEliminar_listaAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $result = $servicio->eliminarLista($data, $login);
        return $result;

    }

    /**
     * Este Metodo Eliminar Item
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Eliminar Item",
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
    public function postEliminar_itemsAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $result = $servicio->eliminarItem($data, $login);
        return $result;

    }

    /**
     * Este Metodo Guarda Listas Relacionadas
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @Rest\Post("/items_rel")
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Lista Rel",
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
    public function postGuardarListasRelacionadassAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $result = $servicio->grabarListasItemsRel($data, $login);
        return $result;

    }

    /**
     * Este Metodo Elimina Listas Relacionadas
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @Rest\Post("/items_rel/eliminar")
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Lista Rel",
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
    public function postEliminarListasRelacionadassAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.listas_service');
        $result = $servicio->eliminarListaItemRel($data, $login);
        return $result;

    }

}