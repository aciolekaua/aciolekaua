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

use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;

use App\Model\ClassGerenciador;
use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;

class ClassValidateGerenciador extends ClassValidate{
    
    private $Gerenciador;
    private $JWT;
    private $RequestJSON;
    
    public function __construct(){
        parent::__construct();
        //$this->Gerenciador = new ClassGereciador();
        $this->JWT = new ClassJWT();
        $this->RequestJSON = new ClassRequestJSON();
    }
    
}
?>