<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Interfaces\InterfaceView;
use Src\Classes\ClassValidate;
use Src\Classes\ClassMail;
use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassIncludes;
use Src\Classes\ClassWrite;
use Src\Classes\ClassValidateCadastro;
use Src\Traits\TraitUrlParser;
use Src\Traits\TraitGetIp;
class ControllerCadastro{
    use TraitUrlParser;
    use TraitGetIp;
    private $Validate;
    private $Write;
    private $objPass;
    private $arrayPost=[];
    private $Render;
    private $Mail;
    private $validateCadastro;
    function __construct(){
        $this->Validate=new ClassValidate;
        $this->objPass=new ClassPasswordHash;
        $this->Write=new ClassWrite;
        $this->Render=new ClassRender;
        $this->Mail = new ClassMail;
        $this->validateCadastro = new ClassValidateCadastro;
        $this->Render->setDir("Cadastro");
        $this->Render->setTitle("Cadastro");
        $this->Render->setDescription("Pagina de cadastro MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout();
        }
    }
    
    public function dados(){
        $result=$this->Validate->validateGetTipoJuridico();
        $json=array(
            'erros'=>$this->Validate->getError(),
            'dados'=>$result
        );
        echo(json_encode($json));
    }
    
    public function cadastrarPF(){
        
        $const=['cost' => 13];
        $token=str_shuffle(md5(uniqid(mt_rand(10000,99999),true)).md5(uniqid(mt_rand(10000,99999),true)));
        
        if(isset($_POST['nome'])){
            $nome=filter_input(INPUT_POST,'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            if($this->Validate->validateNome($nome)){$this->arrayPost+=["Nome"=>$nome];}
        }
        if(isset($_POST['cpf'])){
            $cpf=filter_input(INPUT_POST,'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf = str_replace("/[^0-9]/","",$cpf);
            if($this->Validate->validateCPF($cpf)){$this->arrayPost+=["CPF"=>$cpf];}
        }
        if(isset($_POST['dtnascimento'])){
            $dtNascimento=filter_input(INPUT_POST,'dtnascimento', FILTER_SANITIZE_SPECIAL_CHARS);
            if($this->Validate->validateData($dtNascimento)){$this->arrayPost+=["dtNascimento"=>$dtNascimento];}
        }
        if(isset($_POST['emailPF'])){
            $email="";
            if($this->Validate->validateEmail($_POST['emailPF'])){$email=$_POST['emailPF'];}
            $this->arrayPost+=["Email"=>$email];
        }
        if(isset($_POST['senha'])){
            $senha=filter_input(INPUT_POST,'senha', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha=$this->objPass->passHash($senha,$const);
            $this->arrayPost+=["Senha"=>$senha];
        }
        
        if(isset($_POST['telPF'])){
            $tel=filter_input(INPUT_POST,'telPF', FILTER_SANITIZE_SPECIAL_CHARS);
            //if($this->Validate->validateTelefone($tel)){$this->arrayPost+=["Telefone"=>$tel];}
            $this->arrayPost+=["Telefone"=>$tel];
        }
         
        if(isset($_POST['cepPF'])){
            $cep=preg_replace("/[^0-9]/", "",$_POST['cepPF']);
            if($this->Validate->validateCEP($cep)){$this->arrayPost+=["CEP"=>$cep];}
        }
       
        if(isset($_POST['enderecoPF'])){
            $endereco=filter_input(INPUT_POST,'enderecoPF', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Endereco"=>$endereco];
        }
        if(isset($_POST['numeroPF'])){
            $numero=filter_input(INPUT_POST,'numeroPF', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Numero"=>$numero];
        }
        if(isset($_POST['complementoPF'])){
            $complemento=filter_input(INPUT_POST,'complementoPF', FILTER_SANITIZE_SPECIAL_CHARS);
            //array_push($arrayPost,$complemento);
        }
        if(isset($_POST['bairroPF'])){
            $bairro=filter_input(INPUT_POST,'bairroPF', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Bairro"=>$bairro];
        }
        if(isset($_POST['cidadePF'])){
            $cidade=filter_input(INPUT_POST,'cidadePF', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Cidade"=>$cidade];
        }
        if(isset($_POST['ufPF'])){
            $uf=filter_input(INPUT_POST,'ufPF', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["UF"=>$uf];
        }
        
        $this->Validate->validateFilds($this->arrayPost);
        $this->Validate->validateIssetCPF($this->arrayPost["CPF"]); 
        $this->Validate->validateIssetEmail($this->arrayPost["Email"],'PF');
        $retorno = $this->Validate->validateInsertCad(
            array(
                "DataAtual"=>date("Y-m-d H:i:s"),
                "IP"=>$this->getUserIp(),
                "TipoCliente"=>"PF",
                "Token"=>$token,
                "Nome"=>$nome,
                "Email"=>$email,
                "Senha"=>$senha,
                "Telefone"=>$tel,
                "CPF"=>$cpf,
                "dtNascimento"=>$dtNascimento,
                "CEP"=>$cep,
                "Endereco"=>$endereco,
                "Numero"=>$numero,
                "Complemento"=>$complemento,
                "Bairro"=>$bairro,
                "Cidade"=>$cidade,
                "UF"=>$uf
            ),
            "PF"
        );
        
        if($retorno!=false){self::enviaEmail([
            'email'=>$email,
            'token'=>$token
        ]);}
        
        exit(json_encode([
            'sucessos'=>$this->Validate->getMessage(),
            'erros'=>$this->Validate->getError()
        ]));
    }
    
    public function cadastrarPJ(){
        
        $const=['cost' => 13];
        $token=str_shuffle(md5(uniqid(mt_rand(10000,99999),true)).md5(uniqid(mt_rand(10000,99999),true)));
        
        if(isset($_POST['tipoJuri'])){
            $tipoJuri=filter_input(INPUT_POST,'tipoJuri', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["TipoJuridico"=>$tipoJuri];
        }
        if(isset($_POST['nomeFantazia'])){
            $nomeFantazia=filter_input(INPUT_POST,'nomeFantazia', FILTER_SANITIZE_ADD_SLASHES);
            //if($this->Validate->validateNome($nome)){$arrayPost+=["Nome"=>$nome];}
            $this->arrayPost+=["nomeFantazia"=>$nomeFantazia];
        }
        if(isset($_POST['razaoSocial'])){
            $razaoSocial=filter_input(INPUT_POST,'razaoSocial', FILTER_SANITIZE_ADD_SLASHES);
            //if($this->Validate->validateNome($nome)){$arrayPost+=["Nome"=>$nome];}
            $this->arrayPost+=["razaoSocial"=>$razaoSocial];
        }
        if(isset($_POST['cnpj'])){
            $cnpj=filter_input(INPUT_POST,'cnpj', FILTER_SANITIZE_SPECIAL_CHARS);
            $cnpj=preg_replace("/[^0-9]/","",$cnpj);
            if($this->Validate->validateCNPJ($cnpj)){$this->arrayPost+=["CNPJ"=>$cnpj];}
        }
        if(isset($_POST['emailPJ'])){
            $email="";
            if($this->Validate->validateEmail($_POST['emailPJ'])){$email=$_POST['emailPJ'];}
            $this->arrayPost+=["Email"=>$email];
        }
        if(isset($_POST['senha'])){
            $senha=filter_input(INPUT_POST,'senha', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha=$this->objPass->passHash($senha,$const);
            $this->arrayPost+=["Senha"=>$senha];
        }
        
        if(isset($_POST['telPJ'])){
            $tel=filter_input(INPUT_POST,'telPJ', FILTER_SANITIZE_SPECIAL_CHARS);
            //if($this->Validate->validateTelefone($tel)){$this->arrayPost+=["Telefone"=>$tel];}
            $this->arrayPost+=["Telefone"=>$tel];
        }
         
        if(isset($_POST['cepPJ'])){
            $cep=preg_replace("/[^0-9]/", "",$_POST['cepPJ']);
            if($this->Validate->validateCEP($cep)){$this->arrayPost+=["CEP"=>$cep];}
        }
       
        if(isset($_POST['enderecoPJ'])){
            $endereco=filter_input(INPUT_POST,'enderecoPJ', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Endereco"=>$endereco];
        }
        if(isset($_POST['numeroPJ'])){
            $numero=filter_input(INPUT_POST,'numeroPJ', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Numero"=>$numero];
        }
        if(isset($_POST['complementoPJ'])){
            $complemento=filter_input(INPUT_POST,'complementoPJ', FILTER_SANITIZE_SPECIAL_CHARS);
            //array_push($arrayPost,$complemento);
        }
        if(isset($_POST['bairroPJ'])){
            $bairro=filter_input(INPUT_POST,'bairroPJ', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Bairro"=>$bairro];
        }
        if(isset($_POST['cidadePJ'])){
            $cidade=filter_input(INPUT_POST,'cidadePJ', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["Cidade"=>$cidade];
        }
        if(isset($_POST['ufPJ'])){
            $uf=filter_input(INPUT_POST,'ufPJ', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["UF"=>$uf];
        }
        
        $this->Validate->validateFilds($this->arrayPost);
        $this->Validate->validateIssetCNPJ($this->arrayPost["CNPJ"]); 
        $this->Validate->validateIssetEmail($this->arrayPost["Email"],'PJ');
        $retorno = $this->validateCadastro->validateInsertCadPJ(
            array(
                "DataAtual"=>date("Y-m-d H:i:s"),
                "IP"=>$this->getUserIp(),
                "TipoCliente"=>"PJ",
                "Token"=>$token,
                "NomeFantazia"=>$nomeFantazia,
                "RazaoSocial"=>$razaoSocial,
                "Email"=>$email,
                "Senha"=>$senha,
                "CNPJ"=>$cnpj,
                "TipoJuridico"=>(int)$tipoJuri,
                "Telefone"=>$tel,
                "CEP"=>$cep,
                "Endereco"=>$endereco,
                "Numero"=>$numero,
                "Complemento"=>$complemento,
                "Bairro"=>$bairro,
                "Cidade"=>$cidade,
                "UF"=>$uf
            )
        );
    
        if($retorno!=false){
            self::enviaEmail([
                'email'=>$email,
                'token'=>$token
            ]);
        }
        
        exit(json_encode([
            'sucessos'=>$this->Validate->getMessage(),
            'erros'=>$this->Validate->getError()
        ]));
    }
    
    private function enviaEmail($dados){
        $corpo = "<strong>Para confirmar o seu cadastro: </strong><a href='".DIRPAGE."confirma-cadastro/confirmarCadastro/".$dados['token']."/".$dados['email']."'>Clique Aqui</a>";
        if($this->Mail->sendMail($dados['email'],"Suporte Elai",null,"Confirmação de Cadastro",$corpo)){
            $this->Validate->setMessage("Ative a conta no email");
        }else{
            $this->Validate->setError("Email não enviado");
        }
    }
    
    public function cadastrar(){
      
        exit(json_encode($_POST));
        
        $requires=12;
        $const=['cost' => 13];
        $token=str_shuffle(md5(uniqid(mt_rand(10000,99999),true)).md5(uniqid(mt_rand(10000,99999),true)));
        
        if(isset($_POST['tipoCliente'])){
            $TipoCliente=filter_input(INPUT_POST,'tipoCliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->arrayPost+=["TipoCliente"=>$TipoCliente];
            if($TipoCliente=="PJ"){
                if(isset($_POST['tipoJuri'])){
                    $tipoJuri=filter_input(INPUT_POST,'tipoJuri', FILTER_SANITIZE_SPECIAL_CHARS);
                    $this->arrayPost+=["TipoJuridico"=>$tipoJuri];
                }
                if(isset($_POST['nomeEmpresa'])){
                    $nomeEmpresa=filter_input(INPUT_POST,'nomeEmpresa', FILTER_SANITIZE_SPECIAL_CHARS);
                    //if($this->Validate->validateNome($nome)){$arrayPost+=["Nome"=>$nome];}
                    $this->arrayPost+=["NomeDaEmpresa"=>$nomeEmpresa];
                }
                if(isset($_POST['cnpj'])){
                    $cnpj=filter_input(INPUT_POST,'cnpj', FILTER_SANITIZE_SPECIAL_CHARS);
                    $cnpj=str_replace(["-",".","/"],"",$cnpj);
                    if($this->Validate->validateCNPJ($cnpj)){$this->arrayPost+=["CNPJ"=>$cnpj];}
                }
                
            }else if($TipoCliente=="PF"){
                if(isset($_POST['nome'])){
                    $nome=filter_input(INPUT_POST,'nome', FILTER_SANITIZE_SPECIAL_CHARS);
                    if($this->Validate->validateNome($nome)){$this->arrayPost+=["Nome"=>$nome];}
                }
                if(isset($_POST['cpf'])){
                    $cpf=filter_input(INPUT_POST,'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
                    $cpf = str_replace(["-",".","/"],"",$cpf);
                    if($this->Validate->validateCPF($cpf)){$this->arrayPost+=["CPF"=>$cpf];}
                }
                if(isset($_POST['dtnascimento'])){
                    $dtNascimento=filter_input(INPUT_POST,'dtnascimento', FILTER_SANITIZE_SPECIAL_CHARS);
                    if($this->Validate->validateData($dtNascimento)){$this->arrayPost+=["dtNascimento"=>$dtNascimento];}
                }
                
            }
            
            if(isset($_POST['email'])){
                $email=filter_input(INPUT_POST,'email', FILTER_SANITIZE_SPECIAL_CHARS);
                if($this->Validate->validateEmail($email)){$this->arrayPost+=["Email"=>$email];}
            }
            if(isset($_POST['senha'])){
                $senha=filter_input(INPUT_POST,'senha', FILTER_SANITIZE_SPECIAL_CHARS);
                $senha=$this->objPass->passHash($senha,$const);
                $this->arrayPost+=["Senha"=>$senha];
            }
            if(isset($_POST['tel'])){
                $tel=filter_input(INPUT_POST,'tel', FILTER_SANITIZE_SPECIAL_CHARS);
                //if($this->Validate->validateTelefone($tel)){$this->arrayPost+=["Telefone"=>$tel];}
                $this->arrayPost+=["Telefone"=>$tel];
            }
             
            if(isset($_POST['cep'])){
                $cep=preg_replace("/[^0-9]/", "",$_POST['cep']);
                if($this->Validate->validateCEP($cep)){$this->arrayPost+=["CEP"=>$cep];}
            }
           
            if(isset($_POST['endereco'])){
                $endereco=filter_input(INPUT_POST,'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Endereco"=>$endereco];
            }
            if(isset($_POST['numero'])){
                $numero=filter_input(INPUT_POST,'numero', FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Numero"=>$numero];
            }
            if(isset($_POST['complemento'])){
                $complemento=filter_input(INPUT_POST,'complemento', FILTER_SANITIZE_SPECIAL_CHARS);
                //array_push($arrayPost,$complemento);
            }
            if(isset($_POST['bairro'])){
                $bairro=filter_input(INPUT_POST,'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Bairro"=>$bairro];
            }
            if(isset($_POST['cidade'])){
                $cidade=filter_input(INPUT_POST,'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Cidade"=>$cidade];
            }
            if(isset($_POST['uf'])){
                $uf=filter_input(INPUT_POST,'uf', FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["UF"=>$uf];
            }
        }
            
            $this->Validate->validateFilds($this->arrayPost);
           
            if($this->arrayPost["TipoCliente"]=="PF"){
                $var=$this->Validate->validateIssetCPF($this->arrayPost["CPF"]); 
            }else if($this->arrayPost["TipoCliente"]=="PJ"){
                $var=$this->Validate->validateIssetCNPJ($this->arrayPost["CNPJ"]);
            }
            $this->Validate->validateIssetEmail($this->arrayPost["Email"],$this->arrayPost["TipoCliente"]);
            $retorno = false;
            if($this->arrayPost["TipoCliente"]=="PF"){
                $retorno = $this->Validate->validateInsertCad(array(
                "DataAtual"=>date("Y-m-d H:i:s"),
                "IP"=>$this->getUserIp(),
                "TipoCliente"=>$this->arrayPost["TipoCliente"],
                "Token"=>$token,
                "Nome"=>$nome,
                "Email"=>$email,
                "Senha"=>$senha,
                "Telefone"=>$tel,
                "CPF"=>$cpf,
                "dtNascimento"=>$dtNascimento,
                "CEP"=>$cep,
                "Endereco"=>$endereco,
                "Numero"=>$numero,
                "Complemento"=>$complemento,
                "Bairro"=>$bairro,
                "Cidade"=>$cidade,
                "UF"=>$uf
                ),"PF");
            }else if($this->arrayPost["TipoCliente"]=="PJ"){
                $retorno = $this->Validate->validateInsertCad(array(
                "DataAtual"=>date("Y-m-d H:i:s"),
                "IP"=>$this->getUserIp(),
                "TipoCliente"=>$this->arrayPost["TipoCliente"],
                "Token"=>$token,
                "NomeDaEmpresa"=>$nomeEmpresa,
                "Email"=>$email,
                "Senha"=>$senha,
                "CNPJ"=>$cnpj,
                "TipoJuridico"=>(int)$tipoJuri,
                "Telefone"=>$tel,
                "CEP"=>$cep,
                "Endereco"=>$endereco,
                "Numero"=>$numero,
                "Complemento"=>$complemento,
                "Bairro"=>$bairro,
                "Cidade"=>$cidade,
                "UF"=>$uf
                ),"PJ");
                
                
            }
            
            if(!$retorno){$this->Validate->setError("Email não enviado(Falha no cadastro)");}else{
                $corpo = "<strong>Para confirmar o seu cadastro: </strong><a href='".DIRPAGE."confirma-cadastro/confirmarCadastro/{$token}/{$email}'>Clique Aqui</a>";
                if($this->Mail->sendMail($email,"Suporte Elai",null,"Confirmação de Cadastro",$corpo)){
                    $this->Validate->setMessage("Ative a conta no email");
                }else{
                    $this->Validate->setError("Email não enviado");
                }
            }
            
            $json=array(
                'erros'=>$this->Validate->getError(),
                'sucesso'=>$this->Validate->getMessage()
            );
            
            echo(json_encode($json));
        
    }
    
}
?>