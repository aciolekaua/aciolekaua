<?php
namespace Src\Classes;
class ClassRequestJSON{
    function request(
        $url,
        $tpRequest,
        $body=null,
        $header=null,
        $certificado=null
    ){
        
        $ch = curl_init();
        
        curl_setopt($ch,CURLOPT_URL,$url);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tpRequest);
        
        if($body!=null){curl_setopt($ch, CURLOPT_POSTFIELDS, $body);}
    
        if($header!=null){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }else{
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }

        if($certificado!=null){
            curl_setopt($ch, CURLOPT_SSLCERT, $certificado['Certificado']);
            curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $certificado['Senha']);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $resultado = curl_exec($ch);

        if (curl_errno($ch)) {
            $resultado = curl_error($ch);
        }
        
        curl_close($ch);
        
        return $resultado;
    }
}
?>