<?php

namespace Elfec\SgauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('ElfecSgauthBundle:Default:index.html.twig');
    }
}
