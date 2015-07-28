<?php

namespace Elfec\SgauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Exception;

class DefaultController extends Controller
{

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

    public function logonAction()
    {
            return $this->render('ElfecSgauthBundle:Default:login.html.twig');
    }
}
