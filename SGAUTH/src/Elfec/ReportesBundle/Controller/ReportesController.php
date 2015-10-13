<?php


namespace Elfec\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Date;

class ReportesController extends Controller
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getReportesAction(Request $request)
    {
//        var_dump($request->query);die();  
        $datos= $request->query;
        $login = "EBALLESTEROS";
        $servicio = $this->get('reportesbundle.reportes_service');
        $result = $servicio->obtenerReportes($datos,$login);
        $response = new Response($result);
        $tipos = array("pdf"=>"application/pdf","xls"=>"application/vnd.ms-excel");
        $response->headers->set('Content-Type', $tipos[$datos->get('tipo')]);
        $response->headers->set('Another-Header', 'header-value');
        return $response;
    }


}