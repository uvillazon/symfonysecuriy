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
       // $cliente = new Client("http://192.168.50.80:8080/jasperserver", //maquina local de erika
       $cliente = new Client("http://192.168.30.218:8080/jasperserver",
            "jasperadmin",
            "jasperadmin",
            ""
        );
        $controls = $this->obtenerParametros($datos,$login);

        $report = $cliente->reportService()->runReport($this->obtenerRuta($datos->get("reporte")), $datos->get('tipo'),null,null,$controls);
        return $report;

    }
    private function obtenerRuta($reporte){
        $arrayRutas = array("Indice1"=>"/reports/Sistema_ST/rpt_cindices_1_2","Indice2"=>"/reports/Sistema_ST/rpt_indices_1_2");
        return $arrayRutas[$reporte];
    }
    private function obtenerParametros($datos,$login){
        $controls  = array();
        if($datos->get("reporte")== "Indice1"){
            
            $controls = array("REPORT_LOCALE" => array("NL_BE"),"niv_calidad" => array($datos->get("niv_calidad")),"periodo" => array($datos->get("id_periodo")),"f_ini_periodo" => array($datos->get("f_ini_periodo"))); 
        }
        elseif ($datos->get("reporte")=="Indice2") {
            $this->generarFuncionIndice2($datos, $login);
            $controls = array("REPORT_LOCALE" => array("NL_BE"),"niv_calidad" => array($datos->get("niv_calidad")),"periodo" => array($datos->get("id_periodo"))); 
        }
        return $controls;
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
        return $result;
        
    }


//
}