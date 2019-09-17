<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 02/07/2015
 * Time: 05:29 PM
 */

namespace Elfec\ErpBundle\Services;

use Elfec\ErpBundle\Entity;
use Elfec\SgauthBundle\Model\ResultPaginacion;

class EmpleadosService
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {

        $this->em = $em;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerEmpleadossPaginados($paginacion, $array)
    {
        $result = new ResultPaginacion();
        $repo = $this->em->getRepository('ElfecErpBundle:Empleados');
        $query = $repo->createQueryBuilder('app');
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["idempleado", "nombre"], $paginacion->contiene);
        }
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }


}