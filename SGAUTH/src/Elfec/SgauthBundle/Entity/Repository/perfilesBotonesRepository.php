<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:07 PM
 */

namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Elfec\SgauthBundle\Entity\Repository\BaseRepository;

class perfilesBotonesRepository extends BaseRepository
{

    public function obtenerBotonesPorPerfilyOpcion($idPerfil , $idOpc){
        $query =  $this->_em->createQuery("SELECT btn FROM botones btn LEFT JOIN btn. a WITH a.topic LIKE :foo");


        $opciones = $this->findBy(array('perfil'=>$idPerfil));

        /**
         * @var perfilesOpciones $opcion
         */
        $rows =array();
        foreach ($opciones as $opcion ) {
            $perfil = $opcion->getIdPerfil();
            $row = [
                "opcion"=>$opcion->getIdOpc()->getOpcion(),
                "id"=>$opcion->getIdOpc()->getIdOpc(),
                "url" => $opcion->getIdOpc()->getLink(),
                "tooltip" => $opcion->getIdOpc()->getTooltip(),
                "icono" => $opcion->getIdOpc()->getIcono(),
                "estado" => $opcion->getIdOpc()->getEstado(),
                "padre" => ($opcion->getIdOpc()->getIdPadre() != null)?  $opcion->getIdOpc()->getIdPadre()->getIdOpc():null,
                "estilo"=> $opcion->getIdOpc()->getEstilo(),
                "orden" => $opcion->getIdOpc()->getOrden()

            ];
            array_push($rows,$row);
        }

        $rows = $this->sortArray($rows,"orden");

        $menus = $this->obtenerMenuFormado($rows);
        return $menus;

    }

}