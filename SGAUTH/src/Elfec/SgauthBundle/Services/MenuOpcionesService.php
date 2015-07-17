<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


class MenuOpcionesService
{
    protected $em;
    public function __construct(\Doctrine\ORM\EntityManager $em){

        $this->em = $em;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerOpcionesaginados($paginacion,$array){

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:menuOpciones');
        $query = $repo->createQueryBuilder('men');
        $query = $repo->filtrarDatos($query,$array);
        if(!is_null($paginacion->contiene)){
            $query = $repo->consultaContiene($query,["opcion","tooltip","estado"],$paginacion->contiene);
        }
        $result->total=$repo->total($query);
        if(!$paginacion->isEmpty()){
            $query = $repo->obtenerElementosPaginados($query,$paginacion);
        }
        $rows =array();
        /**
         * @var \Elfec\SgauthBundle\Entity\menuOpciones $obj
         */
        foreach($query->getQuery()->getResult() as $obj){
            $row = [
                "id_opc"=> $obj->getIdOpc(),
                "id_aplic" =>$obj->getIdAplic()->getIdAplic(),
                "aplicacion" => $obj->getIdAplic()->getNombre(),
                "opcion" => $obj->getOpcion(),
                "link" =>$obj->getLink(),
                "tooltip" =>$obj->getTooltip(),
                "icono" =>$obj->getIcono(),
                "estilo" => $obj->getEstilo(),
                "padre" => (is_null($obj->getIdPadre()))? null : $obj->getIdPadre()->getOpcion(),
                "estado" => $obj->getEstado(),
                "orden" => $obj->getOrden()

            ];
            array_push($rows,$row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }
}