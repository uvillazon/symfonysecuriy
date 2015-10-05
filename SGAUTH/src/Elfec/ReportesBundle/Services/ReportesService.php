<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\ReportesBundle\Services;

use \Jaspersoft\Client\Client ;

class ReportesService
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {

        $this->em = $em;
    }

    public function obtenerReportes()
    {
        $cliente = new Client("http://localhost:8080/jasperserver-pro",
            "jasperadmin",
            "jasperadmin",
            "organization_1"
        );
        var_dump($cliente);die();

    }
//
}