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
}