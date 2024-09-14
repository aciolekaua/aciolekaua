<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassMail;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
use Src\Traits\TraitGetIp;
class ControllerGestaoDeUsuarios{
    use TraitUrlParser;
    use TraitGetIp;
    private $Render;
    private $Session;
    private $Mail;
    private $Write;
    private $Validade;
    public function __construct(){
        $this->Session=new ClassSessions;
        $this->Mail = new ClassMail;
        $this->Write=new ClassWrite;
        $this->Validate = new ClassValidate;
        $this->Render=new ClassRender;
        $this->Render->setDir("GestaoDeUsuarios");
        $this->Render->setTitle("Gestão de Usuários");
        $this->Render->setDescription("Pagina de gestão MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }
    
    public function tabelaGestaoUsuarios(){
        $json = array(
            'erros'=>$this->Validate->getError(),
            'dados'=>$this->Validate->validadeGetAssociados($_SESSION['ID'])
        );
        echo(json_encode($json));
    }
    
    public function dados(){
        $permissoes=$this->Validate->validateGetPermissoes();
        $json=array(
            'erros'=>$this->Validate->getError(),
            'dados'=>$permissoes,
            'regras'=>$this->Validate->validategetNumConselheirosNaRegra(['empresa'=>$_SESSION['ID']])
        );
        echo(json_encode($json));
    }
    
    public function registroDeRegrasConselho(){
        $arrayRequired=array();
        if(isset($_POST['nMaxConselheiros'])){
            $nMaxConselheiros=filter_input(INPUT_POST, 'nMaxConselheiros', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $arrayRequired+=["nMaxConselheiros"=>$nMaxConselheiros];
        }
        if(isset($_POST['nMinVotos'])){
            $nMinVotos=filter_input(INPUT_POST, 'nMinVotos', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $arrayRequired+=["nMinVotos"=>$nMinVotos];
        }
        if(isset($_POST['nMaxVotos'])){
            $nMaxVotos=filter_input(INPUT_POST, 'nMaxVotos', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $arrayRequired+=["nMaxVotos"=>$nMaxVotos];
        }
        
        $this->Validate->validateFilds($arrayRequired);
       
        if(isset($_POST['nMaxConselheiros'])){$this->Validate->validateNumero($nMaxConselheiros);}
        if(isset($_POST['nMinVotos'])){$this->Validate->validateNumero($nMinVotos);}
        if(isset($_POST['nMaxVotos'])){$this->Validate->validateNumero($nMaxVotos);}
        $nMaxConselheiros=(int)$nMaxConselheiros;
        $nMinVotos=(int)$nMinVotos;
        $nMaxVotos=(int)$nMaxVotos;
        
        if(($nMaxConselheiros<$nMaxVotos) || ($nMinVotos>$nMaxVotos)){
            $this->Validate->setError("Coloque uma lógica nas regras");
        }else{
            $z=$this->Validate->validateIssetRegrasConselho($_SESSION['ID']);
            if($z){
                $this->Validate->validateUpdateRegrasConselho([
                    "cnpj"=>$_SESSION['ID'],
                    "nMaxConselheiros"=>$nMaxConselheiros,
                    "nMinVotos"=>$nMinVotos,
                    "nMaxVotos"=>$nMaxVotos
                ]);
            }else{
                $this->Validate->validateInsertRegrasConselho([
                    "cnpj"=>$_SESSION['ID'],
                    "nMaxConselheiros"=>$nMaxConselheiros,
                    "nMinVotos"=>$nMinVotos,
                    "nMaxVotos"=>$nMaxVotos
                ]);
            }  
        }
        $json=array(
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage()
        );
        
        echo(json_encode($json));
        
    }
    
    public function salvarUsuariosOriginal(){
        
        $arrayRequired=[];
        $empresa=$_SESSION['ID'];
        $id=md5(uniqid(rand(),true));
    
        if(isset($_POST['nome'])){
            $nome=filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_ADD_SLASHES);
            $arrayRequired+=["nome"=>$nome];
        }
        
        if(isset($_POST['email'])){
            $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
            $arrayRequired+=["email"=>$email];
        }
        if(isset($_POST['cpf'])){
            $cpf=filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
            $arrayRequired+=["cpf"=>$cpf];
        }
        if(isset($_POST['permissao'])){
            $permissao=filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT);
            $arrayRequired+=["permissao"=>$permissao];
        }
       
        $this->Validate->validateFilds($arrayRequired);
        
        if(isset($_POST['permissao'])){$this->Validate->validateNumero($permissao);}

        $cpf=(string)$cpf;
        $permissao=(int)$permissao;
        $tamanho = 5;
        $token = str_shuffle(md5(uniqid(mt_rand(10000,99999),true)).md5(uniqid(mt_rand(10000,99999),true)));
        $senha = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($tamanho/strlen($x)) )),1,$tamanho);
        
        $this->Validate->validateEmail($email);
        
        if($this->Validate->validateIssetCPF($cpf) && $this->Validate->validateIssetEmail($email,"PF")){
            $retorno = $this->Validate->validateInsertAssociados_PF([
                "DataAtual"=>(string)date("Y-m-d H:i:s"),
                "IP"=>(string)$this->getUserIp(),
                "Email"=>(string)$email,
                "TipoCliente"=>"PF",
                "CPF"=>(string)$cpf,
                "Token"=>(string)$token,
                "Nome"=>(string)$nome,
                "Senha"=>(string)$senha
            ]);
            $corpoSenha="<strong>Você foi cadastrado no Elai. Sua senha para de acesso: {$senha}</strong>";
            $corpoToken = "<strong>Para confirmar o seu cadastro: </strong><a href='".DIRPAGE."confirma-cadastro/confirmarCadastro/{$token}/{$email}'>Clique Aqui</a>";
            if(!$retorno){
                //$this->Validate->setError("");
            }else{
                if($this->Mail->sendMail($email,"Suporte Elai",null,"Cadastro de Conta",$corpoSenha)){
                    $this->Validate->setMessage("Email de senha enviado");
                }else{
                    $this->Validate->setError("Email senha não enviado");
                }
                if($this->Mail->sendMail($email,"Suporte Elai",null,"Confirmação de senha",$corpoToken)){
                    $this->Validate->setMessage("Email de ativação de conta enviado");
                }else{
                    $this->Validate->setError("Email de ativação não enviado");
                }
            }
            
        }
        
        if($this->Validate->validateIssetAssociado(['cnpj'=>$empresa,'cpf'=>$cpf])){
            /*if($this->Validate->validatePermissaoAssociado(['cnpj'=>$empresa,'cpf'=>$cpf,'permissao'=>$permissao])){
                $this->Validate->validateUpdateAssociado(
                    [
                        "permissao"=>$permissao,
                        'cnpj'=>$empresa,
                        "cpf"=>$cpf
                    ]
                );
            }*/
        }else{
            $this->Validate->validateInsertAssociados(
                [
                    "id"=>$id,
                    "cpf"=>$cpf,
                    "empresa"=>$empresa,
                    "permissao"=>$permissao
                ]
            );
        }
        
        $json=array(
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage()
        );
        
        echo(json_encode($json));
    }
    
    public function salvarUsuarios(){
        $arrayRequired=[];
        $id=md5(uniqid(rand(),true));
        
        if(isset($_POST['email'])){
            $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_EMAIL);
            $arrayRequired+=["email"=>$email];
        }
        if(isset($_POST['cpf'])){
            $cpf=preg_replace("/[^0-9]/","",$_POST['cpf']);
            $this->Validate->validateNumero($cpf);
            $arrayRequired+=["cpf"=>$cpf];
        }
     
        if(isset($_POST['permissao'])){
            $permissao=filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT);
            $this->Validate->validateNumero($permissao);
            $arrayRequired+=["permissao"=>$permissao];
        }
    
        $this->Validate->validateFilds($arrayRequired);
        if(!empty($email)){ $cpf = $this->Validate->getCPF_Email($email)["CPF"];}
        
        if($this->Validate->validateIssetCPF($cpf, 'validar existencia')!=true || $this->Validate->validateIssetEmail($email,"PF", 'validar existencia')!=true){
            $this->Validate->setError("Usuário inexistente");
            
        }else{
          
            if($this->Validate->validateIssetAssociado(['cnpj'=>$_SESSION['ID'],'cpf'=>$cpf])){
                $this->Validate->setError("Usuário já vinculado");
            }else{
                $this->Validate->validateInsertAssociados(
                    [
                        "id"=>(string)$id,
                        "cpf"=>(string)$cpf,
                        "empresa"=>(string)$_SESSION['ID'],
                        "permissao"=>(int)$permissao
                    ]
                );
            }
        }
        
        
        $json=array(
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage()
        );
        echo(json_encode($json));
    }
    
    public function atualizarUsuarios(){
        
        $arrayRequired=[];
        $id=md5(uniqid(rand(),true));
        
        if(isset($_POST['email'])){
            $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $arrayRequired+=["email"=>$email];
        }
        if(isset($_POST['cpf'])){
            $cpf=preg_replace("/[^0-9]/","",$_POST['cpf']);
            $this->Validate->validateNumero($cpf);
            $arrayRequired+=["cpf"=>$cpf];
        }
       
        if(isset($_POST['permissao'])){
            $permissao=(int)filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT);
            $arrayRequired+=["permissao"=>$permissao];
        }
    
       
        $this->Validate->validateFilds($arrayRequired);
        
        if(isset($_POST['permissao'])){$this->Validate->validateNumero($permissao);}
        
        if(!empty($email)){ $cpf = $this->Validate->getCPF_Email($email)["CPF"];}
        
        $cpf=(string)$cpf;
        $permissao=(int)$permissao;
        
        if($this->Validate->validateIssetAssociado(['cnpj'=>$_SESSION['ID'],'cpf'=>$cpf])){
            if($this->Validate->validatePermissaoAssociado(['cnpj'=>$_SESSION['ID'],'cpf'=>$cpf,'permissao'=>$permissao])){
                $this->Validate->validateUpdateAssociado(
                    [
                        "permissao"=>(int)$permissao,
                        'cnpj'=>(string)$_SESSION['ID'],
                        "cpf"=>(string)$cpf
                    ]
                );
            }
        }else{
            /*$this->Validate->validateInsertAssociados(
                [
                    "id"=>$id,
                    "cpf"=>$cpf,
                    "empresa"=>$empresa,
                    "permissao"=>$permissao
                ]
            );*/
            $this->Validate->setError("Usuário não vinculado");
        }
        
        $json=array(
            'erros'=>$this->Validate->getError(),
            'sucessos'=>$this->Validate->getMessage()
        );
        
        echo(json_encode($json));
    }
    
    public function excluirUsuarios(){
        
        $arrayRequired=[];
        $empresa=$_SESSION['ID'];
        $id=md5(uniqid(rand(),true));
        
        if(isset($_POST['idAssoc'])){
            $filtro=array('idAssoc'=>array(
                'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                 'flags'  => FILTER_REQUIRE_ARRAY
                ));
            $idAssoc=filter_input_array(INPUT_POST, $filtro);
            $arrayRequired+=["idAssoc"=>$idAssoc];
        }
        
        $this->Validate->validateFilds($arrayRequired);

        
        $delete=$this->Validate->validateDeleteAssociados($idAssoc['idAssoc']);
        
        $json=array(
            'erros'=>$this->Validate->getError(),
            'excluidos'=>$delete['excluidos'],
            'nExcluidos'=>$delete['nExcluidos']
        );
        
        echo(json_encode($json));
        
    }
}
?>