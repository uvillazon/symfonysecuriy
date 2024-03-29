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

class PerfilesController extends BaseController
{
    /**
     * Obtener Opciones de Perfiles Paginados
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
     *   description = "Obtener Perfiles Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getPerfilesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.perfiles_service');
        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerPerfilesPaginados($paginacion , $array);
        return $result;
    }
    /**
     * Este Metodo Guarda un Usuario
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Usuarios",
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
    public function postPerfilesAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);// $request->request->all();
        $servicio = $this->get('sgauthbundle.perfiles_service');
        $result = $servicio->guardarPerfiles($data,$login);
        return $result;
//        return ["success" => true , "msg" => "Proceso Ejecutado Correctamente"];

    }


    /**
     * Este Metodo Guarda un Perfil y APP
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @Rest\Post("/aplicaciones")
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar App por Perfil",
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
    public function postPerfilesAplicacionAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.perfiles_service');
        $result = $servicio->grabarPerfilApp($data, $login);
        return $result;

    }


    /**
     * Obtener Opciones de Perfiles Aplicaciones Paginados
     * formato de respuesta pagiandos
     * rows  : listas de objetos segun lo paginado, success : false o true  , total cantidad de registros encontrados
     * formato de envio
     * start : desde donde empieza, limit : cantidad para mostrar , dir : Ordenamiento ASC o DESC , sort Ordenar por la propiedad (Propiedad de alguna columna a ordenar ) ,
     * contiene : para buscar text libre ,
     * para filtros de datos enviar
     * propiedad de la tabla : valor , operador = AND o OR por defecto esta AND
     * por ejemplo para periodos quiero filtrar todos los periodos con etapa a REGIMEN y nro resolucion LL tengo que enviar
     * etapa : REGIMEN , nro_resolucion : lL
     * @Rest\Get("/aplicaciones")
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Perfiles Aplicaciones Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getAplicacionesPorPerfilesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.perfiles_service');
        $array = $request->query;
//        var_dump($array);
        $result = $servicio->obtenerAplicacionesPerfilesPaginados($paginacion , $array);
        return $result;
    }


}