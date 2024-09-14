
<?php

require_once("../../config/config.php");
require_once("../../src/vendor/autoload.php");
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/
use App\Model\ClassEventos;
$e = new ClassEventos();
//var_dump($e);
$e->limparContas();
echo('OI');
?>