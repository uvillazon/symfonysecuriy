<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;

use Toyota\Component\Ldap\Core\Manager;
use Toyota\Component\Ldap\Platform\Native\Driver;
use Toyota\Component\Ldap\Platform\Native\Search;
use Toyota\Component\Ldap\Exception;

class AreasService
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
    public function obtenerAreasPaginados($paginacion, $array, $con_token = true)
    {
//        $this->AD();
//        $this->ldapNormal();
        $repo = $con_token ? $this->em->getRepository('ElfecSgauthBundle:areas') : $this->emSgauth->getRepository('ElfecSgauthBundle:areas');
        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $query = $repo->createQueryBuilder('app');
        if (!is_null($paginacion->contiene)) {
            $query = $repo->consultaContiene($query, ["nom_area"], $paginacion->contiene);
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

    public function obtenerAreaPorNombre($nomArea ,$con_token = true){
        $repo = $con_token ? $this->em->getRepository('ElfecSgauthBundle:areas') : $this->emSgauth->getRepository('ElfecSgauthBundle:areas');
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP(false);
        $area = $repo->findOneBy(array("nomArea"=>$nomArea));
        if(!is_null($area)){
            $result->data = $area;
            $result->success = true;
        }
        else{
            $result->msg = "No existe el Area";
        }
        return $result;

    }

    /**
     * @param \Elfec\SgauthBundle\Model\PaginacionModel $paginacion
     * @param array $array
     * @return \Elfec\SgauthBundle\Model\ResultPaginacion
     */
    public function obtenerAreasUsuarioPaginados($paginacion, $array)
    {
        $repo = $this->em->getRepository('ElfecSgauthBundle:usuariosAreas');
        $result = new \Elfec\SgauthBundle\Model\ResultPaginacion();
        $query = $repo->createQueryBuilder('app');
        $query = $repo->filtrarDatos($query, $array);
        $result->total = $repo->total($query);
        if (!$paginacion->isEmpty()) {
            $query = $repo->obtenerElementosPaginados($query, $paginacion);
        }
        $result->rows = $query->getQuery()->getResult();
        $result->success = true;
        return $result;
    }

    public function AD()
    {
        try {
            $params = array(
                'hostname' => 'elffls01.elfec.com',
                'base_dn' => 'DC=elfec,DC=com'
            );
            $manager = new Manager($params, new Driver());

            $manager->connect();
            $manager->bind('sisman@elfec.com', 'Agto.2013E');

            $results = $manager->search('OU=ELFEC,DC=elfec,DC=com', 'objectCategory=person');

//            var_dump($results);
// A search result instance is retrieved which provides iteration capability for a convenient use

            /**
             * @var \Toyota\Component\Ldap\Core\Node $node
             */
            foreach ($results as $node) {
                var_dump($node->getAttributes());
                die();
//                foreach ($node->getAttributes() as $attribute) {
//                    $valor = sprintf('%s => %s', $attribute->getName(), implode(',', $attribute->getValues()));
//                    var_dump($);
//                }
            }
            die();
//            var_dump($manager);
        } catch (\Exception  $e) {
            var_dump($e->getMessage());
        }
    }

    public function ldapNormal()
    {
        try {
            $ldap_server = "elffls01.elfec.com";
            $ldap_user = "uvillazon@elfec.com";
            $ldap_pass = 'AvVi30012014........';

            $ldap = ldap_connect($ldap_server);
            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            $bind = ldap_bind($ldap, $ldap_user, $ldap_pass);
            if ($bind) {
                $person = "Erika";
                $dn = "OU=ELFEC,DC=elfec,DC=com";
                $filter = "(|(sn=$person*)(givenname=$person*))";
//                $filter = "objectCategory=person";
                $justthese = array("ou", "sn", "givenname", "mail");

                $sr = ldap_search($ldap, $dn, $filter, $justthese);

                $info = ldap_get_entries($ldap, $sr);

                var_dump($info);
            }
//            var_dump($ad);

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}