<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidatePerfil;
class ControllerPerfil{
    use TraitUrlParser;
    private $Render;
    private $Validate;
    private $ValidatePerfil;
    private $arrayRequest = array();
    function __construct(){

        $this->Render = new ClassRender;
        $this->Validate = new ClassValidate;
        $this->ValidatePerfil = new ClassValidatePerfil;
        $this->Render->setDir("Perfil");
        $this->Render->setTitle("Perfil");
        $this->Render->setDescription("Pagina de perfil MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }

    }
    
    public function dados(){

        $return = $this->ValidatePerfil->validateGetDados([
            "Email"=>$_SESSION["email"],
            "TipoCliente"=>$_SESSION['TipoCliente']
        ]);

        //exit(json_encode($return));
        $json = [
            "Email"=>$return["Email"],
            "TipoCliente"=>$_SESSION['TipoCliente'],
            "Telefone"=>$return['Telefone'],
            "CEP"=>$return['CEP'],
            "Endereco"=>$return['Endereco'],
            "Numero"=>$return['Numero'],
            "Complemento"=>$return['Complemento'],
            "Bairro"=>$return['Bairro'],
            "Cidade"=>$return['Cidade'],
            "UF"=>$return['UF']
        ];

        if($_SESSION['TipoCliente']=='PF'){
            $json += ["Nome"=>$return["Nome"]];
            $json += ["ID"=>$return["CPF"]];
        }else if($_SESSION['TipoCliente']=='PJ'){
            $json+=["TipoJuridico"=>$return['TipoJuridico']];
            $json+=["NomeFantasia"=>$return['NomeFantasia']];
            $json+=["RazaoSocial"=>$return['RazaoSocial']];
            $json += ["ID"=>$return["CNPJ"]];
        }

        exit(json_encode($json));
        
    }

    public function dadosGrupo(){

        if($_SESSION['TipoCliente']=='PJ'){
            
            $dados = $this->ValidatePerfil->validateGetGrupo([
                "Tomador"=>$_SESSION['ID']
            ]);

            exit(json_encode([
                'erros'=>$this->ValidatePerfil->getError(),
                'dados'=>$dados
            ]));

        }else if($_SESSION['TipoCliente']=='PF'){
            if($_SERVER['REQUEST_METHOD']=="POST"){

            }
        }
        
    }
    
    public function atualizar():void{
        
        if(isset($_POST['nome']) && empty($_POST['nome'])==false){
            $nome=filter_input(INPUT_POST,'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "nome"=>$nome,
                "ID"=>$_SESSION['ID']
            ]);
        }
        //exit(json_encode($_POST));
        if(isset($_POST['email']) && empty($_POST['email'])==false){
            $email=filter_input(INPUT_POST,'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Validate->validateEmail($email);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "email"=>$email,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['telefone']) && empty($_POST['telefone'])==false){
            $telefone=filter_input(INPUT_POST,'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "telefone"=>$telefone,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['dtNascimento']) && empty($_POST['dtNascimento'])==false){
            
            $dtNascimento=filter_input(INPUT_POST,'dtNascimento', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Validate->validateData($dtNascimento);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "nascimento"=>$dtNascimento,
                "ID"=>$_SESSION['ID']
            ]);

        }
        if(isset($_POST['cep']) && empty($_POST['cep'])==false){
            $cep=filter_input(INPUT_POST,'cep', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Validate->validateCEP($cep);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "cep"=>$cep,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['endereco']) && empty($_POST['endereco'])==false){
            $endereco=filter_input(INPUT_POST,'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "endereco"=>$endereco,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['numero']) && empty($_POST['numero'])==false){
            $numero=filter_input(INPUT_POST,'numero', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "numero"=>$numero,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['complemento']) && empty($_POST['complemento'])==false){
            $complemento=filter_input(INPUT_POST,'complemento', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "complemento"=>$complemento,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['bairro']) && empty($_POST['bairro'])==false){
            $bairro=filter_input(INPUT_POST,'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "bairro"=>$bairro,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['cidade']) && empty($_POST['cidade'])==false){
            $cidade=filter_input(INPUT_POST,'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "cidade"=>$cidade,
                "ID"=>$_SESSION['ID']
            ]);
        }
        if(isset($_POST['uf']) && empty($_POST['uf'])==false){
            $uf=filter_input(INPUT_POST,'uf', FILTER_SANITIZE_SPECIAL_CHARS);
            $this->ValidatePerfil->validateUpdateDados([
                "tabela"=>$_SESSION['TipoCliente'],
                "TipoCliente"=>$_SESSION['TipoCliente'],
                "uf"=>$uf,
                "ID"=>$_SESSION['ID']
            ]);
        }
        
        // if(count($this->Validate->getError())>0){
        //     $this->Write->Erros($this->Validate->getError(),'mensage','alert alert-danger');
        // }else if(count($this->Validate->getMessage())>0){
        //     $this->Write->Erros($this->Validate->getMessage(),'mensage','alert alert-success');
        // }
    }

    public function registroGrupo():void{
        if($_SERVER['REQUEST_METHOD']=="POST"){

            if($_POST['nomeGrupo']){
                $nomeGrupo = filter_input(INPUT_POST,'nomeGrupo',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$nomeGrupo);
            }

            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if($_POST['PJ']){$cnpj = filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_NUMBER_INT);}
            }
            array_push($this->arrayRequest,$cnpj);

            $this->Validate->validateFilds($this->arrayRequest);
            //exit(json_encode($this->arrayRequest));
            $this->ValidatePerfil->insertGrupo([
                'id'=>uniqid(mt_rand(100000,999999),true),
                'nome'=>$nomeGrupo,
                'cnpj'=>$cnpj
            ]);

            exit(json_encode([
                "erros"=>$this->ValidatePerfil->getError(),
                "sucessos"=>$this->ValidatePerfil->getMessage()
            ]));

        }else{
            
        }
    }

    public function deleteGrupo(string $id):void{
        if($_SERVER['REQUEST_METHOD']=="POST"){
            //exit(json_encode($id));

            if($_SESSION['TipoCliente']=="PJ"){
                $this->ValidatePerfil->validateDeleteGrupo([
                    "Id"=>$id,
                    "Tomador"=>$_SESSION['ID']
                ]);
            }else if($_SESSION['TipoCliente']=="PF"){

            }

            exit(json_encode([
                "erros"=>$this->ValidatePerfil->getError(),
                "sucessos"=>$this->ValidatePerfil->getMessage()
            ]));
            
        }else{
            exit(json_encode("Envie uma requisição POST"));
        }
    }
    
    public function registroContasContabil():void{

        if($_SERVER['REQUEST_METHOD']=="POST"){

            if($_POST['CodigoContabil']){
                $contaContabil = filter_input(INPUT_POST,'CodigoContabil',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$contaContabil);
            }

            if($_POST['GrupoContas']){
                $GrupoContas= filter_input(INPUT_POST,'GrupoContas',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$GrupoContas);
            }
            
            if($_POST['NomeContabil']){
                $nomeConta = filter_input(INPUT_POST,'NomeContabil',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$nomeConta);
            }
            
            if($_POST['DescricaoConta']){
                $descricaoConta = filter_input(INPUT_POST,'DescricaoConta',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$descricaoConta);
            }
            
            if($_POST['PalavraChave']){
                $palavraChave = filter_input(INPUT_POST,'PalavraChave',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$palavraChave);
            }

            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if($_POST['PJ']){$cnpj = filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_NUMBER_INT);}
            }
            array_push($this->arrayRequest,$cnpj);
            
            $this->Validate->validateFilds($this->arrayRequest);

            $this->ValidatePerfil->validateInsertContasContabil([
                "id"=>md5(mt_rand(10000,99999)),
                "numeroconta"=>(int)$contaContabil,
                "nome"=>(string)$nomeConta,
                "descricao"=>(string)$descricaoConta,
                "palavrachave"=>(string)$palavraChave,
                "grupoconta"=>(string)$GrupoContas,
                "cnpj"=>(string)$cnpj
                
            ]);
            
            exit(json_encode([
                "erros"=>$this->ValidatePerfil->getError(),
                "sucessos"=>$this->ValidatePerfil->getMessage()
            ]));
        }
    }

    public function getContaContabil():void{
        
        if($_SESSION['TipoCliente']=='PJ'){
            $cnpj = $_SESSION['ID'];
        }else if($_SESSION['TipoCliente']=='PF'){

        }
        
        $return = $this->ValidatePerfil->validateGetContasContabil($cnpj);

        exit(json_encode(
            [
                'erros'=>$this->ValidatePerfil->getError(),
                'dados'=>$return
            ],
            JSON_UNESCAPED_UNICODE
        ));
    }

    public function updateContaContabil():void{
        if($_SERVER['REQUEST_METHOD']=="POST"){

            if(isset($_POST['IdConta'])){
                $IdConta = filter_input(INPUT_POST,'IdConta',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$IdConta);
            }

            if(isset($_POST['CodigoContabil'])){
                $contaContabil = filter_input(INPUT_POST,'CodigoContabil',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$contaContabil);
            }

            if(isset($_POST['GrupoContas'])){
                $GrupoContas = filter_input(INPUT_POST,'GrupoContas',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$GrupoContas);
            }
            
            if(isset($_POST['NomeContabil'])){
                $nomeConta = filter_input(INPUT_POST,'NomeContabil',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$nomeConta);
            }
            
            if(isset($_POST['DescricaoConta'])){
                $descricaoConta = filter_input(INPUT_POST,'DescricaoConta',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$descricaoConta);
            }
            
            if(isset($_POST['PalavraChave'])){
                $palavraChave = filter_input(INPUT_POST,'PalavraChave',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$palavraChave);
            }

            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if(isset($_POST['PJ'])){$cnpj = filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_NUMBER_INT);}
            }
            array_push($this->arrayRequest,$cnpj);
            
            $this->Validate->validateFilds($this->arrayRequest);

            $this->ValidatePerfil->validateUpdateContasContabil([
                'IdConta'=>$IdConta,
                'NumeroConta'=>(int)$contaContabil,
                'NomeConta'=>$nomeConta,
                'GrupoContas'=>$GrupoContas,
                'Descricao'=>$descricaoConta,
                'PalavraChave'=>$palavraChave,
                'Cnpj'=>$cnpj
            ]);

            exit(json_encode(
                [
                    'erros'=>$this->ValidatePerfil->getError(),
                    'sucessos'=>$this->ValidatePerfil->getMessage()
                ],
                JSON_UNESCAPED_UNICODE
            ));

        }else{
            exit(json_encode('Envie uma requisição POST',JSON_UNESCAPED_UNICODE));
        }
    }

    public function deleteContaContabil(string $id):void{

        //exit(json_encode($id));

        $this->ValidatePerfil->validateDeleteContasContabil($id);

        exit(json_encode([
            'erros'=>$this->ValidatePerfil->getError(),
            'sucessos'=>$this->ValidatePerfil->getMessage()
        ]));
        
    }

}
?>