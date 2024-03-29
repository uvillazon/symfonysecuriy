<?php

namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * listasItemsRelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class listasItemsRelRepository extends BaseRepository
{

    /**
     * @param $data
     * @param $login
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function grabarListasItemsRel($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->_em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_listas_items_rel (
            :p_id_rel::integer,
            :p_id_padre::integer,
            :p_id_hijo::integer,
            :p_login_usr::VARCHAR);");
            $st->bindValue("p_id_rel", $this->getValueArray($data, "id_rel", null));
            $st->bindValue("p_id_padre", $this->getValueArray($data, "id_padre", null));
            $st->bindValue("p_id_hijo", $this->getValueArray($data, "id_hijo", null));
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


    public function eliminarItemRel($id_rel, $login)
    {
//        var_dump($id_lista);
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            /**
             * @var \Elfec\SgauthBundle\Entity\listasItems $lista
             */
            $lista = $this->find($id_rel);
            if (!is_null($lista)) {

                $this->_em->remove($lista);
                $this->_em->flush();
                $result->success = true;
                $result->msg = "Proceso ejecutado Correctamente";


            } else {
                $result->success = false;
                $result->msg = "No existe el dato para eliminar";
            }

        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;
    }
}
