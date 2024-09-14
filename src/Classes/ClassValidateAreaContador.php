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
use App\Model\ClassAreaContador;
use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassSessions;
use Src\Classes\ClassValidate;
use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;
class ClassValidateAreaContador extends ClassValidate{
    
    private $AreaContador;
    
    public function __construct(){
        parent::__construct();
        $this->AreaContador = new ClassAreaContador;
    }
    
    public function validateInsertCodigoHistoricoContador($dados){
        $retorno = $this->AreaContador->insertCodigoHistoricoContador($dados);
        if($retorno<=0){
            return false;
        }else{
            return true;
        }
    }
    
    public function validateIssetCodigoHistoricoContador($dados){
        $retorno = $this->AreaContador->issetCodigoHistoricoContador($dados);
        if($retorno<=0){
            return false;
        }else{
            return true;
        }
    }
    
    public function validateUpdateCodigoHistoricoContador($dados){
        $retorno = $this->AreaContador->updateCodigoHistoricoContador($dados);
        if($retorno<=0){
            return false;
        }else{
            return true;
        }
    }
    
    public function validateGetCodigoHistoricoContador($dados){
        
        $retorno = $this->AreaContador->getCodigoHistoricoContador($dados);
        
        if($retorno['linhas']<=0){
            return false;
        }else{
            return $retorno;
        }
    }
}
?>