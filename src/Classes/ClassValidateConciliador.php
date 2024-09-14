<?php 
namespace Src\Classes;
use App\Model\ClassCadastro;
use App\Model\ClassLogin;
use App\Model\ClassHome;
use App\Model\ClassLancamentos;
use App\Model\ClassTabelas;
use App\Model\ClassGestaoDeUsuarios;
use App\Model\ClassGestaoDeConselho;
use App\Model\ClassPerfil;
use App\Model\ClassNotaFiscal;
use App\Model\ClassRecuperacaoDeSenha;
use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassSessions;
use Src\Classes\ClassValidate;
use App\Model\ClassConciliador;

class ClassValidateConciliador extends ClassValidate{
    
    private $Conciliador;
    public function __construct(){
        parent::__construct();
        $this->Conciliador = new ClassConciliador;
    }
        
     public function insertArquivos($arquivo){
        //exit(json_encode("OI"));
        if(count($this->getError())>0){
            $this->setError("Não encontramos o Arquivo!");
            return false;
        }else{
            $primeira_linha = true;
            $linhas_importadas = 0;
            $linhas_nao_importadas = 0;
            $dados_nao_importados = "";
            
            $tipoArquivo = $arquivo['type'];
            
            if($tipoArquivo == "text/csv"){
                $nomeArquivo = $arquivo['tmp_name'];
                
                $dados_arquivos = fopen($nomeArquivo,"r");
                //exit(json_encode($dados_arquivos));
                while($linha = fgetcsv($dados_arquivos, 1000, ";")){
                //exit(json_encode($dados_arquivos));
        
                if($primeira_linha){
                    $primeira_linha = false;
                    continue;
                }
    
                //usar para quando estiver com defeito no caracter especial
                array_walk_recursive($linha, function($dados_arquivos){
                    $dados_arquivos = mb_convert_encoding($dados_arquivos, "UTF-8","ISO-8859-1");
                }, $dados_arquivos);
                $result = explode('/',$linha[0]);
                $dia = $result[0];
                $mes = $result[1];
                $ano = $result[2];
                $data =  $ano .'-'. $mes .'-'. $dia;
                $linha[0] = $data;
                
                
                $query_dados = $this->Conciliador->insertArquivos(array(
                    "data"=>(string)$linha[0],
                    "historico"=>(string)$linha[1],
                    "documento"=>(int)$linha[2],
                    "historicoEditado"=>(string)"",
                    "valor"=>(float)$linha[3],
                    "tipo"=>(string)$linha[4]
                 ));
    
                }
            }else{
                 $this->setError("O Arquivo não é do tipo CSV!");
                 return false;
            }
            $resultados = array(
                "linhasimportadas"=>$linhas_importadas,
                "linhasnaoimportadas"=>$linhas_nao_importadas
            );
            return $resultados;
        }
        
        
    }
    public function desenharTabela($dados_requisao){
        if($dados_requisicao['id']){
            $id = $dados_requisicao['id'];
            
            $consulta_usuario = $this->Conciliador->listarUsuarios(array(
                "id"=>(int)$id,
                "data"=>(string)$data,
                "historico"=>(string)$historico,
                "historicoEditado"=>(string)$historicoEditado,
                "valor"=>(string)$valor
            ));
            
            if(!empty($dados_requisicao['search']['value'])){
                    
                $colunas = [
                    0 => 'id',  
                    1 => 'data',  
                    2 => 'historico',  
                    3 => 'historicoEditado',  
                    4 => 'valor'  
                ];
                
                
                $row_qnt_usuarios;//Variavel de Wallacy
        
                while($row_dados = $consulta_usuario){
                    extract($row_dados);
                    $result = explode('-',$data);
                    $dia = $result[0];
                    $mes = $result[1];
                    $ano = $result[2];
                    $data = $ano .'/'. $mes .'/'. $dia;
                    $registro = [];
                    $registro[] = $id;
                    $registro[] = $data;
                    $registro[] = $historico;
                    $registro[] = $historicoEditado;
                    $registro[] = "R$".$valor;
                    $registro[] = "<span type='button' id='$id' class='visualizar'
                    data-toggle='tooltip' title='Visualizar seus dados'
                    onclick='visUsuario($id)'><i class='fa-solid fa-eye'></i></span>
                    <span type='button' class='editar' onclick='editUsuario($id)'><i class='bi bi-pencil-fill'></i></span>
                    <span type='button' id='$id' class='lixo' onclick='apagarRegistro($id)'
                    ><i class='bi bi-trash3-fill'></i></span>";
                    $todos_dados[] = $registro;
                    
                    return $todos_dados;
                }
            } else {
                $this->setError("Dados da requisição estão vazios");
                return false;
            }
        } else {
            $this->setError("Você precisa de um Id");
            return false;
        }
        
    }
    
}
?>