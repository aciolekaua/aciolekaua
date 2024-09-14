<?php
namespace Src\Classes;
use App\Model\ClassCadastro;
use App\Model\ClassLogin;
use App\Model\ClassHome;
use App\Model\ClassLancamentos;
use App\Model\ClassTabelas;
use App\Model\ClassGestaoDeUsuarios;
use App\Model\ClassGestaoDeConselho;
use App\Model\ClassPerfil;
use App\Model\ClassNotaFiscal;
use App\Model\ClassRecuperacaoDeSenha;
use App\Model\ClassTeste;

use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassSessions;
use Src\Classes\ClassValidate;
use Src\Traits\TraitUrlParser;

class ClassValidateRegistroDePonto extends ClassValidate{
    public function __construct(){
        parent::__construct();
    }
    
    public function validateAutenticacao($dados){
        if(count($this->getError())>0){
            $this->setError('Verifique os dados (Login)');
            return false;
        }else{
            
        }
    }
}
?>