<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


class PerfilesService
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
    public function obtenerPerfilesPaginados($paginacion,$array){

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:perfiles');
        $query = $repo->createQueryBuilder('per');
        $query = $repo->filtrarDatos($query,$array);
        if(!is_null($paginacion->contiene)){
            $query = $repo->consultaContiene($query,["nombre","descripcion","estado"],$paginacion->contiene);
        }
        $result->total=$repo->total($query);
        if(!$paginacion->isEmpty()){
            $query = $repo->obtenerElementosPaginados($query,$paginacion);
        }
        $rows =array();
        /**
         * @var \Elfec\SgauthBundle\Entity\perfiles $obj
         */
        foreach($query->getQuery()->getResult() as $obj){
            $row = array(
                "id_perfil"=> $obj->getIdPerfil(),
                "id_aplic" =>$obj->getIdAplic()->getIdAplic(),
                "codigo_app" =>$obj->getIdAplic()->getCodigo(),
                "aplicacion" => $obj->getIdAplic()->getNombre(),
                "nombre" => $obj->getNombre(),
                "descripcion" =>$obj->getDescripcion(),
                "rol_bd" =>$obj->getRolBd(),
                "estado" =>$obj->getEstado()
            );
            array_push($rows,$row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    public function guardarPerfiles($data , $login ){
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_perfiles(:p_id_perfil::NUMERIC,:p_id_aplic::NUMERIC,:p_nombre::VARCHAR,:p_descripcion::VARCHAR ,:p_rol_bd::VARCHAR, :p_estado::VARCHAR ,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_perfil",($data["id_perfil"]=='')? 0 : $data["id_perfil"]);
            $st->bindValue(":p_id_aplic", $data["id_aplic"]);
            $st->bindValue(":p_nombre",  $data["nombre"]);
            $st->bindValue(":p_descripcion", $data["descripcion"]);
            $st->bindValue(":p_rol_bd", '');
            $st->bindValue(":p_estado", $data["estado"]);
            $st->bindValue(":p_login_usr",$login);
            $st->execute();
            $response = $st->fetchAll();
            if(count($response)>0){
                if(is_numeric($response[0]["grabar_perfiles"])){
                    $result->success=true;
                    $result->msg= "Proceso Ejectuado Correctamente";
                    $result->id= $response[0]["grabar_perfiles"];
                }
                else{
                    $result->success=false;
                    $result->msg= $response[0]["grabar_perfiles"];
                }
            }
            else{
                $result->success=false;
                $result->msg="Ocurrio algun problema al Ejectuar la Funcion en Postgresql";
            }
        }
        catch (Exception $e) {
            $result->success=false;
            $result->msg= $e->getMessage();
        }
        return $result;

    }

//
}