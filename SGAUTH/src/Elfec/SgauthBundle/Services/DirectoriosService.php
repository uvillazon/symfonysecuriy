<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


use Elfec\SgauthBundle\Entity\gruposCorreos;
use Elfec\SgauthBundle\Entity\gruposDestCorreo;

class DirectoriosService
{
    protected $em;
    protected $emSgauth;

    public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\ORM\EntityManager $emSgauth)
    {

        $this->em = $em;
        $this->emSgauth = $emSgauth;
    }


    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerGruposPaginados($paginacion, $array, $token = true)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        if ($token) {
            $repo = $this->em->getRepository('ElfecSgauthBundle:gruposCorreos');
        } else {
            $repo = $this->emSgauth->getRepository('ElfecSgauthBundle:gruposCorreos');
        }
        $query = $repo->createQueryBuilder('app');
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["nombre", "estado"], $paginacion->contiene);
        }
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }

        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    public function guardarGrupo($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:gruposCorreos');
        $result = $repo->grabarGruposCorreo($data, $login);
        return $result;

    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerDestinatariosPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:destinatariosCorreos');
        $query = $repo->createQueryBuilder('app');
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["nombre", "correo", "apellido"], $paginacion->contiene);
        }
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }

        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    public function guardarDestinatario($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:destinatariosCorreos');
        $result = $repo->grabarDestinatario($data, $login);
        return $result;

    }


    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerDestinatariosGruposPaginados($paginacion, $array)
    {

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:gruposDestCorreo');
        $query = $repo->createQueryBuilder('app');
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["tipo_msg_dest"], $paginacion->contiene);
        }
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $rows = array();
        foreach ($query->getQuery()->getResult() as $item) {
            /**
             * @var gruposDestCorreo $item
             */
            $row = array(
                "id" => $item->getId(),
                "nombre" => $item->getDestinatarioCorreo()->getNombre(),
                "apellido" => $item->getDestinatarioCorreo()->getApellido(),
                "correo" => $item->getDestinatarioCorreo()->getCorreo(),
                "grupo" => $item->getGrupoCorreo()->getNombre(),
                "tipo_msg_dest" => $item->getTipoMsgDest()

            );
            array_push($rows, $row);
        }

//        $result->rows = $query->getQuery()->getResult();
        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    public function guardarDestinatarioGrupo($data, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:gruposDestCorreo');
        $result = $repo->grabarDestinatarioGrupo($data, $login);
        return $result;

    }

    public function eliminarDestinatarioGrupo($id, $login)
    {
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repo = $this->em->getRepository('ElfecSgauthBundle:gruposDestCorreo');
        $result = $repo->eliminarDestinatarioDelGrupo($id);
        return $result;

    }
}