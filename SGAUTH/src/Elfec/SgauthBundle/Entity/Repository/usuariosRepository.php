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
use Elfec\SgauthBundle\Entity\usuarios;
use Elfec\SgauthBundle\Model\RespuestaSP;

class usuariosRepository extends BaseRepository
{

    public function actuliazarCertificado($data, $login)
    {
        /**
         * @var usuarios $usuario
         */
        try {
            $idusuario = $this->getValueArray($data, 'id_usuario', null);
            $usuario = $this->find($idusuario);
            if (empty($usuario)) {
                return new RespuestaSP(false, "No Existe el usuario");
            }
            $usuario->setCertBase64($this->getValueArray($data, 'cert_base64', null));
            $usuario->setCertPwdBase64(base64_encode($this->getValueArray($data, 'cert_pwd_base64', null)));
            $fecha = new \DateTime($this->getValueArray($data, 'fch_cert_caducidad', null));
//            var_dump($fecha);
            $usuario->setFchCertCaducidad($fecha);
            $this->_em->persist($usuario);
            $this->_em->flush();
            return new RespuestaSP(true, "Proceso Ejecutado Correctamente", $usuario);

        } catch (\Exception $e) {
            return new RespuestaSP(false, $e->getMessage());
        }
    }
}