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
use App\Model\ClassAreaContador;
use Src\Classes\ClassPasswordHash;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;
class ClassValidate{

    use TraitUrlParser;
    private $Message=[];
    private $Erro=[];
    private $Tabela;
    private $Tabelas;
    protected $Cadastro;
    private $PasswordHash;
    private $Sessions;
    protected $Login;
    private $Home;
    private $Lancamento;
    private $GestaoDeUsuarios;
    private $GestaoDeConselho;
    protected $Perfil;
    private $NotaFiscal;
    private $RecuperacaoDeSenha;
    private $Teste;
    
    function __construct(){
        $this->Teste = new ClassTeste;
        $this->RecuperacaoDeSenha = new ClassRecuperacaoDeSenha;
        $this->GestaoDeUsuarios = new ClassGestaoDeUsuarios;
        $this->GestaoDeConselho = new ClassGestaoDeConselho;
        $this->Cadastro = new ClassCadastro;
        $this->PasswordHash = new ClassPasswordHash;
        $this->Login = new ClassLogin;
        $this->Home = new ClassHome;
        $this->Sessions = new ClassSessions;
        $this->Lancamento = new ClassLancamentos;
        $this->Tabelas = new ClassTabelas;
        $this->Perfil = new ClassPerfil;
        $this->NotaFiscal = new ClassNotaFiscal;
    }
    
    public function getError(){
        return $this->Erro;
    }
    
    public function setError($Erro){
        array_push($this->Erro,$Erro);
    }
    
    public function getMessage(){
        return $this->Message;
    }
    
    public function setMessage($Message){
        array_push($this->Message,$Message);
    }
    
    //Com conexão
    //Teste
    public function validateInsertPagamentoTeste($dados){
        if($this->Lancamento->insertPagamentoTeste($dados)<=0){
            $this->setError("Houve um erro no processamento do pagamento de teste.");
            return false;
        }else{
            $this->setMessage("O pagamento de teste foi realizado com sucesso!");
            return true;
        }
    }
    public function validateGetInformacoesAnexo($dados){
        $result = $this->Teste->getInformacoesAnexo($dados);
        if($result['linhas']<=0){
            $this->setError('Informações não encotradas sobre o anexo');
            return false;
        }else{
            return $result['dados'];
        }
    }
    
    public function validateGetCNAE($cnae){
        $teste = $this->Teste->getCNAE($cnae);
        if($teste['linhas']<=0){
            $this->setError('CNAE não encontrado');
            return false;
        }else{
            return $teste['dados'];
        }
    }
 
    public function validateGetPJ($cnpj){
        $retorno = $this->Teste->getPJ($cnpj);
        if($retorno['linhas']<=0){
            $this->setError("PJ não cadastrado");
            return false;
        }else{return $retorno['dados'];}
    }
    
   /*public function validateInsertListaServico($dados){
        
        $r = $this->Teste->issetListaServico([
            "cod"=>$dados['cod'],
            "cnpj"=>$dados['cnpj']
        ]);
        
        if(!$r){
            $result = $this->Teste->insertListaServico([
                "cod"=>(float)$dados['cod'],
                "cnpj"=>(string)$dados['cnpj'],
                "descricao"=>(string)$dados['descricao']
            ]);
        }
        if($result){
            $this->setMessage("Serviço registrado");
            return true;
        }else{
            $this->setError("Serviço não registrado");
            return false;
        }
    }
    
    public function validateGetListaServico($cnpj){
        $result = $this->Teste->getListaServico($cnpj);
        if($result['linhas']<=0){
            $this->setError("Sem serviço");
            return false;
        }else{
            return $result['dados'];
        }
    }*/
    
    public function validateInsertTributosMunicipais($dados){
        
        if($this->Teste->issetTributosMunicipais($dados)){
            $this->setError("Tributo já registrado");
            return false;
        }else{
            if(!$this->Teste->insertTributosMunicipais($dados)){
                $this->setError("Tributo não registrado");
                return false;
            }else{
                $this->setMessage("Tributo registrado");
                return true;
            }
        }
        
    }
    
    public function validateGetTributosMunicipais($cnpj){
        
        $result = $this->Teste->getTributosMunicipais($cnpj);
        if($result['linhas']<=0){
            $this->setError("Sem tributo");
            return false;
        }else{
            return $result['dados'];
        }
        
    }
    
    //Cadastro
    public function validateGetTipoJuridico(){
        $res=$this->Cadastro->getTipoJuridico();
        if($res['linhas']>0){
            return $res['dados'];
        }else{
            $this->setError("Erro na busca de dados");
            return false;
        }
    }
    
    #Validador de e-mail
    public function validateIssetEmail($Email,$TipoCliente,$Action=null){
        
        if($TipoCliente=="PF"){
            $Tabela="PF";
        }else if($TipoCliente=="PJ"){
            $Tabela="PJ";
        }else{
            $this->setError("Tipo de Cliente inválido");
            return false;
        }
        
        $res=$this->Cadastro->issetEmail($Email,$Tabela);
        //exit(json_encode("OI"));
        if($Action==null){
            if($res > 0){
                $this->setError("Email já cadastrado");
                return false; 
            }else{
                return true;
            }
        }else{
            if($res > 0){
                return true; 
            }else{
                $this->setError("Email não cadastrado");
                return false;
            }
        }
    }
    
    #Validador de CPF
    public function validateIssetCPF($CPF,$Action=null){
        $res=$this->Cadastro->issetCPF($CPF);
        if($Action==null){
            if($res > 0){
                $this->setError("CPF já cadastrado");
                return false; 
            }else{
                return true;
            }
        }else{
            if($res > 0){
                return true; 
            }else{
                $this->setError("CPF não cadastrado");
                return false;
            }
        }
    }
    
    #Validador de CNPJ
    public function validateIssetCNPJ($CNPJ,$Action=null){
        $res=$this->Cadastro->issetCNPJ($CNPJ);
        if($Action==null){
            if($res > 0){
                $this->setError("CNPJ já cadastrado");
                return false; 
            }else{
                return true;
            }
        }else{
            if($res > 0){
                return true; 
            }else{
                $this->setError("CNPJ não cadastrado");
                return false;
            }
        }
    }
    
    #Validador de senha
    public function validateSenha($Email,$TipoCliente,$Senha,$verficar=null){
        
        if($this->PasswordHash->passwordVerify($Email,$TipoCliente,$Senha)){return true;}else{
            
            if($verficar!=null){
                $this->setError('Senha inválida');
            }else{
                $this->setError('Email ou senha inválidos');
            }
            return false;
        }
    }
    
    #Validar a inserssão de dados
    public function validateInsertCad($Dados=array(),$Tipo){
        if(count($this->getError())>0){
            $this->setError("Falha no cadastro");
            return false;
        }else{
           
            if(count($Dados)>0){
                if($Tipo=="PF"){
                    
                    if(!$this->Cadastro->insertTokenConfirmaCad($Dados)){
                        $this->setError("Cadastro não realizado(Token não registrado)");
                        return false;
                    }else{
                        
                        if($this->Cadastro->validateInsertPF($Dados)>0){
                            $this->setMessage("Cadastro feito");
                            return true;
                        }else{
                            $this->setError("Cadastro não realizado");
                            return false;
                        }
                    }
                    
                }else if($Tipo=="PJ"){
                    if(!$this->Cadastro->insertTokenConfirmaCad($Dados)){
                        $this->setError("Cadastro não realizado(Token não registrado)");
                        return false;
                    }else{
                        if($this->Cadastro->validateInsertPJ($Dados)>0){
                            $this->setMessage("Cadastro feito");
                            return true;
                        }else{
                            $this->setError("Cadastro não realizado");
                            return false;
                        }
                    }
                }else{
                    $this->setError('Tipo de cliente inválido');
                    return false;
                }
            }else{
                $this->setError("Array vazio");
                return false;
            }
            
        }
        
    }
    
    public function validateIssetTokenCadastro($token){
        $isset = $this->Cadastro->issetTokenConfirmaCad($token);
        
        if($isset['linhas']<=0){
            $this->setError("Token não existente");
            return false;
        }else{
            return $isset['dados'];
        }
    }
    
    public function validateAtivarContaCad($dados){
       
        if(!$this->Cadastro->deleteTokenConfirmaCad($dados['Token'])){
            return false;
        }else{
            if(!$this->Cadastro->ativarConta($dados['Email'],$dados['TipoCliente'])){
                return false;
            }else{
                return true;
            }
        }
    }
    
    //Login
    
    #Conta o número de tentativas
    
    public function validateTempoDeTentativa(){
        
        $return = $this->Login->ultimaOcorrenciaDeTentativa();
        
        if($return['linhas']<=0){
            return true;
        }else{
            if($this->Login->countTentativas()>=5){
                if(strtotime($return['dados']['Data'])<=(time()-(24*60*60))){
                    $this->Login->deleteTentativas();
                    return true;  
                }else{
                    return false;
                }
            }else{
               return true; 
            }
        }
    }
    
    public function validateConutTentativas(){
        
        if($var=$this->Login->countTentativas()>=NUMERO_DE_TENTATIVAS){
            $this->setError("Você já fez mais que 5 tentativas");
            return false;
        }else{
            return $var;
        }
        
    }
    
    #Faz a de login verificação final
    public function validateContaAtiva($Email,$TipoCliente){
        
        $dados = $this->Login->getDataUser($Email,$TipoCliente);
        $ativado = false;
        
        $ativado = (bool)$dados['dados']['Ativo'];
        
        if(!$ativado){
            $this->setError("Ative sua conta");
            return false;
        }else{
            return true;
        }
        
    }
    
    public function validateTentativasFinal($Email,$TipoCliente,$Pagina){
        if(count($this->getError())>0){
            $arrayResponse=[
                'retorno'=>'erro',
                'erros'=>$this->getError()
                ];
            $this->Login->insertTentativas();
            return false;
        }else if(count($this->getError())<=0){
            $this->Login->deleteTentativas();
            if($this->Sessions->sessionStatus()==2){
                if($this->Sessions->setSessions($Email,$TipoCliente)){
                    if($TipoCliente=="PF"){
                        if(
                            isset($_SESSION['nome']) 
                            && isset($_SESSION['email'])
                            && isset($_SESSION['ID'])
                            && isset($_SESSION['TipoCliente'])
                            && isset($_SESSION['login'])
                            && isset($_SESSION['time'])
                        ){//echo"<script>window.location.href='".DIRPAGE."{$Pagina}';</script>";
                            return true;
                        }
                    }else if($TipoCliente=="PJ"){
                         if(
                            isset($_SESSION['nomeFantasia'])
                            && isset($_SESSION['razaoSocial'])
                            && isset($_SESSION['email'])
                            && isset($_SESSION['ID'])
                            && isset($_SESSION['TipoCliente'])
                            && isset($_SESSION['login'])
                            && isset($_SESSION['time'])
                            && isset($_SESSION['TipoJuridico'])
                        ){//echo"<script>window.location.href='".DIRPAGE."{$Pagina}';</script>";
                            return true;
                        }
                    }
                }
            }
        }
    }
    
    //Recuperação de Senha
    public function validateInsertToken($email,$token){
        if(count($this->getError())){
            $this->setError("Erro no resgistro de token(1)");
            return false;
        }else{
            if($this->RecuperacaoDeSenha->issetToken($email)){
                
                if(!$this->RecuperacaoDeSenha->deleteToken($email,$token)){
                    $this->setError("Falha no registro token");
                    return false;
                }else{
                    if($this->RecuperacaoDeSenha->insertToken($email,$token)){
                        $this->setMessage("Token criado");
                        return true;
                    }else{
                        $this->setError("Token não criado");
                        return false;
                    }
                }
            }else{
                if($this->RecuperacaoDeSenha->insertToken($email,$token)){
                    
                    $this->setMessage("Token criado");
                    return true;
                }else{
                    
                    $this->setError("Token não criado");
                    return false;
                }
            }
            
        }
        
    }
    
    public function validateIssetToken($email,$token){
        
        if($this->RecuperacaoDeSenha->issetToken($email,$token)){
            return true;
        }else{
            $this->setError("Token não válido");
            return false;
        }
    }
    
    public function validateGetEmail_Token($token){
        $dados=$this->RecuperacaoDeSenha->getEmail($token);
        if($dados['linhas']>0){
            return $dados['dados'];
        }else{
            $this->setError("Erros na busca de dados");
            return false;
        }
    }
    
    public function validateUpdateSenha($email,$senha,$tabela){
        if(count($this->getError())>0){
            $this->setError("Falnha ao atualizar a senha (verifique os dados)");
            return false;
        }else{
            $senha=$this->PasswordHash->passHash($senha);
            if($this->RecuperacaoDeSenha->updateSenha($email,$senha,$tabela)){
                $this->RecuperacaoDeSenha->deleteToken($email,"");
                $this->setMessage("Senha atualizada");
                return true;
            }else{
                $this->setError("Falnha ao atualizar a senha");
                return false;
            }
        }
    }
    
    //Mudar Senha
    public function validateMudarSenha($dados){
        if(count($this->getError())>0){
            $this->setError("Falnha ao atualizar a senha (verifique os dados)");
            return false;
        }else{
            $dados['novaSenha']=$this->PasswordHash->passHash($dados['novaSenha']);
        
            if($this->Perfil->updateSenha($dados)){
                $this->setMessage("Senha atualizada");
                return true;
            }else{
                $this->setError("Falnha ao atualizar a senha");
                return false;
            }
        }
        
    }
    
    //Home
    
    public function validateGetReceitasMensal($dados){
        $receitas = $this->Home->getRecebimentoMes($dados);
        if($receitas['linhas']<=0){
            $this->setError("Sem receitas");
            return false;
        }else{
            return $receitas['dados'];
        }
    }
    
    public function validateGetDespesasMensal($dados){
        $despensas = $this->Home->getPagamentoMes($dados);
        if($despensas['linhas']<=0){
            $this->setError("Sem despesas");
            return false;
        }else{
            return $despensas['dados'];
        }
    }
    
    public function validateGetValorSaldo($dados){
        $recebimento = $this->Home->getRecebimentoTotal($dados);
        if($recebimento['linhas']<=0){
            $recebimentoTotal = 0;
        }else{
            $recebimentoTotal = $recebimento['dados'][0]['RecebimentoTotal'];
        }
        
        $pagamento = $this->Home->getPagamentoTotal($dados);
        if($pagamento['linhas']<=0){
            $pagamentoTotal = 0;
        }else{
            $pagamentoTotal = $pagamento['dados'][0]['PagamentoTotal'];
        }
       
        return ($recebimentoTotal-$pagamentoTotal);
    }
    
    public function validateReceitaAnual($dados){
        $receitaAnual = $this->Home->getReceitaAnual($dados);

        if($receitaAnual['linhas']<=0){
            $this->setError("Falha na busca de receitas Anuais");
            return false;
        }else{
            return $receitaAnual['dados'];
        }
    }
    
    public function validateDespesaAnual($dados){
        
        $pagamentoAnual = $this->Home->getDespesaAnual($dados);
      
        if($pagamentoAnual['linhas']<=0){
            $this->setError("Falha na busca de despesas Anuais");
            return false;
        }else{
            return $pagamentoAnual['dados'];
        }
    }
    
    public function validateLimiteGasto($dados){
        
    }
    
    //Nota Fiscal
    public function validateInsertNotaFiscalServico($dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do arquivo");
            return false;
        }else{
            if($this->NotaFiscal->issetNotaFiscalServico($dados)){
                return false;
            }else{
                if($this->NotaFiscal->insertNotaFiscalServico($dados)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
    } 
    
    public function validateInsertNotaFiscalPrestador($dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do arquivo");
            return false;
        }else{
            if($this->NotaFiscal->issetNotaFiscalPrestador($dados)){
                return false; 
            }else{
                if($this->NotaFiscal->insertNotaFiscalPrestador($dados)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        
    } 
    
    public function validateInsertNotaFiscalTomador($dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do arquivo");
            return false;
        }else{
            if($this->NotaFiscal->issetNotaFiscalTomador($dados)){
                return false;
            }else{
                if($this->NotaFiscal->insertNotaFiscalTomador($dados)){
                    return true;
                }else{
                    return false;
                }
            }
            
        }
        
    } 
    
    public function validateInsertNotaFiscalBruta($dados){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do arquivo");
            return false;
        }else{
            if($this->NotaFiscal->issetNotaFiscalBruta($dados)){
                return false;
            }else{
                if($this->NotaFiscal->insertNotaFiscalBruta($dados)){return true;}else{return false;}
            }
        }
        
    } 
    
    
    //Lacamentos
    
    #Valida o upload do arquivo
    public function validadeUploadDir($File,$Dir, $Grupo=null){
        
        if(count($this->getError())>0){
            $this->setError("Falha no upload");
            return false;
        }

        if($Grupo!=null){
            $grupo = $Grupo;
        }else{
            $grupo = mt_rand(111111111111111,999999999999999);
        }
        
        //$dados_return = [];
        for($i=0;$i<=(count($File['tmp_name'])-1);$i++){
            $idArquivo = md5(uniqid(rand(1000,9999),true));
            $uniqid = uniqid();
            $extensao = strtolower(pathinfo($File['name'][$i], PATHINFO_EXTENSION));
            $url = DIRPAGE.$Dir.$uniqid.".".$extensao;
            $path = DIRREQ.$Dir.$uniqid.".".$extensao;

            $moverArquivo = move_uploaded_file($File['tmp_name'][$i],$path);
        
            if(!$moverArquivo){
                $this->setError("Falha no upload");
                return false;   
            }

            $resul = $this->Lancamento->insertUpload([
                "IdArquivo"=>$idArquivo,
                "URL"=>$url,
                "Caminho"=>$path,
                "Extensao"=>$extensao,
                "Nome"=>$File['name'][$i],
                "Uniqid"=>$uniqid,
                "Grupo"=>$grupo
            ]);

            if($resul["linhas"]<=0){
                $this->setError("Falha no upload");
                return false; 
            }
        }

        return $resul["dados"];
    }
    
    #Tipo Juridico 
    public function validateTipoJuri($CNPJ){
        $var=$this->Lancamento->tipoJuri($CNPJ);
        if($var["linhas"]<=0){
            $this->setError("Não foi possível realizar a conexão");
            return false;
        }else if($var["linhas"]>0){return $var["dados"];}
    }
    
    #Valida a associação de PJ com PF 
    public function validateGetAssociacao($Param){
        if($this->validateCPF($Param)){
            if($this->validateIssetCPF($Param,"verificar")){
                if(!$var=$this->Lancamento->getAssociacao($Param)){
                    $this->setError("Informação não encontrada");
                    return array();
                }else{return $var;}
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    #Valida historios
    public function validateGetHistoricos($dados=null){
        if($dados!==null){
            return $this->Lancamento->historicos($dados); 
        }else{
            return $this->Lancamento->historicos(); 
        }
    }

    function validateGetGrupoLancamento($dados){
        if(count($this->getError())>0){
            $this->setError("Sem grupos");
            return false;
        }else{
            $res = $this->Perfil->getGrupo($dados);
            if($res['linhas']<=0){
                $this->setError("Sem grupos");
                return false;
            }else{
                return $res['dados'];
            }
        }
    }
    public function validateGetSubGrupo($dados){
        if(count($this->getError())>0){
            $this->setError("Sem SubGrupos");
            return false;
        }else{
            
            $res = $this->Perfil->getContasContabil($dados['cnpj'],$dados['idGrupo']);
            //exit(json_encode($res));
            if($res['linhas']<=0){
                $this->setError("Sem SubGrupos");
                return false;
            }else{
                return $res['dados'];
            }
        }
    }
    
    #Validas contas
    public function validateGetContas($ID){

        $contas=$this->Lancamento->getContas($ID);
        if($contas['linhas']<=0){
            $this->setError("Não há contas");
            return false;
        }else{return $contas;}

        /*if($this->validateCPF($ID)){
            if($this->validateIssetCPF($ID,"verificar")){
                
            }else{
                $this->setError("CPF não existente");
                return false;
            }
        }else{
            $this->setError("CPF não válido");
            return false;
        }*/
    }
    
    #Valida o registro de contas bancarias
    public function validateRegistroDeConta($Dados){
            if(count($this->getError())>0){
                $this->setError("Falha no registro");
                return false;
            }else{
                //exit(json_encode($Dados));
                if($this->Lancamento->issetConta($Dados)['linhas']>0){
                    $this->setError("Conta já existente");
                    return false;
                }else{
                    if($this->Lancamento->insertConta($Dados)['linhas']<=0){
                        $this->setError("Falha no registro");
                        return false;
                    }else{
                        $this->setMessage("Registro de conta feito");
                        return true;
                    }
                }
                
            }
    }
    
    #Pega os tipo de Pagamento
    public function getTiposDePagamento(){return $this->Lancamento->getTipoDePagamento();}
    
    /*Pagamento*/
    #Valida o resgitro de pagamneto
    public function validateRegistroDePagamento($Dados){
       
        if(count($this->getError())>0){
            $this->setError("Falha no registro");
            return false;
        }else{

            /*if(!empty($Dados['Nota'])){
                if(!$Dados['Parcelas']){
                    if($this->Lancamento->issetPagamento($Dados)){
                        $this->setError("Registro já existente");
                        return false;
                    }
                }
            }*/
            
            if($this->Lancamento->insertPagamento($Dados)<=0){
                $this->setError("Falha no registro");
                return false;
            }else{
                $this->setMessage("Registro de pagamento feito");
                $result=$this->GestaoDeConselho->getConselheiros($Dados['PJ']);
                if($result['linhas']<=0){
                    return true;
                }else{
                    foreach ($result['dados'] as $array){
                        $this->GestaoDeConselho->insertAprovacao(
                            [
                                "ID" => md5(uniqid(rand(1000,9999),true)),
                                "IdTabela" => $Dados['IdRegistro'],
                                "cnpj" => $Dados['PJ'],
                                'cpf' => $array['CPF'],
                                "status" => 0
                            ],
                            "Pagamento"
                        );
                    }
                    return true;
                }
            }   
            
        }
        
            
    }
        
    /*Recebimento*/
    #Valida o registro do recebimento
    public function validateRegistroDeRecebimento($Dados){
        
        if(count($this->getError())>0){
            $this->setError("Falha no Registro");
            return false;
        }else{
            //$result=$this->GestaoDeConselho->getConselheiros($Dados['PJ']);
            //exit(json_encode(array('resultado'=>$result['dados'])));
            if($this->Lancamento->insertRecebimento($Dados)<=0){
                $this->setError("Falha no registro de recebimento");
                return false;
            }else{
                $this->setMessage("Registro de recebimento feito");
                $result=$this->GestaoDeConselho->getConselheiros($Dados['PJ']);
                if($result['linhas']<=0){
                    return true;
                }else{
                    foreach ($result['dados'] as $array){
                        $this->GestaoDeConselho->insertAprovacao(
                            [
                                "ID" => md5(uniqid(rand(1000,9999),true)),
                                "IdTabela" => $Dados['IdRegistro'],
                                "cnpj" => $Dados['PJ'],
                                'cpf' => $array['CPF'],
                                "status" => 0
                            ],
                            "Recebimento"
                        );
                    }
                    return true;
                }
            }
        }
        
        
        
    }
    
    /*Nota*/
    #Valida o registro de nota
    public function validateRegistroDeNota($Dados){
        
        if(count($this->getError())>0){
            $this->setError("Falha no registro");
            return false;
        }else{
            if(!$this->Lancamento->issetNota($Dados)){
                $this->setError("Registro já existente");
                return false;
            }else{
                if($this->Lancamento->insertNota($Dados)<=0){
                    $this->setError("Falha no registro");
                    return false;
                }else{
                    $this->setMessage("Registro feito");
                    return true;
                }   
            }
        }
        
        
    }
    
    /*Contrato*/
    #Valida o registro de contrato
    public function validateRegistroDeContrato($Dados){
        
        if(count($this->getError())>0){
            $this->setError("Falha no registro");
            return false;
        }else{
            if(!$this->Lancamento->issetContrato($Dados)){
                $this->setError("Registro já existente");
                return false;
            }else{
                
                if($this->Lancamento->insertContrato($Dados)<=0){
                    $this->setError("Falha no registro1");
                    return false;
                }else{
                    $this->setMessage("Registro feito");
                    return true;
                }   
            }
        }
        
    }
    
    //Tabelas
    public function validateGetPermissao($dados){
        if(count($this->getError())>0){
            $this->setError("Falha na busca de dados");
            return false;
        }else{
            $b=$this->Tabelas->getPermissao($dados);
            if($b['linhas']<=0){
                return false;
            }else{
                return $b['dados'];
            }
        }
    }
    /*Pagamento*/
    #Valida a busca de dados na tabela Pagamento
    
    public function validateGetPagamento(array $dados){
       if(count($this->getError())>0){
            $this->setError("Falha na busca de dados");
            return false;
        }else{
        
            if($dados['TipoCliente']=="PF"){
                $pagamento=$this->Tabelas->getPagamento($dados);
                
                if(!($pagamento['linhas']>0)){
                    $this->setError("Não há registros");
                    return false; 
                }else{
                    foreach($pagamento['dados'] as $key => $value){
                        if(!empty($value['GrupoComprovante'])){
                            $returnArquivos = $this->Tabelas->getArquivoByGrupo($value['GrupoComprovante']);
                            if($returnArquivos['linhas']>0){
                                $pagamento['dados'][$key]+=["arquivos"=>$returnArquivos['dados']];
                            }
                        }else{
                            $pagamento['dados'][$key]+=["arquivos"=>[]]; 
                        }
                    }
                    return $pagamento['dados'];
                }
                
            }else if($dados['TipoCliente']=="PJ"){
                
                $pagamento = $this->Tabelas->getPagamento($dados);

                
                if(($pagamento['linhas']>0)){

                    foreach($pagamento['dados'] as $key => $value){
                        if(!empty($value['GrupoComprovante'])){
                            $returnArquivos = $this->Tabelas->getArquivoByGrupo($value['GrupoComprovante']);
                            if($returnArquivos['linhas']>0){
                                $pagamento['dados'][$key]+=["arquivos"=>$returnArquivos['dados']];
                            }
                        }else{
                            $pagamento['dados'][$key]+=["arquivos"=>[]]; 
                        }
                    }
                    
                    $conselheiros=$this->GestaoDeConselho->getConselheirosVotacao($dados['Id'],"Pagamento");

                    if($conselheiros['linhas']>0){
                        for($y=0;$y<=(count($pagamento['dados'])-1);$y++){
                            for($i=0;$i<=(count($conselheiros['dados'])-1);$i++){
                                if($pagamento['dados'][$y]['ID']==$conselheiros['dados'][$i]['IdPagamento']){
                                    
                                    $cpf=preg_replace("/[^0-9]/", "", $conselheiros['dados'][$i]['CPF']);
                                    //exit(json_encode($conselheiros['dados'][$i]));
                                    array_push($pagamento['dados'][$y], [
                                        'IdPagamento'=>$conselheiros['dados'][$i]['IdPagamento'],
                                        'Status'=>$conselheiros['dados'][$i]['Status'],
                                        'IdStatus'=>$conselheiros['dados'][$i]['IdStatus'],
                                        'NomePF'=>$conselheiros['dados'][$i]['NomePF'],
                                        'CPF'=>$conselheiros['dados'][$i]['CPF']
                                    ]);
                                }
                            }
                        }
                    }
                    return $pagamento['dados'];
                }else{
                    $this->setError("Não há registros");
                    return false;
                }
                
            }else{
                $this->setError("Cliente inválido");
                return false;
            }
        }
        
    }
    
    #Valida a exclusão dos dados na tabela Pagamento
    public function validateDeletePagamento(array $ID=[]){
        if(count($this->getError())>0){
            $this->setError("Erro na exclusão de dados (Verifique os dados corretamente)");
            return false;
        }else{
            
            $apagados=0;
            $nApagados=0;
            foreach($ID as $key => $value){
                
                $arquivo=$this->Tabelas->getCaminhoDoArquivo_Pagemento($value);
                
                if($arquivo['linhas']<=0){
                    $this->Tabelas->deletePagamento($value) ? $apagados++ : $nApagados++;
                }else{
                    
                    if(file_exists($arquivo['dados']['Caminho'])){
                        if(!unlink($arquivo['dados']['Caminho'])){
                            $this->setError("Arquivo não excluido");
                            return false;
                        }else{
                            $this->Tabelas->deletePagamento($value) ? $apagados++ : $nApagados++;
                            $this->Tabelas->deleteArquivo($arquivo['dados']['ID']);
                        }
                    }else{
                        $this->Tabelas->deletePagamento($value) ? $apagados++ : $nApagados++;
                        $this->Tabelas->deleteArquivo($arquivo['dados']['ID']);
                    }
                }
                
            }
            
            return [
                "apagados"=>$apagados,
                "nApagados"=>$nApagados
            ];
        }
        
    }

    #Valida a atualização de dados na tabela de Pagamento
    public function validateUpdatePagamento(array $dados=[]){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }else{

            $query = $this->Tabelas->getPagamentoById([
                'id'=>$dados['IdPagamento'],
                'cnpj'=>$dados['PJ']
            ]);

            if($query['linhas']<=0){
                $this->setError("Sem pagamento");
                return false;
            }

            //exit(json_encode($query));

            if(!empty($query['dados']['idComprovante'])){

                $retorno = $this->Tabelas->getArquivoLancamentoById($query['dados']['idComprovante']);

                if($retorno['linhas']<=0){
                    $this->setError("Sem comprovante registrado");
                    return false;
                }

                //exit(json_encode($retorno));

                self::validate_Substituicao_Arquivo([
                    "arquivo"=>$dados['Comprovante'],
                    "dados_comprovante"=>$retorno['dados'],
                    "caminho"=>"public/img/lancamentos/pagamentos/"
                ]);

            }else{
                
                $returnUpload = self::validadeUploadDir($dados['Comprovante'],
                "public/img/lancamentos/pagamentos/");
                //exit(json_encode($returnUpload));
                if(!is_array($returnUpload)){
                    $this->setError("Upload não realizado");
                    return false;
                }
                $dados += ["IdComprovante"=>$returnUpload['str_id_LancamentosArquivos']];

            }

            $return = $this->Tabelas->updatePagamento($dados);
            //exit(json_encode($return));
            if(!$return){
                $this->setError("Dados não atualizados");
                return false;
            }else{
                $this->setMessage("Dados atualizados");
                return true;
            }
        }
    }

    private function validate_Substituicao_Arquivo(array $dados){
        if($dados['arquivo']['error']!=0 || count($this->getError())>0){
            $this->setError("Falha no upload");
            return false;
        }else{
            
    	    //$idArquivo=$dados['dados_comprovante']['id'];
            
    	    $uniqid_old = $dados['dados_comprovante']['uniqid'];
            $uniqid_new = uniqid();

    	    $extensao_new = strtolower(pathinfo($dados['arquivo']['full_path'], PATHINFO_EXTENSION));
            $extensao_old = $dados['dados_comprovante']['extensao'];
            //exit(json_encode(file_exists(DIRREQ.$dados['caminho'].$uniqid.".".$extensao)));
            if($extensao_new != $extensao_old){
                //exit(json_encode(file_exists(DIRREQ.$dados['caminho'].$uniqid.".".$extensao)));
                if(!file_exists($dados['dados_comprovante']['path'])){
                    $this->setError("Arquivo não existente");
                    return false;   
                }
                if(!unlink($dados['dados_comprovante']['path'])){
                    $this->setError("Arquivo não excluido");
                    return false;
                }
                //$extesao = $dados['dados_comprovante']['extensao'];
            }
            //exit(json_encode($dados['caminho']));
            $url=DIRPAGE.$dados['caminho'].$uniqid_new.".".$extensao_new;
            $path=DIRREQ.$dados['caminho'].$uniqid_new.".".$extensao_new;
    	    
            $moverArquivo = move_uploaded_file($dados['arquivo']['tmp_name'],$path);
            
            if(!$moverArquivo){
                $this->setError("Arquivo não alterado");
                return false;
            }

            $return = $this->Tabelas->updateArquivo([
                "id"=>$dados['dados_comprovante']['id'],
                "url"=>$url,
                "path"=>$path,
                "extensao_new"=>$extensao_new,
                "uniqid_old"=>$uniqid_old,
                "uniqid_new"=>$uniqid_new,
                "nome"=>$dados['arquivo']['name']
            ]);

            if(!$return){
                $this->setError("Arquivo não atualizado");
                return false;
            }else{
                return true;
            }
    	}
    }
    
    /*Recebimento*/
    #Valida a busca de dados na tabela de Recebimento
    public function validateGetRecebimento($ID,$TipoJuri,$TipoPermissao=null,$Empresa=null){

        if(count($this->getError())>0){
            $this->setError("Erro na busca de dados (Verifique os dados)");
            return false;
        }else{
            
            if($TipoJuri=="PF"){
                $recebimento=$this->Tabelas->getRecebimento($ID,$TipoJuri,$TipoPermissao,$Empresa);
                
                if(($recebimento['linhas']>0)){
                    foreach($recebimento['dados'] as $key => $value){
                        if(!empty($value['GrupoComprovante'])){
                            $returnArquivos = $this->Tabelas->getArquivoByGrupo($value['GrupoComprovante']);
                            if($returnArquivos['linhas']>0){
                                $recebimento['dados'][$key]+=["arquivos"=>$returnArquivos['dados']];
                            }
                        }else{
                            $recebimento['dados'][$key]+=["arquivos"=>[]]; 
                        }
                    }
                    return $recebimento['dados'];
                }else{
                    $this->setError("Não há registros de recebimento");
                    return false;
                }
            }else if($TipoJuri=="PJ"){
                
               
                $recebimento=$this->Tabelas->getRecebimento($ID,$TipoJuri);
                
                if(($recebimento['linhas']>0)){

                    foreach($recebimento['dados'] as $key => $value){
                        if(!empty($value['GrupoComprovante'])){
                            $returnArquivos = $this->Tabelas->getArquivoByGrupo($value['GrupoComprovante']);
                            if($returnArquivos['linhas']>0){
                                $recebimento['dados'][$key]+=["arquivos"=>$returnArquivos['dados']];
                            }
                        }else{
                            $recebimento['dados'][$key]+=["arquivos"=>[]]; 
                        }
                    }
                    
                    $conselheiros=$this->GestaoDeConselho->getConselheirosVotacao($ID,"Recebimento");

                    if($conselheiros['linhas']>0){
                        for($y=0;$y<=(count($recebimento['dados'])-1);$y++){
                            for($i=0;$i<=(count($conselheiros['dados'])-1);$i++){
                                if($recebimento['dados'][$y]['ID']==$conselheiros['dados'][$i]['IdRecebimento']){
                                    
                                    $cpf=preg_replace("/[^0-9]/", "", $conselheiros['dados'][$i]['CPF']);
                                    array_push($recebimento['dados'][$y], [
                                        'IdRecebimento'=>$conselheiros['dados'][$i]['IdRecebimento'],
                                        'Status'=>$conselheiros['dados'][$i]['Status'],
                                        'IdStatus'=>$conselheiros['dados'][$i]['IdStatus'],
                                        'NomePF'=>$conselheiros['dados'][$i]['NomePF'],
                                        'CPF'=>$conselheiros['dados'][$i]['CPF']
                                    ]);
                                }
                            }
                        }
                    }
                    
                    return $recebimento['dados'];
                }else{
                    $this->setError("Falha na transição de dados");
                    return false;
                }
               
                
            }else{
                $this->setError("Cliente inválido");
                return false;
            }
        }
    }

    #Valida a atualização de dados na tabela de Recebimento
    public function validateUpdateRecebimento(array $dados=[]){
        if(count($this->getError())>0){
            $this->setError("Verifique os dados do formulário");
            return false;
        }else{
            $return = $this->Tabelas->updateRecebimento($dados);
            if($return['linhas']<=0){
                $this->setError("Dados não atualizados");
                return false;
            }else{
                $this->setMessage("Dados atualizados");
                return true;
            }
        }
    }

    #Valida a exclusão dos dados na tabela de Recebimento
    public function validateDeleteRecebimento($ID){
        if(count($this->getError())>0){
            $this->setError("Erro na exclusão de dados (Verifique os dados corretamente)");
            return false;
        }else{
            
            $apagados=0;
            $nApagados=0;
            
            foreach($ID as $key => $value){
                
                $arquivo=$this->Tabelas->getCaminhoDoArquivo_Recebimento($value);
                
                if($arquivo['linhas']<=0){
                    $this->Tabelas->deleteRecebimento($value) ? $apagados++ : $nApagados++;
                }else{
                    if(file_exists($arquivo['Caminho'])){
                        if(!unlink($arquivo['Caminho'])){
                            $this->setError("Arquivo não excluido");
                            return false;
                        }else{
                            $this->Tabelas->deleteRecebimento($value) ? $apagados++ : $nApagados++;
                            $this->Tabelas->deleteArquivo($arquivo['ID']);
                        }
                    }else{
                        $this->Tabelas->deleteRecebimento($value) ? $apagados++ : $nApagados++;
                        $this->Tabelas->deleteArquivo($arquivo['ID']);
                    }
                }
                
            }
            
            return [
                "apagados"=>$apagados,
                "nApagados"=>$nApagados
            ];
        }
        
    }

    public function validateAdicionarArquivo_Recebimento(array $dados){
        //exit(json_encode($dados));
        if($dados['IdGrupoComprovante']!=null){
            //exit(json_encode("Primeiro caso"));
            $returnUpload = self::validadeUploadDir($dados['Comprovante'],
            "public/img/lancamentos/pagamentos/", $dados["IdGrupoComprovante"]);
            //exit(json_encode($returnUpload));
            if(!is_array($returnUpload)){
                $this->setError("Upload não realizado");
                return false;
            }else{
                return true;
            }
        }else{
            //exit(json_encode("Segundo caso"));
            $returnUpload = self::validadeUploadDir($dados['Comprovante'],
            "public/img/lancamentos/pagamentos/", mt_rand(111111111111111,999999999999999));
            //exit(json_encode($returnUpload));
            if(!is_array($returnUpload)){
                $this->setError("Upload não realizado");
                return false;
            }
            $dados += ["IdComprovante"=>$returnUpload['str_id_LancamentosArquivos']];
            $dados["IdGrupoComprovante"] = $returnUpload['str_grupo_LancamentosArquivos'];

            //exit(json_encode($dados));

            $return = $this->Tabelas->updateArquivoRecebimento($dados);

            if(!$return){
                $this->setError("Arquivo não atualizado");
                return false;
            }else{
                $this->setMessage("Arquivo atualizado");
                return true;
            }
        }
        
        
    }
    
    /*Nota*/
    #Valida a busca de dados na tabela de Nota
    public function validateGetNota($ID,$TipoJuri,$TipoPermissao=null,$Empresa=null){
        if($TipoJuri=="PF"){
            $pagamento=$this->Tabelas->getNota($ID,$TipoJuri,$TipoPermissao,$Empresa);
            if($pagamento['linhas']<0){
                $this->setError("Falha na transição de dados");
                return false;
            }else{return $pagamento['dados'];}
        }else if($TipoJuri=="PJ"){
            
            if(empty($Empresa)){
                $pagamento=$this->Tabelas->getNota($ID,$TipoJuri);
                if($pagamento['linhas']<0){
                    $this->setError("Falha na transição de dados");
                    return false;
                }else{return $pagamento['dados'];}
                
            }else{
                // $pagamento=$this->Tabelas->getPagamento($ID,$TipoJuri,$Tabela);
                // $tipoPag=$this->Lancamento->getTipoDePagamento();
                
                // $pagNum=count($pagamento['dados']);
                // $tipoPagNum=count($tipoPag['dados']);
                // if(($tipoPag['linhas']>0) && ($pagamento['linhas']>0)){
                //     for($i=0;$i<=$pagNum-1;$i++){
                //         for($x=0;$x<=$tipoPagNum-1;$x++){
                //             $idBanco=$pagamento['dados'][$i]['int_idBanco_Contas'];
                //             $idTipoPag=$tipoPag['dados'][$x]['int_id_TiposDePagamento'];
                //             if($idBanco==$idTipoPag){
                //                 $pagamento['dados'][$i]['int_idBanco_Contas']=$tipoPag['dados'][$x]['str_nome_TiposDePagamento'];
                //             }
                //             $idBanco=$pagamento['dados'][$i][4];
                //             $idTipoPag=$tipoPag['dados'][$x][0];
                //             if($idBanco==$idTipoPag){
                //                 $pagamento['dados'][$i][4]=$tipoPag['dados'][$x][1];
                //             }
                //         }
                //     }
                //     return $pagamento['dados'];
                // }else{
                //     $this->setError("Falha na transição de dados");
                //     return false;
                // }
            }
            
        }else{
            $this->setError("Cliente inválido");
            return false;
        }
    }
    
    #Valida a exclusão dos dados na tabela de Nota
    public function validateDeleteNota($ID){
        if(count($this->getError())>0){
            $this->setError("Erro na exclusão de dados (Verifique os dados corretamente)");
            return false;
        }else{
            
            $apagados=0;
            $nApagados=0;
            
            foreach($ID as $key => $value){
                
                $arquivo=$this->Tabelas->getCaminhoDoArquivo_Nota($value);
                
                if(empty($arquivo)){
                    $this->Tabelas->deleteNota($value) ? $apagados++ : $nApagados++;
                }else{
                    if(file_exists($arquivo['str_path_LancamentosArquivos'])){
                        if(!unlink($arquivo['str_path_LancamentosArquivos'])){
                            $this->setError("Arquivo não excluido");
                            return false;
                        }else{
                            $this->Tabelas->deleteNota($value) ? $apagados++ : $nApagados++;
                            $this->Tabelas->deleteArquivo($arquivo['str_id_LancamentosArquivos']);
                        }
                    }else{
                        $this->Tabelas->deleteNota($value) ? $apagados++ : $nApagados++;
                        $this->Tabelas->deleteArquivo($arquivo['str_id_LancamentosArquivos']);
                    }
                }
                
            }
            
            return [
                "apagados"=>$apagados,
                "nApagados"=>$nApagados
            ];
        }
        
    }
    
    /*Contrato*/
    #Valida a busca de dados na tabela de Contrato
    public function validateGetContrato($ID,$TipoJuri,$TipoPermissao=null,$Empresa=null){
        
        if($TipoJuri=="PF"){
            $pagamento=$this->Tabelas->getContrato($ID,$TipoJuri,$TipoPermissao,$Empresa);
            
            if(($pagamento['linhas']>0)){
                return $pagamento['dados'];
            }else{
                $this->setError("Falha na transição de dados");
                return false;
            }
        }else if($TipoJuri=="PJ"){
            
            if(empty($Empresa)){
                $pagamento=$this->Tabelas->getContrato($ID,$TipoJuri);
                
                if(($pagamento['linhas']>0)){
                    return $pagamento['dados'];
                }else{
                    $this->setError("Falha na transição de dados");
                    return false;
                }
                
            }else{
                // $pagamento=$this->Tabelas->getPagamento($ID,$TipoJuri,$Tabela);
                // $tipoPag=$this->Lancamento->getTipoDePagamento();
                
                // $pagNum=count($pagamento['dados']);
                // $tipoPagNum=count($tipoPag['dados']);
                // if(($tipoPag['linhas']>0) && ($pagamento['linhas']>0)){
                //     for($i=0;$i<=$pagNum-1;$i++){
                //         for($x=0;$x<=$tipoPagNum-1;$x++){
                //             $idBanco=$pagamento['dados'][$i]['int_idBanco_Contas'];
                //             $idTipoPag=$tipoPag['dados'][$x]['int_id_TiposDePagamento'];
                //             if($idBanco==$idTipoPag){
                //                 $pagamento['dados'][$i]['int_idBanco_Contas']=$tipoPag['dados'][$x]['str_nome_TiposDePagamento'];
                //             }
                //             $idBanco=$pagamento['dados'][$i][4];
                //             $idTipoPag=$tipoPag['dados'][$x][0];
                //             if($idBanco==$idTipoPag){
                //                 $pagamento['dados'][$i][4]=$tipoPag['dados'][$x][1];
                //             }
                //         }
                //     }
                //     return $pagamento['dados'];
                // }else{
                //     $this->setError("Falha na transição de dados");
                //     return false;
                // }
            }
            
        }else{
            $this->setError("Cliente inválido");
            return false;
        }
        
    }
    
    #Valida a exclusão dos dados na tabela de Nota
    public function validateDeleteContrato($ID){
        if(count($this->getError())>0){
            $this->setError("Erro na exclusão de dados (Verifique os dados corretamente)");
            return false;
        }else{
            
            $apagados=0;
            $nApagados=0;
            
            foreach($ID as $key => $value){
                
                $arquivo=$this->Tabelas->getCaminhoDoArquivo_Contrato($value);
                
                if(empty($arquivo)){
                    $this->Tabelas->deleteContrato($value) ? $apagados++ : $nApagados++;
                }else{
                    if(file_exists($arquivo['str_path_LancamentosArquivos'])){
                        if(!unlink($arquivo['str_path_LancamentosArquivos'])){
                            $this->setError("Arquivo não excluido");
                            return false;
                        }else{
                            $this->Tabelas->deleteContrato($value) ? $apagados++ : $nApagados++;
                            $this->Tabelas->deleteArquivo($arquivo['str_id_LancamentosArquivos']);
                        }
                    }else{
                        $this->Tabelas->deleteContrato($value) ? $apagados++ : $nApagados++;
                        $this->Tabelas->deleteArquivo($arquivo['str_id_LancamentosArquivos']);
                    }
                }
                
            }
            
            return [
                "apagados"=>$apagados,
                "nApagados"=>$nApagados
            ];
        }
        
    }
    
    //Gestão de Usuários
    #Busca o CPF usando o E-mail
    public function getCPF_Email($email){
        $b=$this->GestaoDeUsuarios->getCPF_Email($email);
        if($b['linhas']<=0){
            return false;
        }else{return $b['dados'];}
        
    }
    
    public function validateGetPermissoes(){
        
        $permissao=$this->GestaoDeUsuarios->getPermissoes();
        if($permissao['linhas']<=0){
            $this->setError('Falnha na buasca de dados(Permissão)');
            return false;
        }else{
            return $permissao['dados'];
        }
        
    }
    
    public function validadeGetAssociados($cnpj){
        if($this->validateCNPJ($cnpj) && $this->validateIssetCNPJ($cnpj,"validar existencia")){
            $assoc=$this->GestaoDeUsuarios->getAssociados($cnpj);
            if($assoc['linhas']<=0){
                $this->setError("Não há usuários afiliados a você");
                return false;
            }else{
                return $assoc['dados'];
            }
        }else{
            $this->setError("Falha na busca de dados");
            return false;
        }
    }
    
    public function validateInsertAssociados_PF($dados){
         if(count($this->getError())>0){
            $this->setError("Cadastro não efetuado (verefique os dados)");
            return false;
        }else{
           
            if(!$this->Cadastro->insertTokenConfirmaCad($dados)){
                $this->setError("Cadastro não realizado(Token não registrado)");
                return false;
            }else{
                $dados['Senha'] = $this->PasswordHash->passHash($dados['Senha']);
                if($this->GestaoDeUsuarios->validateInsertPF($dados)){
                    $this->setMessage("Cadastro feito");
                    return true;
                }else{
                    $this->setError("Cadastro não realizado");
                    return false;
                }
            }
        }
        
    }
    
    public function validateInsertAssociados($Dados){
        if(count($this->getError())>0){
            $this->setError("Falha no registro(Verifique os dados inseridos)");
            return false;
        }else{
            
            $id = (int)$Dados['permissao'];
            
            if($id==948880538 || $id==147031419){
                
                $regras = $this->GestaoDeConselho->getNumConselheirosNaRegra($Dados['empresa']);
                $conselehiros = $this->GestaoDeConselho->getConselheiros($Dados['empresa']);
                
                if($regras['linhas']<=0){
                    $this->setError("Construa uma regra de conselho antes de adicionar os membros");
                    return false;
                }else{
                    $numeroMax = $regras['dados'][0]['NumMaxCon'];
                    $conselheirosNum = count($conselehiros['dados']);
                    
                    if($conselheirosNum>=$numeroMax){
                        $this->setError("Numero máximo de conselheiros atingido");
                        return false;
                    }else{
                        if($this->GestaoDeUsuarios->insertAssociado($Dados)<=0){
                            $this->setError("Falha no registro");
                            return false;
                        }else{
                            $this->setMessage("Registro feito");
                            return true;
                        }
                    }
                }
                
            }else{
                
                if($this->GestaoDeUsuarios->insertAssociado($Dados)<=0){
                    $this->setError("Falha no registro");
                    return false;
                }else{
                    $this->setMessage("Registro feito");
                    return true;
                }
                
            }
        }
    }
    
    public function validategetNumConselheirosNaRegra($dados){
        if(count($this->getError())>0){
            $this->setError('Verifique os dados');
            return false;
        }else{
            $regras = $this->GestaoDeConselho->getNumConselheirosNaRegra($dados['empresa']);
            if($regras['linhas']<=0){
                return false;
            }else{
                return $regras['dados'][0];
            }
        }
    }
    
    public function validateIssetAssociado($dados){
        //exit(json_encode($dados));
        if(count($this->getError())>0){
            $this->setError('Verifique os dados');
            return false;
        }else{
            if($this->GestaoDeUsuarios->issetAssociado($dados)['linhas']>0){
                return true;
            }else{
                return false;
            }   
        }
        
    }
    
    public function validatePermissaoAssociado($dados){
        if(($this->GestaoDeUsuarios->issetAssociado($dados)['dados']['int_permissao_Associados']) == ($dados['permissao'])){
            $this->setError("Alteração não feita");
            return false;
        }else{return true;}
    }
    
    public function validateUpdateAssociado($dados){
        
        if($this->GestaoDeUsuarios->updateAssociado($dados)>0){
            $this->setMessage("Atualização feita");
            return true;
        }else{
            $this->setError("Atualização não feita");
            return false;
        }
    }
    
    public function validateDeleteAssociados($dados){
        $excluidos=0;
        $nExcluidos=0;

        foreach($dados as $key => $value){
            
            if($this->GestaoDeUsuarios->deleteAssociados($value)<=0){
                $excluidos++;
            }else{
                $nExcluidos++;
            }
        }
        
        return [
            "excluidos"=>$excluidos,
            "nExcluidos"=>$nExcluidos
        ];
        
    }
    
    //Gestão de Conselho Fiscal
    public function validateIssetRegrasConselho($cnpj){
        $result=$this->GestaoDeConselho->issetRegra($cnpj);
        return $result<=0?false:true; 
    }
    
    public function validateInsertRegrasConselho($dados){
        if(count($this->getError())>0){
            return false;
        }else{
            
            $result=$this->GestaoDeConselho->insertRegra($dados);
            $result = $result<=0?false:true; 
            
            if($result){
                $this->setMessage("Registro feito");
                return $result;
            }else{
                $this->setError("Falha no registro");
                return $result;
            }
        }
    }
    
    public function validateUpdateRegrasConselho($dados){
        if(count($this->getError())>0){
            return false;   
        }else{
            $result=$this->GestaoDeConselho->updateRegra($dados);
            $result = $result<=0?false:true;
            
            if($result){
                $this->setMessage("Atualização feita");
                return $result;
            }else{
                $this->setError("Falha na atualização");
                return $result;
            }
        }
        
    }
    
    public function validateAprovaConselho($dados,$tabela){
        if(count($this->getError())>0){
            $this->setError("Falha na aprovação (Algumns dados estão incorretos)");
            return false;
        }else{
            $cnpj=$this->GestaoDeConselho->getCNPJ_IdTabela($dados['IdTabela'],$tabela);
            $dados["cnpj"]=$cnpj['dados']['str_empresa_'.$tabela];
            $c=$this->GestaoDeConselho->issetAprovacao($dados,$tabela);
            
            if($c<=0){
                $result=$this->GestaoDeConselho->insertAprovacao($dados,$tabela);
            }else{
                $result=$this->GestaoDeConselho->updateAprovacao($dados,$tabela);
            }
            
            
            if($result<=0){
                return ["nAprovado"=>1];
            }else{
                return ["Aprovado"=>1];
            }
            
        }
    }
    
    public function validateGetVotacaoConselho($dados,$tabela){
        $dados=$this->GestaoDeConselho->getVotacaoConselheiros($dados,$tabela);
        if($dados['linhas']>0){
            return $dados['dados'];
        }else{
            $this->setError("Erro na consulta de dados");
            return false;
        }
    }
    
    public function validateGetConselheiros($ID){
        $dados=$this->GestaoDeConselho->getConselheiros($ID);
        if($dados['linhas']<=0){
            $this->setError("Erro na busca de dados(Conselho)");
            return false;
        }else{
            return $dados['dados'];
        }
    }
    
    //Sem conexão
    
    #Validador de data
    public function validateFilds($Param){
        
        $i=false;
        foreach($Param as $Key => $Value){
            if(empty($Value)){$i=true;}
        }
        
        if($i){
            $this->setError("Preencha todos os campos");
            return false;
        }else{return true;}
        
    }
    
    #Valida o arquivo
    public function validateArquivo($File,$Extensao,$Tamanho=null){

        if(count($this->getError())>0){
            return false;
        }

        if(!isset($File['error']) || !is_array($File['error'])){
            $this->setError("Envie um arquivo");
            return false;
        }

        for($i=0;$i<=(count($File['error'])-1);$i++){
            if($File['error'][$i]!=0){
                $this->setError("Erro no arquivo: ".$File['name'][$i]);
                return false;
            }
        }

        $return=false;
            
        if($Tamanho!=null){
            for($i=0;$i<=(count($File['size'])-1);$i++){
                if($File['size'][$i] > $Tamanho){
                    $this->setError("Arquivo muito grande");
                    return false;
                }
            } 
        }    
        
        if(!is_array($Extensao)){
            $this->setError("Extensões não definidas");
            return false;
        }

        for($i=0;$i<=(count($File['name'])-1);$i++){
            $extensao = strtolower(pathinfo($File['name'][$i], PATHINFO_EXTENSION));
            foreach($Extensao as $key => $value){if($Extensao[$key]==$extensao){$return=true;}}
            if($return==false){$this->setError("Extensão de arquivo não permitida para o arquivo: ".$File['name'][$i]);}
        }
        
        return $return;
        
    }

    #Validador de e-mail
    public function validateEmail($Param){
        if(filter_var($Param,FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            $this->setError("E-mail inválido");
            return false;
        }
    }
    
    #Validador de data
    public function validateData($Param, $format=null){
        if($format==null){$format='Y-m-d';}
        $Date=\DateTime::createFromFormat($format,$Param);
        if(($Date) && ($Date->format($format)===$Param)){
            return true;
        }else{
            $this->setError("Data inválida");
            return false;
        }
    }
    
    #Validador de CPF
    public function validateCPF($Param){
        
        // Extrai somente os números
        $Param = preg_replace( '/[^0-9]/is', '', $Param );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($Param) != 11) {
            $this->setError("CPF inválido");
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $Param)) {
            $this->setError("CPF inválido");
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $Param[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($Param[$c] != $d) {
                $this->setError("CPF inválido");
                return false;
            }
        }
        return true;
    }
    
     #Validador de CNPJ
    public function validateCNPJ($cnpj){
        
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	
    	// Valida tamanho
    	if (strlen($cnpj) != 14){
    	    $this->setError("CNPJ inválido");
    		return false;
    	}
    	// Verifica se todos os digitos são iguais
    	if (preg_match('/(\d)\1{13}/', $cnpj)){
    	    $this->setError("CNPJ inválido");
    		return false;	
    	}
    	// Valida primeiro dígito verificador
    	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
    	{
    		$soma += $cnpj[$i] * $j;
    		$j = ($j == 2) ? 9 : $j - 1;
    	}
    
    	$resto = $soma % 11;
    
    	if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)){
    	    $this->setError("CNPJ inválido");
    		return false;
    	}
    	// Valida segundo dígito verificador
    	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
    	{
    		$soma += $cnpj[$i] * $j;
    		$j = ($j == 2) ? 9 : $j - 1;
    	}
    
    	$resto = $soma % 11;
    
    	//return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    	return true;
        }
    
    #Validador de CEP
    public function validateCEP($Param){
        
        $Param = preg_replace("/[^0-9]/", "", $Param);
        $url = "http://viacep.com.br/ws/$Param/xml/";
        $xml = simplexml_load_file($url);
        
        //return $xml;
        if($xml==false){
            $this->setError("CEP inválido");
            return false;
        }else{return true;}
        
    }
    
    #Validador de telefone
    public function validateTelefone($Param){
        if(!preg_match('^\(+[0-9]{2,3}\) [0-9]{4}-[0-9]{4}$^', $Param)){return true;}
        else{
            $this->setError("Telefone inválido");
            return false;
        }
    }
    
    #Validador de nome
    public function validateNome($Param){
        $registro="/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/";
        if(preg_match($registro, $Param)){return true;}
        else{
            $this->setError("Nome inválido");
            return false;
        }
    }
    
    #Validador de números
    public function validateNumero($Param){
        $registro="/^[0-9]+$/";
        if(preg_match($registro, $Param)){return true;}
        else{
            $this->setError("Numero inválido");
            return false;
        }
    }
    
}
?>