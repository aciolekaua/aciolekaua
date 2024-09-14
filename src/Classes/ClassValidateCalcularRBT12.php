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
use Src\Classes\ClassRequestJSON;
use App\Model\ClassCalcularRBT12;

use Smalot;

class ClassValidateCalcularRBT12 extends ClassValidate{
    
    private $rbt12;
    private $RequestJSON;
    private $Smalot;

    public function __construct(){
        /*ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);*/
        parent::__construct();
        $this->rbt12 = new ClassCalcularRBT12;
        $this->RequestJSON = new ClassRequestJSON;
        $this->Smalot = new \Smalot\PdfParser\Parser();
    }

    public function validate_testeCronJobs(){
        //$this->rbt12->insertCronJobs();
    }

    public function validate_testeCNPJ(){
        $json = '[
            {
                "cnpj": "49.327.633/0001-06",
                "razao": "49.327.633 GABRIELA DE ANDRADE"
            },
            {
                "cnpj": "51.766.544/0001-08",
                "razao": "51.766.544 TAYLANE ROSY DE LIMA MARQUES"
            },
            {
                "cnpj": "52.916.686/0001-69",
                "razao": "5JRCM EMPREENDIMENTOS MINIMERCADO LTDA"
            },
            {
                "cnpj": "19.216.844/0001-00",
                "razao": "A & M ENGENHARIA E SERVICOS TECNICOS LTDA"
            },
            {
                "cnpj": "32.662.718/0001-30",
                "razao": "ADILSON SOARES DA COSTA 00891194444"
            },
            {
                "cnpj": "27.657.321/0001-10",
                "razao": "AGUIAR CONSULTORIA EM GESTAO EMPRESARIAL LTDA"
            },
            {
                "cnpj": "05.157.898/0001-20",
                "razao": "ALBAP CONSULTORIA E ADMINISTRACAO LTDA"
            },
            {
                "cnpj": "01.719.701/0001-48",
                "razao": "ALUSTAU CORRETORA DE SEGUROS LTDA"
            },
            {
                "cnpj": "32.206.927/0001-79",
                "razao": "ANDREZA DE MORAES SILVA BELTRAO"
            },
            {
                "cnpj": "18.998.857/0001-08",
                "razao": "ARTHUR PAGANO"
            },
            {
                "cnpj": "08.021.752/0001-40",
                "razao": "BLOG DO MAGNO MARTINS COMUNICACAO LTDA"
            },
            {
                "cnpj": "26.875.953/0001-97",
                "razao": "BR7 CORRETORA DE SEGUROS LTDA"
            },
            {
                "cnpj": "47.468.976/0001-57",
                "razao": "BUREAU INTERNACIONAL DE POSGRADO LTDA."
            },
            {
                "cnpj": "51.628.960/0001-31",
                "razao": "CAIO CORTEZ LION SERVICOS DE CONSULTORIA EM PROJETOS"
            },
            {
                "cnpj": "51.031.578/0001-46",
                "razao": "COLEGIO E CURSO PENTAGONO LTDA"
            },
            {
                "cnpj": "39.936.510/0001-00",
                "razao": "CONSULTORIO VETERINARIO ERICKA JANYNE LTDA"
            },
            {
                "cnpj": "33.714.363/0001-48",
                "razao": "COOPERH SERVICOS COMBINADOS DE ESCRITORIO E CONSULTORIA LTDA"
            },
            {
                "cnpj": "28.676.594/0002-55",
                "razao": "EDSON OLIVIR ZOTTO ANDRADE"
            },
            {
                "cnpj": "28.676.594/0001-74",
                "razao": "EDSON OLIVIR ZOTTO ANDRADE"
            },
            {
                "cnpj": "40.305.142/0001-81",
                "razao": "ERICO VERISSIMO CORREIA DO NASCIMENTO REPRESENTACOES"
            },
            {
                "cnpj": "27.177.643/0001-61",
                "razao": "EVODIA SANTOS SOCIEDADE INDIVIDUAL DE ADVOCACIA"
            },
            {
                "cnpj": "12.302.552/0001-33",
                "razao": "EVODIA SOARES DA SILVA FAGUNDES"
            },
            {
                "cnpj": "06.175.091/0001-82",
                "razao": "EZEQUIEL SEVERINO DA SILVA"
            },
            {
                "cnpj": "17.141.393/0001-56",
                "razao": "F.ROSENDO PRODUTOS OTICOS LTDA"
            },
            {
                "cnpj": "50.019.115/0001-04",
                "razao": "FABIOLA BARBOSA RAMOS DA SILVA"
            },
            {
                "cnpj": "40.797.095/0001-30",
                "razao": "FACTO COMUNICACAO & MARKETING LTDA"
            },
            {
                "cnpj": "02.472.149/0001-07",
                "razao": "FIRME ENGENHARIA E AVALIACOES LTDA"
            },
            {
                "cnpj": "40.975.869/0001-76",
                "razao": "FUTEBOL PET LTDA"
            },
            {
                "cnpj": "43.808.247/0001-41",
                "razao": "GATI ENGENHARIA E ENERGIA SOLAR LTDA"
            },
            {
                "cnpj": "37.513.282/0001-30",
                "razao": "GILMAR R. DE AMORIM"
            },
            {
                "cnpj": "09.088.198/0001-81",
                "razao": "GROUPDOM SOLUCOES E SERVICOS LTDA"
            },
            {
                "cnpj": "38.319.152/0001-24",
                "razao": "HUMBERTO SAVIO DE MELO ROSAS"
            },
            {
                "cnpj": "35.676.951/0001-60",
                "razao": "IMGL CONSULTORIA & TREINAMENTO LTDA"
            },
            {
                "cnpj": "38.204.015/0001-44",
                "razao": "INACIA MARIA DE OLIVEIRA TEOTONIO"
            },
            {
                "cnpj": "18.270.946/0001-33",
                "razao": "JAMISSON L. ALVES"
            },
            {
                "cnpj": "32.830.715/0001-68",
                "razao": "JESSICA JULIANE MONTEIRO DA SILVA 08534190437"
            },
            {
                "cnpj": "46.805.336/0001-22",
                "razao": "JOELICSAN SANTANA DOS SANTOS"
            },
            {
                "cnpj": "14.856.142/0001-60",
                "razao": "JOSELMA F. DE LIMA ME"
            },
            {
                "cnpj": "24.407.626/0001-85",
                "razao": "KARINA KARLA FERREIRA KIELING"
            },
            {
                "cnpj": "31.228.947/0001-88",
                "razao": "LEANDRO CANDIDO LOURENCO 04485077497"
            },
            {
                "cnpj": "43.729.046/0001-59",
                "razao": "LOJA DA COSTURA LTDA"
            },
            {
                "cnpj": "40.345.633/0001-56",
                "razao": "LUCIANO RECAMON BORGOGNONI REPRESENTACAO"
            },
            {
                "cnpj": "13.762.914/0001-31",
                "razao": "LUISA BRENNAND BARBOSA CHIAPERINI"
            },
            {
                "cnpj": "53.361.678/0001-66",
                "razao": "MARCOS DOMINGOS DA SILVA"
            },
            {
                "cnpj": "55.458.588/0001-13",
                "razao": "MARIA J. DE F. VERAS"
            },
            {
                "cnpj": "53.262.149/0001-05",
                "razao": "MARIANA MERCES SERVIÇOS MEDICOS"
            },
            {
                "cnpj": "45.304.486/0001-90",
                "razao": "MEIRY LANUNCE COMUNICACOES & EVENTOS LTDA"
            },
            {
                "cnpj": "05.374.796/0001-66",
                "razao": "MJMOURA S/S LTDA"
            },
            {
                "cnpj": "19.361.202/0001-97",
                "razao": "MONICA SANTOS DE LIMA 60887508472"
            },
            {
                "cnpj": "29.483.126/0001-46",
                "razao": "MONICA VALERIA SAMPAIO DAS MERCES"
            },
            {
                "cnpj": "29.303.008/0001-09",
                "razao": "MORPHOS LIFE SAUDE & BEM ESTAR LTDA"
            },
            {
                "cnpj": "27.987.995/0001-82",
                "razao": "MOSAEL ROSENO DOS SANTOS"
            },
            {
                "cnpj": "08.839.828/0001-40",
                "razao": "NOVA AURORA COMUNICACAO E MARKETING LTDA"
            },
            {
                "cnpj": "11.316.866/0001-22",
                "razao": "PERNAMBUCONT - CONTABILIDADE, CORRETORA DE SEGUROS E APOIO ADMINISTRATIVO LTDA"
            },
            {
                "cnpj": "53.527.223/0001-78",
                "razao": "PONTUAL DISTRIBUIDORA LTDA"
            },
            {
                "cnpj": "51.019.209/0001-38",
                "razao": "POUSADA TRIP INN RECIFE LTDA"
            },
            {
                "cnpj": "01.328.338/0001-30",
                "razao": "PRODOTICA PRODUTOS OTICOS LTDA"
            },
            {
                "cnpj": "56.088.614/0001-21",
                "razao": "R A DA FONSECA"
            },
            {
                "cnpj": "19.222.468/0001-59",
                "razao": "R. NASCIMENTO DE LIMA"
            },
            {
                "cnpj": "36.021.097/0001-66",
                "razao": "REAL KOMBUCHA ALIMENTACAO SAUDAVEL LTDA"
            },
            {
                "cnpj": "30.256.265/0001-16",
                "razao": "RONALDO PESSOA DA CRUZ COM E SERV DE ESTOFADOS LTDA"
            },
            {
                "cnpj": "31.659.199/0001-98",
                "razao": "RP COMUNICACAO E MARKETING LTDA"
            },
            {
                "cnpj": "54.227.623/0001-20",
                "razao": "SANE PRAG LTDA"
            },
            {
                "cnpj": "29.350.026/0001-41",
                "razao": "SB CONSULTORIA EM GESTAO EMPRESARIAL LTDA"
            },
            {
                "cnpj": "20.258.481/0001-47",
                "razao": "SEIS CONSULTORIA E TREINAMENTO LTDA"
            },
            {
                "cnpj": "26.700.664/0001-57",
                "razao": "SOLUTECHSYSTEMS TECNOLOGIA E SERVICOS EM INFORMATICA LTDA"
            },
            {
                "cnpj": "41.158.018/0001-01",
                "razao": "TEKHNE VET SCIENCE DIAGNOSTICO, CURSO E CONSULTORIA VETERINARIA LTDA"
            },
            {
                "cnpj": "03.902.161/0001-69",
                "razao": "VM SERVICOS CONTABEIS EM GERAL LTDA"
            },
            {
                "cnpj": "54.201.805/0001-22",
                "razao": "YURI ESMERALDO TELES LTDA"
            }
        ]';

        $dados = json_decode($json,true);
        foreach($dados as $key => $array){
            $array['cnpj'] = preg_replace("/[^0-9]/","",$array['cnpj']);
            $this->rbt12->insertEmpresasDAS($array);
        }
       
        /*$cnpj = [];
        foreach($select['dados'] as $key=>$value){
            array_push($cnpj, $value);
            $return = json_decode($this->RequestJSON->request("https://receitaws.om.br/v1/cnpj/{$value['cnpj']}","GET",null,null),true);
        }*/
        //$return = json_decode($this->RequestJSON->request("https://receitaws.om.br/v1/cnpj/55458588000113","GET",null,null),true);
        //$update = $this->rbt12->
        exit(json_encode($dados));
    }
    
    public function validateAutenticacaoIntegraContador(){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }else{
            $return  = $this->RequestJSON->request(
                "https://autenticacao.sapi.serpro.gov.br/authenticate",
                "POST",
                "grant_type=client_credentials"
                ,
                [
                    "Content-Type:application/x-www-form-urlencoded",
                    "Role-Type: TERCEIROS",
                    "Authorization: Basic ".CHAVE_AUTENTICACAO_INTEGRA_CONTADOR
                ],
                [
                    "Certificado"=>DIR_CERTIFICADO."elai.pem",
                    "Senha"=>PASS_CER_ELAI
                ]        
            );

            $dados = json_decode($return, true);

            if(!isset($dados['token_type']) && !isset($dados['jwt_token']) && !isset($dados['access_token'])){
                $this->setError('Token não gerado');
                return false;
            }

            return [
                'token_type'=>$dados['token_type'],
                'jwt_token'=>$dados['jwt_token'],
                'access_token'=>$dados['access_token']
            ];
        }
    }

    public function validateConsultarDeclaracao(array $dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }else{
            
            $competencia_array = explode('-',$dados['competencia']); 

            $return  = $this->RequestJSON->request(

                "https://gateway.apiserpro.serpro.gov.br/integra-contador/v1/Consultar",
                "POST",
                json_encode([
                    "contratante"=>[
                        "numero"=>CONTRATANTE,
                        "tipo"=>2
                    ],
                    "autorPedidoDados"=>[
                        "numero"=>AUTOR_PEDIDO_DADOS,
                        "tipo"=>2
                    ],
                    "contribuinte"=>[
                        "numero"=>"{$dados['cnpj']}",
                        "tipo"=>2
                    ],
                    "pedidoDados"=>[
                        "idSistema"=>"PGDASD",
                        "idServico"=>"CONSULTIMADECREC14",
                        "versaoSistema"=> "1.0",
                        "dados"=> "{ \"periodoApuracao\": \"{$competencia_array[0]}{$competencia_array[1]}\" }"
                    ]
                ]),
                [
                    "Content-Type:application/json",
                    "Authorization:{$dados['token_type']} {$dados['access_token']}",
                    "jwt_token: {$dados['jwt_token']}"
                ]
                    
            );

            if(!$return){
                $this->setError("Falha na requisição");
                return false;
            }

            $return = json_decode($return,true);

            //exit(json_encode(empty($return['dados'])));

            if(!isset($return['status'])){
                $this->setError('Erro na composição da api');
                return false;
            }

            if(empty($return['dados'])){
                $this->setError($return['mensagens'][0]['texto']);
                return false;
            }

            return $return;
        }
    }

    public function validateGetFatulra(array $dados){
        
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }

        $return = $this->rbt12->getFaturamento($dados);

        if($return['linhas']<=0){
            $this->setError("Fatura(s) não encontrada(s)");
            return false;
        }

        return $return['dados'];
        
    }

    public function validateInsertRBT12(array $dados){
        //exit(json_encode($dados));
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }else{
            if($this->rbt12->issetRBT12([
                "competencia"=>$dados['competencia'],
                "cnpj"=>$dados['cnpj']
            ])){
                $this->setError("RBT12 já existente");
                return false;
            }else{
                if(!$this->rbt12->insertRBT12($dados)){
                    $this->setError("RBT12 não registrado");
                    return false;
                }else{
                    $this->setMessage("RBT12 registrado");
                    return true;
                }
            }
        }
        
    }

    public function validateIssetRBT12(array $dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }else{
            $array = array();

            if(!isset($dados['competencia'])){
                $this->setError("Sem competência");
                return false;
            }
            $array += ["competencia"=>$dados['competencia']];

            if(isset($dados['cnpj'])){
                $array += ["cnpj"=>$dados['cnpj']];
            }else if(isset($dados['id'])){
                $array += ["id"=>$dados['id']];
            }else{
                $this->setError("Sem cnpj ou id");
                return false;
            }

            return $this->rbt12->issetRBT12($array);
        }
    }

    public function validateUpdateRBT12(array $dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }

        $update = $this->rbt12->updateRBT12($dados);

        if($update){
            $this->setMessage('RBT12 atualizado');
            return true;
        }else{
            //$this->setError('RBT12 não atualizado');
            return false;
        }

    }

    public function validateGetRBT12(array $dados){
        //exit(json_encode($dados));
        $return = $this->rbt12->getRBT12($dados);
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }else{
            if($return['linhas']<=0){
                $this->setError("Não há dados");
                return false;
            }else{
                return $return['dados'];
            }
        }
    }

    public function validateGetEmpresasFaturamentoDAS(){
        $return = $this->rbt12->getEmpresasFaturamentoDAS();
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }

        if($return['linhas']<=0){
            $this->setError("Não há empresas!");
            return false;
        }else{
            return $return['dados'];
        }
    }

    public function validateGetRBT12_Empresas(string $competencia, array $razoes){
        //exit(json_encode($competencia));
        $return = $this->rbt12->getRBT12_Empresas($competencia);
        //exit(json_encode($return));
        if($return['linhas']<=0){
            $this->setError("Não há empresas!");
            return false;
        }else{

            return $return['dados'];
        }
    }

    public function validateGetEmpresasDAS(){
        $return = $this->rbt12->getEmpresasDAS();

        if($return['linhas']<=0){
            $this->setError("Não há empresas!");
            return false;
        }else{
            return $return['dados'];
        }
    }
}