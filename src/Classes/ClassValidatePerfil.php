<?php
namespace Src\Classes;
use App\Model\ClassCadastro;
use App\Model\ClassHome;
use App\Model\ClassLancamentos;
use App\Model\ClassTabelas;
use App\Model\ClassGestaoDeUsuarios;
use App\Model\ClassGestaoDeConselho;
use App\Model\ClassNotaFiscal;
use App\Model\ClassRecuperacaoDeSenha;
use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassSessions;
use Src\Classes\ClassValidate;

use Src\Model\ClassPerfil;
use App\Model\ClassLogin;
class ClassValidatePerfil extends ClassValidate{
			
	public function __construct(){
        parent::__construct();
    }

    public function validateGetDados(array $dados){
        //exit(json_encode($dados));
        $return = $this->Login->getDataUser($dados['Email'],$dados['TipoCliente']);
        if(!$return || $return['linhas']<=0){
            $this->setError("Dados não obtidos");
            return false;
        }else{
            return $return['dados'];
        }
    }

	public function validateUpdateDados($dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados inseridos");
            return false;
        }else{
			
            /*if(isset($dados['email'])){
                
                $r=$this->Perfil->updateEmail($dados);
                if($r>0){
                    $this->setMessage("Email alterado com sucesso");
                    return true;
                }else{
                    $this->setError("Email não alterado");
                    return false;
                }
                
            }*/

			if(isset($dados['nome'])){
                $r=$this->Perfil->updateNome($dados);
                if($r>0){
                    $this->setMessage("Nome alterado com sucesso");
                    return true;
                }else{
                    $this->setError("Nome não alterado");
                    return false;
                }
            }
			if(isset($dados['telefone'])){
                $r=$this->Perfil->updateTelefone($dados);
                if($r>0){
                    $this->setMessage("Telefone alterado com sucesso");
                    return true;
                }else{
                    $this->setError("Telefone não alterado");
                    return false;
                }
            }
			if(isset($dados['cep'])){
                $r=$this->Perfil->updateCEP($dados);
                if($r>0){
                    $this->setMessage("CEP alterado com sucesso");
                    return true;
                }else{
                    $this->setError("CEP não alterado");
                    return false;
                }
            }
			if(isset($dados['endereco'])){
                $r=$this->Perfil->updateEndereco($dados);
                if($r>0){
                    $this->setMessage("Endereço alterado com sucesso");
                    return true;
                }else{
                    $this->setError("Endereço não alterado");
                    return false;
                }
            }
			if(isset($dados['numero'])){
                $r=$this->Perfil->updateNumero($dados);
                if($r>0){
                    $this->setMessage("Numero alterado com sucesso");
                    return true;
                }else{
                    $this->setError("Numero não alterado");
                    return false;
                }
            }
			if(isset($dados['bairro'])){
                $r=$this->Perfil->updateBairro($dados);
                if($r>0){
                    $this->setMessage("Bairro alterado com sucesso");
                    return true;
                }else{
                    $this->setError("Bairro não alterado");
                    return false;
                }
            }
			if(isset($dados['cidade'])){
                $r=$this->Perfil->updateCidade($dados);
                if($r>0){
                    $this->setMessage("Cidade alterada com sucesso");
                    return true;
                }else{
                    $this->setError("Cidade não alterada");
                    return false;
                }
            }
			if(isset($dados['uf'])){
                $r=$this->Perfil->updateUF($dados);
                if($r>0){
                    $this->setMessage("UF alterada com sucesso");
                    return true;
                }else{
                    $this->setError("UF não alterada");
                    return false;
                }
                
            }
			if(isset($dados['nascimento'])){
                $r=$this->Perfil->updateNascimento($dados);
                if($r>0){
                    $this->setMessage("Data de nascimento alterada com sucesso");
                    return true;
                }else{
                    $this->setError("Data de nascimento não alterada");
                    return false;
                }
            }
        }
        
    }

    public function insertGrupo(array $dados):bool{
    	if(count($this->getError())>0){
    		$this->setError("Registro não efetuado");
    		return false;
    	}else{
    		//exit(json_encode($this->Perfil->issetGrupo($dados)));
            
            $result = self::issetGrupo($dados);
            //exit(json_encode($result));
            if($result['linhas']>0){
                $this->setError("Grupo"+$dados['nome']+" já existente");
                return false;
            }else{
                if($this->Perfil->insertGrupo($dados)){
                    $this->setMessage('Grupo adicionado');
                    return true;
                }else{
                    $this->setError("Grupo não adicionado");
                    return false;
                }
            }
    	}
    }
    
    public function issetGrupo(array $dados):array{return $this->Perfil->issetGrupo($dados);}

    /*public function updateContasContabil(array $dados){
        if(count($this->getError())>0){
            $this->setError("Update não efetuado");
            return false;
        }else{
            if($this->Perfil->updateContasContabil($dados)){
                $this->setMessage("Conta Adicionada");
                return true;
            }else{
                $this->setError("Conta não adicionada");
                return false;
            }
        }
    }*/

    public function validateIssetContasContabil(array $dados):bool{return $this->Perfil->issetContasContabil($dados);}

    public function validateInsertContasContabil(array $dados):bool{
    	//exit(json_encode($dados));
    	if(count($this->getError())>0){
            $this->setError("Registro não efetuado");
            return false;
        }else{
        	if($this->Perfil->insertContasContabil($dados)){
                $this->setMessage("Conta Adicionada");
                return true;
            }else{
                $this->setError("Conta não adicionada");
                return false;
            }
        }
    }

	public function validateGetContasContabil(string $cnpj):array{
		
		$return = $this->Perfil->getContasContabil($cnpj);

		if($return['linhas']<=0){
			return [];
		}else{
			return $return['dados'];
		}
	}

	public function validateGetGrupo(array $dados){

		if(count($this->getError())>0){
			return false;
		}else{
			$return = $this->Perfil->getGrupo($dados);
			if($return['linhas']<=0){
				//$this->serError('');
				return false;
			}else{
				return $return['dados'];
			}
		}
	}

	public function validateDeleteGrupo(array $dados){

		if(count($this->getError())>0){
			return false;
		}else{
			if(!$this->Perfil->deleteGrupo($dados)){
				$this->serError('Grupo não deletado');
				return false;
			}else{
				$this->setMessage("Grupo deletado");
				return true;
			}
		}

	}

    public function validateUpdateGrupo(array $dados):bool{
		if(count($this->getError())>0){
			return false;
		}else{
			if(!$this->Perfil->updateGrupo($dados)){
				$this->setError('Grupo não atualizada');
				return false;
			}else{
				$this->setMessage('Grupo atualizada');
				return true;
			}
		}
	}

	public function validateUpdateContasContabil(array $dados):bool{
		if(count($this->getError())>0){
			return false;
		}else{
			if(!$this->Perfil->updateContasContabil($dados)){
				$this->setError('Conta não atualizada');
				return false;
			}else{
				$this->setMessage('Conta atualizada');
				return true;
			}
		}
	}

	public function validateDeleteContasContabil(string $id):bool{
		
		if(count($this->getError())>0){
			return false;
		}else{
			if(!$this->Perfil->deleteContasContabil($id)){
				$this->setError('Conta não apagada');
				return false;
			}else{
				$this->setMessage('Conta apagada');
				return true;
			}
		}
	}

}
?>