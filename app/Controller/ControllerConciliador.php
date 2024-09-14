<?php 
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidateConciliador;
class ControllerConciliador {
     use TraitUrlParser;
     private $Render;
     private $Session;
     private $ValidateConciliador;
     private $Request;
     function __construct(){
        $this->Request = array();
        $this->Render=new ClassRender;
        $this->ValidateConciliador = new ClassValidateConciliador;
        $this->Session=new ClassSessions;
        $this->Render->setDir("Conciliador");
        $this->Render->setTitle("Conciliador Bancario");
        $this->Render->setDescription("Pagina de Conciliador MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
            if(isset($url[1])){
                $this->Render->addSession();
                header("Content-Type:application/json");
            }else{
                $this->Render->renderLayout("Home");
            }
        }
        
        
        function enviarArquivos(){
            
            if(isset($_FILES['arquivo'])){
                $arquivo = $_FILES['arquivo'];
                $arrayArquivo = $this->Request+=["arquivo"=>$arquivo];
            }
            
            $array = $this->ValidateConciliador->validateFilds($arrayArquivo);
            // exit(json_encode($array));
            
            $arquivoCSV = $this->ValidateConciliador->insertArquivos($arquivo);
            //exit(json_encode($arquivoCSV));
            
            //exit(json_encode("OI2"));
            
            exit(json_encode(
                array(
                    "erros"=>$this->ValidateConciliador->getError(),
                    "retornoArquivo"=>$arquivoCSV
                )
            ));
        }
        
        
        function visualizandoTabela(){
            $tabela = $this->ValidateConciliador->desenharTabela($_REQUEST);
            
            exit(json_encode(array(
                    "erros"=>$this->ValidateConciliador->getError(),
                    "draw" => intval($tabela['draw']),//para cada requisição é enviada um número como parâmentro
                    "recordsTotal" => intval($row_qnt_usuarios['qnt_usuarios']),//Quantidade de registros que há no banco de dados
                    "recordsFiltered" => intval($row_qnt_usuarios['qnt_usuarios']),//Total de registros qunado houver pesquisa
                    "data" => $todos_dados //Array de dados com os registros retornados   da tabela dados_teste
                )
            ));
        }
        
    }
?>