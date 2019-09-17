<?php

namespace Elfec\ErpBundle\Controller;

use Elfec\SgauthBundle\Controller\BaseController;
use Elfec\SgauthBundle\Model\RespuestaSP;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;


class ProveedoresController extends BaseController
{
    /**
     * @Rest\Get("/proveedores")
     * @ApiDoc(
     *   resource = true,
     *   description = "Obtener Proveedores del ERP Paginado",
     *   output = "Array",
     *   authentication = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found",
     *     403 = "Returned when permission denied"
     *   }
     * )
     */
    public function getProveedoresErpPaginadosAction(Request $request)
    {
        $paginacion = $this->obtenerPaginacion($request);
        $servicio = $this->get('erp_proveedores_service');
        $array = $request->query;
        $result = $servicio->obtenerProveedoresPaginados($paginacion, $array);
        return $result;
    }


}
