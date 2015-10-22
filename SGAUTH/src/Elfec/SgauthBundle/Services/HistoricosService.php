<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;

use Elfec\SgauthBundle\Entity\histEdicionDatos;
use Elfec\SgauthBundle\Entity;

class HistoricosService
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {

        $this->em = $em;
    }

    /**
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerHistoricosEdicionDatos($array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:histEdicionDatos');
        $query = $repo->createQueryBuilder('hist');
        $query = $repo->filtrarDatos($query, $array);

//        $result->total = $repo->total($query);
        $result->rows = $this->generarAgrupado($result->rows, $query);
        $result->success = true;
        $result->total = count($result->rows);
        return $result;
    }

    public function generarAgrupado($row, $query)
    {
        $queryTmp = clone $query;
        $alias = $query->getRootAlias();
        $result = $queryTmp->select($alias . ".fechaReg")
            ->groupBy($alias . '.fechaReg')
            ->orderBy($alias . '.fechaReg', 'DESC')
            ->getQuery();
        $rows = [];
        foreach ($result->getResult() as $obj) {
            $row = $this->generarHistorico($query, $obj["fechaReg"]);
            array_push($rows, $row);
        }
        return $rows;

    }

    /**
     * @param $query
     * @param $date
     * @return array
     */
    public function generarHistorico($query, $date)
    {
        $queryTmp = clone $query;
        $alias = $query->getRootAlias();
        $result = $queryTmp->select($alias)
            ->andWhere($alias . '.fechaReg = :fecha');
        $result->setParameter("fecha", $date);
        $row = [];
        $nuevos = "";
        $antiguos = "";
        /**
         * @var histEdicionDatos $obj
         */
        foreach ($result->getQuery()->getResult() as $obj) {
            $row["login_usr"] = $obj->getLoginUsr();
            $row["fecha_reg"] = $obj->getFechaReg();
            $row["motivo"] = $obj->getMotivo();
            $row["tabla"] = $obj->getTabla();
            $row["id_dato"] = $obj->getIdDato();
            $nuevos = ($nuevos === "") ? sprintf("<em>%s </em>: %s", $obj->getCampo(), $obj->getValorNuevo()) : sprintf("%s </br> <em>%s </em>: %s", $nuevos, $obj->getCampo(), $obj->getValorNuevo());
            $antiguos = ($antiguos === "") ? sprintf("<em>%s </em>: %s", $obj->getCampo(), $obj->getValorAntiguo()) : sprintf("%s </br> <em>%s </em>: %s", $antiguos, $obj->getCampo(), $obj->getValorAntiguo());
        }
        $row["valores_nuevos"] = $nuevos;
        $row["valores_antiguos"] = $antiguos;
        return $row;

    }

//
}