<?php

namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Elfec\SgauthBundle\Entity\Repository\BaseRepository;

/**
 * listaItemsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class listasItemsRepository extends BaseRepository
{

    /**
     * @param \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder $query
     * @param int $idAplic
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
     */
    public function filtrarPorAplicacion($query, $idAplic)
    {
        $alias = $query->getRootAlias();
        $query->innerJoin($alias . '.lista', 'lis');
        $query->andWhere('lis.idAplic = :idAplic');
        $query->setParameter("idAplic", $idAplic);
        return $query;

    }


    /**
     * @param $data
     * @param $login
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function grabarListasItems($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->_em->getConnection();
            $st = $conection->prepare("SELECT  elfec.grabar_listas_items (
            :p_id_item::integer,
            :p_id_lista::integer,
            :p_codigo::varchar,
            :p_valor::varchar,
            :p_estado::char,
            :p_orden::numeric,
            :p_login_usr::VARCHAR);");
            $st->bindValue("p_id_item", $this->getValueArray($data, "id_item", 0));
            $st->bindValue("p_id_lista", $this->getValueArray($data, "id_lista", 0));
            $st->bindValue("p_codigo", $this->getValueArray($data, "codigo", null));
            $st->bindValue("p_valor", $this->getValueArray($data, "valor", null));
            $st->bindValue("p_estado", $this->getValueArray($data, "estado", 0));
            $st->bindValue("p_orden", $this->getValueArray($data, "orden", null));
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


    public function eliminarItem($id_item, $login)
    {
//        var_dump($id_lista);
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            /**
             * @var \Elfec\SgauthBundle\Entity\listasItems $lista
             */
            $lista = $this->find($id_item);
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
