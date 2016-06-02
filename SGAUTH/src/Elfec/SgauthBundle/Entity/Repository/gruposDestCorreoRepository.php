<?php


namespace Elfec\SgauthBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Elfec\SgauthBundle\Entity\Repository\BaseRepository;

/**
 * gruposDestCorreoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class gruposDestCorreoRepository extends BaseRepository
{
    /**
     * @param $data
     * @param $login
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function grabarDestinatarioGrupo($data, $login)
    {
//        var_dump($data);
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $grupo = $this->findOneBy(array("idGrp" => $data["id_grp"], "idDest" => $data["id_dest"]));
            if (is_null($grupo)) {
                $new = new \Elfec\SgauthBundle\Entity\gruposDestCorreo();
                $repoGrp = $this->_em->getRepository("ElfecSgauthBundle:gruposCorreos");
                $repoDest = $this->_em->getRepository("ElfecSgauthBundle:destinatariosCorreos");

                $new->setDestinatarioCorreo($repoDest->find($data["id_dest"]));
                $new->setGrupoCorreo($repoGrp->find($data["id_grp"]));
                $new->setTipoMsgDest($data["tipo_msg_dest"]);
                $this->_em->persist($new);
                $this->_em->flush();
                $result->success = true;
                $result->msg = "Proceso Ejecutado correctamente";
                $result->id = $new->getId();

            } else {
                $result->success = false;
                $result->msg = "Existe el destinatario en el mismo grupo";
            }

        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;
    }

    public function eliminarDestinatarioDelGrupo($id)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $grupo = $this->find($id);
            if (is_null($grupo)) {
                $result->success = false;
                $result->msg = "No existe el registro";

            } else {
                $this->_em->remove($grupo);
                $this->_em->flush();
                $result->success = true;
                $result->msg = "Proceso Ejecutado correctamente";
            }

        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
        }
        return $result;

    }

}

