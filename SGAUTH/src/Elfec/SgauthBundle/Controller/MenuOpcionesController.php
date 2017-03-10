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

class MenuOpcionesController extends BaseController
{
    /**
     * Obtener Opciones de Menu Paginafos
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
     *   description = "Obtener Opciones de Menu Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getMenusAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.MenuOpciones_service');
        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerOpcionesaginados($paginacion , $array);
        return $result;
    }

    /**
     * Obtener Opciones de  Menu Segun Perfil de Usuario
     * RespuestaSP {success : true , data : lista de objetos , msg : mensaje de Error o Exito}
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Opciones de Menu Por usuario",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getOpcionesAction(Request $request)
    {
        $usuario = 1;
        $codigoApp =2;
        $servicio= $this->get('sgauthbundle.MenuOpciones_service');
        $result = $servicio->obtenerOpcionesPorUsuario($usuario, $codigoApp);
        return $result;
    }

    /**
     * Obtener Botones Paginagos
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
     *   description = "Obtener Botones Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getBotonesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.MenuOpciones_service');
        $array = $request->query;
        $result = $servicio->obtenerBotonesPaginados($paginacion , $array);
        return $result;
    }


    /**
     * Este Metodo Guarda Opciones por Aplicacion
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Opciones Por Aplicacion ",
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
    public function postOpcionesAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.MenuOpciones_service');
        $result = $servicio->guardarOpcion($data,$login);
        return $result;
//        return ["success" => true , "msg" => "Proceso Ejecutado Correctamente"];

    }

    /**
     * Este Metodo Guarda Botones por Opcion
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Botones Por Opcion ",
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
    public function postBotonesAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.MenuOpciones_service');
        $result = $servicio->guardarBoton($data,$login);
        return $result;

    }

    /**
     * Obtener Opciones de Menu Por Perfil Paginados
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
     *   description = "Obtener Opciones de Menu Por Perfil Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getMenusperfilesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.MenuOpciones_service');
        $array = $request->query;
        $result = $servicio->obtenerOpcionesPerfilPaginados($paginacion , $array);
        return $result;
    }


    /**
     * Obtener Opciones de Menu Por Perfil Paginados
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
     *   description = "Obtener Opciones de Menu Por Perfil Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getBotonesperfilesAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.MenuOpciones_service');
        $array = $request->query;
        $result = $servicio->obtenerBotonesPerfilPaginados($paginacion , $array);
        return $result;
    }

    /**
     * Este Agrega una Opciona  un determinado Perfil
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Agregar Opciones a Perfil",
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
    public function postAgregarOpcionAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.MenuOpciones_service');
        $result = $servicio->guardarOpcionPerfil($data,$login);
        return $result;

    }

    /**
 * Este Metodo Quitar Opciones de Perfil
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "quitar Opcion a un perfil ",
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
    public function postQuitarOpcionAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.MenuOpciones_service');
        $result = $servicio->eliminarOpcionPerfil($data,$login);
        return $result;

    }

    /**
     * Este Agrega un Boton a un determinado Perfil
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Agregar Boton a Perfil",
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
    public function postAgregarBotonesAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.MenuOpciones_service');
        $result = $servicio->guardarBotonPerfil($data,$login);
        return $result;

    }

    /**
     * Este Metodo Quitar Boton de Perfil
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "quitar Boton a un perfil ",
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
    public function postQuitarBotonAction(Request $request) {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.MenuOpciones_service');
        $result = $servicio->eliminarBotonPerfil($data,$login);
        return $result;

    }
//guardarBotonPerfil
//eliminarBotonPerfil
}