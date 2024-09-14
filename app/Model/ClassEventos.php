<?php
namespace App\Model;
use App\Model\ClassCrud;

class ClassEventos extends ClassCrud {

	public function limparContas(){
		
		$this->deleteDB(
			'PF',
			'bool_ativo_PF = false || bool_ativo_PF = 0',
			[]
		);

		$this->deleteDB(
			'PJ',
			'bool_ativo_PJ = false || bool_ativo_PJ = 0',
			[]
		);
	}

}
?>