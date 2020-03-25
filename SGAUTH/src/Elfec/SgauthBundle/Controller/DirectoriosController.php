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

class DirectoriosController extends BaseController
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
     * @Rest\Get("/grupos")
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
    public function getGruposDireccionesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.directorios_service');
        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerGruposPaginados($paginacion , $array);
        return $result;
    }

    /**
     * Este Metodo Guarda un Usuario
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @Rest\Post("/grupos")
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
    public function postGruposDireccionesAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;

        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.directorios_service');
        $result = $servicio->guardarGrupo($data,$login);
        return $result;
//        return ["success" => true , "msg" => "Proceso Ejecutado Correctamente"];

    }


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
     * @Rest\Get("/destinatarios")
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
    public function getDestinatariosDireccionesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.directorios_service');
        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerDestinatariosPaginados($paginacion , $array);
        return $result;
    }

    /**
     * Este Metodo Guarda un Usuario
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @Rest\Post("/destinatarios")
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
    public function postDestinatariosDireccionesAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;

        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.directorios_service');
        $result = $servicio->guardarDestinatario($data,$login);
        return $result;
//        return ["success" => true , "msg" => "Proceso Ejecutado Correctamente"];

    }


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
     * @Rest\Get("/destGrupos")
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
    public function getDestinatariosGruposDireccionesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.directorios_service');
        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerDestinatariosGruposPaginados($paginacion , $array);
        return $result;
    }

    /**
     * Este Metodo Guarda un Usuario
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @Rest\Post("/destGrupos")
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
    public function postDestinatariosGruposDireccionesAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;

        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.directorios_service');
        $result = $servicio->guardarDestinatarioGrupo($data,$login);
        return $result;
//        return ["success" => true , "msg" => "Proceso Ejecutado Correctamente"];

    }

    /**
     * Este Metodo Retira al usuario del grupo de corrreo
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @param $id
     * @Rest\Delete("/destGrupos/{id}")
     * @ApiDoc(
     *   resource = true,
     *   description = "Quitar del Grupo de Destinatarios",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function deleteDestinatariosGruposDireccionesAction($id){
//        var_dump($id);
        $Usertoken = $this->container->get("JWTUser");
//        var_dump($Usertoken);
        $login = $Usertoken->login;

        $servicio = $this->get('sgauthbundle.directorios_service');
        $result = $servicio->eliminarDestinatarioGrupo($id,$login);
        return $result;

    }

}