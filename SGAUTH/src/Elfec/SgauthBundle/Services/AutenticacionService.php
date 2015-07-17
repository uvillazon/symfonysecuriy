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
    public function __construct(\Doctrine\ORM\EntityManager $em){

        $this->em = $em;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerAplicacionesPaginados($paginacion,$array){

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:aplicaciones');
        $query = $repo->createQueryBuilder('app');
        $query = $repo->filtrarDatos($query,$array);
        if(!is_null($paginacion->contiene)){
            $query = $repo->consultaContiene($query,["nombre","descripcion","codigo"],$paginacion->contiene);
        }
        $result->total=$repo->total($query);
        if(!$paginacion->isEmpty()){
            $query = $repo->obtenerElementosPaginados($query,$paginacion);
        }
        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
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
     * @return string
     */
    private function obtenerTokenPerfil($idPerfil,$app){
        $key = $app->getSecretKey();
        $repoUsr = $this->em->getRepository('ElfecSgauthBundle:perfilesOpciones');
        $opciones = $repoUsr->findBy(array('perfil'=>$idPerfil));
        /**
         * @var perfilesOpciones $opcion
         */
        $rows =array();
        foreach ($opciones as $opcion ) {
//            var_dump($opcion);
            $row = [
                "estado"=>$opcion->getIdOpc()->getEstado(),
                "perfil"=>$opcion->getIdOpc()->getOpcion()

            ];
            array_push($rows,$row);
        }

//        $token = array(
//
//        );
//        $jwt = \JWT::encode($token, $key);
        $jwt = JWT::encode($rows, $key);

        return $jwt;
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
            $result=1;
        }
        catch(Exception $ex){
            $result=$ex->getMessage();
        }
        return $result;
    }
}