<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\ReportesBundle\Services;

use \Jaspersoft\Client\Client ;
use Elfec\ReportesBundle\Model\PDF;

class ReportesService
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {

        $this->em = $em;
    }

    public function obtenerReportes($datos,$login)
    {
        $cliente = new Client("http://localhost:8080/jasperserver",
            "jasperadmin",
            "jasperadmin",
            ""
        );
      
//        $pdf = new PDF();//reporte tipo PDF
        //$pdf->nombre = 'zip-' . time() . ".zip";
        $controls = $this->obtenerParametros($datos,$login);
        
        $report = $cliente->reportService()->runReport($this->obtenerRuta($datos->get("reporte")), $datos->get('tipo'),null,null,$controls);
        return $report;
//        $pdf->$cache_Control='must-revalidate';
//        $pdf->$pragma='public';
//        $pdf->$description='File Transfer';
//        $pdf->$disposition='attachment';
//        $pdf->$filename='report.pdf';
//        
//        $pdf->$transfer='binary';
//        $pdf->$length=' . strlen($report)';
//        $pdf->$type='application/pdf';
//        
//        var_dump($cliente);die();
//       /* $report = $c->reportService()->runReport('/reports/ReportesSGCST/Periodos/Prueba', 'pdf');
//        header('Cache-Control: must-revalidate');
//        header('Pragma: public');
//        header('Content-Description: File Transfer');
//        header('Content-Disposition: attachment; filename=report.pdf');
//        header('Content-Transfer-Encoding: binary');
//        header('Content-Length: ' . strlen($report));
//        header('Content-Type: application/pdf');
//
//        echo $report;*/

    }
    private function obtenerRuta($reporte){
        $arrayRutas = array("Indice1"=>"/reports/ReportesSGCST/indice1","Indice2"=>"/reports/ReportesSGCST/indice2");
        return $array[$reporte];
    }
    private function obtenerParametros($datos,$login){
        if($datos->get("reporte")== "Indice1"){
            
            $controls = array("REPORT_LOCALE" => array("NL_BE"),"niv_calidad" => array($datos->get("niv_calidad")),"periodo" => array($datos->get("id_periodo"))); 
        }
        elseif ($datos->get("reporte")=="Indice2") {
            $this->generarFuncionIndice2($datos, $login);
            $controls = array("REPORT_LOCALE" => array("NL_BE"),"niv_calidad" => array($datos->get("niv_calidad")),"periodo" => array($datos->get("id_periodo"))); 
        }
    }
    public function generarFuncionIndice2($data,$login){
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT public.generar_tmp_rpt_indica_glob(:p_niv_calidad::VARCHAR,:p_id_periodo::INTEGER ,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_niv_calidad", $data->get("niv_calidad"));
            $st->bindValue(":p_id_periodo", $data->get("id_periodo"));
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["generar_tmp_rpt_indica_glob"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["generar_tmp_rpt_indica_glob"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["generar_tmp_rpt_indica_glob"];
                }
            } else {
                $result->success = false;
                $result->msg = "Ocurrio algun problema al Ejectuar la Funcion en Postgresql";
            }
        } catch (Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        var_dump($result);die();
        return $result;
        
    }


//
}