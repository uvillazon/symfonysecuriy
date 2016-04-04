<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


class RecuperacionService
{
    protected $em;
    protected $nzo;
    protected $correo;

    public function __construct(\Doctrine\ORM\EntityManager $_em, \Nzo\UrlEncryptorBundle\UrlEncryptor\UrlEncryptor $enct, \Elfec\SgauthBundle\Services\CorreoService $_correo)
    {

        $this->em = $_em;
        $this->nzo = $enct;
        $this->correo = $_correo;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerRecuperacionesCntPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:recuperacionCnt');
        $query = $repo->createQueryBuilder('app');
        $query = $repo->filtrarDatos($query, $array);
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["usuario", "email", "codigo"], $paginacion->contiene);
        }
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }

        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    public function guardarRecuperacionCnt($data)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:recuperacionCnt');
        $repoApp = $this->em->getRepository('ElfecSgauthBundle:aplicaciones');
        $aplicacion = $repoApp->findOneBy(array("codigo" => $data["codigoApp"]));
        if (is_null($aplicacion)) {
            $result->msg = "No existe la aplicacion";
            $result->success = false;
            return $result;
        } else {
            $data["id_aplic"] = $aplicacion->getIdAplic();
        }
        $result = $repo->guardarRecuperacionCnt($data);
        if ($result->success)
        {
            /**
             * @var \Elfec\SgauthBundle\Entity\recuperacionCnt $email
             */
            $email = $repo->findOneBy(array("codigo" => $result->id));
            //vamos a enviar un correo si todo esta ok
            $valor = sprintf("%s|%s|%s|%s", $result->id, $data["id_aplic"], $data["usuario"], $data["ip_solic"]);
            $encript = $this->nzo->encrypt($valor);
            $datos = array("usuario"=>$email->getUsuario() , "fecha_exp"=>$email->getFechaExp()->format("d/m/Y H:i:s") , "navegador"=> $email->getClienteSolic(),"ip"=>$email->getIpSolic());

            $result->msg = "se le envio el codigo de control a su correo electronico asociado a su cuenta : " . $data["usuario"];
            try {
                $this->correo->enviarCorreos("Recuperacion de Correos", $email->getEmail(), null, $encript, array(), $email->getEmail(),$datos);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }

        }

        return $result;

    }

    public function cambiar_password($data)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $decrypt = $this->nzo->decrypt($data["codigo"]);
        $array = explode('|', $decrypt);
        $data["usuario"] = $array[2];
        $data["codigo"] = $array[0];
//        var_dump($decrypt);die();
        $repo = $this->em->getRepository('ElfecSgauthBundle:recuperacionCnt');
        $result = $repo->cambiar_password($data);
        return $result;

    }

    public function cambiar_password_sc($data)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:recuperacionCnt');
        $result = $repo->cambiar_password_sc($data);
        return $result;

    }

//
}