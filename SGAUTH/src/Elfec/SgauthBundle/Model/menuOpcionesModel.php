<?php
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 16/07/2015
 * Time: 03:06 PM
 */

namespace Elfec\SgauthBundle\Model;


class menuOpcionesModel
{
    public $titulo;
    public $iconcls;
    public $href;
    public $alias;
    public $id;
    public $tooltip;
    public $parametros;
    /**
     * @var  array $submenu
     */
    public $submenu;
    /**
     * @var array $botones
     */
    public $botones;
}