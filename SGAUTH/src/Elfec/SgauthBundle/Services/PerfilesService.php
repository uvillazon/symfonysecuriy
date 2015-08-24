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

        $query = $this->em->createQuery('
    SELECT c
    FROM ElfecSgauthBundle:perfiles c
    JOIN c.botones
');
        var_dump($query->getDQL());

        return $query->getResult();

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
}