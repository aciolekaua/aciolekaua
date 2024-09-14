<?php 
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidate;

use  Src\Classes\ClassValidateAgenda;

class ControllerAgenda{
    
    use TraitUrlParser;
    private $Render;
    private $Session;
    private $ValidateAgenda;
    private $Validate;
    private $RequestArray = [];
    
    function __construct(){
        $this->Render = new ClassRender;
        $this->Session = new ClassSessions;
        $this->ValidateAgenda = new ClassValidateAgenda;
        $this->Validate = new ClassValidate;
        $this->Render->setDir("Agenda");
        $this->Render->setTitle("Agenda");
        $this->Render->setDescription("Pagina de Agenda MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
        if(isset($url[1])){
            $this->Render->addSession();
            header("Content-Type:application/json");
        }else{
            $this->Render->renderLayout("Home");
        }
    }
    
    public function insertEventosAgenda(){
        //exit(json_encode($_POST));
        if($_SERVER['REQUEST_METHOD']=="POST"){
            
            if(isset($_POST['titulo'])){
                $titulo = filter_input(INPUT_POST,'titulo',FILTER_SANITIZE_ADD_SLASHES);
                $this->RequestArray += ['titulo'=>$titulo];
            }
            if(isset($_POST['inicio'])){
                $inicio = filter_input(INPUT_POST,'inicio',FILTER_SANITIZE_ADD_SLASHES);
                $this->RequestArray += ['inicio'=>$inicio];
            }
            if(isset($_POST['fim'])){
                $fim = filter_input(INPUT_POST,'fim',FILTER_SANITIZE_ADD_SLASHES);
                $this->RequestArray += ['fim'=>$fim];
            }
            if(isset($_POST['data'])){
                $data = filter_input(INPUT_POST,'data',FILTER_SANITIZE_ADD_SLASHES);
                $this->RequestArray += ['data'=>$data];
            }
            $cnpj='';
            if(isset($_POST['cnpj'])){
                $cnpj = filter_input(INPUT_POST,'cnpj',FILTER_SANITIZE_ADD_SLASHES);
                $this->RequestArray += ['cnpj'=>$cnpj];
            }else if($_SESSION['TipoCliente']=='PJ'){
                $cnpj = $_SESSION['ID'];
                $this->RequestArray += ['cnpj'=>$cnpj];
            }else{
                $this->RequestArray += ['cnpj'=>null];
            }
            
            //exit(json_encode($this->RequestArray));
            
            $this->ValidateAgenda->validateFilds($this->RequestArray);
            
            $result = $this->ValidateAgenda->validateInsertEventosAgenda([
                'id'=>md5(rand(100,999)),
                'descricao'=>$titulo,
                'inicio'=>$inicio,
                'fim'=>$fim,
                'data'=>$data,
                'cnpj'=>$cnpj
            ]);
            //exit(json_encode($result));
            exit(json_encode([
                'erros'=>$this->ValidateAgenda->getError(),
                'sucessos'=>$this->ValidateAgenda->getMessage()
            ]));
            
        }else{
            exit(json_encode("Mande uma requisão POST"));
        }
    }
    
    public function getEventosAgenda(){
        if($_SESSION['TipoCliente']=='PJ'){
            
            if(isset($_POST['dia'])){
                $dia = filter_input(INPUT_POST,'dia',FILTER_SANITIZE_NUMBER_INT);
                $this->RequestArray += ['dia'=>$dia];
            }
            
            $this->ValidateAgenda->validateFilds($this->RequestArray);
            
            $result = $this->ValidateAgenda->validateGetEventos(
                [
                    'dia'=>$dia,
                    'cnpj'=>$_SESSION['ID']
                ]
                ,$_SESSION['TipoCliente']
            );
            exit(json_encode([
                'erros'=>$this->ValidateAgenda->getError(),
                'dados'=>$result
            ]));
        }else if($_SESSION['TipoCliente']=='PF'){
            if($_SERVER['REQUEST_METHOD']=="POST"){
                
            }else{
                exit(json_encode("Mande uma requisão POST"));
            }
        }
    }
    
}

?>