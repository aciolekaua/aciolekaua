<?php
    //ini_set('display_errors','1');
    //error_reporting(E_ALL);
    date_default_timezone_set('America/Sao_Paulo');
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    header("Content-Type: text/html; charset=utf-8");
    require_once("../config/config.php");
    require_once("../src/vendor/autoload.php");
    $Dispatch=new App\Despatch;
?>