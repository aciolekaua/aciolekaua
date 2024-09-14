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
use App\Model\ClassSimplesNacional;

class ClassValidateSimplesNacional extends ClassValidate{

    private $Simples;

    public function __construct(){
        parent::__construct();
        $this->Simples = new ClassSimplesNacional();
    }
    
    private function validateIssetSimples(array $dados):bool{
        $return = $this->Simples->issetSimples($dados);

        if(!$return){
            return false;
        }else{
            return true;
        }
    }

    /*public function validateInsertRBT12(array $dados){
        
        if($this->Simples->issetRBT12([
            "competencia"=>$dados['competencia'],
            "cnpj"=>$dados['cnpj']
        ])){
            $this->setError("RBT12 já existente");
            return false;
        }else{
            if(!$this->Simples->insertRBT12($dados)){
                $this->setError("RBT12 não registrado");
                return false;
            }else{
                $this->setMessage("RBT12 registrado");
                return true;
            }
        }
        
    }*/

    public function validateInsertSimples(array $dados):bool{

        if(count($this->getError())>0){
            $this->setError("Simples Digitado não foi Efetuado");
            return false;
        }else{
            $return = self::validateIssetSimples($dados);
            if($return){
                $this->setError("Simples já registrado");
                return false;
            }else{
                if($this->Simples->insertDadosSimples($dados)){
                    $this->setMessage("Simples foi registrato");
                    return true;
                }else{
                    $this->setError("Simples não foi registrato");
                    return false;
                }
            }
            
        }
    }
    
    public function validateGetSimples(array $dados):array|bool{
        if(count($this->getError())>0){
            //$this->setError("");
            return false;
        }else{
            
            $return = $this->Simples->getSimples($dados);

            //exit(json_encode($return));

            if($return['linhas']<=0){
                $this->setError("Simples não encontrado");
                return false;
            }else{
                for($i=0;$i<=count($return['dados'])-1;$i++){
                    
                    $r = self::validateCalcularSimples([
                        "Tomador"=>$dados['tomador'],
                        "Anexo"=>$dados['anexo'],
                        "Data"=>$return['dados'][$i]['AnoCompetencia']."-".$return['dados'][$i]["MesCompetencia"]."-01"
                    ]);

                    /*$return['dados'][$i]+=["StatusSimples"=>$r];*/

                    if($r['dados']['Meses']!=12){
                        $return['dados'][$i]+=["StatusSimples"=>false,"AliquotaEfetiva"=>"0"];
                    }else{
                        $return['dados'][$i]+=["StatusSimples"=>true,"AliquotaEfetiva"=>$r['dados']['AliquotaEfetiva']];
                    }
                }
                
                return $return['dados'];
            }
        }
    }

    public function validateDeleteSimples(string $id):bool{
        $return = $this->Simples->deleteSimples($id);
        if(!$return){
            $this->setError("Simples não excluido");
            return false;
        }else{
            $this->setMessage('Simples excluido');
            return true;
        }
    }

    public function validateUpdateSimples(array $dados):bool{
        $return = $this->Simples->updateSimples($dados);
        if(!$return){
            $this->setError('Simples não atualizado');
            return false;
        }else{
            $this->setMessage('Simples atualizado');
        }
    }

    public function validateCalcularSimples(array $dados){

        $return = $this->Simples->calculaSimples($dados);

        if($return['linhas']<=0){
            return false;
        }else{

            
            if((int)$return['dados']['Meses']<=11){
                return false;
            }else{
               
                //$dados+=['Anexo'=>1];
        
                $aliquotaArray = [    
                    1=>[
                        1=>["Aliquota"=>4,"Desconto"=>0],
                        2=>["Aliquota"=>7.3,"Desconto"=>5940],
                        3=>["Aliquota"=>9.5,"Desconto"=> 13860],
                        4=>["Aliquota"=>10.7,"Desconto"=>22500],
                        5=>["Aliquota"=>14.3,"Desconto"=>87300],
                        6=>["Aliquota"=>19,"Desconto"=>378000]
                    ],
                    2=>[
                        1=>["Aliquota"=>4.5,"Desconto"=>0],
                        2=>["Aliquota"=>7.8,"Desconto"=>5940],
                        3=>["Aliquota"=>10,"Desconto"=> 13860],
                        4=>["Aliquota"=>11.2,"Desconto"=>22500],
                        5=>["Aliquota"=>14.7,"Desconto"=>85500],
                        6=>["Aliquota"=>30,"Desconto"=>720000]
                    ],
                    3=>[
                        1=>["Aliquota"=>6,"Desconto"=>0],
                        2=>["Aliquota"=>11.2,"Desconto"=>9360],
                        3=>["Aliquota"=>13.5,"Desconto"=> 17640],
                        4=>["Aliquota"=>16,"Desconto"=>35640],
                        5=>["Aliquota"=>21,"Desconto"=>125640],
                        6=>["Aliquota"=>33,"Desconto"=>648000]
                    ],
                    4=>[
                        1=>["Aliquota"=>4.5,"Desconto"=>0],
                        2=>["Aliquota"=>9,"Desconto"=>8100],
                        3=>["Aliquota"=>10.2,"Desconto"=> 12420],
                        4=>["Aliquota"=>14,"Desconto"=>39780],
                        5=>["Aliquota"=>22,"Desconto"=>183780],
                        6=>["Aliquota"=>33,"Desconto"=>828000]
                    ],
                    5=>[
                        1=>["Aliquota"=>15.5,"Desconto"=>0],
                        2=>["Aliquota"=>18,"Desconto"=>4500],
                        3=>["Aliquota"=>19.5,"Desconto"=> 9900],
                        4=>["Aliquota"=>20.5,"Desconto"=>17100],
                        5=>["Aliquota"=>23,"Desconto"=>62100],
                        6=>["Aliquota"=>30.5,"Desconto"=>540000]
                    ]
                ];
                
                $RBT12 = (float)$return['dados']['Valor'];

                $faixa = null;
                if($RBT12 <= 180000){
                    $faixa = 1;
                }else if($RBT12>  180000  && $RBT12 <= 360000){
                    $faixa = 2;
                }else if($RBT12>  360000  && $RBT12 <= 720000){
                    $faixa = 3;
                }else if($RBT12>  720000  && $RBT12 <= 1800000){
                    $faixa = 4;
                }else if($RBT12>  1800000  && $RBT12 <= 3600000){
                    $faixa = 5;
                }else if($RBT12>  3600000  && $RBT12 <= 4800000){
                    $faixa = 6;
                }

                $aliquota = $aliquotaArray[$dados['Anexo']][$faixa]['Aliquota'];
                $desconto = $aliquotaArray[$dados['Anexo']][$faixa]['Desconto'];

                $aliquota/=100;

                $ALIQEfetiva =  (($RBT12 * $aliquota) - $desconto) / $RBT12;
                $return['dados'] +=["AliquotaEfetiva"=>number_format(($ALIQEfetiva * 100), 2, ".", "")];

                return $return;
            }

            
           
        }
        
        

        /*$array_post = array();
        if(isset($_POST['RBT12'])){
            $RBT12 = (float) str_replace([".",","],["","."],$_POST['RBT12']);
            $array_post+=['RBT12'=>$RBT12];
        }
        if(isset($_POST['anexo'])){
            $anexo = (int)filter_input(INPUT_POST,'anexo',FILTER_SANITIZE_NUMBER_INT);
            $array_post+=['anexo'=>$anexo];
        }
        if(isset($_POST['ValorTotalDosServicos'])){
             $ValorTotalDosServicos = (float) str_replace([".",","],["","."],$_POST['ValorTotalDosServicos']);
             $array_post+=['ValorTotalDosServicos'=>$ValorTotalDosServicos];
        }
        if(isset($_POST['aliquota'])){
            $aliquota = str_replace(",",".",$_POST['aliquota']);
            $aliquota = (float)filter_input(INPUT_POST,'aliquota',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $array_post+=['aliquota'=>$aliquota];
        }
        if(isset($_POST['ValorTotalDasDeducoes'])){
            $pclDeduzir = (float) str_replace([".",","],["","."],$_POST['ValorTotalDasDeducoes']);
            $array_post+=['ValorTotalDasDeducoes'=>$pclDeduzir];
        }*/
        
        
        //$this->Validate->validateFilds($array_post);
        
        
        
        /*$conta_fator_R = $pagamento/$RBT12;
        $resultado_Fator_R = $conta_fator_R * 100;
        if($resultado_Fator_R >= 28){$anexo=3;}*/
        
        /*$ValorTributadoAliquota = $ValorTotalDosServicos * $ALIQEfetiva; 
        $json +=["valorTributadoAliquota"=>number_format($ValorTributadoAliquota, 2, ".", "")];
        
        $valores_recebidos = 0;
        foreach($aliquotaArray[$evento][$anexo] as $key => $value){
            if($value>0 && $value<1){
                $valores_recebidos+=$value;
                $json["dadosAliquota"][$key]+=[$key."_Decimal"=>number_format($value, 4, ".", "")];
                $json["dadosAliquota"][$key]+=[$key."_Percentual"=>number_format(($value * 100), 4, ".", "")];
            }
        }
        $json+=['totalSomaPercentual'=>($valores_recebidos*100)];
        
        $valor_total_aliquota = 0;
        foreach($aliquotaArray[$evento][$anexo] as $key => $value){
            if($value>0 && $value<1){
                $cal=($ValorTributadoAliquota * $value);
                $valor_total_aliquota+=$cal;
                $json["dadosAliquota"][$key]+=[$key."_ValorImposto"=>number_format($cal, 2, ".", "")];
            }
        }
        $json+=["erros"=> $this->Validate->getError()];
        exit(json_encode($json));*/
    }
}