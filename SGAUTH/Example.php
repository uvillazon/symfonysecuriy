<?php
//echo DateTime();
//echo "hola";
//$conn = new COM("ADODB.Connection") or die("No se puede iniciar ADO");
/**
 * Created by PhpStorm.
 * User: uvillazon
 * Date: 27/07/2015
 * Time: 05:30 PM
 */
$command = "composer";
$pid = popen( $command,"r");
var_dump($pid);
while( !feof( $pid ) )
{
    echo fread($pid, 256);
    flush();
    ob_flush();
    usleep(100000);
}
pclose($pid);
?>