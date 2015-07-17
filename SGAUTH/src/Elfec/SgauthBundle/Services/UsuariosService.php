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
    public function __construct(\Doctrine\ORM\EntityManager $em){

        $this->em = $em;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerUsuariosPaginados($paginacion,$array){

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:usuarios');
        $query = $repo->createQueryBuilder('usu');
        $query = $repo->filtrarDatos($query,$array);
        if(!is_null($paginacion->contiene)){
            $query = $repo->consultaContiene($query,["login","nombre","email","estado"],$paginacion->contiene);
        }
        $result->total=$repo->total($query);
        if(!$paginacion->isEmpty()){
            $query = $repo->obtenerElementosPaginados($query,$paginacion);
        }
        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    /**
     * @param $id
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function obtenerUsuarioPorId($id){

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
    public function obtenerAppUsrPaginados($paginacion,$array){

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:appUsr');
        $query = $repo->createQueryBuilder('usu');
        $query = $repo->filtrarDatos($query,$array);
        if(!is_null($paginacion->contiene)){
            $query = $repo->consultaContiene($query,["login","nombre"],$paginacion->contiene);
        }
        $result->total=$repo->total($query);
        if(!$paginacion->isEmpty()){
            $query = $repo->obtenerElementosPaginados($query,$paginacion);
        }
        var_dump($query->getDQL());
        $rows =array();
        /**
         * @var \Elfec\SgauthBundle\Entity\appUsr $obj
         */
        foreach($query->getQuery()->getResult() as $obj){
            $row = [
                "id_usuario"=> $obj->getIdUsuario()->getIdUsuario(),
                "login" =>$obj->getIdUsuario()->getLogin(),
                "email" => $obj->getIdUsuario()->getEmail(),
                "fch_alta" => $obj->getFchAlta(),
                "fch_baja" =>$obj->getFchBaja(),
                "estado" =>$obj->getEstado(),
                "aplicacion" =>$obj->getIdAplic()->getNombre(),
                "id_perfil" => $obj->getIdPerfil()->getIdPerfil(),
                "id_aplic" => $obj->getIdAplic()->getIdAplic(),
                "perfil" => $obj->getIdPerfil()->getNombre()

            ];
            array_push($rows,$row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

}