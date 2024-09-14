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

use App\Model\ClassAgenda;
/*use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;

use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;*/

class ClassValidateAgenda extends ClassValidate{
    
    private $Agenda;
    
    public function __construct(){
        parent::__construct();
        $this->Agenda = new ClassAgenda;
    }
    
    public function validateInsertEventosAgenda($dados){
        
        if(count($this->getError())>0){
            
            $this->setError("Verifique os dados");
            return false;
            
        }else{
            //
            if($this->Agenda->issetEvento($dados)){
                $this->setError('Evento já cadastrado');
                return false;
            }else{
                //
                if(!$this->Agenda->insertEvento($dados)){
                    $this->setError('Evento não registrado');
                    return false;
                }else{
                    $this->setMessage('Evento registrado');
                    return true;
                }
            }
            
        }
    }
    
    public function validateGetEventos($dados,$tpCliente){
        if($tpCliente=="PJ"){
            $result = $this->Agenda->selectEventoPJ($dados);
            if($result['linhas']<=0){
                return false;
            }else{
                return $result['dados'];
            }
        }
    }
}