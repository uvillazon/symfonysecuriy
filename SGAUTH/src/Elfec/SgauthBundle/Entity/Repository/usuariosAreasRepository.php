<?php

namespace Elfec\SgauthBundle\Entity\Repository;


/**
 * usuariosAreasRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class usuariosAreasRepository extends BaseRepository
{


    /**
     * @param $data
     * @param $login
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function grabarUsuarioArea($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->_em->getConnection();
            $st = $conection->prepare("SELECT  elfec.grabar_usuario_area (
            :p_id_usr_area::numeric,
            :p_id_usuario::numeric,
            :p_id_area::numeric,
            :p_id_aplic::numeric,
            :p_login_usr::VARCHAR);");
            $st->bindValue("p_id_usr_area", $this->getValueArray($data, "id_usr_area", 0));
            $st->bindValue("p_id_usuario", $this->getValueArray($data, "id_usuario", null));
            $st->bindValue("p_id_area", $this->getValueArray($data, "id_area", null));
            $st->bindValue("p_id_aplic", $this->getValueArray($data, "id_aplic", null));
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            $result = $this->respuestaSP($response);
        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;

    }

    public function eliminarUsuarioArea($id)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $areaUsuario = $this->find($id);
            if (is_null($areaUsuario)) {
                $result->success = true;
                $result->msg = "No existe el Area";
                return $result;
            }
            $this->_em->remove($areaUsuario);
            $this->_em->flush();
            $result->success = true;
            $result->msg = "Proceso ejecutado correctamente";
            return $result;


        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
    }
}
