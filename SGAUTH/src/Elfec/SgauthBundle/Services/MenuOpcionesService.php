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

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {

        $this->em = $em;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerOpcionesaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:menuOpciones');
        $query = $repo->createQueryBuilder('men');
        $query = $repo->filtrarDatos($query, $array);
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["opcion", "tooltip", "estado"], $paginacion->contiene);
        }
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $rows = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\menuOpciones $obj
         */
        foreach ($query->getQuery()->getResult() as $obj) {
            $row = [
                "id_opc" => $obj->getIdOpc(),
                "id_aplic" => $obj->getIdAplic()->getIdAplic(),
                "aplicacion" => $obj->getIdAplic()->getNombre(),
                "opcion" => $obj->getOpcion(),
                "link" => $obj->getLink(),
                "tooltip" => $obj->getTooltip(),
                "icono" => $obj->getIcono(),
                "estilo" => $obj->getEstilo(),
                "padre" => (is_null($obj->getIdPadre())) ? null : $obj->getIdPadre()->getOpcion(),
                "estado" => $obj->getEstado(),
                "orden" => $obj->getOrden()

            ];
            array_push($rows, $row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    public function obtenerOpcionesPorUsuario($usuario, $codigoApp)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repUsr = $this->em->getRepository('ElfecSgauthBundle:appUsr');
        /**
         * @var \Elfec\SgauthBundle\Entity\appUsr $usu
         */
        $usu = $repUsr->findOneBy(array("usuario" => $usuario, "aplicacion" => $codigoApp));
        if (is_null($usu)) {
            $result->success = false;
            $result->msg = "No existe el Usuario en la aplicacion";
        } else {
            $idPerfil = $usu->getIdPerfil()->getIdPerfil();
//            var_dump($usu);
            $repoUsr = $this->em->getRepository('ElfecSgauthBundle:perfilesOpciones');
            $menus = $repoUsr->obtenerOpcionesMenuPorPerfil($idPerfil);

            $result->data = $menus;
            $result->success = true;
        }

        return $result;


    }


    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerBotonesPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:botones');
        $query = $repo->createQueryBuilder('btn');
        $query = $repo->filtrarDatos($query, $array);
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["boton", "tooltip", "estado"], $paginacion->contiene);
        }
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $rows = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\botones $obj
         */
        foreach ($query->getQuery()->getResult() as $obj) {
            $row = [
                "id_opc" => $obj->getIdOpc(),
                "opcion" => $obj->getMenuOpciones()->getOpcion(),
                "id_boton" => $obj->getIdBoton(),
                "boton" => $obj->getBoton(),
                "accion" => $obj->getAccion(),
                "id_item" => $obj->getIdItem(),
                "tooltip" => $obj->getTooltip(),
                "icono" => $obj->getIcono(),
                "estilo" => $obj->getEstilo(),
                "padre" => (is_null($obj->getPadre())) ? null : $obj->getPadre()->getBoton(),
                "estado" => $obj->getEstado(),
                "orden" => $obj->getOrden(),
                "disabled" => $obj->getDisabled()
            ];
            array_push($rows, $row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    public function guardarOpcion($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_menu_opciones(:p_id_opc::NUMERIC,:p_id_aplic::NUMERIC,:p_opcion::VARCHAR , :p_link::VARCHAR,:p_tooltip::VARCHAR,:p_icono::VARCHAR,:p_estilo::VARCHAR,:p_id_padre::NUMERIC ,:p_orden::NUMERIC, :p_estado::VARCHAR ,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_opc", ($data["id_opc"] == '') ? 0 : $data["id_opc"]);
            $st->bindValue(":p_id_aplic", ($data["id_aplic"] == '') ? 0 : $data["id_aplic"]);
            $st->bindValue(":p_opcion", $data["opcion"]);
            $st->bindValue(":p_link", $data["link"]);
            $st->bindValue(":p_tooltip", $data["tooltip"]);
            $st->bindValue(":p_icono", $data["icono"]);
            $st->bindValue(":p_estilo", $data["estilo"]);
            $st->bindValue(":p_id_padre", ($data["id_padre"] == '') ? 0 : $data["id_padre"]);
            $st->bindValue(":p_orden", $data["orden"]);
            $st->bindValue(":p_estado", $data["estado"]);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["grabar_menu_opciones"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["grabar_menu_opciones"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["grabar_menu_opciones"];
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

    public function guardarBoton($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_boton(:p_id_boton::NUMERIC,:p_id_opc::NUMERIC,:p_boton::VARCHAR ,:p_tooltip::VARCHAR,:p_id_item::VARCHAR,:p_estilo::VARCHAR,:p_accion::VARCHAR, :p_icono::VARCHAR ,:p_orden::NUMERIC, :p_estado::VARCHAR , :p_id_padre::NUMERIC , :p_disabled::BOOLEAN, :p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_opc", ($data["id_opc"] == '') ? 0 : $data["id_opc"]);
            $st->bindValue(":p_id_boton", ($data["id_boton"] == '') ? 0 : $data["id_boton"]);
            $st->bindValue(":p_boton", $data["boton"]);
            $st->bindValue(":p_id_item", $data["id_item"]);
            $st->bindValue(":p_tooltip", $data["tooltip"]);
            $st->bindValue(":p_icono", $data["icono"]);
            $st->bindValue(":p_estilo", $data["estilo"]);
            $st->bindValue(":p_accion", $data["accion"]);
            $st->bindValue(":p_id_padre", ($data["id_padre"] == '') ? 0 : $data["id_padre"]);
            $st->bindValue(":p_orden", $data["orden"]);
            $st->bindValue(":p_disabled", ($data["disabled"] === "HABILITADO") ? 0 : 1);
            $st->bindValue(":p_estado", $data["estado"]);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["grabar_boton"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejecutado Correctamente";
                    $result->id = $response[0]["grabar_boton"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["grabar_boton"];
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


    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerOpcionesPerfilPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:perfilesOpciones');
        $query = $repo->createQueryBuilder('men');
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $rows = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\perfilesOpciones $obj
         */
        foreach ($query->getQuery()->getResult() as $obj) {
            $row = [
                "id_opc" => $obj->getIdOpc()->getIdOpc(),
                "id_aplic" => $obj->getIdOpc()->getIdAplic()->getIdAplic(),
                "aplicacion" => $obj->getIdOpc()->getIdAplic()->getNombre(),
                "opcion" => $obj->getIdOpc()->getOpcion(),
                "link" => $obj->getIdOpc()->getLink(),
                "tooltip" => $obj->getIdOpc()->getTooltip(),
                "icono" => $obj->getIdOpc()->getIcono(),
                "estilo" => $obj->getIdOpc()->getEstilo(),
                "padre" => (is_null($obj->getIdOpc()->getIdPadre())) ? null : $obj->getIdOpc()->getIdPadre()->getOpcion(),
                "estado" => $obj->getIdOpc()->getEstado(),
                "orden" => $obj->getIdOpc()->getOrden()

            ];
            array_push($rows, $row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerBotonesPerfilPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:perfiles');
        $query = $repo->createQueryBuilder('men');
        $query = $query->join('men.botones', 'b', 'WITH', 'men.idPerfil = :idPerfil');
//        $query = $query->join('men.botones b')->where('men.idPerfil = :idPerfil');
        $query->setParameter('idPerfil', $array->get('id_perfil'));
//        var_dump($query->getDQL());

        $rows = array();
        /**
         * @var \Elfec\SgauthBundle\Entity\perfiles $obj
         */
        foreach ($query->getQuery()->getResult() as $obj) {
            /**
             * @var \Elfec\SgauthBundle\Entity\botones $btn
             */
            foreach ($obj->getBotones() as $btn) {
                $array = [
                    "id_boton" => $btn->getIdBoton(),
                    "id_opc" => $btn->getIdOpc(),
                    "boton" => $btn->getBoton(),
                    "tooltip" => $btn->getTooltip(),
                    "id_item" => $btn->getIdItem(),
                    "estilo" => $btn->getEstilo(),
                    "accion" => $btn->getAccion(),
                    "icono" => $btn->getIcono(),
                    "orden" => $btn->getOrden(),
                    "id_padre" => $btn->getIdPadre(),
                    "padre" => (is_null($btn->getPadre())) ? null : $btn->getPadre()->getBoton(),
                    "estado" => $btn->getEstado(),
                    "disabled" => $btn->getDisabled()
                ];
                array_push($rows, $array);
            }
        }
        $result->total = count($rows);
        $result->rows = $rows;
        $result->success = true;
        return $result;
    }


    public function guardarOpcionPerfil($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_perfil_opcion(:p_id_perfil::NUMERIC,:p_id_opc::NUMERIC,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_opc", ($data["id_opc"] == '') ? 0 : $data["id_opc"]);
            $st->bindValue(":p_id_perfil", ($data["id_perfil"] == '') ? 0 : $data["id_perfil"]);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["grabar_perfil_opcion"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["grabar_perfil_opcion"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["grabar_perfil_opcion"];
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
    public function eliminarOpcionPerfil($data,$login){
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.borrar_perfil_opcion(:p_id_perfil::NUMERIC,:p_id_opc::NUMERIC,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_opc", ($data["id_opc"] == '') ? 0 : $data["id_opc"]);
            $st->bindValue(":p_id_perfil", ($data["id_perfil"] == '') ? 0 : $data["id_perfil"]);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["borrar_perfil_opcion"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["borrar_perfil_opcion"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["borrar_perfil_opcion"];
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
        //eliminacion con doctrine
//        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
//        try{
//            $repo = $this->em->getRepository('ElfecSgauthBundle:perfilesOpciones');
//            $query = $repo->findOneBy(array("perfil"=>$data["id_perfil"],"opcion"=>$data["id_opc"]));
//            if(!is_null($query)){
//                $this->em->remove($query);
//                $this->em->flush();
//                $result->success = true;
//                $result->msg = "Proceso Ejecutado Correctamente";
//
//            }
//            else{
//                $result->success = false;
//                $result->msg = "No Exite el Registro";
//            }
//
//        }catch (\Exception $e){
//            $result->success = false;
//            $result->msg = $e->getMessage();
//        }
//        return $result;
    }

    public function guardarBotonPerfil($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_perfil_boton(:p_id_perfil::NUMERIC,:p_id_boton::NUMERIC,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_boton", ($data["id_boton"] == '') ? 0 : $data["id_boton"]);
            $st->bindValue(":p_id_perfil", ($data["id_perfil"] == '') ? 0 : $data["id_perfil"]);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["grabar_perfil_boton"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["grabar_perfil_boton"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["grabar_perfil_boton"];
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
    public function eliminarBotonPerfil($data,$login){
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->em->getConnection();
            $st = $conection->prepare("SELECT elfec.borrar_perfil_boton(:p_id_perfil::NUMERIC,:p_id_boton::NUMERIC,:p_login_usr::VARCHAR);");
            $st->bindValue(":p_id_boton", ($data["id_boton"] == '') ? 0 : $data["id_boton"]);
            $st->bindValue(":p_id_perfil", ($data["id_perfil"] == '') ? 0 : $data["id_perfil"]);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["borrar_perfil_boton"])) {
                    $result->success = true;
                    $result->msg = "Proceso Ejectuado Correctamente";
                    $result->id = $response[0]["borrar_perfil_boton"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["borrar_perfil_boton"];
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

}