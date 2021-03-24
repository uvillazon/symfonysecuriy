<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


use Elfec\SgauthBundle\Entity\aplicaciones;
use Elfec\SgauthBundle\Entity\appUsr;
use Elfec\SgauthBundle\Entity\usuarios;
use Elfec\SgauthBundle\Model\RespuestaSP;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

class UsuariosService
{
    protected $em;
    protected $emSgauth;
    protected $repoUsuariosAreas;
    protected $erpProveedor;

    /**
     * @var RequestStack
     */
    protected $request;


//    public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\ORM\EntityManager $emSgauth, RequestStack $request)
    public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\ORM\EntityManager $emSgauth, RequestStack $request, \Elfec\ErpBundle\Services\ProveedoresService $erpProv)
    {

        $this->em = $em;
        $this->emSgauth = $emSgauth;
        $this->repoUsuariosAreas = $em->getRepository("ElfecSgauthBundle:usuariosAreas");
        $this->request = $request;
        $this->erpProveedor = $erpProv;
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
            $query = $repo->consultaContiene($query, array("login", "nombre", "email", "estado"), $paginacion->contiene);
        }
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        /**
         * @var usuarios $item
         */
        foreach ($query->getQuery()->getResult() as $item) {
            $today = new \DateTime();
            $item->tieneCertificado = (!is_null($item->getCertBase64()) && $item->getFchCertCaducidad() > $today) ? true : false;
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
            $query = $repo->contieneUsuario($query, array("login", "nombre", "email"), $paginacion->contiene);

        }
//        if (!is_null($paginacion->contiene)) {
//            $query = $repo->consultaContiene($query, ["estado"], $paginacion->contiene);
//        }
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
            $row = array(
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
            );
            array_push($rows, $row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }


    public function guardarUsuario($data, $login)
    {
        $repo = $this->em->getRepository('ElfecSgauthBundle:appUsr');
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
            :p_idempleado::numeric,
            :p_idproveedor::numeric,
            :p_telefono::varchar,
            :p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_usuario", ($data["id_usuario"] == '') ? 0 : $data["id_usuario"]);
            $st->bindValue(":p_login", strtolower($data["login"]));
            $st->bindValue(":p_nombre", $repo->replace($data["nombre"]));
            $st->bindValue(":p_clave", NULL);
            $st->bindValue(":p_email", $data["email"]);
            $st->bindValue(":p_fch_baja", NULL);
            $st->bindValue(":p_estado", $data["estado"]);
            $st->bindValue(":p_id_area", $repo->getValueArray($data, 'id_area', null));
            $st->bindValue(":p_idproveedor", $repo->getValueArray($data, 'idproveedor', null));
            $st->bindValue(":p_idempleado", $repo->getValueArray($data, 'idempleado', null));
            $st->bindValue(":p_telefono", $repo->getValueArray($data, 'telefono', null));
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
            $st = $conection->prepare("SELECT elfec.grabar_perfil_usr(
                :p_id_usuario::NUMERIC,
                :p_id_aplic::NUMERIC,
                :p_id_perfil::NUMERIC,
                :p_operacion::varchar,
                :p_fch_baja::DATE, 
                :p_estado::VARCHAR ,
                :p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_usuario", ($data["id_usuario"] == '') ? 0 : $data["id_usuario"]);
            $st->bindValue(":p_id_aplic", $data["id_aplic"]);
            $st->bindValue(":p_id_perfil", $data["id_perfil"]);
            $st->bindValue(":p_operacion", $data["operacion"]);
            $fechaBaja = array_key_exists('fch_baja', $data) ? $data["fch_baja"] : null;
            $fechaBaja = empty($fechaBaja) ? null : $fechaBaja;

            $st->bindValue(":p_fch_baja", $fechaBaja);
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

    public function borrarAppUsr($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $repo = $this->em->getRepository('ElfecSgauthBundle:appUsr');
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.borrar_app_usr (
            :p_id_usuario::numeric,
            :p_id_aplic::numeric,
            :p_id_perfil::numeric,
            :p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_usuario", $repo->getValueArray($data, "id_usuario", null));
            $st->bindValue(":p_id_aplic", $repo->getValueArray($data, "id_aplic", null));
            $st->bindValue(":p_id_perfil", $repo->getValueArray($data, "id_perfil", null));
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["borrar_app_usr"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["borrar_app_usr"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["borrar_app_usr"];
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
            $query = $repo->contieneUsuario($query, array("login", "nombre", "email"), $paginacion->contiene);

        }
        if (!is_null($array->get("perfil"))) {
            $query = $repo->filtrarPorPerfil($query, $array->get("perfil"));
        }
        if (!is_null($array->get("login"))) {
            $query = $repo->filtrarPorLogin($query, $array->get("login"));
        }
        if (!is_null($array->get("idproveedor"))) {
            $query = $repo->filtrarPorIdProveedor($query, $array->get("idproveedor"));
        }

        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
//        if (!$paginacion->isEmpty()) {
//            $query = $repo->obtenerElementosPaginados($query, $paginacion);
//        }

        $rows = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\appUsr $obj
         */
        foreach ($query->getQuery()->getResult() as $obj) {
            $row = array(
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
                "area" => $obj->getIdUsuario()->getArea(),
                "idproveedor" => $obj->getIdUsuario()->getIdproveedor(),
                "idempleado" => $obj->getIdUsuario()->getIdempleado(),
                "proveedor" => $this->erpProveedor->obtenerProveedorPorId($obj->getIdUsuario()->getIdproveedor())

            );
            array_push($rows, $row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }


    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @return \Elfec\CommonBundle\Model\ResultPaginacion
     * @throws \Exception
     */
    public function obtenerUsuariosActiveDirectory($paginacion)
    {
//        var_dump($paginacion);

        $ad = new \Adldap\Adldap();
        $config = array(
            // An array of your LDAP hosts. You can use either
            // the host name or the IP address of your host.
            'hosts' => array('elffls01.elfec.com'),

            // The base distinguished name of your domain to perform searches upon.
            'base_dn' => 'OU=ELFEC,DC=elfec,DC=com',

            // The account to use for querying / modifying LDAP records. This
            // does not need to be an admin account. This can also
            // be a full distinguished name of the user account.
            'username' => 'sisman@elfec.com',
            'password' => 'Agto.2013E'
        );
        $ad->addProvider($config);
        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        try {
            $provider = $ad->connect();
            $filter = '(objectCategory=person)';
            $search = $provider->search()->rawFilter($filter);
            if (!is_null($paginacion->contiene)) {
                if (!empty($paginacion->condicion)) {
                    $search->whereContains($paginacion->condicion, $paginacion->contiene);
                } else {
                    $search->whereContains('cn', $paginacion->contiene);
                }
            }
            $paginator = $search->paginate($paginacion->limit, $paginacion->page);
            $result->total = $paginator->count();
            /**
             * @var \Adldap\Models\User $item
             */
            $rows = array();
            foreach ($paginator as $item) {
//                var_dump($item);
                $row = array(
                    "nombre" => $item->getName(),
                    "fecha_expiracion" => $item->expirationDate(),
                    "descripcion" => $item->getDescription(),
                    "login" => $item->getFirstAttribute('samaccountname'),
                    "mail" => $item->getFirstAttribute('mail'),
                    "email" => $item->getFirstAttribute('mail'),
                    "tumb" => base64_encode($item->getThumbnail()),
                    "is_active" => $item->isActive(),
                    "is_expired" => $item->isExpired()
                );
                array_push($rows, $row);
            }
            $result->rows = $rows;
        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;
    }

    public function obtenerUsuariosActiveDirectoryOld()
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
                $dn = "OU=ELFEC,DC=elfec,DC=com";
                $filter = "objectCategory=person";
                $justthese = array("mail", "name", "samaccountname", "physicaldeliveryofficename");
                $sr = ldap_search($ldap, $dn, $filter, $justthese);
                $info = ldap_get_entries($ldap, $sr);
                for ($j = 0; $j < count($info) - 1; $j++) {
                    $nombre = array_key_exists("name", $info[$j]) ? $info[$j]["name"][0] : "";
                    $mail = array_key_exists("mail", $info[$j]) ? $info[$j]["mail"][0] : "";
                    $login = array_key_exists("samaccountname", $info[$j]) ? $info[$j]["samaccountname"][0] : "";
                    $unidad = array_key_exists("physicaldeliveryofficename", $info[$j]) ? $info[$j]["physicaldeliveryofficename"][0] : "";
                    array_push($usuarios, array("nombre" => $nombre, "email" => $mail, "login" => $login, "unidad" => $unidad));
                }
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

    protected $directory = "uploads/certificados/";

    public function guardarCertificado($login)
    {
        $result = new RespuestaSP();

        $data = $this->request->getMasterRequest()->request->all();
//        var_dump($data);
        try {
            $files = $this->request->getMasterRequest()->files;
            if (count($files)) {
                /**
                 * @var UploadedFile $uploadedFile
                 */
                $uploadedFile = $files->get('archivo');
                $nombre = $this->directory . "" . $uploadedFile->getClientOriginalName();
                $rename = file_exists($nombre) ? time() . "-" . $uploadedFile->getClientOriginalName() : $uploadedFile->getClientOriginalName();
                $uploadedFile->move($this->directory, $rename);
                $url = $this->directory . "" . $rename;

                if (!$cert_store = file_get_contents($url)) {
                    return new RespuestaSP(false, "Error: Unable to read the cert file\n");
                }
                if (openssl_pkcs12_read($cert_store, $cert_info, $data["cert_pwd_base64"])) {
//                   var_dump($cert_info);
                    $data["cert_base64"] = base64_encode($cert_store);
                    return $this->em->getRepository('ElfecSgauthBundle:usuarios')->actuliazarCertificado($data, $login);

                } else {
                    return new RespuestaSP(false, "no se puede leer el certificado");
                }
            }
        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;

    }

    public function obtenerCertificado($login)
    {
        try {
            /**
             * @var usuarios $usuario
             */
            $usuario = $this->emSgauth->getRepository('ElfecSgauthBundle:usuarios')->findOneBy(array("login" => $login));
            if (empty($usuario)) {
                return new RespuestaSP(false, 'No Existe usuario ni certificado');
            }
            $today = new \DateTime();
            $usuario->tieneCertificado = (!is_null($usuario->getCertBase64()) && $usuario->getFchCertCaducidad() > $today) ? true : false;
            if ($usuario->tieneCertificado) {
                $data = array(
                    "p12" => $usuario->getCertBase64(),
                    "pws" => $usuario->getCertPwdBase64()
                );
                return new RespuestaSP(true, 'Proceso Ejecutado Correctamente', $data);
            } else {
                return new RespuestaSP(false, 'Certificado Caducado o no Existe');
            }
        } catch (\Exception $e) {
            return new RespuestaSP(false, $e->getMessage());
        }
    }

    public function obtenerPerfilesPorUsuariosApp($data)
    {
        /**
         * @var usuarios $usuario
         * @var aplicaciones $aplicacion
         * @var appUsr $item
         */
        $repo = $this->emSgauth->getRepository("ElfecSgauthBundle:appUsr");
        $parametros = $repo->verificarSiExistenCampos(array("usuario", "codigoApp"), $data);
        if (!$parametros->success) {
            return $parametros;
        }
        $usuario = $this->em->getRepository("ElfecSgauthBundle:usuarios")->findOneBy(array("login" => $data["usuario"]));
        if (empty($usuario)) {
            return new RespuestaSP(false, "No existe ese usuario");
        }
        $aplicacion = $this->em->getRepository("ElfecSgauthBundle:aplicaciones")->findOneBy(array("codigo" => $data["codigoApp"]));
        if (empty($aplicacion)) {
            return new RespuestaSP(false, "No existe la aplicacion");
        }
        $appUsr = $repo->findBy(array("usuario" => $usuario->getIdUsuario(), "aplicacion" => $aplicacion->getIdAplic(), "estado" => "ACTIVO"));
        if (count($appUsr) > 1) {
            $rows = array();
            foreach ($appUsr as $item) {
                array_push($rows, $item->getIdPerfil());
            }
            return new RespuestaSP(true, "proceso ejecutado correctamente", $rows);
        }
        return new RespuestaSP(false, "No existe perfiles asociados al usuario");

    }

}