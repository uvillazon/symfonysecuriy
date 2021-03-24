<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:05 PM
 */

namespace Elfec\SgauthBundle\Model;


class PaginacionModel
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
    public $multiSort = false;

    /**
     * @return bool
     */
    public function isEmpty(){
        $result= true;
        foreach ( $this as $prop =>  $val ) {
            if(!is_null($val)){
                $result=false;
                break;
            }
        }
        return $result;
    }
    public function conIntervaloFecha()
    {
        $result = true;
        if (empty($this->startDate) || empty($this->endDate)) {
            $result = false;
        } else {
            $result = true;
        }
//        var_dump($this);
        return $result;
    }

    public function setIntervaloDeFecha($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}