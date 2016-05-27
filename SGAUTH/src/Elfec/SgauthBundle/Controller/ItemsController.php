<?php

namespace Elfec\SgauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ItemsController extends BaseController
{

    /**
     *  @Rest\Get("/listas/items")
     */
    public function getListasItemsAction(Request $request)
    {
        $Usertoken = $this->container->get("JWTUser");
        $id_aplic = $Usertoken->id_aplic;
        $paginacion = $this->obtenerPaginacion($request);
        $servicio= $this->get('sgauthbundle.listas_service');
        $array = $request->query;
        $result = $servicio->obtenerItemsPorLista($paginacion , $array,$id_aplic);
        return $result;
    }
}
