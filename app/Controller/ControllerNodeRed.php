<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;
//use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidateAreaNotaLancamnetoNFSE;
use Src\Classes\ClassValidateNodeRed;

use Src\Classes\ClassMail;
class ControllerNodeRed{
    use TraitUrlParser;

    private $Render;
    private $JWT;
    private $RequestJSON;
    private $Validate;
    private $ValidateAreaNotaLancamnetoNFSE;
    private $ValidateNodeRed;
    private $Mail;
    private $arrayPost = array();
    function __construct(){
        $this->Validate=new ClassValidate;
        $this->Render=new ClassRender;
        $this->JWT = new ClassJWT;
        $this->RequestJSON = new ClassRequestJSON;
        $this->ValidateAreaNotaLancamnetoNFSE = new ClassValidateAreaNotaLancamnetoNFSE;
        $this->ValidateNodeRed = new ClassValidateNodeRed;
        $this->Mail = new ClassMail;
        $url=$this->parseUrl();
        if(isset($url[1])){
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout();
        }
    }

    public function oi(){
        echo json_encode(['msg'=>'oi']);
    }

    public function certificado(){
        if($_SERVER['REQUEST_METHOD']!="POST" && isset($_FILES['certificado'])==false){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            
            if(isset($_POST['cnpj'])){
                $cnpj=filter_input(INPUT_POST,'cnpj', FILTER_SANITIZE_SPECIAL_CHARS);
                $cnpj=str_replace("/[^0-9]/","",$cnpj);
                if($this->Validate->validateCNPJ($cnpj)){$this->arrayPost+=["CNPJ"=>$cnpj];}
            }

            if(isset($_POST['nome'])){
                $nome=filter_input(INPUT_POST,'nome', FILTER_SANITIZE_ADD_SLASHES);
                //if($this->Validate->validateNome($nome)){$arrayPost+=["Nome"=>$nome];}
                $this->arrayPost+=["Nome"=>$nome];
            }

            if(isset($_POST['senhaCertificado'])){
                $senhaCertificado = filter_var($_POST['senhaCertificado'],FILTER_SANITIZE_ADD_SLASHES);
                $this->arrayPost+=['SenhaCertificado'=>$senhaCertificado];
            }

            if(isset($_FILES['certificado'])){
               if($_FILES['certificado']['error']==0){

                    $certificado = $_FILES['certificado'];
                    $arq = $this->Validate->validateArquivo(
                        $certificado,
                        ["pfx","p12"]
                    );
                    $certificadoTMP= $_FILES['certificado']['tmp_name'];
                    $certificado = base64_encode(file_get_contents($certificadoTMP));
                    $this->arrayPost+=["Certificado"=>$certificado];

                }else if($_FILES['certificado']['error']==4){}else{
                        $this->Validate->setError("Error no arquivo");
                }

            }
            
            $this->Validate->validateFilds($this->arrayPost);

            $return = $this->ValidateNodeRed->validateRegistrarCertificado($this->arrayPost,1);

            /*if(count($_POST)>0){
                $myfile = fopen(DIRREQ."app/Controller/cetificadoPost.txt", "a");
                $txt = date("d/m/Y H:i:s")." - ".json_encode($_POST,JSON_UNESCAPED_UNICODE)."\n\n";
                fwrite($myfile, $txt);
                fclose($myfile);
            }else{
                $myfile = fopen(DIRREQ."app/Controller/certificadoVazio.txt", "a");
                $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$_POST],JSON_UNESCAPED_UNICODE)."\n\n";
                fwrite($myfile, $txt);
                fclose($myfile);
            }*/

            exit(json_encode(["erros"=>$this->ValidateNodeRed->getError(),"sucessos"=>$this->ValidateNodeRed->getMessage()]));
        }
    }

    public function emissaoNota(){
        
        if($_SERVER['REQUEST_METHOD']!="POST"){

            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
            
        }else{

            date_default_timezone_set('America/Sao_Paulo');
            
            if(count($_POST)<=0){
                $_POST = json_decode(file_get_contents("php://input"),true);
            }

            /*var_dump($_POST);
            exit();*/
            //exit(json_encode($_POST,JSON_UNESCAPED_UNICODE));

            if(isset($_POST['cpfcnpjtomador'])){
                $cpfcnpjtomador = filter_var($_POST['cpfcnpjtomador'],FILTER_SANITIZE_NUMBER_INT);
                //$this->arrayPost += ['CpfCnpjTomador'=>$cpfcnpjtomador];
            }

            if(isset($_POST['atividades'])){
                //$codigo = explode('=',$_POST['atividades']);
                $atividade_codigo = filter_var($_POST['atividades'],FILTER_SANITIZE_NUMBER_INT);
                $this->arrayPost += ['atividade'=>$atividade_codigo];
            }

            if(isset($_POST['escolhaopj'])){
                //$p = explode('=',$_POST['escolhaopj']);
                $emissor = filter_var($_POST['escolhaopj'],FILTER_SANITIZE_NUMBER_INT);
                $this->arrayPost += ['PJ'=>$emissor];
            }

            if(isset($_POST['naturezaoperacao'])){
                //$n = explode('=',$_POST['naturezaoperacao']);
                $naturezaoperacao = preg_replace("/[^0-9]/",'',$_POST['naturezaoperacao']);
                $this->arrayPost += ['naturezaOperacao'=>$naturezaoperacao];
            }

            if(isset($_POST['datacompetencia'])){
                $d = preg_replace("/[^0-9 \/]/",'',$_POST['datacompetencia']);
                if($this->Validate->validateData($d,"d/m/Y")){
                    $datacompetencia = implode('-', array_reverse(explode('/', $d)));
                    //$datacompetencia=date_format(date_create($datacompetencia),'Y-m-d H:i:s');
                    $datacompetencia=date_format(date_create($datacompetencia),'Y-m-d 00:00:00');
                    $datacompetencia=str_replace(" ","T",$datacompetencia);
                    $this->arrayPost += ['dataCompetencia'=>$datacompetencia];
                }else{
                    $datacompetencia = false;
                }
            }

            if(isset($_POST['valorservico'])){
                $valorservico = filter_var($_POST['valorservico'],FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $this->arrayPost += ['ValorTotalDosServicos'=>$valorservico];
            }

            if(isset($_POST['descricao'])){
                $DescriminacaoDosServicos=filter_var($_POST['descricao'],FILTER_SANITIZE_ADD_SLASHES);
                $this->arrayPost+=["DescriminacaoDosServicos"=>$DescriminacaoDosServicos];
            }

            if(isset($_POST['serierps'])){
                $serierps = filter_var($_POST['serierps'],FILTER_SANITIZE_NUMBER_INT);
                $this->arrayPost += ['SerieDoRPS'=>$serierps];
            }

            if(isset($_POST['iss'])){
                $iss = filter_var($_POST['iss'],FILTER_SANITIZE_NUMBER_INT);
                $this->arrayPost += ['ISSPercentual'=>$iss];
            }

            if(isset($_POST['servico'])){
                $codigoServico = filter_var($_POST['servico'],FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $this->arrayPost += ['codServico'=>$codigoServico];
            }

            if(isset($_POST['nrps'])){
                $nrps = filter_var($_POST['nrps'],FILTER_SANITIZE_NUMBER_INT);
                $this->arrayPost += ['NdoRPS'=>$nrps];
            }

            if(isset($_POST['nometomador'])){
                $nometomador = filter_var($_POST['nometomador'],FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
                $this->arrayPost += ['nomeTomador'=>$nometomador];
            }

            if(isset($_POST['ceptomador'])){
                $cepTomador=preg_replace("/[^0-9]/","",$_POST['ceptomador']);
                $this->arrayPost += ["cepTomador"=>$cepTomador];
            }

            if(isset($_POST['localservico'])){
                $localservico=preg_replace("/[^0-9]/","",$_POST['localservico']);
                $this->arrayPost += ["localServico"=>$localservico];
            }

            if(isset($_POST['email'])){
                $email="";
                if($this->Validate->validateEmail($_POST['email'])){$email=$_POST['email'];}
                $this->arrayPost+=["Email"=>$email];
            }

            if(isset($_POST['incentivadorcultural'])){
                $incentivadorCultural = preg_replace("/[^0-9]/","",$_POST['incentivadorcultural']);
                $this->arrayPost+=['incentivadorCultural'=>$incentivadorCultural];
            }

            if(strlen($cpfcnpjtomador)<=11){
                $this->arrayPost+=['cpfTomador' => $cpfcnpjtomador];
            }else{
                $this->arrayPost+=['cnpjTomador' => $cpfcnpjtomador];
            }

            $this->Validate->validateFilds($this->arrayPost);

            $result = $this->ValidateAreaNotaLancamnetoNFSE->validateEmitirNFSENodeRed($this->arrayPost,1);
            //$result = $this->ValidateNodeRed->validateEmitirNFSENodeRed($this->arrayPost,2);

            /*$corpo = "<strong>Para confirmar o seu cadastro: </strong><a href='".DIRPAGE."confirma-cadastro/confirmarCadastro/".$this->arrayPost['token']."/".$this->arrayPost['email']."'>Clique Aqui</a>";
            if($this->Mail->sendMail($this->arrayPost['email'],"Suporte Ivici",null,"Confirmação de Cadastro",$corpo)){
                $this->Validate->setMessage("Ative a conta no email");
            }else{
                $this->Validate->setError("Email não enviado");
            }*/
            
            if(count($_POST)>0){
                $myfile = fopen(DIRREQ."app/Controller/post.txt", "w");
                //$txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$_POST,"validate"=>$this->arrayPost],JSON_UNESCAPED_UNICODE)."\n\n";
                $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$_POST,"erro"=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),"sucesso"=>$this->ValidateAreaNotaLancamnetoNFSE->getMessage()],JSON_UNESCAPED_UNICODE)."\n\n";
                fwrite($myfile, $txt);
                fclose($myfile);
            }else{
                $myfile = fopen(DIRREQ."app/Controller/vazio.txt", "w");
                $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$_POST],JSON_UNESCAPED_UNICODE)."\n\n";
                fwrite($myfile, $txt);
                fclose($myfile);
            }

            exit(json_encode(["dados"=>$_POST,"erro"=>$this->ValidateAreaNotaLancamnetoNFSE->getError(),"sucesso"=>$this->ValidateAreaNotaLancamnetoNFSE->getMessage()],JSON_UNESCAPED_UNICODE));            
        }
    }
    public function cadastro(){
        if($_SERVER['REQUEST_METHOD']!="POST"){

            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
            
        }else{

            date_default_timezone_set('America/Sao_Paulo');
            
            if(count($_POST)<=0){
                $_POST = json_decode(file_get_contents("php://input"),true);
            }

            if(isset($_POST['regime'])){
                $Regimento = (int)preg_replace("/[^0-9]/","",$_POST['regime']);
                $Regimento = filter_var($Regimento,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $this->arrayPost+=["Regimento"=>$Regimento];
            }

            if(isset($_POST['codigocrt'])){
                $CodigoCRT = (int)preg_replace("/[^0-9]/","",$_POST['codigocrt']);
                $CodigoCRT = filter_var($CodigoCRT,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $this->arrayPost+=["CodigoCRT"=>$CodigoCRT];
            }

            if(isset($_POST['inscricaoestadual'])){
                $InscricaoEstadual = (int)preg_replace("/[^0-9]/","",$_POST['inscricaoestadual']);
                $InscricaoEstadual = filter_var($InscricaoEstadual,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $this->arrayPost+=["InscricaoEstadual"=>$InscricaoEstadual];
            }

            if(isset($_POST['inscricaomunicipal'])){
                $InscricaoMunicipal = (int)preg_replace("/[^0-9]/","",$_POST['inscricaomunicipal']);
                $InscricaoMunicipal = filter_var($InscricaoMunicipal,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $this->arrayPost+=["InscricaoMunicipal"=>$InscricaoMunicipal];
            }
            
            if(isset($_POST['cnae'])){
                $cnae = (int)preg_replace("/[^0-9]/","",$_POST['cnae']);
                $cnae = filter_var($cnae,FILTER_VALIDATE_INT,FILTER_FLAG_ALLOW_OCTAL);
                $this->arrayPost+=["CNAE"=>$cnae];
            }

            if(isset($_POST['fantasia'])){
                $nomeFantazia=filter_var($_POST['fantasia'], FILTER_SANITIZE_ADD_SLASHES);
                //if($this->Validate->validateNome($nome)){$arrayPost+=["Nome"=>$nome];}
                $this->arrayPost+=["NomeFantazia"=>$nomeFantazia];
            }

            if(isset($_POST['municipio'])){
                $cidade=filter_var($_POST['municipio'], FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Cidade"=>$cidade];
            }
            
            if(isset($_POST['razaosocial'])){
                $razaoSocial=filter_var($_POST['razaosocial'], FILTER_SANITIZE_ADD_SLASHES);
                //if($this->Validate->validateNome($nome)){$arrayPost+=["Nome"=>$nome];}
                $this->arrayPost+=["RazaoSocial"=>$razaoSocial];
            }
            if(isset($_POST['cnpj'])){
                $cnpj=filter_var($_POST['cnpj'], FILTER_SANITIZE_SPECIAL_CHARS);
                $cnpj=str_replace("/[^0-9]/","",$cnpj);
                if($this->Validate->validateCNPJ($cnpj)){$this->arrayPost+=["CNPJ"=>$cnpj];}
            }
            if(isset($_POST['email'])){
                $email="";
                if($this->Validate->validateEmail($_POST['email'])){$email=$_POST['email'];}
                $this->arrayPost+=["Email"=>$email];
            }
            
            if(isset($_POST['telefone'])){
                $tel=filter_var($_POST['telefone'], FILTER_SANITIZE_ADD_SLASHES);
                //if($this->Validate->validateTelefone($tel)){$this->arrayPost+=["Telefone"=>$tel];}
                $this->arrayPost+=["Telefone"=>$tel];
            }
             
            if(isset($_POST['cep'])){
                $cep=preg_replace("/[^0-9]/", "",$_POST['cep']);
                if($this->Validate->validateCEP($cep)){$this->arrayPost+=["CEP"=>$cep];}
            }
           
            if(isset($_POST['tipoendereco'])){
                $endereco=filter_var($_POST['tipoendereco'], FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Endereco"=>$endereco];
            }
            if(isset($_POST['numero'])){
                $numero=filter_var($_POST['numero'], FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Numero"=>$numero];
            }
            if(isset($_POST['complemento'])){
                $complemento=filter_var($_POST['complemento'], FILTER_SANITIZE_SPECIAL_CHARS);
                //array_push($arrayPost,$complemento);
                $this->arrayPost+=["Complemento"=>$complemento];
            }
            if(isset($_POST['bairro'])){
                $bairro=filter_var($_POST['bairro'], FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Bairro"=>$bairro];
            }
            if(isset($_POST['logradouro'])){
                $logradouro=filter_var($_POST['logradouro'], FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["Logradouro"=>$logradouro];
            }
            if(isset($_POST['uf'])){
                $uf=filter_var($_POST['uf'], FILTER_SANITIZE_SPECIAL_CHARS);
                $this->arrayPost+=["UF"=>$uf];
            }

            /*$url="https://servicodados.ibge.gov.br/api/v1/localidades/municipios?orderBy=nome";
            $request=$this->RequestJSON->request($url,null);
            $municipios=json_decode($request);*/

            $request=json_decode($this->RequestJSON->request("https://viacep.com.br/ws/{$cep}/json/","GET"),true);
            $this->arrayPost+=["CodigoMunicipal"=>(int)$request['ibge']];


            /*for($i=0;$i<=(count($municipios)-1);$i++){
                $M1=strtolower($municipios[$i]->nome);
                $M2=strtolower($cidade);
                if($M1==$M2){
                    $CodigoMunicipal=($municipios[$i]->id);
                    $this->arrayPost+=["CodigoMunicipal"=>$CodigoMunicipal];
                }
            }*/

            //exit(json_encode("https://viacep.com.br/ws/{$cep}/json/",JSON_UNESCAPED_UNICODE));

            $this->Validate->validateFilds($this->arrayPost);
            
            $return = $this->ValidateNodeRed->validateCadastroEmpresaMigrate($this->arrayPost,1);

            $email = urlencode('aciolekaua74@gmail.com');

            if($return!=false){
                $corpo = "
                <strong>Para confirmar o seu cadastro clique no link a seguir: </strong>
                <a 
                    href='https://ivici.com.br/upload/index.html?email={$email}&cnpj={$this->arrayPost['CNPJ']}&nome={$this->arrayPost['NomeFantazia']}'
                >
                    Clique Aqui
                </a>";

                if($this->Mail->sendMail($this->arrayPost['Email'],"Suporte Elai",null,"Confirmação de Cadastro",$corpo)){
                    $this->Validate->setMessage("Ative a conta no email");
                }else{
                    $this->Validate->setError("Email não enviado");
                }

                if($this->Mail->sendMail('aciolekaua74@gmail.com',"Suporte Elai",null,"Confirmação de Cadastro",$corpo)){
                    $this->Validate->setMessage("Ative a conta no email");
                }else{
                    $this->Validate->setError("Email não enviado");
                }
        

                /*if(count($_POST)>0){
                    $myfile = fopen(DIRREQ."app/Controller/post.txt", "w");
                    $txt = date("d/m/Y H:i:s")." - ".json_encode(["erro"=>$this->Validate->getError(),"sucesso"=>$this->Validate->getMessage()],JSON_UNESCAPED_UNICODE)."\n\n";
                    fwrite($myfile, $txt);
                    fclose($myfile);
                }else{
                    $myfile = fopen(DIRREQ."app/Controller/vazio.txt", "w");
                    $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$_POST],JSON_UNESCAPED_UNICODE)."\n\n";
                    fwrite($myfile, $txt);
                    fclose($myfile);
                }*/
            }

            exit(json_encode(["erro"=>$this->Validate->getError(),"sucesso"=>$this->Validate->getMessage(),"chave"=>$return],JSON_UNESCAPED_UNICODE));
        }
    }

    public function assinatura(){
        if($_SERVER['REQUEST_METHOD']!="POST"){

            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
            
        }else{
            
            if(count($_POST)>0 && count($_FILES)>0){
                $myfile = fopen(DIRREQ."app/Controller/post-arquivo.txt", "w");
                $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$_POST,"requisição"=>$_REQUEST,],JSON_UNESCAPED_UNICODE)."\n\n";
                fwrite($myfile, $txt);
                fclose($myfile);
            }else{
                $myfile = fopen(DIRREQ."app/Controller/vazio-arquivo.txt", "w");
                $txt = date("d/m/Y H:i:s")." - ".json_encode(["dados"=>$_POST,"requisição"=>$_REQUEST,],JSON_UNESCAPED_UNICODE)."\n\n";
                fwrite($myfile, $txt);
                fclose($myfile);
            }
            

            exit(json_encode(
                [
                    "dados"=>$_POST,
                    "arquivo"=>$_FILES,
                    "requisição"=>$_REQUEST,
                ],JSON_UNESCAPED_UNICODE)); 
        }
    }

}
?>