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

class perfilesOpcionesRepository extends BaseRepository
{
    public function obtenerOpcionesMenuPorPerfil($idPerfil){
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
    /**
     * @param $array
     * @return array
     */
    private function obtenerMenuFormado($array){
        $result = array();
//        $result = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
        foreach ( $array as $menu ) {
            if($menu['estado']== 'ACTIVO' && $menu['padre'] == null){
                $opcion = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
                $opcion->href = $menu['url'];
                $opcion->titulo = $menu['opcion'];
                $opcion->iconcls = $menu['icono'];
                $opcion->id = $menu['id'];
                $opcion->tooltip = $menu['tooltip'];
                $subMenus = $this->buscarHijos($array,$menu['id']);
                if(count($subMenus)> 0){
                    $opcion->submenu= $subMenus;
                }
                array_push($result,$opcion);
            }
        }
        return $result;
    }

    private function buscarHijos($array,$idPadre){
        $result = array();
//        var_dump($idPadre);
        foreach ($array as $menu ) {
            if($menu['estado'] == 'ACTIVO' && $menu['padre']==$idPadre){
                $opcion = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
                $opcion->href = $menu['url'];
                $opcion->titulo = $menu['opcion'];
                $opcion->iconcls = $menu['icono'];
                $opcion->id = $menu['id'];
                $opcion->tooltip = $menu['tooltip'];
                $subMenus = $this->buscarHijos($array,$menu['id']);
                if(count($subMenus)> 0){
                    $opcion->submenu= $subMenus;
                }

                array_push($result,$opcion);
            }
        }
        return $result;
    }

}