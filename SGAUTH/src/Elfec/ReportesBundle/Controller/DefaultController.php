<?php

namespace Elfec\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class DefaultController extends Controller
{
   
    public function indexAction(Request $request) 
    {
     //   $request->getReportesAction(Request $request);
        
        var_dump($request->query);
        return $this->render('ElfecReportesBundle:Default:reportes.html.twig');
    }
    
}
