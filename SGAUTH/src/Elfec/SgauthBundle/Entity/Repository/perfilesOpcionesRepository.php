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
    public function obtenerBotonesPorPerfilOpcion($idPerfil, $idOpc)
    {
        $query = $this->_em->createQuery("
        SELECT c
    FROM ElfecSgauthBundle:perfiles c
    JOIN c.botones b
    WHERE c.idPerfil = :idPerfil
        ");
        $query->setParameters(array(
            'idPerfil' => $idPerfil
        ));
//        var_dump($query->getDQL());
        $result = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\perfiles $obj
         */
        foreach ($query->getResult() as $obj) {

            /**
             * @var \Elfec\SgauthBundle\Entity\botones $btn
             */
            foreach ($obj->getBotones() as $btn) {
                if ($btn->getIdOpc() === $idOpc) {
                    $array = [
                        "id_boton" => $btn->getIdBoton(),
                        "nombre" => $btn->getBoton(),
                        "tooltip" => $btn->getTooltip(),
                        "id_item" => $btn->getIdItem(),
                        "estilo" => $btn->getEstilo(),
                        "accion" => $btn->getAccion(),
                        "icono" => $btn->getIcono(),
                        "orden" => $btn->getOrden(),
                        "id_padre" => $btn->getIdPadre(),
                        "estado" => $btn->getEstado(),
                        "disabled" => $btn->getDisabled()
                    ];
                    array_push($result, $array);
                }
            }

        }
        $result = $this->sortArray($result, "orden");
        $botones = $this->obtenerBotonesFormado($result);
        return $botones;
    }

    public function obtenerOpcionesMenuPorPerfil($idPerfil)
    {
        $opciones = $this->findBy(array('perfil' => $idPerfil));

        /**
         * @var \Elfec\SgauthBundle\Entity\perfilesOpciones $opcion
         */
        $rows = array();
        foreach ($opciones as $opcion) {
            $perfil = $opcion->getIdPerfil();
            $row = [
                "opcion" => $opcion->getIdOpc()->getOpcion(),
                "id" => $opcion->getIdOpc()->getIdOpc(),
                "url" => $opcion->getIdOpc()->getLink(),
                "tooltip" => $opcion->getIdOpc()->getTooltip(),
                "icono" => $opcion->getIdOpc()->getIcono(),
                "estado" => $opcion->getIdOpc()->getEstado(),
                "padre" => ($opcion->getIdOpc()->getIdPadre() != null) ? $opcion->getIdOpc()->getIdPadre()->getIdOpc() : null,
                "estilo" => $opcion->getIdOpc()->getEstilo(),
                "orden" => $opcion->getIdOpc()->getOrden(),
                "id_perfil" => $opcion->getIdPerfil()->getIdPerfil(),
                "botones" => $this->obtenerBotonesPorPerfilOpcion($idPerfil, $opcion->getIdOpc()->getIdOpc())


            ];
            array_push($rows, $row);
        }

        $rows = $this->sortArray($rows, "orden");

        $menus = $this->obtenerMenuFormado($rows);
        return $menus;

    }

    /**
     * @param $array
     * @return array
     */
    private function obtenerMenuFormado($array)
    {
        $result = array();
//        $result = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
        foreach ($array as $menu) {
            if ($menu['estado'] == 'ACTIVO' && $menu['padre'] == null) {
                $opcion = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
                $opcion->href = $menu['url'];
                $opcion->titulo = $menu['opcion'];
                $opcion->iconcls = $menu['icono'];
                $opcion->id = $menu['id'];
                $opcion->tooltip = $menu['tooltip'];
                $opcion->botones = $menu['botones'];
                $subMenus = $this->buscarHijos($array, $menu['id']);
                if (count($subMenus) > 0) {
                    $opcion->submenu = $subMenus;
                }
                array_push($result, $opcion);
            }
        }
        return $result;
    }

    private function buscarHijos($array, $idPadre)
    {
        $result = array();
//        var_dump($idPadre);
        foreach ($array as $menu) {
            if ($menu['estado'] == 'ACTIVO' && $menu['padre'] == $idPadre) {
                $opcion = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
                $opcion->href = $menu['url'];
                $opcion->titulo = $menu['opcion'];
                $opcion->iconcls = $menu['icono'];
                $opcion->id = $menu['id'];
                $opcion->tooltip = $menu['tooltip'];
                $opcion->botones = $menu['botones'];
                $subMenus = $this->buscarHijos($array, $menu['id']);
                if (count($subMenus) > 0) {
                    $opcion->submenu = $subMenus;
                }

                array_push($result, $opcion);
            }
        }
        return $result;
    }

    private function obtenerBotonesFormado($array)
    {
        $result = array();
//        $result = new \Elfec\SgauthBundle\Model\menuOpcionesModel();
        foreach ($array as $btn) {
            if ($btn['estado'] == 'ACTIVO' && $btn['id_padre'] == null) {
                $row = array();
                $row["id_boton"] = $btn['id_boton'];
                $row["nombre"] = $btn['nombre'];
                $row["tooltip"] = $btn['tooltip'];
                $row["id_item"] = $btn['id_item'];
                $row["estilo"] = $btn['estilo'];
                $row["accion"] = $btn['accion'];
                $row["icono"] = $btn['icono'];
                $row["orden"] = $btn['orden'];
                $row["estado"] = $btn['estado'];
                $row["disabled"] = $btn['disabled'];
                $subBtns = $this->buscarHijosBotones($array, $btn['id_boton']);
                if (count($subBtns) > 0) {
                    $row["subBotones"] = $subBtns;
                }
                array_push($result, $row);
            }
        }
        return $result;
    }

    private function buscarHijosBotones($array, $idPadre)
    {
        $result = array();
        foreach ($array as $btn) {
            if ($btn['estado'] == 'ACTIVO' && $btn['id_padre'] == $idPadre) {
                $row = array();
                $row["id_boton"] = $btn['id_boton'];
                $row["nombre"] = $btn['nombre'];
                $row["tooltip"] = $btn['tooltip'];
                $row["id_item"] = $btn['id_item'];
                $row["estilo"] = $btn['estilo'];
                $row["accion"] = $btn['accion'];
                $row["icono"] = $btn['icono'];
                $row["orden"] = $btn['orden'];
                $row["estado"] = $btn['estado'];
                $row["disabled"] = $btn['disabled'];
                $subBtns = $this->buscarHijosBotones($array, $btn['id_boton']);
                if (count($subBtns) > 0) {
                    $row["subBotones"] = $subBtns;
                }

                array_push($result, $row);
            }
        }
        return $result;
    }

}