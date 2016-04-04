<?php

namespace Elfec\SgauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Exception;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
//        try{
//            $Usertoken = $this->container->get("JWTUser");
//            return $this->render('ElfecSgauthBundle:Default:index.html.twig');
//        }
//        catch(Exception $e){
//            var_dump($e->getMessage());
//            return $this->render('ElfecSgauthBundle:Default:login.html.twig');
//        }
        return $this->render('ElfecSgauthBundle:Default:index.html.twig');
    }

    /**
     * @Route("/logon", name="logon")
     */
    public function logonAction()
    {
            return $this->render('ElfecSgauthBundle:Default:login.html.twig');
    }

    /**
     * @Route("/recuperacion/{codigoApp}", name="recuperacion")
     */
    public function recuperacionAction($codigoApp)
    {

        $des = $this->get('nzo_url_encryptor')->encrypt($codigoApp);
        $MyId = $this->get('nzo_url_encryptor')->decrypt($des);
//       var_dump($this->;
//        $codigoApp = "adsdad";
        return $this->render('ElfecSgauthBundle:Default:recuperacion.html.twig',array("codigoApp"=>$codigoApp, "encriptar"=> $des , "decr"=> $MyId));
    }
}
