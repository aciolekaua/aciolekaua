<?php
namespace Src\Classes;
use App\Model\ClassLogin;
use Src\Traits\TraitGetIp;
class ClassSessions{
    private $Login;
    private $timeSession=TEMPO_DE_SESSAO;
    private $timeCanary=300;
    private $nameSession='IVICISESSION';
    
    public function __construct(){
        $this->Login=new ClassLogin;
        if(session_id() == ''){
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            ini_set("session.save_handler","files");
            ini_set('session.use_cookies',1);
            ini_set('session.cookie_lifetime',0);
            ini_set('session.use_only_cookies',1);
            ini_set('session.use_strict_mode',1);
            ini_set('session.cookie_httponly',1);
            ini_set('session.cookie_domain',DOMAIN);
            ini_set('session.cookie_samesite','Strict');
            ini_set('session.name',$this->nameSession);
            if(DOMAIN!="localhost"){ini_set('session.cookie_secure',1);}
            ini_set("session.entropy_length",512);
            ini_set("session.entropy_file",'/dev/urandom');
            ini_set('session.sid_bits_per_character',6);
            ini_set('session.hash_function','sha256');
            ini_set('session.use_trans_sid',0);
            ini_set('session.sid_length',200);
            ini_set('session.gc_maxlifetime',1800);
            session_start();
        }
        
    }
    public function sessionStatus(){
        return session_status();
    }
    
    public function setSessionCanary($Param=null){
        session_regenerate_id(true);
        if($Param==null){
            $_SESSION['canary']=array(
                'birth'=>time(),
                'IP'=>TraitGetIp::getUserIp()
                );
        }else{
            $_SESSION['canary']['birth']=time();
        }
    }
    
    public function destructSessions(){
        foreach (array_keys($_SESSION) as $key) {
            unset($_SESSION[$key]);
        }
        if(count($_SESSION)<=0){return true;}
        else if(count($_SESSION)>0){return false;}
    }
    
    public function verifyIdSessions(){
        
        if(!isset($_SESSION['canary'])){
            $this->setSessionCanary();
        }
    
        if($_SESSION['canary']['IP'] !== TraitGetIp::getUserIp()){
            $this->destructSessions();
            $this->setSessionCanary();
        }
    
        if($_SESSION['canary']['birth'] < time() - $this->timeCanary){
            $this->setSessionCanary("time");
        }
    }
    
    public function setSessions($Email,$TipoCliente){
        
        $this->verifyIdSessions();
        $_SESSION['login']=true;
        $_SESSION['time']=time();
        
        $_SESSION['TipoCliente']=$TipoCliente;
        $_SESSION['email']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Email'];
        $_SESSION['telefone']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Telefone'];
        $_SESSION['cep']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['CEP'];
        $_SESSION['endereco']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Endereco'];
        $_SESSION['numero']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Numero'];
        $_SESSION['complemento']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Complemento'];
        $_SESSION['bairro']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Bairro'];
        $_SESSION['cidade']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Cidade'];
        $_SESSION['uf']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['UF'];
        
        if($TipoCliente=="PF"){
            $_SESSION['ID']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['CPF'];
            $_SESSION['nome']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['Nome'];
            //$_SESSION['TipoPermissao']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['int_permissao_Associados'];
            return true;
        }else if($TipoCliente=="PJ"){
            $_SESSION['ID']=$this->Login->getDataUser($Email,$TipoCliente)['dados']['CNPJ'];
            $_SESSION['TipoJuridico']=$this->Login->getDataUser($Email,$TipoCliente)['dados']['TipoJuridico'];
            $_SESSION['nomeFantasia']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['NomeFantasia'];
            $_SESSION['razaoSocial']= $this->Login->getDataUser($Email,$TipoCliente)['dados']['RazaoSocial'];
            return true;
        }else{
            $this->destructSessions();
            return false;
        }
        
        
    }
    
    public function verifyInsideSession(){
       
        if(!$_SESSION['TipoCliente']){
            $this->destructSessions();
            echo"
                <script>
                    //alert('Faça o login');
                    window.location.href='".DIRPAGE."login';
                </script>
            ";
        }else{
          
            if(!isset($_SESSION['ID'])){
                $this->destructSessions();
                echo"
                    <script>
                        //alert('Faça o login');
                        window.location.href='".DIRPAGE."login';
                    </script>
                ";
            }
            
            if($_SESSION['TipoCliente']=="PJ"){
                if(!isset($_SESSION['TipoJuridico'])){
                    $this->destructSessions();
                    echo"
                        <script>
                            //alert('Faça o login');
                            window.location.href='".DIRPAGE."login';
                        </script>
                    ";
                }   
            }
            
            if($_SESSION['time']>time()-$this->timeSession){
                 $_SESSION['time']=time();
            }else{
                $this->destructSessions();
                echo"
                    <script>
                        //alert('Faça o login');
                        window.location.href='".DIRPAGE."login';
                    </script>
                ";
            }
                
            
            
        }
        
    }
}
?>