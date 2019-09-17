<?php

namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Elfec\SgauthBundle\Entity\Repository\BaseRepository;

/**
 * gruposCorreosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class gruposCorreosRepository extends BaseRepository
{
    /**
     * @param $data
     * @param $login
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function grabarGruposCorreo($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
//            var_dump($data);
            $data["id_grp"] =  $this->getValueArray($data,"id_grp",0);
            if ( $data["id_grp"] === 0) {
                $grupo = $this->findOneBy(array("nombre" => $data["nombre"]));
                if (is_null($grupo)) {
                    $newGrupo = new \Elfec\SgauthBundle\Entity\gruposCorreos();
                    $newGrupo->setEstado("ACTIVO");
                    $newGrupo->setNombre($data["nombre"]);
                    $newGrupo->setIdAplic($data["id_aplic"]);
                    $this->_em->persist($newGrupo);

                    $this->_em->flush();
                    $result->success = true;
                    $result->msg = "Proceso Ejecutado correctamente";
                    $result->id = $newGrupo->getIdGrp();

                } else {
                    $result->success = false;
                    $result->msg = "Existe un grupo con el mismo nombre intente nuevamente";
                }
            }
            else{
                $grupo = $this->find($data["id_grp"]);
                if (is_null($grupo)) {

                    $result->success = false;
                    $result->msg = "No Existe el registro.";

                } else {

                    $grupo->setEstado($data["estado"]);
                    $grupo->setNombre($data["nombre"]);
                    $grupo->setIdAplic($data["id_aplic"]);
                    $this->_em->persist($grupo);
                    $this->_em->flush();
                    $result->success = true;
                    $result->msg = "Proceso Ejecutado correctamente";
                    $result->id = $grupo->getIdGrp();
                }
            }
        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;
    }
}