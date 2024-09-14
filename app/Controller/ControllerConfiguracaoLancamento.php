<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidatePerfil;
class ControllerConfiguracaoLancamento{
    use TraitUrlParser;
    private $Validate;
    private $Render;
    private $ValidatePerfil;
    private $arrayRequest = array();
    function __construct(){
        $this->Render=new ClassRender;
        $this->Validate=new ClassValidate;
        $this->ValidatePerfil = new ClassValidatePerfil;
        $this->Render->setDir("ConfiguracaoLancamento");
        $this->Render->setTitle("Configuração");
        $this->Render->setDescription("Pagina Home MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
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

    public function planoDeContas(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo nao suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            http_response_code(200);
            //exit(json_encode($_FILES));
            $handle = fopen($_FILES['layoutCSV']['tmp_name'],'r');
           
            $header = fgetcsv($handle, 1000, ",");
            
            $tabela=array();
            while ($row = fgetcsv($handle, 1000, ",")) {
                array_push($tabela,array_combine($header, $row));
            }

            //exit(json_encode($tabela));

            fclose($handle);
            $codGrupo=0;
            foreach($tabela as $key => $array){
                $result = $this->ValidatePerfil->issetGrupo([
                    'cnpj'=>(string)$array['CNPJ'],
                    'codConta'=>(int)$array['COD GRUPO']
                ]);
                if($result['linhas']<=0){
                    $codGrupo=(int)$array['COD GRUPO'];
                    $result = $this->ValidatePerfil->insertGrupo([
                        'id'=>md5(mt_rand(10000,99999)),
                        'tipoAcao'=>(int)$array['TIPO DE ACAO'],
                        'nome'=>(string)$array['DESC GRUPO'],
                        'codConta'=>(int)$array['COD GRUPO'],
                        'cnpj'=>(string)$array['CNPJ']
                    ]);
                }
                
            }

            foreach($tabela as $key => $array){
                $result = $this->ValidatePerfil->issetGrupo([
                    'cnpj'=>(string)$array['CNPJ'],
                    'codConta'=>(int)$array['COD GRUPO']
                ]);
                
                if($result['linhas']>0){
                    $r = $this->ValidatePerfil->validateIssetContasContabil([
                        "numeroconta"=>(int)$array['COD SUB GRUPO'],
                        "cnpj"=>(string)$array['CNPJ']
                    ]);
                    
                    if(!$r){
                        $this->ValidatePerfil->validateInsertContasContabil([
                            "id"=>md5(mt_rand(10000,99999)),
                            "numeroconta"=>(int)$array['COD SUB GRUPO'],
                            "nome"=>(string)$array['DESC SUB GRUPO'],
                            "descricao"=>(string)"",
                            "palavrachave"=>(string)"",
                            "grupoconta"=>(string)$result["dados"][0]['Id'],
                            "cnpj"=>(string)$array['CNPJ']
                        ]);
                    }
                }
            }

            echo json_encode([$this->ValidatePerfil->getMessage(),$this->ValidatePerfil->getError()],JSON_UNESCAPED_UNICODE);
            
            return false;
        }
    }

    public function registroGrupo():void{
        if($_SERVER['REQUEST_METHOD']!="POST"){

           

        }else{
            //exit(json_encode($_POST));
            if(isset($_POST['nomeGrupo'])){
                $nomeGrupo = filter_input(INPUT_POST,'nomeGrupo',FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$nomeGrupo);
            }

            if(isset($_POST['acao'])){
                $acao = filter_input(INPUT_POST,'acao',FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$acao);
            }

            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if(isset($_POST['PJ'])){$cnpj = filter_var($_POST['PJ'],FILTER_SANITIZE_NUMBER_INT);}
            }
            array_push($this->arrayRequest,$cnpj);

            $this->Validate->validateFilds($this->arrayRequest);
            //exit(json_encode($this->arrayRequest));
            $this->ValidatePerfil->insertGrupo([
                'id'=>uniqid(mt_rand(100000,999999),true),
                'nome'=>$nomeGrupo,
                'tipoAcao'=>(int)$acao,
                'codConta'=>(int)mt_rand(1,999),
                'cnpj'=>$cnpj
            ]);

            exit(json_encode([
                "erros"=>$this->ValidatePerfil->getError(),
                "sucessos"=>$this->ValidatePerfil->getMessage()
            ]));
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

    public function updateGrupoContabil(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo(json_encode("Métoodo não permitido"));
            return false;
        }else{
            http_response_code(200);
            if(isset($_POST['Acao'])){
                $acao=filter_var($_POST['Acao'],FILTER_SANITIZE_NUMBER_INT);
                array_push($this->arrayRequest,$acao);
            }
            if(isset($_POST['IdGrupo'])){
                $idGrupo=filter_var($_POST['IdGrupo'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$idGrupo);
            }
            if(isset($_POST['Nome'])){
                $nome=filter_var($_POST['Nome'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->arrayRequest,$nome);
            }

            if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
            }else if($_SESSION['TipoCliente']=='PF'){
                if(isset($_POST['PJ'])){$cnpj = filter_input(INPUT_POST,'PJ',FILTER_SANITIZE_NUMBER_INT);}
            }
            array_push($this->arrayRequest,$cnpj);

            //exit(json_encode($_POST));

            $this->Validate->validateFilds($this->arrayRequest);

            $this->ValidatePerfil->validateUpdateGrupo([
                "tipoAcao"=>$acao,
                "descricao"=>$nome,
                "id"=>$idGrupo,
                "cnpj"=>$cnpj
            ]);

            echo(json_encode(["erros"=>$this->ValidatePerfil->getError(),"sucesso"=>$this->ValidatePerfil->getMessage()]));
            
            return true;
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