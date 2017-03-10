<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:06 PM
 */

namespace Elfec\SgauthBundle\Model;


class ResultPaginacion
{
    public $success;
    public $rows;
    public $total;
    public $page;
    public $msg;

    /**
     * ResultPaginacion constructor.
     * @param $rows
     * @param $total
     */
    public function __construct($rows = array(), $total = 0, $msg = "Proceso Ejectuado Correctamente")
    {
        $this->rows = $rows;
        $this->total = $total;
        $this->msg = $msg;
    }
}