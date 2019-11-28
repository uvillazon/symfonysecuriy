<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:06 PM
 */

namespace Elfec\SgauthBundle\Model;


class RespuestaSP
{
    public $success;
    public $msg;
    public $id;
    public $data;
    public $code;
    public $sessionId;

    public function __construct($success = true, $msg = "Proceso Ejectuado Correctamente", $data = null, $id = null, $code = 200,$sessionId = null)
    {
        $this->success = $success;
        $this->msg = $msg;
        $this->id = $id;
        $this->data = $data;
        $this->code = $code;
        $this->sessionId = $sessionId;
    }
}