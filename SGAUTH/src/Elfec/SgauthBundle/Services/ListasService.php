<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


use Jaspersoft\Service\Result\SearchResourcesResult;

class ListasService
{
    protected $em;
    protected $emSgauth;

    public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\ORM\EntityManager $emSgauth)
    {

        $this->em = $em;
        $this->emSgauth = $emSgauth;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerListasPaginados($paginacion, $array)
    {
//        var_dump($this->correo);

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listas');
        $query = $repo->createQueryBuilder('lis');

        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["lista", "descripcion"], $paginacion->contiene);
        }
        $query = $repo->filtrarDatos($query, $array);
//        var_dump($query->getDQL());
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }

        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerListasItemsPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listasItems');
        $query = $repo->createQueryBuilder('item');

        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["codigo", "valor"], $paginacion->contiene);
        }
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerListasItemsRelPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listasItemsRel');
        $query = $repo->createQueryBuilder('item');
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["codigo", "valor"], $paginacion->contiene);
        }
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }


    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerItemsPorLista($paginacion, $array, $id_aplic)
    {
//                                                                    var_dump($id_aplic);die();
        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        if (!is_null($paginacion->condicion) && is_numeric($id_aplic)) {
            $repo = $this->emSgauth->getRepository('ElfecSgauthBundle:listas');
            /**
             * @var \Elfec\SgauthBundle\Entity\listas $lista
             */
            $lista = $repo->findOneBy(array("lista" => $paginacion->condicion, "idAplic" => $id_aplic));
            if (!is_null($lista)) {
                $rows = array();

                foreach ($lista->getListaItems() as $item) {
//                    var_dump($item->getEstado());
                    if ($item->getEstado() == 'A') {
                        $row = [
                            "codigo" => $item->getCodigo(),
                            "orden" => $item->getOrden(),
                            "valor" => $item->getValor(),
                            "id_lista" => $item->getIdLista(),
                            "id_item" => $item->getIdItem(),
                            "hijos" => $item->getHijos()
                        ];
                        array_push($rows, $row);
                    }
                }
                $result->success = true;

                $result->rows = $repo->array_sort_by_column($rows, $lista->getOrdenarPor(), $lista->getTipoOrden() == 'ASC' ? SORT_ASC : SORT_DESC);
            } else {
                $result->success = false;
                $result->msg = "No Existe Existe La Lista";
            }
        } else {
            $result->success = false;
            $result->msg = "No Existe Condicion intentar nuevamente";
        }
        return $result;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerItemsRelPorPadre($paginacion, $array, $id_aplic)
    {
//        var_dump($array);
//                                                                    var_dump($id_aplic);die();
        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
//        var_dump($id_aplic);
        if ((is_numeric($id_aplic)) && (!is_null($array->get('id_padre')) && is_numeric($array->get('id_padre')))) {
            $repo = $this->emSgauth->getRepository('ElfecSgauthBundle:listasItemsRel');

            /**
             * @var \Elfec\SgauthBundle\Entity\listasItemsRel $item
             */

            $lista_rel = $repo->findBy(array("idPadre" => $array->get('id_padre')));
            if (count($lista_rel) > 0) {
                $rows = array();
                if (is_null($paginacion->condicion)) {
                    foreach ($lista_rel as $item) {
                        if ($item->getHijo()->getEstado() == 'A') {
                            $row = [
                                "codigo" => $item->getHijo()->getCodigo(),
                                "valor" => $item->getHijo()->getValor(),
                                "id_lista" => $item->getHijo()->getIdLista(),
                                "id_item" => $item->getHijo()->getIdItem()
                            ];
                            array_push($rows, $row);
                        }
                    };


                } else {
                    $codigo = $paginacion->condicion;
                    foreach ($lista_rel as $item) {
                        if ($item->getHijo()->getLista()->getLista() === $codigo) {
                            $row = [
                                "codigo" => $item->getHijo()->getCodigo(),
                                "valor" => $item->getHijo()->getValor(),
                                "id_lista" => $item->getHijo()->getIdLista(),
                                "id_item" => $item->getHijo()->getIdItem()
                            ];
                            array_push($rows, $row);
                        }
                    };

                }
                $result->success = true;
                $result->rows = $rows;
//                $result->rows = $repo->array_sort_by_column($rows, $lista->getOrdenarPor(), $lista->getTipoOrden() == 'ASC' ? SORT_ASC : SORT_DESC);
            } else {
                $result->success = false;
                $result->msg = "No Existe Existe La Lista";
            }
        } else {
            $result->success = false;
            $result->msg = "No Existe Condicion intentar nuevamente";
        }

        return $result;
    }


    /**
     * @param $data
     * @param $login
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function guardarLista($data, $login)
    {
//        var_dump($data);
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listas');
        $result = $repo->grabarListas($data, $login);
        return $result;

    }

    public function guardarListaItem($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listasItems');
        $result = $repo->grabarListasItems($data, $login);
        return $result;

    }

    public function eliminarLista($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listas');
        $result = $repo->eliminarLista($data["id_lista"], $login);
        return $result;

    }

    public function eliminarItem($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listasItems');
        $result = $repo->eliminarItem($data["id_item"], $login);
        return $result;

    }

    public function grabarListasItemsRel($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listasItemsRel');
        $result = $repo->grabarListasItemsRel($data, $login);
        return $result;

    }

    public function eliminarListaItemRel($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:listasItemsRel');
        $result = $repo->eliminarItemRel($data["id_rel"], $login);
        return $result;

    }


}