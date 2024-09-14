<?php 
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Classes\ClassSessions;
use Src\Traits\TraitUrlParser;
use Src\Classes\ClassValidateCheckoutPagamento;
class ControllerCheckoutPagamento {
     use TraitUrlParser;
     private $Render;
     private $Session;
     private $ValidatePagamento;
     function __construct(){
        $this->Render=new ClassRender;
        $this->ValidatePagamento = new ClassValidateCheckoutPagamento;
        $this->Session=new ClassSessions;
        $this->Render->setDir("CheckoutPagamento");
        $this->Render->setTitle("Checkout-Pagamento");
        $this->Render->setDescription("Pagina de Checkout-Pagamento MVC");
        $this->Render->setKeywords("mvc, mvc teste");
        $url=$this->parseUrl();
            if(isset($url[1])){
                $this->Render->addSession();
                header("Content-Type:application/json");
            }else{
                $this->Render->renderLayout("Home");
            }
        }
        
        
        function gerarQrcode(){
            $array_pix = [];
            if(isset($_POST['nome-pix'])){
                $nomePix = filter_input(INPUT_POST,'nome-pix',FILTER_SANITIZE_ADD_SLASHES);
                $arrayPix+=['name'=>$nomePix];
            }

            $this->Validate->validateFilds($array_pix);
            
            $result = $this->ValidatePagamento->gerarQrcode($array_pix);
            
            
            exit(json_encode(
                array(
                "erros"=>$this->ValidatePagamento->getError(),
                "resultados"=>$result
                )
            ));
        }
        
        function pagarPix(){
            gerarQrcode();
            $codPix = $body['qr_codes'][0]['id'];
            $imagemPix = $body['qr_codes'][0]['links'][0]['href'];
            $urlPix = "https://sandbox.api.pagseguro.com/pix/pay/{$codPix}";
            curl_setopt_array($curl,[
            CURLOPT_URL=>$urlpix,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_ENCODING=>"",
            CURLOPT_MAXREDIRS=>10,
            CURLOPT_TIMEOUT=>30,
            CURLOPT_SSL_VERIFYPEER=>false,
            //CURLOPT_CAINFO=>DIRREQ.'cacert.pem',
            CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST=>"POST",
            CURLOPT_HTTPHEADER=> [
                'Authorization: Bearer '.TOKENHOMLOGPAGSEGURO,
                'Content-type: application/json'
                ],
            ]);
    
            $response = curl_exec($curl);
        
            curl_close($curl);
            $error = curl_error($curl);
            
            exit(json_encode(
                array(
                    "erros"=>$error
                )
            ));
        }
        
    }