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

class UsuariosController extends BaseController
{
    /**
     * Obtener Usuarios Paginados
     * formato de respuesta pagiandos
     * rows  : listas de objetos segun lo paginado, success : false o true  , total cantidad de registros encontrados
     * formato de envio
     * start : desde donde empieza, limit : cantidad para mostrar , dir : Ordenamiento ASC o DESC , sort Ordenar por la propiedad (Propiedad de alguna columna a ordenar ) ,
     * contiene : para buscar text libre ,
     * para filtros de datos enviar
     * propiedad de la tabla : valor , operador = AND o OR por defecto esta AND
     * por ejemplo para periodos quiero filtrar todos los periodos con etapa a REGIMEN y nro resolucion LL tengo que enviar
     * etapa : REGIMEN , nro_resolucion : lL
     * @Rest\Get("/usuarios")
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Usuarios Paginados",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getUsuariosAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $array = $request->query;
        $result = $servicio->obtenerUsuariosPaginados($paginacion, $array);
        return $result;
    }


    /**
     * Obtener Un Usuario dado un id
     * formato de respuesta
     * {success : (true o false) , msg : Mensaje de accion  , data : objecto solicitado }
     * @Rest\Get("/usuarios/{id}")
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener un usuario",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getUsuarioAction($id)
    {

        $servicio = $this->get('sgauthbundle.usuarios_service');
        $result = $servicio->obtenerUsuarioPorId($id);
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
    public function postUsuariosAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $result = $servicio->guardarUsuario($data, $login);
        return $result;
//        return ["success" => true , "msg" => "Proceso Ejecutado Correctamente"];

    }

    //Usuarios por Aplicaciones

    /**
     * Obtener Usuarios Aplicaciones Paginados para obtener usuarios de la aplicacion SGCST se tiene que enviar ?id_aplic=1&(optional id_perfil= {algun perfil especifico si coresponde}) (1 id de la aplicacion SGCST)
     * formato de respuesta pagiandos
     * rows  : listas de objetos segun lo paginado, success : false o true  , total cantidad de registros encontrados
     * formato de envio
     * start : desde donde empieza, limit : cantidad para mostrar , dir : Ordenamiento ASC o DESC , sort Ordenar por la propiedad (Propiedad de alguna columna a ordenar ) ,
     * contiene : para buscar text libre ,
     * para filtros de datos enviar
     * propiedad de la tabla : valor , operador = AND o OR por defecto esta AND
     * por ejemplo para periodos quiero filtrar todos los periodos con etapa a REGIMEN y nro resolucion LL tengo que enviar
     * etapa : REGIMEN , nro_resolucion : lL
     * @Rest\Get("/usuarios_app")
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Usuarios APP",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getUsuariosappaaAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.usuarios_service');

        $array = $this->getTokenApp($request);
        $result = $servicio->obtenerAppUsrPaginados($paginacion, $array);
        return $result;
    }

//


    /**
     * @param Request $request
     * @Rest\Get("/usuariosAD")
     * @return ResultPaginacion
     */
    public function getUsuariosActiveDirectoryAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $array = $request->query;
//        var_dump($array);
        $result = $servicio->obtenerUsuariosActiveDirectory($paginacion, $array, false);
        return $result;
    }

    /**
     * Este Metodo Guarda un Usuario por Aplicacion
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Asignacion de Usuarios Por Aplicacion ",
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
    public function postUsuariosappAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $result = $servicio->guardarUsuarioPorApp($data, $login);
        return $result;
//        return ["success" => true , "msg" => "Proceso Ejecutado Correctamente"];

    }

    /**
     * Este Metodo Guarda un Usuario por Aplicacion
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Guardar Asignacion de Usuarios Por Aplicacion ",
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
    public function postEliminarUsuariosappAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $request->request->all();
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $result = $servicio->borrarAppUsr($data, $login);
        return $result;

    }

    /**
     * Este Metodo Cqambia la contrasea del usuario
     * como resultado devuelve los sig. datos{ success= true cuando esta correcto o false si ocurrio algun problema}
     * msg = "mensaje de la accion" , id = "Id del objeto guardado" , data = datos del objeto guardado}
     * Se debe enviar los nombres de las propiedades de las tablas de la BD
     * @ApiDoc(
     *   resource = true,
     *   description = "Cambiar la contrasea del usuario",
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
    public function postCambiarcontrasenaAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $servicio = $this->get('sgauthbundle.recuperacion_service');
        $data = $request->request->all();
//        var_dump($data)
        $data["usuario"] = $Usertoken->login;
        $result = $servicio->cambiar_password_sc($data);
        if ($result->success) {
            $servicio = $this->get('sgauthbundle.autenticacion_service');
            $array = $request->query;
            $array1 = $request->request->all();
            $array->set("codigoApp", $Usertoken->codigoApp);
            $array->set("usuario", $Usertoken->login);
            $array->set("password", $array1['password']);
            $header = $request->headers;
            $result = $servicio->generarTokenPorUsuarioApp($array, $header);
        }
        return $result;
    }

    /**
     * @Rest\Post("/usuarios_areas")
     * @param Request $request
     * @return mixed
     */
    public function postGrabarUsuarioAreaAction(Request $request)
    {

        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $result = $servicio->grabarUsuarioArea($data, $login);
        return $result;
    }

    /**
     * @Rest\Post("/usuarios_areas/eliminar")
     * @param Request $request
     * @return mixed
     */
    public function postEliminarUsuarioAreaAction(Request $request)
    {
        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        $data = $this->postTokenApp($request);
        $servicio = $this->get('sgauthbundle.usuarios_service');
        $result = $servicio->eliminarUsuarioArea($data["id"]);
        return $result;
    }

    /**
     * @Rest\Post("/certificado")
     * @param Request $request
     * @return mixed
     */
    public function postGuardarCertificadoAction(Request $request)
    {
        $Usertoken = $this->container->get("JWTUser");
        $login = $Usertoken->login;
        return $this->get('sgauthbundle.usuarios_service')->guardarCertificado($login);

    }
}