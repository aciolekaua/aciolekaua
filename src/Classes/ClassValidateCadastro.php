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
use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;
class ClassValidateCadastro extends ClassValidate{
    
    //private $Cadastro;
    
    public function __construct(){
        parent::__construct();
    }
    
    public function validateInsertCadPF($Dados=array()){
        if(count($this->getError())>0){
            $this->setError("Falha no cadastro");
            return false;
        }else{
           
            if(count($Dados)>0){
               
                if(!$this->Cadastro->insertTokenConfirmaCad($Dados)){
                    $this->setError("Cadastro não realizado(Token não registrado)");
                    return false;
                }else{
                    
                    if($this->Cadastro->validateInsertPF($Dados)>0){
                        $this->setMessage("Cadastro feito");
                        return true;
                    }else{
                        $this->setError("Cadastro não realizado");
                        return false;
                    }
                }
                    
            }else{
                $this->setError("Array vazio");
                return false;
            }
            
        }
        
    }
    
    public function validateInsertCadPJ($Dados=array()){
        
        if(count($this->getError())>0){
            $this->setError("Falha no cadastro");
            return false;
        }else{
           
            if(count($Dados)>0){
                
                //exit(json_encode($this->Cadastro->issetTokenConfirmaCad($Dados)));
                if($this->Cadastro->issetTokenEmailConfirmaCad($Dados['Email'])>0){
                    
                    if($this->Cadastro->updateTokenConfirmaCad($Dados)<=0){
                        $this->setError("Cadastro não realizado");
                        return false;
                    }else{
                        if($this->Cadastro->validateInsertPJ($Dados)>0){
                            $this->setMessage("Cadastro feito");
                            return true;
                        }else{
                            $this->setError("Cadastro não realizado");
                            return false;
                        }
                    }
                   
                }else{
                    //exit(json_encode($Dados));
                    if(!$this->Cadastro->insertTokenConfirmaCad($Dados)){
                        $this->setError("Cadastro não realizado(Token não registrado)");
                        return false;
                    }else{
                        if($this->Cadastro->validateInsertPJ($Dados)>0){
                            $this->setMessage("Cadastro feito");
                            return true;
                        }else{
                            $this->setError("Cadastro não realizado");
                            return false;
                        }
                    }
                }
               
                
              
            }else{
                $this->setError("Sem dados presentes");
                return false;
            }
            
        }
        
    }
    
}
?>