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
use App\Model\ClassExtrato;

class ClassValidateExtrato extends ClassValidate{
    private $Extrato;
    public function __construct(){
        parent::__construct();
        $this->Extrato = new ClassExtrato;
    }
    
    public function validateEnviarArquivo(array $dados):bool{
        if(count($this->getError())>0){
            $this->setError("Erro Critico");
            return false;
        }else{

            $file = $dados['arquivo'];
            $Dir = "public/arquivos/extrato/";
            $uniqid=uniqid();
            $extensao=strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $url=DIRPAGE.$Dir.$uniqid.".".$extensao;
            $path=DIRREQ.$Dir.$uniqid.".".$extensao;
            if(!self::validadeUploadArquivo($file,$path)){
                return false;
            }else{

                $return = $this->Extrato->insertExtrato([
                    'idExtrato'=>(string)md5(uniqid(rand(1000,9999),true)),
                    "uniqid"=>(string)$uniqid,
                    'dataCompetencia'=>(string)$dados['dataCompetencia'],
                    'url'=>(string)$url,
                    'extensao'=>(string)$extensao,
                    'path'=>(string)$path,
                    'nome'=>(string)$file['name'],
                    'tomador'=>(string)$dados['tomador']
                ]);

                if(!$return){
                    $this->setError("Error");
                    return false;
                }else{
                    $this->setMessage("Registro feito");
                    return true;
                }

            }
        }
    }

    public function validateGetExtrato(array $dados):array{

        $return = $this->Extrato->getExtrato($dados);

        if($return['linhas']<=0){
            return [];
        }else{
            return $return['dados'];
        }
        
    }

    public function validateDeleteExtrato(array $dados){
        //exit(json_encode($dados));
        if(count($this->getError())>0){
            $this->setError("Reveja os dados do formulário.");
            return false;
        }else{
            
            $id = null;
            $r = $this->Extrato->getExtratoId($dados);
            $return = false;

            if($r['linhas']<=0){
                $this->setError("Rejava os dados do formulário.");
                return false;
            }else{
                $path = $r['dados']['path'];
                
                if(file_exists($path)){
                    if(!unlink($path)){
                        $this->setError("Dados não deletados");
                        return false;
                    }else{
                        $return = $this->Extrato->deleteExtrato($dados);
                    }
                }else{
                    $return = $this->Extrato->deleteExtrato($dados);
                }
            }

            $return = $this->Extrato->deleteExtrato($dados);
            if(!$return){
                $this->setError("Dados não deletados");
                return false;
            }else{
                $this->setMessage("Dados deletados");
                return true;
            }
        }
    }

    private function validadeUploadArquivo($File,$Path){
        
        if($File['error']!=0 || count($this->getError())>0){
            $this->setError("Falha no upload");
            return false;
        }else{
            
            $moverArquivo = move_uploaded_file($File['tmp_name'],$Path);
            
            if($moverArquivo){
                $this->setMessage("Upload realizado");
                return true;
            }else{
                $this->setError("Falha no upload");
                return false;
            }
        }
    }

    public function validateUpdateExtrato(array $dados){
        if(count($this->getError())>0){
            $this->setError("Rejava os dados do formulário.");
            return false;
        }else{
            //exit(json_encode($dados));
            $r = $this->Extrato->getExtratoId([
                "id"=>$dados['idExtrato'],
                "cnpj"=>$dados['cnpj']
            ]);

            if($r['linhas']<=0){
                $this->setError("Rejava os dados do formulário.");
                return false;
            }

            $path = $r['dados']['path'];

            if(file_exists($path)){
                if(!unlink($path)){
                    $this->setError("Dados não atualizados.");
                    return false;
                }
            }

            $file = $dados['arquivo'];
            $Dir = "public/arquivos/extrato/";
            $uniqid = uniqid();
            $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $url = DIRPAGE.$Dir.$uniqid.".".$extensao;
            $path = DIRREQ.$Dir.$uniqid.".".$extensao;

            if(!self::validadeUploadArquivo($file,$path)){
                $this->setError("Dados não atualizados.");
                return false;
            }

            $update = $this->Extrato->updateExtrato([
                "idExtrato"=>$dados['idExtrato'],
                "competencia"=>$dados['competencia'],
                "cnpj"=>$dados['cnpj'],
                "url"=>$url,
                "path"=>$path,
                "extensao"=>$extensao,
                "nome"=>$nome,
                "uniqid"=>$uniqid
            ]);

            if(!$update){
                $this->setError("Dados não atualizados");
                return false;
            }else{
                $this->setMessage('Dados atualizados');
                return true;
            }

        }
    }
    
    #Tipo Juridico 
    public function validateTipoJuri($CNPJ){
        $var=$this->Lancamento->tipoJuri($CNPJ);
        if($var["linhas"]<=0){
            $this->setError("Não foi possível realizar a conexão");
            return false;
        }else if($var["linhas"]>0){return $var["dados"];}
    }
}