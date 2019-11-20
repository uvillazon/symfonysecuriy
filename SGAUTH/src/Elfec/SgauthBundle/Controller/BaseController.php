<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:53 PM
 */

namespace Elfec\SgauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Elfec\SgauthBundle\Model\PaginacionModel;
use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends Controller
{

    protected $nameArray = "data";

//    protected $request;
//    public function __construct(){
//
//        $this->cl
//        $this->request = $request;
//    }

    /**
     * @param Request $request
     * @return PaginacionModel
     */
    public function obtenerPaginacion(Request $request)
    {
        $paginacion = new PaginacionModel();
        $paginacion->contiene = $request->query->get('contiene');
        $paginacion->condicion = $request->query->get('condicion');
        $paginacion->dir = $request->query->get('dir');
        $paginacion->sort = $request->query->get('sort');
        $paginacion->limit = $request->query->get('limit');
        $paginacion->start = $request->query->get('start');
        $paginacion->startDate = $request->query->get('startDate');
        $paginacion->endDate = $request->query->get('endDate');
        $paginacion->contiene = ($paginacion->contiene == "") ? null : $paginacion->contiene;
        return $paginacion;
    }

    public function getTokenApp(Request $request)
    {

        $array = $request->query;
        if (!is_null($array->get("mostrar_todos"))) {

            if ($array->get("mostrar_todos") === "SI") {
//                var_dump($array);
                return $array;
            }
        }

        $AppToke = $this->container->get("JWTApp");
        if (is_null($array->get("id_aplic"))) {
            $array->set("id_aplic", $AppToke->id_aplic);
        }

        return $array;

    }

    public function postTokenApp(Request $request)
    {

//        var_dump($request->query);die();
        $array = $request->request->all();
        $AppToke = $this->container->get("JWTApp");
        $array["id_aplic"] = $AppToke->id_aplic;
//        var_dump($AppToke);die();
//        $array->set("id_aplic", $AppToke->id_aplic);

        return $array;

    }

    /**
     * @param Request $request
     * @param bool $many
     * @return mixed
     */
    public function arrayToFormPost(Request $request, $arrayId = null, $many = false)
    {
        $data = $request->request->all();

        if (!$many) {
            $array = array_key_exists($this->nameArray, $data) ? $data[$this->nameArray][0] : $data;
            if ($arrayId == null) {
                return $array;
            }
            $arrayMerge = array_merge($array, $arrayId);
            return $arrayMerge;
        } else {
            $array = array_key_exists($this->nameArray, $data) ? $data[$this->nameArray] : $data;
            return $array;
        }

    }

}