<?php
namespace App\Controller;
use Src\Classes\ClassValidate;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Classes\ClassWrite;
use Src\Traits\TraitUrlParser;
class ControllerTabela_Recebimento{
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
        $this->Session->verifyInsideSession();
        $this->Write=new ClassWrite;
        $this->Validate=new ClassValidate;
        $this->Render->setDir("Tabelas/Recebimento");
        $this->Render->setTitle("Recebimento");
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
                    'Acao'=>2
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
            //exit(json_encode($_POST));
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
    
    public function tipocliente(){
        $json=array(
            'TipoCliente'=>$_SESSION['TipoCliente']
        );
        echo(json_encode($json));
    }
    
    public function associadosPJ(){
        $json=array(
            'erros'=>$this->Validate->getError(),
            'conselheiros'=>$this->Validate->validateGetConselheiros($_SESSION['ID'])
        );
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
    
    public function tabelaPF(){
        if($_SESSION['TipoCliente']=="PF"){ 
            if(isset($_POST['pj']) && !empty($_POST['pj'])){
                $json=array(
                    'permissao'=>array(),
                    'tabela'=>array(),
                    'erros'=>array()
                );
                $Cnpj=(string)filter_input(INPUT_POST,'pj', FILTER_SANITIZE_SPECIAL_CHARS);
                $this->Validate->validateCNPJ($Cnpj);
                $this->Validate->validateIssetCNPJ($Cnpj,"verifivar existencia");
                $permissao=$this->Validate->validateGetPermissao([
                    'cnpj'=>$Cnpj,
                    'cpf'=>$_SESSION['ID']
                ]);
                
                //echo(json_encode([$permissao]));
                $dados=$this->Validate->validateGetRecebimento($_SESSION['ID'],$_SESSION['TipoCliente'],$permissao['Permissao'],$Cnpj);
                
                array_push($json['erros'],$this->Validate->getError());
                array_push($json['permissao'],$permissao);
                array_push($json['tabela'],$dados);
                echo(json_encode($json));
            }
        } 
    }
    
    public function tabelaPJ(){
        if($_SESSION['TipoCliente']=="PJ"){

            $dados=$this->Validate->validateGetRecebimento($_SESSION['ID'],$_SESSION['TipoCliente']);
            
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

            echo(json_encode($json));

        }
    }
    
    public function aprovarRecebimento(){
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
                
                    $result=$this->Validate->validateAprovaConselho([
                        "ID"=>$id,
                        "IdTabela"=>$value,
                        "cnpj"=>"",
                        "cpf"=>$_SESSION["ID"],
                        "status"=>2
                    ],
                    "Recebimento");
                    
                    if($result["nAprovado"]>0){
                        $nAprovado+=$result["nAprovado"];
                    }else if($result["Aprovado"]>0){
                        $Aprovado+=$result["Aprovado"];
                    }
                    
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
    
    public function negarRecebimento(){
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
                
                    $result=$this->Validate->validateAprovaConselho([
                        "ID"=>$id,
                        "IdTabela"=>$value,
                        "cnpj"=>"",
                        "cpf"=>$_SESSION["ID"],
                        "status"=>1
                    ],
                    "Recebimento");
                    
                    if($result["nAprovado"]>0){
                        $nAprovado+=$result["nAprovado"];
                    }else if($result["Aprovado"]>0){
                        $Aprovado+=$result["Aprovado"];
                    }
                    
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
    
    public function excluirRecebimento(){
       
        //exit(json_encode($_POST));
        
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
        $resul=$this->Validate->validateDeleteRecebimento([$id]);
        
        $json=array(
            'erros'=>$this->Validate->getError(),
            'retornos'=>$resul
        );
        
        echo(json_encode($json));   
        
    }

    public function atualizarRecebimento(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo nao suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            //exit(json_encode($_POST));
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

            if(isset($_POST['Ofertante'])){
                $ofertante= filter_var($_POST['Ofertante'],FILTER_SANITIZE_ADD_SLASHES);
                //array_push($this->request,$beneficiario);
            }

            if(isset($_POST['FormaDeRecebimento'])){
                $formaDePagamento = filter_var($_POST['FormaDeRecebimento'],FILTER_SANITIZE_ADD_SLASHES);
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
            
            if(isset($_POST['IdRecebimento'])){
                $idRecebimento = filter_var($_POST['IdRecebimento'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$idRecebimento);
            }

            $this->Validate->validateFilds($this->request);

            $return = $this->Validate->validateUpdateRecebimento([
                "Valor"=>(float)$valor,
                "Descricao"=>(string)$descricao,
                "Data"=>(string)$data,
                "Ofertante"=>(string)$Ofertante,
                "Conta"=>(string)$formaDePagamento,
                "PJ"=>(string)$pjUpdate,
                "Historico"=>(string)$subGrupo,
                "IdRecebimento"=>(string)$idRecebimento
            ]);

            exit(json_encode([
                "sucesso"=>$this->Validate->getMessage(),
                "erro"=>$this->Validate->getError()
            ]));

        }
    }

    public function adicionarImagem(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            http_response_code(405);
            echo json_encode(['erro'=>'Metodo nao suportado'],JSON_UNESCAPED_UNICODE);
            return false;
        }else{
            if(isset($_POST['IdRecebimento'])){
                $idRecebimento = filter_var($_POST['IdRecebimento'],FILTER_SANITIZE_ADD_SLASHES);
                array_push($this->request,$idRecebimento);
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

            $this->Validate->validateAdicionarArquivo_Recebimento([
                "Comprovante"=>$Comprovante,
                "IdRecebimento"=>$idRecebimento,
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