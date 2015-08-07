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
use Exception;
use Firebase\JWT\JWT;
class AutenticacionService
{
    protected $em;
    private $usrArray = array();
    private $idUsr = 0;
    public function __construct(\Doctrine\ORM\EntityManager $em){

        $this->em = $em;
    }
    public function generarTokenPorUsuarioApp($data,$header){


        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        if(is_null($data->get('codigoApp'))){
            $result->msg="Tiene que Ingresar un codigo de aplicacion";
            $result->success = false;
        }
        else{
            $codigoApp = $data->get('codigoApp');
            $managerApp =  $this->em->getRepository('ElfecSgauthBundle:aplicaciones');

            $obj = $managerApp->findOneBy(array('codigo'=> $codigoApp ));
            if(is_null($obj)){
                $result->msg="Codigo de Apliacion  no existe";
                $result->success = false;
            }
            else{
                $test = $this->testConnection($data->get('usuario'),$data->get('password'),$obj);
                if(is_numeric($test)){
                    $usrTest = $this->esUsuarioAppActivo($data->get('usuario'),$obj->getIdAplic());
                    if(is_numeric($usrTest)){
                        $result->msg= "Proceso Ejecutado Correctamente";
                        $result->success = true;
                        $result->data = $this->obtenerTokenPerfil($usrTest,$obj);
                    }
                    else{
                        $result->msg= $usrTest;
                        $result->success = false;
                    }
                }
                else{
                    $result->msg=$test;
                    $result->success = false;
                }

            }
        }
        return $result;
    }



    /**
     * @param $idPerfil
     * @param \Elfec\SgauthBundle\Entity\aplicaciones $app
     * @return array
     */
    private function obtenerTokenPerfil($idPerfil,$app){
        $key = $app->getSecretKey();
        $repoUsr = $this->em->getRepository('ElfecSgauthBundle:perfilesOpciones');
        $menus = $repoUsr->obtenerOpcionesMenuPorPerfil($idPerfil);
        $repoUsr = $this->em->getRepository('ElfecSgauthBundle:appUsr');
        /**
         * @var appUsr $usr
         */
        $usr = $repoUsr->findOneBy(array('perfil'=> $idPerfil , 'usuario' => $this->idUsr));
        $connect = JWT::encode(JWT::encode($this->usrArray["dbConnect"],$key),$key);
        $usuario = array(
            "login" => $usr->getIdUsuario()->getLogin() ,
            "nombre" => $usr->getIdUsuario()->getNombre(),
            "perfil" => $usr->getIdPerfil()->getNombre(),
            "id_perfil" => $usr->getIdPerfil()->getIdPerfil(),
            "id_usuario" => $usr->getIdUsuario()->getIdUsuario(),
            "email" => $usr->getIdUsuario()->getEmail(),
            "estado" => $usr->getIdUsuario()->getEstado(),
            "aplicacion" => $usr->getIdAplic()->getNombre(),
            "codigoApp" => $usr->getIdAplic()->getCodigo(),
            "id_aplic" => $usr->getIdAplic()->getIdAplic()
        );
        $token = [
            "exp" => time() + 120,
            "menu" => $menus,
            "usuario" => $usuario,
            "key" => $connect

        ];
        $jwt = JWT::encode($token, $key);
        $result = array(
            "token" => $jwt ,
            "menu" => $menus,
            "usuario" => $usuario
        );
        return $result;
    }

    /**
     * @param string $usuario
     * @return string
     */
    private function esUsuarioAppActivo($usuario,$idApp){
        $repoUsr = $this->em->getRepository('ElfecSgauthBundle:usuarios');
        /**
         * @var usuarios $usr
         */
        $usr =  $repoUsr->findOneBy(array('login'=> $usuario));
        $result = "";
        if(is_null($usr)){
            $result = sprintf("el usuario: %s No tiene permiso para acceder a la Aplicacion",$usuario);
        }
        else{
            if($usr->getEstado()=="ACTIVO"){
                $repoUsrApp =  $this->em->getRepository('ElfecSgauthBundle:appUsr');
                /**
                 * @var appUsr $usrApp
                 */
                $usrApp =  $repoUsrApp->findOneBy(array('usuario'=>$usr->getIdUsuario(),'aplicacion'=>$idApp));
//                var_dump($usrApp->getEstado());
                if(is_null($usrApp)){
                    $result = sprintf("el usuario: %s No tiene permiso para acceder a la Aplicacion",$usuario);
                }
                else{
                    if($usrApp->getEstado()=="ACTIVO"){
                        $result = $usrApp->getIdPerfil()->getIdPerfil();
                        $usrArray = array(
                            "usuario" => $usr->getLogin(),
                            "nombre" => $usr->getNombre(),
                            "estado" => $usr->getEstado(),
                            "email" => $usr->getEmail()
                        );
                        $this->idUsr = $usr->getIdUsuario();
                        $this->usrArray["usuario"] = $usrArray;
                    }
                    else{
                        $result = sprintf("el usuario: %s esta INACTIVO",$usuario);
                    }
                }
            }
            else{
                $result = sprintf("el usuario: %s esta INACTIVO",$usuario);
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
    private function testConnection($usuario,$password , $app){
        try{
            $config = new \Doctrine\DBAL\Configuration();
            $connectionParams = array(
                'dbname' => $app->getBdPrinc(),
                'user' => $usuario,
                'password' => $password,
                'host' => $app->getBdHost(),
                'port'=> $app->getBdPort(),
                'driver' => $app->getBdDrive()
            );
            $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
            $conn->connect();
            $conn->close();
            $this->usrArray["dbConnect"] = $connectionParams;
//            array_push($this->usrArray,$connectionParams);
            $result=1;
        }
        catch(Exception $ex){
            $result=$ex->getMessage();
        }
        return $result;
    }
}