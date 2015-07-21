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

    private function sortArray( $data, $field ) {
        $field = (array) $field;
        uasort( $data, function($a, $b) use($field) {
            $retval = 0;
            foreach( $field as $fieldname ) {
                if( $retval == 0 ) $retval = strnatcmp( $a[$fieldname], $b[$fieldname] );
            }
            return $retval;
        } );
        return $data;
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
            $perfil = $opcion->getIdPerfil();
            $row = [
                "opcion"=>$opcion->getIdOpc()->getOpcion(),
                "id"=>$opcion->getIdOpc()->getIdOpc(),
                "url" => $opcion->getIdOpc()->getLink(),
                "tooltip" => $opcion->getIdOpc()->getTooltip(),
                "icono" => $opcion->getIdOpc()->getIcono(),
                "estado" => $opcion->getIdOpc()->getEstado(),
                "padre" => ($opcion->getIdOpc()->getIdPadre() != null)?  $opcion->getIdOpc()->getIdPadre()->getIdOpc():null,
                "estilo"=> $opcion->getIdOpc()->getEstilo(),
                "orden" => $opcion->getIdOpc()->getOrden()

            ];
            array_push($rows,$row);
        }
        $arrayPerfil = array(
            "iderfil" => $perfil->getIdPerfil(),
            "perfil" => $perfil->getNombre(),
            "rol" => $perfil->getRolBd(),
            "descripcion" => $perfil->getDescripcion(),
            "estado" => $perfil->getEstado()
        );
        $this->usrArray["perfil"] = $arrayPerfil;
        $rows = $this->sortArray($rows,'orden');
        $menus = $this->obtenerMenuFormado($rows);
        $connect = JWT::encode(JWT::encode($this->usrArray,$key),$key);
        $token = [
            "exp" => time() + 1,
            "menu" => $menus,
            "aplicacion" =>[
                "bd" => $app->getBdPrinc(),
                "port" => $app->getBdPort(),
                "drive" => $app->getBdPrinc(),
                "host" => $app->getBdHost(),
                "url" => $app->getAppHost(),
                "codigoApp" => $app->getCodigo(),

            ],
            "app" => $connect

        ];
        $jwt = JWT::encode($token, $key);

        return $jwt;
    }

    /**
     * @param $array
     * @return array
     */
    private function obtenerMenuFormado($array){
        $result = array();
//        $result = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
        foreach ( $array as $menu ) {
            if($menu['estado']== 'ACTIVO' && $menu['padre'] == null){
                $opcion = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
                $opcion->href = $menu['url'];
                $opcion->titulo = $menu['opcion'];
                $opcion->iconcls = $menu['icono'];
                $opcion->id = $menu['id'];
                $opcion->tooltip = $menu['tooltip'];
                $subMenus = $this->buscarHijos($array,$menu['id']);
                if(count($subMenus)> 0){
                    $opcion->submenu= $subMenus;
                }
                array_push($result,$opcion);
            }
        }
        return $result;
    }

    private function buscarHijos($array,$idPadre){
        $result = array();
//        var_dump($idPadre);
        foreach ($array as $menu ) {
            if($menu['estado'] == 'ACTIVO' && $menu['padre']==$idPadre){
                $opcion = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
                $opcion->href = $menu['url'];
                $opcion->titulo = $menu['opcion'];
                $opcion->iconcls = $menu['icono'];
                $opcion->id = $menu['id'];
                $opcion->tooltip = $menu['tooltip'];
                $subMenus = $this->buscarHijos($array,$menu['id']);
                if(count($subMenus)> 0){
                    $opcion->submenu= $subMenus;
                }

                array_push($result,$opcion);
            }
        }
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