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


    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param string $perfil
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function filtrarPorPerfil($query, $perfil)
    {
        $alias = $query->getRootAlias();
        $query->innerJoin($alias . '.idPerfil', 'a');
        $query->andWhere('a.nombre LIKE :perfil');
        $query->setParameter("perfil", "%" . $perfil . "%");
        return $query;

    }
}