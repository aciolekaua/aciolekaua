<?php
namespace Src\Classes;
class ClassJWT{
    private $ChaveParceiro;
    
    function base64UrlEncode($data){
        return str_replace(['+','/','='],['-','_',''],base64_encode($data));
    }
    
    function jwtEncode($payLoader,$chave){
        if(!is_array($payLoader)){
            return false;
        }else{
            if(empty($payLoader)){
                return false;
            }else{
                $hearder = array(
                "alg"=>'HS256',
                "typ"=>'JWT'
                );
                
                
                $hearder = json_encode($hearder);
                $hearder = $this->base64UrlEncode($hearder);
                //var_dump($hearder);
                
                $payLoader = json_encode($payLoader);
                $payLoader = $this->base64UrlEncode($payLoader);
                //var_dump($payLoader);
                
                $signature = hash_hmac('sha256', "{$hearder}.{$payLoader}",$chave,true);
    
                $signature = $this->base64UrlEncode($signature);
                //var_dump($signature);
                
                $token = "{$hearder}.{$payLoader}.{$signature}";
                
                $tokenJSON = array("token"=>$token);
                
                $tokenJSON = json_encode($tokenJSON);
                
                return $tokenJSON;
            }
        }
    }
}
?>