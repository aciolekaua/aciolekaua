<?php
namespace Src\Classes;
use App\Model\ClassEventos;
class ClassValidateEventos {
	private $eventos;
	function __construct(){
		exit();
		$eventos = new ClassEventos;
	}

	function limparContas(){

		$eventos->limparContas();
	}
}
?>