<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:04 PM
 */

namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param array $array
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function filtrarDatos($query, $array)
    {

        $operador = (is_null($array->get('operador'))) ? " and " : $array->get('operador');
        $fields = array_keys($this->getClassMetadata()->fieldNames);
//        var_dump($query->getDQL());
//         var_dump($this->getClassMetadata()->getFieldMapping());die();
        $alias = $query->getRootAlias();
        foreach ($fields as $field) {
            if (!is_null($array->get($field))) {
                $fieldMapping = $this->getClassMetadata()->getFieldForColumn($field);
                if (trim(strtoupper($operador)) === "AND") {
                    $where = sprintf("%s.%s = :%s", $alias, $fieldMapping, $field);
                    $query->andWhere($where);
                    $query->setParameter($field, $array->get($field));
                } else {
                    $where = sprintf("%s.%s = :%s", $alias, $fieldMapping, $field);
                    $query->orWhere($where);
                    $query->setParameter($field, $array->get($field));
                }
            }
        }
        return $query;
    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param array $array
     * @param string $contiene
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function consultaContiene($query, $array, $contiene)
    {

        if ($contiene != "") {
            $fields = array_keys($this->getClassMetadata()->fieldNames);
            $alias = $query->getRootAlias();
            $count = 0;
            foreach ($array as $field) {
                $fieldMapping = $this->getClassMetadata()->getFieldForColumn($field);
                $where = sprintf("UPPER(%s.%s) LIKE :condicion", $alias, $fieldMapping);
                if ($count == 0) {
                    $query->andWhere($where);
                } else {
                    $query->orWhere($where);
                }
                $count++;
            }
            $query->setParameter("condicion", "%" . strtoupper($contiene) . "%");
        }
        return $query;
    }

    /**Metodo que retorna el Total con los filtros de un queryBuilder
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @return int
     */
    public function total($query)
    {
        $queryTmp = clone $query;
        $alias = $query->getRootAlias();
//        var_dump($query->getDQL());
        $total = $queryTmp->select('COUNT(' . $alias . ')')
            ->getQuery()
            ->getSingleScalarResult();
//        var_dump($total);
        return $total;


    }
//    public function total($query)
//    {
//        return count($query->getQuery()->getResult());
//
//    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function obtenerElementosPaginados($query, $paginacion)
    {
        $alias = $query->getRootAlias();
        $this->configPaginacion($paginacion);
//        var_dump($paginacion);
        $fieldMapping = $this->getClassMetadata()->getFieldForColumn($paginacion->sort);
        $order = sprintf("%s.%s", $alias, $fieldMapping);
        $query->addOrderBy($order, $paginacion->dir)->setFirstResult($paginacion->start)->setMaxResults($paginacion->limit);
        return $query;

    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     */
    public function configPaginacion($paginacion)
    {

        $paginacion->dir = (is_null($paginacion->dir)) ? "ASC" : $paginacion->dir;
        $paginacion->sort = (is_null($paginacion->sort)) ? $this->getClassMetadata()->getIdentifierColumnNames()[0] : $paginacion->sort;
        $paginacion->start = (is_null($paginacion->start)) ? 0 : $paginacion->start;
        $paginacion->limit = (is_null($paginacion->limit)) ? 25 : $paginacion->limit;
    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param \Doctrine\Common\Collections\Criteria $criterio
     */
    public function buscarPorCriterio($query, $criterio)
    {
        $query->addCriteria($criterio);
    }

    /**
     * Ordena un array por el campo mencionado
     * @param array $data
     * @param strign $field
     * @return array
     */
    public function sortArray($data, $field)
    {
        $field = (array)$field;
        uasort($data, function ($a, $b) use ($field) {
            $retval = 0;
            foreach ($field as $fieldname) {
                if ($retval == 0) $retval = strnatcmp($a[$fieldname], $b[$fieldname]);
            }
            return $retval;
        });
        return $data;
    }
}