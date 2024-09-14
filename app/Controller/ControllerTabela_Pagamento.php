<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerTabela_Pagamento{
    use TraitUrlParser;
    private $Render;
    private $Session;
    private $Write;
    private $Validate;

    private $request;

    public function __construct(){
        $this->request = array();
        $this->Render=new ClassRender;
        $this->Session=new ClassSessions;
        $this->Write=new ClassWrite;
        $this->Validate=new ClassValidate;
        $this->Render->setDir("Tabelas/Pagamento");
        $this->Render->setTitle("Pagamento");
        $this->Render->setDescription("Pagina de lançamentos MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }

    public function atualizarPagamento(){

        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo nao suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{

            if(isset($_POST['Valor'])){
                $valor=filter_var($_POST['Valor'], FILTER_SANITIZE_ADD_SLASHES);
                $valor=str_replace([".",","],["","."],$valor);
                $valor=(float)$valor;
                array_push($this->request,$valor);
            }

            if(isset($_POST['Descricao'])){
                $descricao = filter_var($_POST['Descricao'],FILTER_SANITIZE_ADD_SLASHES);
                //array_push($this->request,$descricao);
                //$this->Validate->validateData($Data);
            }

            if(isset($_POST['Data'])){
                $data = filter_var($_POST['Data'],FILTER_SANITIZE_ADD_SLASHES);
                $this->Validate->validateData($data);
                array_push($this->request,$data);
            }

            if(isset($_POST['Beneficiario'])){
                $beneficiario = filter_var($_POST['Beneficiario'],FILTER_SANITIZE_ADD_SLASHES);
                //array_push($this->request,$beneficiario);
            }

            if(isset($_POST['FormaDePagamento'])){
                $formaDePagamento = filter_var($_POST['FormaDePagamento'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$formaDePagamento);
            }

            if(isset($_POST['Nota'])){
                $nota = filter_var($_POST['Nota'],FILTER_SANITIZE_NUMBER_INT);
                //array_push($this->request,$nota);
            }

            if(isset($_POST['PJUpdate'])){
                $pjUpdate = filter_var($_POST['PJUpdate'],FILTER_SANITIZE_NUMBER_INT);
                array_push($this->request,$pjUpdate);
            }
            
            if(isset($_POST['SubGrupo'])){
                $subGrupo = filter_var($_POST['SubGrupo'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$subGrupo);
            }
            
            if(isset($_POST['IdPagamento'])){
                $idPagamento = filter_var($_POST['IdPagamento'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$idPagamento);
            }

            if(isset($_FILES['Comprovante'])){
                $Comprovante = $_FILES['Comprovante'];
                $this->Validate->validateArquivo(
                    $Comprovante,
                    [
                        'jpeg',
                        'jpg',
                        'pdf',
                        'png'
                    ],
                    8388608
                );
            }

            
            $this->Validate->validateFilds($this->request);

            $return = $this->Validate->validateUpdatePagamento([
                "Valor"=>(float)$valor,
                "Descricao"=>(string)$descricao,
                "Data"=>(string)$data,
                "Beneficiario"=>(string)$beneficiario,
                "Conta"=>(string)$formaDePagamento,
                "Nota"=>(int)$nota,
                "PJ"=>(string)$pjUpdate,
                "Historico"=>(string)$subGrupo,
                "IdPagamento"=>(string)$idPagamento,
                "Comprovante"=>$Comprovante
            ]);

            exit(json_encode([
                "sucesso"=>$this->Validate->getMessage(),
                "erro"=>$this->Validate->getError()
            ]));

        }
    }
    
    public function tipocliente(){
        $json=array('TipoCliente'=>$_SESSION['TipoCliente']);
        echo(json_encode($json));
    }
    
    public function associadosPF(){
        $json=array(
            "erros"=>array(),
            "pj"=>array()
        );
        if($_SESSION['TipoCliente']=="PF"){ 
            array_push($json['pj'],$this->Validate->validateGetAssociacao($_SESSION['ID']));
            echo(json_encode($json));
        }else{
            array_push($json['erros'],"Não é PF");
            echo(json_encode($json));
        }
    }
    
    public function associadosPJ(){
        $json=array(
            'erros'=>$this->Validate->getError(),
            'conselheiros'=>$this->Validate->validateGetConselheiros($_SESSION['ID'])
        );
        echo(json_encode($json));
    }
    
    public function tabelaPF(){

        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            if($_SESSION['TipoCliente']=="PF"){ 
                if(isset($_POST['pj']) && !empty($_POST['pj'])){

                    $json=array(
                        'permissao'=>array(),
                        'tabela'=>array(),
                        'erros'=>array()
                    );

                    $post = [
                        "Id"=>$_SESSION['ID'],
                        "TipoCliente"=>$_SESSION['TipoCliente']
                    ];
                    
                    if(isset($_POST['mes'])){
                        $mes = (int)filter_var($_POST['mes'],FILTER_SANITIZE_NUMBER_INT);
                        $post += ["Mes"=>$mes];
                    }
    
                    if(isset($_POST['ano'])){
                        $ano = (int)filter_var($_POST['ano'],FILTER_SANITIZE_NUMBER_INT);
                        $post += ["Ano"=>$ano];
                    }

                    if(isset($_POST['pj'])){
                        $cnpj=filter_var($_POST['pj'], FILTER_SANITIZE_SPECIAL_CHARS);
                        $post += ["Empresa"=>$cnpj];
                    }

                    //exit(json_encode($post));

                    $this->Validate->validateFilds($post);
    
                    $this->Validate->validateCNPJ($cnpj);
                    $this->Validate->validateIssetCNPJ($cnpj,"verifivar existencia");
                    $permissao=$this->Validate->validateGetPermissao([
                        'cnpj'=>$cnpj,
                        'cpf'=>$_SESSION['ID']
                    ]);

                    $post += ["TipoPermissao"=>$permissao['Permissao']];
                    
                    //exit(json_encode([$permissao]));
                    $dados=$this->Validate->validateGetPagamento($post);
                    
                    $json += ["erros"=>$this->Validate->getError()];
                    array_push($json['permissao'],$permissao);
                    array_push($json['tabela'],$dados);
                    echo(json_encode($json));
                }
            } 
        }
        
    }
    
    public function tabelaPJ(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            if($_SESSION['TipoCliente']=="PJ"){

                $post = [
                    "Id"=>$_SESSION['ID'],
                    "TipoCliente"=>$_SESSION['TipoCliente']
                ];
                
                if(isset($_POST['mes'])){
                    $mes = filter_var($_POST['mes'],FILTER_SANITIZE_NUMBER_INT);
                    $post += ["Mes"=>$mes];
                }

                if(isset($_POST['ano'])){
                    $ano = filter_var($_POST['ano'],FILTER_SANITIZE_NUMBER_INT);
                    $post += ["Ano"=>$ano];
                }

                /*if(isset($_POST['Mes']) && isset($_POST['ano'])){
                    exit(json_encode($post));
                }*/

                $this->Validate->validateFilds($post);

                $dados=$this->Validate->validateGetPagamento($post);
                
                
                $tipoJuri=$this->Validate->validateGetTipoJuridico();
                foreach($tipoJuri as $linha){
                    $ID=(int)$linha['ID'];
                    if($ID==$_SESSION['TipoJuridico']){$Tipo=$linha['Tipo'];}
                }
                $json=array(
                    'erros'=>$this->Validate->getError(),
                    'tipoJuridico'=>array('ID'=>$_SESSION['TipoJuridico'],'Tipo'=>$Tipo),
                    'tabela'=>$dados,
                    'conselheiros'=>$this->Validate->validateGetConselheiros($_SESSION['ID'])
                );
                exit(json_encode($json));
            }
        }
        
    }

    public function dadosPJ(){
        if($_SESSION['TipoCliente']=="PJ"){
            $contas=$this->Validate->validateGetContas($_SESSION['ID']);
            if(!$contas){
                $c = false;
            }else{
                if($contas['linhas']<=0){
                    $c = false;
                }else{
                    $c = $contas['dados'];
                }
            }
            $json=array(
                'erros'=>$this->Validate->getError(),
                'grupo'=>$this->Validate->validateGetGrupoLancamento([
                    'Tomador'=>$_SESSION['ID'],
                    'Acao'=>1
                ]),
                'contas'=>$c,
                'cnpj'=>$_SESSION['ID'],
                'nome'=>$_SESSION['nomeFantasia']
            );
            exit(json_encode($json));
        }
    }

    public function getSubGrupo(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            
            if(isset($_POST['PJUpdate'])){
                $pj = preg_replace('/[^0-9]/',"",$_POST['PJUpdate']);
                array_push($this->request,$pj);
            }

            if(isset($_POST['Grupo'])){
                $idGrupo = filter_var($_POST['Grupo'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$idGrupo);
            }

            $this->Validate->validateFilds($this->request);

            //exit(json_encode($this->request));

            $res = $this->Validate->validateGetSubGrupo([
                'cnpj'=>$pj,
                'idGrupo'=>$idGrupo
            ]);

            exit(json_encode([
                'erros'=>$this->Validate->getError(),
                'dados'=>$res
            ]));
        }
    }
    
    public function negarPagamento(){
        
        if(isset($_POST['sel'])){
            $sel=filter_input_array(INPUT_POST,array(
                'sel'=>array(
                    'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                    'flags'  => FILTER_REQUIRE_ARRAY
                )
            ));
            
            $this->Validate->validateFilds(array('sel'=>$sel));
            $nAprovado=0;
            $Aprovado=0;
            foreach($sel as $key => $array){
                
                foreach($array as $key => $value){
                    $id=md5(uniqid(mt_rand(),true));
                
                    $result=$this->Validate->validateAprovaConselho(
                        [
                            "ID"=>$id,
                            "IdTabela"=>$value,
                            "cnpj"=>"",
                            "cpf"=>$_SESSION["ID"],
                            "status"=>1
                        ],
                        "Pagamento"
                    );
                    
                    if($result["nAprovado"]>0){
                        $nAprovado+=$result["nAprovado"];
                    }else if($result["Aprovado"]>0){
                        $Aprovado+=$result["Aprovado"];
                    }
                    
                }
                
            }
            
            $json=array(
                'erros'=>$this->Validate->getError(),
                'retorno'=>array(
                    'aprovados'=>$Aprovado,
                    'nAprovados'=>$nAprovado
                )
            );
            
            echo(json_encode($json));
            
        }
    }
    
    public function aprovarPagamento(){
        if(isset($_POST['sel'])){
            $sel=filter_input_array(INPUT_POST,array(
                'sel'=>array(
                    'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                    'flags'  => FILTER_REQUIRE_ARRAY
                )
            ));
            
            $this->Validate->validateFilds(array('sel'=>$sel));
            $nAprovado=0;
            $Aprovado=0;
            foreach($sel as $key => $array){
                
                foreach($array as $key => $value){
                    $id=md5(uniqid(mt_rand(),true));
                
                    $result=$this->Validate->validateAprovaConselho(
                        [
                            "ID"=>$id,
                            "IdTabela"=>$value,
                            "cnpj"=>"",
                            "cpf"=>$_SESSION["ID"],
                            "status"=>2
                        ],
                        "Pagamento"
                    );
                    
                    if($result["nAprovado"]>0){
                        $nAprovado+=$result["nAprovado"];
                    }else if($result["Aprovado"]>0){
                        $Aprovado+=$result["Aprovado"];
                    }
                    
                }
                
            }
            
            $json=array(
                'erros'=>$this->Validate->getError(),
                'retorno'=>array(
                    'aprovados'=>$Aprovado,
                    'nAprovados'=>$nAprovado
                )
            );
            
            echo(json_encode($json));
            
        }
        
    }
    
    public function excluirPagamento(){

        $this->request = array();
        
        /*if(isset($_POST['sel'])){
             $sel=filter_input_array(INPUT_POST,array(
                'sel'=>array(
                    'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                    'flags'  => FILTER_REQUIRE_ARRAY
                )
            ));
        }*/

        if(isset($_POST['id'])){
            $id=filter_var($_POST['id'],FILTER_SANITIZE_SPECIAL_CHARS);
            array_push($this->request,$id);
        }
        
        $this->Validate->validateFilds($this->request);
        $resul=$this->Validate->validateDeletePagamento([$id]);
        
        $json=array(
            'erros'=>$this->Validate->getError(),
            'retornos'=>$resul
        );
        
        echo(json_encode($json));
    }

    public function adicionarImagem(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo nao suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            if(isset($_POST['IdPagamento'])){
                $idPagamento = filter_var($_POST['IdPagamento'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$idPagamento);
            }

            $grupoComprovante = null;
            if(isset($_POST['GrupoComprovante'])){
                $grupoComprovante = filter_var($_POST['GrupoComprovante'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$grupoComprovante);
            }

            if(isset($_FILES['Comprovante'])){
                $Comprovante = $_FILES['Comprovante'];
                $this->Validate->validateArquivo(
                    $Comprovante,
                    [
                        'jpeg',
                        'jpg',
                        'pdf',
                        'png'
                    ],
                    8388608
                );
            }

            $this->Validate->validateFilds($this->request);

            $this->Validate->validateAdicionarArquivo_Pagamento([
                "Comprovante"=>$Comprovante,
                "IdPagamento"=>$idPagamento,
                "IdGrupoComprovante"=>$grupoComprovante
            ]);

            exit(json_encode([
                "erro"=>$this->Validate->getError(),
                "sucesso"=>$this->Validate->getMessage()
            ]));
        }
    }

    public function removerArquivo(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo nao suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{

            //exit(json_encode($_POST));

            if(isset($_POST['idGrupoComprovante'])){
                $idGrupoComprovante = filter_var($_POST['idGrupoComprovante'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request, $idGrupoComprovante);
            }

            if(isset($_POST['idComprovante'])){
                $idComprovante = filter_var($_POST['idComprovante'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request, $idComprovante);
            }

            if(isset($_POST['idLancamento'])){
                $idLancamento = filter_var($_POST['idLancamento'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request, $idLancamento);
            }

            $this->Validate->validateFilds($this->request);

            $this->Validate->validateRemoverArquivo([
                "idGrupoComprovante"=>$idGrupoComprovante,
                "idComprovante"=>$idComprovante,
                "idLancamento"=>$idLancamento
            ]);

            exit(json_encode([
                "erro"=>$this->Validate->getError(),
                "sucesso"=>$this->Validate->getMessage()
            ]));
        }
    }
}
?>