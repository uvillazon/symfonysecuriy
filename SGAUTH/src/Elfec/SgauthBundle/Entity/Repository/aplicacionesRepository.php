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

class aplicacionesRepository extends BaseRepository
{
    public function guardar_aplicacion($data,$login){
//                                 var_dump($data);die();
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        try {
            $conection = $this->_em->getConnection();
            $st = $conection->prepare("SELECT elfec.grabar_aplicaciones (
  :p_id_aplic::numeric,
  :p_codigo::varchar,
  :p_nombre::varchar,
  :p_descripcion::varchar,
  :p_bd_princ::varchar,
  :p_estado::varchar,
  :p_bd_port::numeric,
  :p_bd_host::varchar,
  :p_bd_drive::varchar,
  :p_app_host::varchar,
  :p_secret_key::varchar,
  :p_tiempo_valido_token::numeric,
  :p_cant_sesiones_permitidas::numeric,
  :p_login_usr::varchar);");
            $st->bindValue(":p_id_aplic",  array_key_exists('id_aplic', $data) ? $data["id_aplic"] === '' ? 0 : $data["id_aplic"] : 0);
            $st->bindValue(":p_codigo", array_key_exists('codigo', $data) ? $data["codigo"] : null);
            $st->bindValue(":p_nombre", array_key_exists('nombre', $data) ? $data["nombre"] : null);
            $st->bindValue(":p_descripcion", array_key_exists('descripcion', $data) ? $data["descripcion"] : null);
            $st->bindValue(":p_bd_princ", array_key_exists('bd_princ', $data) ? $data["bd_princ"] : null);
            $st->bindValue(":p_estado", array_key_exists('estado', $data) ? $data["estado"] : null);
            $st->bindValue(":p_bd_port", array_key_exists('bd_port', $data) ? $data["bd_port"] : 0);
            $st->bindValue(":p_bd_host", array_key_exists('bd_host', $data) ? $data["bd_host"] : null);
            $st->bindValue(":p_bd_drive", array_key_exists('bd_drive', $data) ? $data["bd_drive"] : null);
            $st->bindValue(":p_app_host", array_key_exists('app_host', $data) ? $data["app_host"] : null);
            $st->bindValue(":p_secret_key", array_key_exists('secret_key', $data) ? $data["secret_key"] : null);
            $st->bindValue(":p_tiempo_valido_token", array_key_exists('tiempo_valido_token', $data) ? $data["tiempo_valido_token"] : null);
            $st->bindValue(":p_cant_sesiones_permitidas", array_key_exists('cant_sesiones_permitidas', $data) ? $data["cant_sesiones_permitidas"] : null);
            $st->bindValue(":p_login_usr", $login);
            $st->execute();
            $response = $st->fetchAll();
            if (count($response) > 0) {
                if (is_numeric($response[0]["grabar_aplicaciones"])) {
                    $result->success = true;
                    $result->msg = "Proceso se ejecuto correctamente";
                    $result->id = $response[0]["grabar_aplicaciones"];
                } else {
                    $result->success = false;
                    $result->msg = $response[0]["grabar_aplicaciones"];
                }
            } else {
                $result->success = false;
                $result->msg = "Ocurrio algun problema al Ejectuar la Funcion en Postgresql";
            }
        } catch (Exception $e) {
            $result->success = false;
            $result->msg = $e->getMessage();
            var_dump($data);die();
        }
        return $result;
    }

}