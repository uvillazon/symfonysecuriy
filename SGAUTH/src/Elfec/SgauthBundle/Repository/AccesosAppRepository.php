<?php

namespace Elfec\SgauthBundle\Repository;

use Elfec\SgauthBundle\Entity\Repository\BaseRepository;
use Elfec\SgauthBundle\Model\RespuestaSP;

/**
 * AccesosAppRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AccesosAppRepository extends BaseRepository
{
    public function GuardarAccesoApp($data){
        $result = new RespuestaSP();

        var_dump($data);
        return $result;
    }
}
