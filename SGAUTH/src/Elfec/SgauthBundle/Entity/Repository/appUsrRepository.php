<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:07 PM
 */

namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Elfec\SgauthBundle\Entity\Repository\BaseRepository;

class appUsrRepository extends BaseRepository
{

    public function contieneUsuario($query, $array, $contiene)
    {
//        var_dump($array);
        if ($contiene != "") {
            $alias = $query->getRootAlias();
            $query->innerJoin($alias . '.idUsuario', 'a');
//            var_dump($query->getDQL());
            $count = 0;
            foreach ($array as $field) {
                $where = sprintf("UPPER(a.%s) LIKE :condicion", $field);
                if ($count == 0) {
                    $query->andWhere($where);
                } else {
                    $query->orWhere($where);
                }
                $count++;
            }
            $query->setParameter("condicion", "%" . strtoupper($contiene) . "%");
        }
//        var_dump($query->getDQL());
//        die();
        return $query;
    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param string $perfil
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function filtrarPorPerfil($query, $perfil)
    {
        $alias = $query->getRootAlias();
        $query->innerJoin($alias . '.idPerfil', 'per');
        $query->andWhere('per.nombre LIKE :perfil');
        $query->setParameter("perfil", "%" . $perfil . "%");
        return $query;

    }

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param int $idproveedor
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function filtrarPorIdProveedor($query, $idproveedor)
    {
        $alias = $query->getAllAliases()[0];
        $query->innerJoin($alias . '.idPerfil', 'prov');
        $query->andWhere('prov.idproveedor = :idproveedor');
        $query->setParameter("idproveedor", $idproveedor);
        return $query;

    }

//
}