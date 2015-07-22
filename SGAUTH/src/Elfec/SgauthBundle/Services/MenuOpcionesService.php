<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


class MenuOpcionesService
{
    protected $em;
    public function __construct(\Doctrine\ORM\EntityManager $em){

        $this->em = $em;
    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerOpcionesaginados($paginacion,$array){

        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $repo = $this->em->getRepository('ElfecSgauthBundle:menuOpciones');
        $query = $repo->createQueryBuilder('men');
        $query = $repo->filtrarDatos($query,$array);
        if(!is_null($paginacion->contiene)){
            $query = $repo->consultaContiene($query,["opcion","tooltip","estado"],$paginacion->contiene);
        }
        $result->total=$repo->total($query);
        if(!$paginacion->isEmpty()){
            $query = $repo->obtenerElementosPaginados($query,$paginacion);
        }
        $rows =array();
        /**
         * @var \Elfec\SgauthBundle\Entity\menuOpciones $obj
         */
        foreach($query->getQuery()->getResult() as $obj){
            $row = [
                "id_opc"=> $obj->getIdOpc(),
                "id_aplic" =>$obj->getIdAplic()->getIdAplic(),
                "aplicacion" => $obj->getIdAplic()->getNombre(),
                "opcion" => $obj->getOpcion(),
                "link" =>$obj->getLink(),
                "tooltip" =>$obj->getTooltip(),
                "icono" =>$obj->getIcono(),
                "estilo" => $obj->getEstilo(),
                "padre" => (is_null($obj->getIdPadre()))? null : $obj->getIdPadre()->getOpcion(),
                "estado" => $obj->getEstado(),
                "orden" => $obj->getOrden()

            ];
            array_push($rows,$row);
        }

        $result->rows = $rows;
        $result->success = true;
        return $result;
    }

    public function obtenerOpcionesPorUsuario($usuario , $codigoApp){
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
        $repUsr = $this->em->getRepository('ElfecSgauthBundle:appUsr');
        /**
         * @var \Elfec\SgauthBundle\Entity\appUsr $usu
         */
        $usu  = $repUsr->findOneBy(array("usuario" => $usuario , "aplicacion" => $codigoApp));
        if(is_null($usu)){
            $result->success=false;
            $result->msg="No existe el Usuario en la aplicacion";
        }
        else{
            $idPerfil = $usu->getIdPerfil()->getIdPerfil();
//            var_dump($usu);
            $repoUsr = $this->em->getRepository('ElfecSgauthBundle:perfilesOpciones');
            $opciones = $repoUsr->findBy(array('perfil'=>$idPerfil));
            /**
             * @var perfilesOpciones $opcion
             */
            $rows =array();
            foreach ($opciones as $opcion ) {
                $perfil = $opcion->getIdPerfil();
                $row = [
                    "opcion"=>$opcion->getIdOpc()->getOpcion(),
                    "id"=>$opcion->getIdOpc()->getIdOpc(),
                    "url" => $opcion->getIdOpc()->getLink(),
                    "tooltip" => $opcion->getIdOpc()->getTooltip(),
                    "icono" => $opcion->getIdOpc()->getIcono(),
                    "estado" => $opcion->getIdOpc()->getEstado(),
                    "padre" => ($opcion->getIdOpc()->getIdPadre() != null)?  $opcion->getIdOpc()->getIdPadre()->getIdOpc():null,
                    "estilo"=> $opcion->getIdOpc()->getEstilo(),
                    "orden" => $opcion->getIdOpc()->getOrden()

                ];
                array_push($rows,$row);
            }
            $result->data = $rows;
            $result->success= true;
        }

        return $result;


    }
}