<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


use Doctrine\ORM\Tools\Export\ExportException;
use Elfec\SgauthBundle\ElfecSgauthBundle;
use Elfec\SgauthBundle\Entity\aplicaciones;
use Elfec\SgauthBundle\Entity\appUsr;
use Elfec\SgauthBundle\Entity\menuOpciones;
use Elfec\SgauthBundle\Entity\perfilesOpciones;
use Elfec\SgauthBundle\Entity\usuarios;
use Elfec\SgauthBundle\Entity\usuariosAreas;
use Exception;
use Firebase\JWT\JWT;

class AutenticacionService
{
    protected $em;
    private $usrArray = array();
    private $idUsr = 0;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {

        $this->em = $em;
    }


    public function generarTokenPorUsuarioApp($data, $header)
    {


        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        if (is_null($data->get('codigoApp'))) {
            $result->msg = "Tiene que Ingresar un codigo de aplicacion";
            $result->success = false;
        } else {
            $codigoApp = $data->get('codigoApp');
            $managerApp = $this->em->getRepository('ElfecSgauthBundle:aplicaciones');

            $obj = $managerApp->findOneBy(array('codigo' => $codigoApp));
            $aplicacion = !is_null($data->get('id_aplic')) ? $managerApp->find($data->get('id_aplic')) : null;

//            var_dump($aplicacion);
            if (is_null($obj)) {
                $result->msg = "Codigo de Apliacion  no existe";
                $result->success = false;
            } else {
                $test = $this->testConnection($data->get('usuario'), $data->get('password'), $obj);
//                var_dump($test);die();
                if (is_numeric($test) && $data->get('codigoApp') != 'SISMAN') {
                    $usrTest = $this->esUsuarioAppActivo($data->get('usuario'), $obj->getIdAplic(), $aplicacion);
                    if (is_numeric($usrTest)) {
                        $result->msg = "Proceso Ejecutado Correctamente";
                        $result->success = true;
                        $result->data = $this->obtenerTokenPerfil($usrTest, $obj, $aplicacion);
                        $result->data = !is_null($aplicacion) ? $this->pushArrayApp($aplicacion, $result->data) : $result->data;
                    } else {
                        $result->msg = $usrTest;
                        $result->success = false;
                    }
                } else if (is_numeric($test) && $data->get('codigoApp') == 'SISMAN') {
                    $result->msg = "Proceso Ejecutado Correctamente";
                    $result->success = true;
                    $result->data = $this->obtenerTokenSisman($obj, $data);
                } else {
                    $result->msg = $test;
                    $result->success = false;
                }

            }
        }
        return $result;
    }

    /**
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $app
     * @param array $array
     * @return array
     */
    private function pushArrayApp($app, $array)
    {
//        var_dump($array);
        $row = array(
            "codigo" => $app->getCodigo(),
            "aplicacion" => $app->getNombre(),
            "id_aplic" => $app->getIdAplic()

        );

        $array["aplicacion"] = $row;
//        array_push($array, $row);

//            var_dump($array);
        return $array;
    }

    /**
     * metodo temporal para obtener
     */
    private function obtenerTokenSisman($app, $data)
    {
        $key = $app->getSecretKey();
        $connect = JWT::encode(JWT::encode($this->usrArray["dbConnect"], $key), $key);
        $token = [
            "exp" => time() + $app->getTiempoValidoToken() * 3600,

            "key" => $connect

        ];
//        var_dump($data);
        $jwt = JWT::encode($token, $key);
        $result = array(
            "token" => $jwt,
            "usuario" => array(
                "login" => $data->get("usuario"),
                "codigoApp" => $data->get("codigoApp")
            )
        );
        return $result;
    }


    private function obtenerAreas($idAplic)
    {
        $repoUsrArea = $this->em->getRepository('ElfecSgauthBundle:usuariosAreas');
        /**
         * @var usuariosAreas $area
         */
        $areas = $repoUsrArea->findBy(array("idUsuario" => $this->idUsr, "idAplic" => $idAplic));
        $rows = array();
        foreach ($areas as $area) {
            $row = array(
                "nom_area" => $area->getArea()->getNomArea(),
                "id_area" => $area->getIdArea(),
                "estado" => $area->getArea()->getEstado()
            );
            array_push($rows, $row);
        }
        return $rows;
    }

    /**
     * @param $idPerfil
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $app
     * * @param \Elfec\SgauthBundle\Entity\aplicaciones $aplicacion
     * @return array
     */
    private function obtenerTokenPerfil($idPerfil, $app, $aplicacion)
    {
        $key = $app->getSecretKey();
        $repoUsr = $this->em->getRepository('ElfecSgauthBundle:perfilesOpciones');
        $menus = $repoUsr->obtenerOpcionesMenuPorPerfil($idPerfil);
        $repoUsr = $this->em->getRepository('ElfecSgauthBundle:appUsr');


        /**
         * @var appUsr $usr
         *
         */
        $usr = $repoUsr->findOneBy(array('perfil' => $idPerfil, 'usuario' => $this->idUsr));
        $areas = $this->obtenerAreas($app->getIdAplic());
        $connect = JWT::encode(JWT::encode($this->usrArray["dbConnect"], $key), $key);
        $usuario = array(
            "login" => $usr->getIdUsuario()->getLogin(),
            "nombre" => $usr->getIdUsuario()->getNombre(),
            "perfil" => $usr->getIdPerfil()->getNombre(),
            "id_perfil" => $usr->getIdPerfil()->getIdPerfil(),
            "id_usuario" => $usr->getIdUsuario()->getIdUsuario(),
            "email" => $usr->getIdUsuario()->getEmail(),
            "estado" => $usr->getIdUsuario()->getEstado(),
            "aplicacion" => $usr->getIdAplic()->getNombre(),
            "codigoApp" => $usr->getIdAplic()->getCodigo(),
            "id_aplic" => $usr->getIdAplic()->getIdAplic(),
            "area" => (is_null($usr->getIdUsuario()->getIdArea())) ? null : $usr->getIdUsuario()->getArea()->getNomArea()
        );
        if ($app->getCodigo() === "SGCST") {
            $token = [
                "exp" => time() + $app->getTiempoValidoToken() * 3600,
//                "menu" => $menus,
                "usuario" => $usuario,
                "areas" => $areas,
                "key" => $connect

            ];
        } else {
            $token = [
                "exp" => time() + $app->getTiempoValidoToken() * 3600,
                "usuario" => $usuario,
                "areas" => $areas,
                "key" => $connect
            ];
        }
        $token = !is_null($aplicacion) ? $this->pushArrayApp($aplicacion, $token) : $token;
        $jwt = JWT::encode($token, $key);
        $result = array(
            "token" => $jwt,
            "menu" => $menus,
            "usuario" => $usuario,
            "areas" => $areas
        );
        return $result;
    }


    /**
     * @param $usuario
     * @param $idApp
     * @param aplicaciones $aplicacion
     * @return string
     */
    private function esUsuarioAppActivo($usuario, $idApp, $aplicacion)
    {
        $repoUsr = $this->em->getRepository('ElfecSgauthBundle:usuarios');
        $repoPerfilApp = $this->em->getRepository('ElfecSgauthBundle:perfilesAplicaciones');
//        $servicioPerfil = $this->get('sgauthbundle.perfiles_service');
//        $apps = $servicioPerfil->obtenerAplicacionesPorPerfil($Usertoken->id_perfil);
        /**
         * @var usuarios $usr
         */
        $usr = $repoUsr->findOneBy(array('login' => $usuario));
        $result = "";
        if (is_null($usr)) {
            $result = sprintf("el usuario: %s No tiene permiso para acceder a la Aplicacion", $usuario);
        } else {
            if ($usr->getEstado() == "ACTIVO") {
                $repoUsrApp = $this->em->getRepository('ElfecSgauthBundle:appUsr');
                /**
                 * @var appUsr $usrApp
                 */
                $usrApp = $repoUsrApp->findOneBy(array('usuario' => $usr->getIdUsuario(), 'aplicacion' => $idApp));
//                var_dump($usrApp->getEstado());
                if (is_null($usrApp)) {
                    $result = sprintf("el usuario: %s No tiene permiso para acceder a la Aplicacion", $usuario);
                } else {
                    if (!is_null($aplicacion)) {
                        $appPerfil = $repoPerfilApp->findOneBy(array("idPerfil" => $usrApp->getPerfil(), "idAplic" => $aplicacion->getIdAplic()));
                        if (is_null($appPerfil)) {
                            return sprintf("El usuario : %s no tiene permiso de administracion de la aplicacion %s", $usuario, $aplicacion->getCodigo());
                        }
                    }
                    if ($usrApp->getEstado() == "ACTIVO") {
                        $result = $usrApp->getIdPerfil()->getIdPerfil();
                        $usrArray = array(
                            "usuario" => $usr->getLogin(),
                            "nombre" => $usr->getNombre(),
                            "estado" => $usr->getEstado(),
                            "email" => $usr->getEmail()
                        );
                        $this->idUsr = $usr->getIdUsuario();
                        $this->usrArray["usuario"] = $usrArray;
                    } else {
                        $result = sprintf("el usuario: %s esta INACTIVO", $usuario);
                    }
                }
            } else {
                $result = sprintf("el usuario: %s esta INACTIVO", $usuario);
            }
        }
        return $result;

    }

    /**
     * @param string $usuario
     * @param string $password
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $app
     * @return string
     */
    private function testConnection($usuario, $password, $app)
    {
        try {
            $config = new \Doctrine\DBAL\Configuration();
            $connectionParams = array(
                'dbname' => $app->getBdPrinc(),
                'user' => $usuario,
                'password' => $password,
                'host' => $app->getBdHost(),
                'port' => $app->getBdPort(),
                'driver' => $app->getBdDrive(),
                'service' => true
            );
//            var_dump($connectionParams);
            $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
            $conn->connect();
            $conn->close();
            $this->usrArray["dbConnect"] = $connectionParams;
//            array_push($this->usrArray,$connectionParams);
            $result = 1;
        } catch (\PDOException $ex) {
//            var_dump($ex);
            $result = "Error: autenticación de contraseña falló para el usuario :" . $usuario;
//            $result = $ex->getMessage();
        }
        return $result;
    }
}