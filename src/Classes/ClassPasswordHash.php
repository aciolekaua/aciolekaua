<?php
namespace Src\Classes;
use App\Model\ClassLogin;
class ClassPasswordHash{
    private $db;
    function __construct(){
        $this->db=new ClassLogin;
    }
    public function passHash($password,$const=['cost' => 12]){
        return password_hash($password,PASSWORD_BCRYPT,$const);
    }
    public function passwordVerify($Email,$TipoCliente,$Senha){
        
        $passFake=password_hash(md5(uniqid(rand(), true)),PASSWORD_DEFAULT ,['cost' => 12]);
        
        $dbHash=$this->db->getDataUser($Email,$TipoCliente);
       
        if($dbHash["linhas"]>0){
            return password_verify($Senha,$dbHash["dados"]["Senha"]);
        }else{
            return password_verify($Senha,$passFake);;
        }
    }
}


?>