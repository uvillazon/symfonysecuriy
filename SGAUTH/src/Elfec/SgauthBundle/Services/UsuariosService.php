<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


class UsuariosService
{
    protected $em;
    protected $emSgauth;
    protected $repoUsuariosAreas;

    public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\ORM\EntityManager $emSgauth)
    {

        $this->em = $em;
        $this->emSgauth = $emSgauth;
        $this->repoUsuariosAreas = $em->getRepository("ElfecSgauthBundle:usuariosAreas");
    }


    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerUsuariosPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:usuarios');
        $query = $repo->createQueryBuilder('usu');
        $query = $repo->filtrarDatos($query, $array);
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["login", "nombre", "email", "estado"], $paginacion->contiene);
        }
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    /**
     * @param $id
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function obtenerUsuarioPorId($id)
    {

        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:usuarios');
        $obj = $repo->find($id);
        /**
         * @var \Elfec\SgauthBundle\Entity\usuarios $obj
         */
        $result->data = $obj;
        $result->success = true;
        return $result;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerAppUsrPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:appUsr');
        $query = $repo->createQueryBuilder('usu');
        $query = $repo->filtrarDatos($query, $array);
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["estado"], $paginacion->contiene);
        }
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
//        var_dump($query->getDQL());
        $rows = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\appUsr $obj
         */
        foreach ($query->getQuery()->getResult() as $obj) {
            $row = [
                "id_usuario" => $obj->getIdUsuario()->getIdUsuario(),
                "login" => $obj->getIdUsuario()->getLogin(),
                "email" => $obj->getIdUsuario()->getEmail(),
                "nombre" => $obj->getIdUsuario()->getNombre(),
                "fch_alta" => $obj->getFchAlta(),
                "fch_baja" => $obj->getFchBaja(),
                "estado" => $obj->getEstado(),
                "aplicacion" => $obj->getIdAplic()->getNombre(),
                "id_perfil" => $obj->getIdPerfil()->getIdPerfil(),
                "id_aplic" => $obj->getIdAplic()->getIdAplic(),
                "perfil" => $obj->getIdPerfil()->getNombre(),
                "codigo_app" => $obj->getIdAplic()->getCodigo(),
                "area" => $obj->getIdUsuario()->getArea()
            ];
            array_push($rows, $row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    public function guardarUsuario($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_usuarios(
            :p_id_usuario::NUMERIC,
            :p_login::VARCHAR,
            :p_nombre::VARCHAR ,
            :p_clave::VARCHAR,
            :p_email::VARCHAR, 
            :p_fch_baja::DATE, 
            :p_estado::VARCHAR ,
            :p_id_area::numeric,
            :p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_usuario", ($data["id_usuario"] == '') ? 0 : $data["id_usuario"]);
            $st->bindValue(":p_login", strtolower($data["login"]));
            $st->bindValue(":p_nombre", $data["nombre"]);
            $st->bindValue(":p_clave", NULL);
            $st->bindValue(":p_email", $data["email"]);
            $st->bindValue(":p_fch_baja", NULL);
            $st->bindValue(":p_estado", $data["estado"]);
            $st->bindValue(":p_id_area", array_key_exists("id_area", $data) ? $data["id_area"] : null);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["grabar_usuarios"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["grabar_usuarios"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["grabar_usuarios"];
                }
            } else {
                $result->success = false;
                $result->msg = "Ocurrio algun problema al Ejectuar la Funcion en Postgresql";
            }
        } catch (Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;

    }

    public function guardarUsuarioPorApp($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_perfil_usr(:p_id_usuario::NUMERIC,:p_id_aplic::NUMERIC,:p_id_perfil::NUMERIC ,:p_fch_baja::DATE, :p_estado::VARCHAR ,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_usuario", ($data["id_usuario"] == '') ? 0 : $data["id_usuario"]);
            $st->bindValue(":p_id_aplic", $data["id_aplic"]);
            $st->bindValue(":p_id_perfil", $data["id_perfil"]);
            $st->bindValue(":p_fch_baja", NULL);
            $st->bindValue(":p_estado", $data["estado"]);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["grabar_perfil_usr"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["grabar_perfil_usr"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["grabar_perfil_usr"];
                }
            } else {
                $result->success = false;
                $result->msg = "Ocurrio algun problema al Ejectuar la Funcion en Postgresql";
            }
        } catch (Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;

    }


    //Rest Api For Other Aplicaction
    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerUsuariosPorAplicacionPaginados($paginacion, $array)
    {
//                                                  var_dump($array);die();
        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->emSgauth->getRepository('ElfecSgauthBundle:appUsr');
        $query = $repo->createQueryBuilder('usu');
        if (!is_null($paginacion->contiene)) {
            $query = $repo->contieneUsuario($query, ["login", "nombre", "email"], $paginacion->contiene);

        }
        if (!is_null($array->get("perfil"))) {
            $query = $repo->filtrarPorPerfil($query, $array->get("perfil"));
//            var_dump($query->getDQL());
//            var_dump($array);
//            die();
        }

        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }

        $rows = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\appUsr $obj
         */
        foreach ($query->getQuery()->getResult() as $obj) {
            $row = [
                "id_usuario" => $obj->getIdUsuario()->getIdUsuario(),
                "login" => $obj->getIdUsuario()->getLogin(),
                "email" => $obj->getIdUsuario()->getEmail(),
                "nombre" => $obj->getIdUsuario()->getNombre(),
                "fch_alta" => $obj->getFchAlta(),
                "fch_baja" => $obj->getFchBaja(),
                "estado" => $obj->getEstado(),
                "aplicacion" => $obj->getIdAplic()->getNombre(),
                "id_perfil" => $obj->getIdPerfil()->getIdPerfil(),
                "id_aplic" => $obj->getIdAplic()->getIdAplic(),
                "perfil" => $obj->getIdPerfil()->getNombre(),
                "codigo_app" => $obj->getIdAplic()->getCodigo(),
                "area" => $obj->getIdUsuario()->getArea()

            ];
            array_push($rows, $row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    public function obtenerUsuariosActiveDirectory()
    {
        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        try {
            $ldap_server = "elffls01.elfec.com";
            $ldap_user = "sisman@elfec.com";
            $ldap_pass = 'Agto.2013E';

            $ldap = ldap_connect($ldap_server);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            $bind = ldap_bind($ldap, $ldap_user, $ldap_pass);
            $usuarios = array();
            $i = 0;
            if ($bind) {
//                $person = "Erika";
                $dn = "OU=ELFEC,DC=elfec,DC=com";
//                $filter = "(|(sn=$person*)(givenname=$person*))";
                $filter = "objectCategory=person";
                $justthese = array("mail", "name", "samaccountname", "physicaldeliveryofficename");
                $sr = ldap_search($ldap, $dn, $filter, $justthese);
                $info = ldap_get_entries($ldap, $sr);
//                var_dump($info);
//                die();
                for ($j = 0; $j < count($info) - 1; $j++) {
//                    var_dump($info[$j]["name"]);
//                    die();
                    $nombre = array_key_exists("name", $info[$j]) ? $info[$j]["name"][0] : "";
//                    var_dump($nombre);
//                    die();
                    $mail = array_key_exists("mail", $info[$j]) ? $info[$j]["mail"][0] : "";
                    $login = array_key_exists("samaccountname", $info[$j]) ? $info[$j]["samaccountname"][0] : "";
                    $unidad = array_key_exists("physicaldeliveryofficename", $info[$j]) ? $info[$j]["physicaldeliveryofficename"][0] : "";
                    array_push($usuarios, array("nombre" => $nombre, "email" => $mail, "login" => $login, "unidad" => $unidad));
//                    var_dump($usuarios);
//                    if($j>103){
//                        die();
//
//                    }

                }
//                var_dump($usuarios);
//                die();

            }
            $result->rows = $usuarios;
            $result->total = count($usuarios);
            return $result;
        } catch (\Exception  $e) {
            $result->msg = $e->getMessage();
            return $result;
        }
    }

    public function grabarUsuarioArea($data, $login)
    {
        return $this->repoUsuariosAreas->grabarUsuarioArea($data, $login);
    }

    public function eliminarUsuarioArea($id)
    {
        return $this->repoUsuariosAreas->eliminarUsuarioArea($id);
    }

}