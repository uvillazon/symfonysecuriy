<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:59 PM
 */

namespace Elfec\SgauthBundle\Services;


use Exception;
use Swift_Mailer;
use Twig_Template;
use Swift_Image;

class CorreoService
{
    protected $mailer;
    protected $template;

    /**
     * @param Swift_Mailer $mailer
     * @param  Twig_Template $template
     */
    public function __construct($mailer , $template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }

    /**
     * @param $destinatarios
     * @param $copias
     * @param $mensaje
     * @param array $archivos
     * @param string $mailUsuario
     * @param array $datos
     * @return \Elfec\SgauthBundle\Model\RespuestaSP
     */
    public function enviarCorreos($subject, $destinatarios, $copias, $mensaje, $archivos, $mailUsuario ,$datos)
    {
//        var_dump($destinatarios);
        $result = new \Elfec\SgauthBundle\Model\RespuestaSP();
//        var_dump($subject);
        if (strlen($destinatarios) > 0) {
            try {
                $to = explode(',', $destinatarios);

//                var_dump($to);
                $message = \Swift_Message::newInstance('Test');
                $imgUrl = $message->embed(Swift_Image::fromPath('Content/images/logoSisman.png'));
//                var_dump($imgUrl);
                $message->setSubject($subject);
                $message->setFrom($mailUsuario);
                $message->setTo($to);
                if (strlen($copias) > 0) {
                    $ccc = explode(',', $copias);
                    $message->setCc($ccc);
                }
                $message->setBcc($mailUsuario);
                if (count($archivos) > 0) {
                    foreach ($archivos as $archivo) {
                        $message->attach(\Swift_Attachment::fromPath($archivo));
                    }
                }

//                $message->setBody($mensaje);
//                $message->setBody(
//                    '<html>' .
//                    ' <head></head>' .
//                    ' <body>' .
//                    ' ' . $mensaje . ' ' .
//                    ' </body>' .
//                    '</html>',
//                    'text/html' // Mark the content-type as HTML
//                );
//                var_dump($message);
                try{
                $body = $this->template->render('ElfecSgauthBundle:Default:recuperacionEmail.html.twig',
                    array('codigoControl' => $mensaje ,
                        'url'=>$imgUrl,
                        'usuario' => $datos["usuario"],
                        "fecha_exp"=> $datos["fecha_exp"],
                        "navegador" => $datos["navegador"],
                        "ip" => $datos["ip"] )
                );
                }catch (Exception $e){
                    var_dump($e->getMessage());
                }
//                var_dump($body);
                $message->setBody($body,'text/html');

//                $message->setBody(
//                    $this->renderView(
//                    // app/Resources/views/Emails/registration.html.twig
//                        'default/base.html.twig',
//                        array('name' => $mensaje)
//                    )
//                    ,'text/html'
//                );
                $this->mailer->send($message);
                $result->success = true;
                $result->msg = "Se Envio Satisfactoriamente los Correos";
            } catch (\Exception $e) {
                $result->success = false;
                $result->msg = $e->getMessage();
            }

        } else {
            $result->msg = "No contiene Destinatarios";
            $result->success = false;
        }
        return $result;
    }

}