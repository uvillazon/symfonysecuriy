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
        //$this->zip = new \ZipArchive();
       // $pdf = new PDF();
//        var_dump($this->contentType);
//        var_dump($this->zip);die();
    }

  /*  public function getContentDisposition()
    {
        return 'attachment; filename="' . $this->nombre . '"';
    }

    public function crearZip()
    {
        try {
            $this->zip->open($this->url, \ZipArchive::CREATE);
//            $this->zip->close();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
//        var_dump($this->zip);die();
    }

    public function agregarArchivos($files)
    {

//        var_dump($this->url);
//        $this->zip->open($this->url);
//        var_dump($this->zip);die();
        foreach ($files as $f) {
            $this->zip->addFromString(basename($f), file_get_contents($f));
        }
//        $this->zip->close();
    }

    public function agregarArchivo($file)
    {
//        $this->zip->open($this->url);
        $this->zip->addFromString(basename($file), file_get_contents($file));
        unlink($file);
//        $this->zip->close();
    }

    public function close()
    {
        $this->zip->close();
    }

    public function getHeader()
    {
        $this->header = array(
            'Content-Type' => $this->contentType,
            'Content-Disposition' => $this->getContentDisposition(),
            'Name-File' => $this->nombre
        );
        return $this->header;

    }*/
}