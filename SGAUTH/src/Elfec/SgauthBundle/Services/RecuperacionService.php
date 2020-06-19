<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


use Elfec\SgauthBundle\Entity\aplicaciones;
use Elfec\SgauthBundle\Entity\recuperacionCnt;
use Elfec\SgauthBundle\Model\RespuestaSP;

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
        if ($result->success) {
            /**
             * @var \Elfec\SgauthBundle\Entity\recuperacionCnt $email
             */
            $email = $repo->findOneBy(array("codigo" => $result->id));
            //vamos a enviar un correo si todo esta ok
            $valor = sprintf("%s|%s|%s|%s", $result->id, $data["id_aplic"], $data["usuario"], $data["ip_solic"]);
            $encript = $this->nzo->encrypt($valor);
            $datos = array("usuario" => $email->getUsuario(), "fecha_exp" => $email->getFechaExp()->format("d/m/Y H:i:s"), "navegador" => $email->getClienteSolic(), "ip" => $email->getIpSolic());

            $result->msg = "se le envio el codigo de control a su correo electronico asociado a su cuenta : " . $data["usuario"];
            try {
                $this->correo->enviarCorreos("Recuperacion de Correos", $email->getEmail(), null, $encript, array(), $email->getEmail(), $datos);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }

        }

        return $result;

    }

    public function enviarAbm($data)
    {
        //token duracion hasta 05/04/3161 12:43:33 -> pre produccion
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjM3NTkyNTI3NDEzLCJ1c3VhcmlvIjp7ImxvZ2luIjoidXZpbGxhem9uIiwibm9tYnJlIjoiVUJBTERPIFZJTExBWk9OIFZJTExDQSIsInBlcmZpbCI6IkFETUlOSVNUUkFET1IiLCJpZF9wZXJmaWwiOiI3NSIsImlkX3VzdWFyaW8iOiI2IiwiZW1haWwiOiJ1YmFsZG8udmlsbGF6b25AZWxmZWMuYm8iLCJlc3RhZG8iOiJBQ1RJVk8iLCJhcGxpY2FjaW9uIjoiR0VTVElPTiBERSBJTVBSRVNJT05FUyBERSBGT1JNVUxBUklPUyIsImNvZGlnb0FwcCI6IkdFU19BQk0iLCJpZF9hcGxpYyI6IjIzIiwiaWRlbXBsZWFkbyI6IjQ1NiIsImlkcHJvdmVlZG9yIjoiMTIzIiwiYXJlYSI6IkxBQk9SQVRPUklPIn0sImFyZWFzIjpbXSwia2V5IjoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LkltVjVTakJsV0VGcFQybEtTMVl4VVdsTVEwcG9Za2RqYVU5cFNrbFZla2t4VG1sS09TNWxlVXByV1cwMWFHSlhWV2xQYVVwdVdsaE9hRmx0TUdsTVEwb3hZekpXZVVscWIybGtXRnB3WWtkNGFHVnRPWFZKYVhkcFkwZEdlbU16WkhaamJWRnBUMmxLTVdSdGJITmlSMFkyWWpJMGFVeERTbTlpTTA0d1NXcHZhVnBYZUcxaVIwcHJUVVJGYVV4RFNuZGlNMG93U1dwdmFVNVVVWHBOYVVselNXMVNlV0ZZV214amFVazJTVzVDYTJJeE9YZGFNMDU0WWtOSmMwbHVUbXhqYmxwd1dUSlZhVTl1VW5sa1YxWTVMbXRMUmt4cFJXUjVjVTE2U1ZvdExUWjBiMEZIWkdoWE1qYzJaMDFYZURCUlRXVkJUVmxNVkhKMldHTWkuVFdsaFpwblVjb0NfMER4UU9EYWpfNjZHVTRZbVNlZTNHNFhSeFUzaEJjZyJ9.4JbSor690DQLBTuH5SBVAk0A81yVqqjGKf26kWfzLkw';
        $api = "http://elflwb03/ges_abm-backend-des/api/actualizacion/password";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'Authorization: Bearer ' . $token
            ));
//        curl_setopt($ch, CURLOPT_USERPWD, sprintf("%s:%s", $this->configReportes["user"], $this->configReportes["password"]));
        $apiResponse = curl_exec($ch);
        curl_close($ch);
        return new RespuestaSP();
    }

    public function cambiar_password($data)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
//            $this->enviarAbm($data);
            $decrypt = $this->nzo->decrypt($data["codigo"]);
            $array = explode('|', $decrypt);
            $data["usuario"] = $array[2];
            $data["codigo"] = $array[0];
//            var_dump($data);
//            die();
            $repo = $this->em->getRepository('ElfecSgauthBundle:recuperacionCnt');
            $result = $repo->cambiar_password($data);
            if ($result->success) {
                /**
                 * @var recuperacionCnt $recuperacionCnt
                 * @var aplicaciones $aplicacion
                 */
                $recuperacionCnt = $repo->find($data['codigo']);
                $aplicacion = $this->em->getRepository('ElfecSgauthBundle:aplicaciones')->find($recuperacionCnt->getIdAplic());
                $array = array(
                    "codigoApp" => $aplicacion->getCodigo(),
                    "usuario" => $data["usuario"],
                    "password" => $data['password']
                );
                $this->enviarAbm($array);
            }
        } catch (\Exception $e) {
            $result->success = false;
            $result->msg = "El codigo no corresponde para cambiar el password.";
        }
        return $result;

    }

    public function cambiar_password_sc($data)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:recuperacionCnt');
        $result = $repo->cambiar_password_sc($data);
        return $result;

    }

    public function cambiarPasswordPorAplicacion($data)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:recuperacionCnt');
        $result = $repo->cambiarPasswordPorAplicacion($data);
        return $result;
    }

//
}