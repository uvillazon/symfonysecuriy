<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


class AplicacionesService
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
    public function guardarAplicacion($data , $login ){
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_usuarios(:p_id_usuario::NUMERIC,:p_login::VARCHAR,:p_nombre::VARCHAR ,:p_clave::VARCHAR,:p_email::VARCHAR, :p_fch_baja::DATE, :p_estado::VARCHAR ,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_usuario",($data["id_usuario"]=='')? 0 : $data["id_usuario"]);
            $st->bindValue(":p_login", $data["login"]);
            $st->bindValue(":p_nombre",  $data["nombre"]);
            $st->bindValue(":p_clave", NULL);
            $st->bindValue(":p_email", $data["email"]);
            $st->bindValue(":p_fch_baja", NULL);
            $st->bindValue(":p_estado", $data["estado"]);
            $st->bindValue(":p_login_usr",$login);
            $st->execute();
            $response = $st->fetchAll();
            if(count($response)>0){
                if(is_numeric($response[0]["grabar_usuarios"])){
                    $result->success=true;
                    $result->msg= "Proceso Ejectuado Correctamente";
                    $result->id= $response[0]["grabar_usuarios"];
                }
                else{
                    $result->success=false;
                    $result->msg= $response[0]["grabar_usuarios"];
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