<?php
namespace App\Controller;
use App\Model\ClassEventos;
class ControllerEventos{
	public $eventos;
	function __construct(){
		$this->eventos = new ClassEventos();
	}

	function limparContas($token){
		if($token=="ba7e36c43aff315c00ec2b8625e3b719"){
			$this->eventos->limparContas();
		}else{
			echo("Token errado");
		}
	}
}
?>