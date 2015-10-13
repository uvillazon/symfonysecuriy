<?php
/**
 * Created by PhpStorm.
 * User: eballesteros
 * Date: 08/10/2015
 */

namespace Elfec\ReportesBundle\Model;


class PDF
{
    public $cache_Control;//'Cache-Control: must-revalidate');
    public $pragma;//('Pragma: public');
    public $description;//'Content-Description: File Transfer');
    public $disposition;//'Content-Disposition: attachment; filename=report.pdf');
    public $transfer;//'Content-Transfer-Encoding: binary');
    public $length;//'Content-Length: ' . strlen($report));
    public $type;//'Content-Type: application/pdf');
    public $filename;

    public $nombre;
    public $url;
    public $contentType = "application/zip";
    private $zip;
    private $header;

    public function __construct()
    {
    }
}