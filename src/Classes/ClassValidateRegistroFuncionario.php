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
use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassSessions;
use Src\Classes\ClassValidate;
use App\Model\ClassRegistroFuncionario;

class ClassValidateRegistroFuncionario extends ClassValidate{
    
    private $RegistroFuncionario;
    public function __construct(){
        parent::__construct();
        $this->RegistroFuncionario = new ClassRegistroFuncionario;
    }
}