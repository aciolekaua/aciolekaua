<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassValidate;
use Src\Classes\ClassWrite;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
class ControllerHome{
    use TraitUrlParser;
    private $Validate;
    private $Render;
    private $Session;
    function __construct(){
        $this->Render=new ClassRender;
        $this->Validate=new ClassValidate;
        $this->Session=new ClassSessions;
        $this->Render->setDir("Home");
        $this->Render->setTitle("Home");
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
    
    public function dadosSideBar(){
        if(isset($_SESSION['nome'])){
            $nome = $_SESSION['nome'];
        }else if(isset($_SESSION['nomeFantasia'])){
            $nome = $_SESSION['nomeFantasia'];
        }
        exit(json_encode([
            "nome"=>$nome,
            "id"=>$_SESSION['ID']
        ]));
    } 
    
    public function dados(){
        if($_SESSION['TipoCliente']=='PF'){
            
            exit(json_encode([
                 "erros"=>$this->Validate->getError(),
                 "PJs"=>$this->Validate->validateGetAssociacao($_SESSION['ID']),
                 "TipoCliente"=>$_SESSION['TipoCliente']
            ]));
            
        }else if($_SESSION['TipoCliente']=='PJ'){
            $cnpj=$_SESSION['ID'];
            
            $despensasMensais = $this->Validate->validateGetDespesasMensal([
               'ID'=>$cnpj,
               'data'=>date('Y-m-d H:i:s')
            ]);
            
            $receitasMensais = $this->Validate->validateGetReceitasMensal([
                'ID'=>$cnpj,
                'data'=>date('Y-m-d H:i:s')
            ]);
            
            $saldo = $this->Validate->validateGetValorSaldo([
                'ID'=>$cnpj
            ]);
            
            $receitaAnual = $this->Validate->validateReceitaAnual([
                'TipoCliente'=>$_SESSION['TipoCliente'],
                'ID'=>$cnpj,
                'DataAtual'=>date('Y-m-d')
            ]);
            
            $despesaAnual = $this->Validate->validateDespesaAnual([
                'TipoCliente'=>$_SESSION['TipoCliente'],
                'ID'=>$cnpj,
                'DataAtual'=>date('Y-m-d')
            ]);
            
            $json = array(
                'erros'=>$this->Validate->getError(),
                'despensasMensais'=>$despensasMensais,
                'receitasMensais'=>$receitasMensais,
                'despesaAnual'=>$despesaAnual,
                'receitaAnual'=>$receitaAnual,
                'saldo'=>$saldo,
                'TipoCliente'=>$_SESSION['TipoCliente']
            );
            
            echo(json_encode($json));
        }
    } 
    
    public function buscarDadosPJ(){
        if($_SERVER['REQUEST_METHOD']!="POST"){
            exit(json_encode("Envie uma requisição POST",JSON_UNESCAPED_UNICODE));
        }else{
            if(isset($_POST['PJ'])){
                $PJ=preg_replace("/[^0-9]/","",$_POST['PJ']);
                $this->Validate->validateCNPJ($PJ);
                $this->Validate->validateIssetCNPJ($PJ,"Validar");
            }
            
            $this->Validate->validateFilds([$PJ]);
            
            $despensasMensais = $this->Validate->validateGetDespesasMensal([
              'ID'=>$PJ,
              'data'=>date('Y-m-d H:i:s')
            ]);
            
            $receitasMensais = $this->Validate->validateGetReceitasMensal([
                'ID'=>$PJ,
                'data'=>date('Y-m-d H:i:s')
            ]);
            
            $saldo = $this->Validate->validateGetValorSaldo([
                'ID'=>$PJ
            ]);
            
            $receitaAnual = $this->Validate->validateReceitaAnual([
                'TipoCliente'=>$_SESSION['TipoCliente'],
                'ID'=>$PJ,
                'DataAtual'=>date('Y-m-d')
            ]);
            
            $despesaAnual = $this->Validate->validateDespesaAnual([
                'TipoCliente'=>$_SESSION['TipoCliente'],
                'ID'=>$PJ,
                'DataAtual'=>date('Y-m-d')
            ]);
            
            
            $json = array(
                'erros'=>$this->Validate->getError(),
                'despensasMensais'=>$despensasMensais,
                'receitasMensais'=>$receitasMensais,
                'despesaAnual'=>$despesaAnual,
                'receitaAnual'=>$receitaAnual,
                'saldo'=>$saldo
            );
            
            echo(json_encode($json));
        }
    } 
    
}
?>