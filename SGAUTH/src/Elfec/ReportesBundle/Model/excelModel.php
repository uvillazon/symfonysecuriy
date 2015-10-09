<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:05 PM
 */

namespace Elfec\ReportesBundle\Model;


class excelModel
{
    public $dir;
    public $limit;
    public $page;
    public $sort;
    public $start;
    public $condicion;
    public $contiene;
    public $startDate;
    public $endDate;

    /**
     * @return bool
     */
   /* public function isEmpty(){
        $result= true;
        foreach ( $this as $prop =>  $val ) {
            if(!is_null($val)){
                $result=false;
                break;
            }
        }
        return $result;
    }*/
}