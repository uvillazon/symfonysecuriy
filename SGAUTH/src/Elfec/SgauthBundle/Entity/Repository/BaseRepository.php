<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:04 PM
 */

namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Elfec\SgauthBundle\Model\RespuestaSP;

class BaseRepository extends EntityRepository
{
    protected $arraySearch = array("'");
    protected $arrayReplece = array(" ");

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
//            var_dump($array);
//            die();
            $fieldMapping = $this->getClassMetadata()->getFieldForColumn($field);
            if (is_array($array->get($field))) {
                $query = $this->contieneInArray($query, $array->get($field), $field);


            } else {
                if (!is_null($array->get($field)) && strlen($array->get($field)) > 0) {
//                var_dump($field);
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
        }
//        var_dump($query->getDQL());
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
//            var_dump($query->getState());
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
        $alias = $query->getRootAliases()[0];
        $idTable = $this->getClassMetadata()->getIdentifier()[0];
//        $queryTmp->select('COUNT(' . $alias . ')');
//        var_dump($queryTmp->getDQL());
        $total = $queryTmp->select('COUNT(' . $alias . '.' . $idTable . ')')
            ->getQuery()
            ->getSingleScalarResult();
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
        $alias = $query->getRootAliases()[0];
        $query = $this->ordenarPor($query, $paginacion);
        $query->setFirstResult($paginacion->start)->setMaxResults($paginacion->limit);
        return $query;


    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function ordenarPor($query, $paginacion)
    {
        $alias = $query->getRootAliases()[0];
        if ($paginacion->multiSort) {
            $objectSort = json_decode($paginacion->sort, true);
            foreach ($objectSort as $objet) {
                $direccion = $this->getValueArray($objet, $this->sortDirection, "ASC");
                $propiedad = $this->getValueArray($objet, $this->sortProperty, $this->getClassMetadata()->getIdentifier()[0]);
                try {
                    $fieldMapping = $this->getClassMetadata()->getFieldForColumn($propiedad);
                } catch (\Exception $e) {
                    $fieldMapping = $this->getClassMetadata()->getIdentifier()[0];
                }
                $order = sprintf("%s.%s", $alias, $fieldMapping);
                $query->addOrderBy($order, $direccion);
            }
        } else {
            $this->configPaginacion($paginacion);
            try {
                $fieldMapping = $this->getClassMetadata()->getFieldForColumn($paginacion->sort);
            } catch (\Exception $e) {
                $fieldMapping = $this->getClassMetadata()->getIdentifier()[0];
            }
            $order = sprintf("%s.%s", $alias, $fieldMapping);
            $query->addOrderBy($order, $paginacion->dir);

        }
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

    /**
     * @param $arr
     * @param $col
     * @param int $dir
     * @return mixed
     */
    function array_sort_by_column($arr, $col, $dir = SORT_ASC)
    {
        $sort_col = array();
        foreach ($arr as $key => $row) {

            $sort_col[$key] = is_string($row[$col]) ? strtoupper($row[$col]) : $row[$col];
        }
//        var_dump($sort_col);
        array_multisort($sort_col, $dir, $arr);
        return $arr;
    }

    /**
     * @param $array
     * @param $index
     * @param $default
     * @return int|null|string
     */
    public function getValueArray($array, $index, $default)
    {
        if ($default === 0) {
//            var_dump(array_key_exists($index, $array) ? $array[$index] === '' ? 0 : $array[$index] : 0);
            return array_key_exists($index, $array) ? $array[$index] === '' ? 0 : $array[$index] : 0;
        } else {
//            var_dump(array_key_exists($index, $array) ? $array[$index] : null);
            return array_key_exists($index, $array) ? $array[$index] === '' ? null : $array[$index] : null;
        }

    }

    /**
     * @param $response
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function respuestaSP($response)
    {

        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        if (count($response) > 0) {
            if (is_numeric($this->getValueToArray($response[0]))) {
                $result->success = true;
                $result->msg = "Proceso Ejectuado Correctamente";
                $result->id = $this->getValueToArray($response[0]);
            } else {
                $result->success = false;
                $result->msg = $this->getValueToArray($response[0]);
            }
        } else {
            $result->success = false;
            $result->msg = "Ocurrio algun problema al Ejectuar la Funcion en Postgresql";
        }

        return $result;
    }

    private function getValueToArray($array)
    {
        foreach ($array as $key => $value) {
            return $value;
        }
        return null;
    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param array $array
     * @param string $campo
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function contieneInArray($query, $array, $campo)
    {

        if (is_array($array)) {
            $fieldMapping = $this->getClassMetadata()->getFieldForColumn($campo);
            $alias = $query->getRootAlias();
            $count = 0;
            $where = sprintf("%s.%s  IN (:" . $fieldMapping . ")", $alias, $fieldMapping);

            $query->andWhere($where);
            $query->setParameter($fieldMapping, $array, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);

        }
        return $query;
    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param array $array
     * @param string $campo
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function noContieneInArray($query, $array, $campo)
    {
//        var_dump($array);
        if (is_array($array)) {
            $fieldMapping = $this->getClassMetadata()->getFieldForColumn($campo);
            $alias = $query->getRootAlias();
            $count = 0;
            $where = sprintf("%s.%s  NOT IN (:notIn)", $alias, $fieldMapping);

            $query->andWhere($where);
            $query->setParameter('notIn', $array, \Doctrine\DBAL\Connection::PARAM_STR_ARRAY);

        }
        return $query;
    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param string $campo
     * @param bool $isnull
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function isOrNotNull($query, $campo, $isnull)
    {
//        var_dump($isnull);
        if (strlen($campo) > 0) {
            $fieldMapping = $this->getClassMetadata()->getFieldForColumn($campo);
            $alias = $query->getRootAlias();
            $where = sprintf("%s.%s  %s", $alias, $fieldMapping, ($isnull) ? 'IS NULL' : 'IS NOT NULL');
            $query->andWhere($where);

        }
        return $query;
    }

    public function replace($val)
    {
        $valor = mb_convert_encoding($val, "ISO-8859-1", "UTF-8");
        $val1 = str_replace(
            $this->arraySearch,
            $this->arrayReplece,
            $val);
        return $val1;
    }


    public function verificarSiExistenCampos($array, $data)
    {
        $result = new RespuestaSP();
        $msg = "";
        try {
            for ($i = 0; $i < count($array); $i++) {
                $value = $this->getValueArray($data, $array[$i], null);
                if (empty($value)) {
                    $msg = ($msg == "") ? "No Existen los campos " . $array[$i] : sprintf("%s , %s", $msg, $array[$i]);
                }
            }
            if (!empty($msg)) {
                return new RespuestaSP(false, $msg);
            }

        } catch (\Exception $e) {
            return new RespuestaSP(false, $e->getMessage());
        }
        return $result;
    }

}