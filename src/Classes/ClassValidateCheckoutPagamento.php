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
use App\Model\ClassCheckoutPagamento;

class ClassValidateCheckoutPagamento extends ClassValidate{
    
    private $Pagamento;
    public function __construct(){
        parent::__construct();
        $this->Pagamento = new ClassCheckoutPagamento;
    }
    
    public function gerarQrcode($dados){
        
        $dataHoje = new DateTime();

        // Adiciona 10 minutos à data e hora atual
        $dataExpiracao = $dataHoje->add(new DateInterval('PT10M'));
        
        // Formata a data de expiração no formato desejado
        $dataExpiracaoFormatted = $dataExpiracao->format('Y-m-d H:i:s');
        
        $arrayPix = [
            "reference_id"=> (string)$dados["prod-0004-{$dataHoje}"],
            "customer"=> [
                "name"=> (string)$dados["name"],
                "email"=> (string)$dados["email"],
                "tax_id"=> (int)$dados["cpf"],
                "phones"=> [
                    [
                        "country"=> (int)$dados["55"],
                        "area"=> (int)$dados["12"],
                        "number"=> (int)$dados["999999999"],
                        "type"=> (string)$dados["MOBILE"]
                    ]
                ]
            ],
            "items"=>[
                    [
                        "name"=> (string)$dados["coxinha"],
                        "quantity"=> (int)$dados[2],
                        "unit_amount"=> (int)$dados[500]
                    ]
                ],
            "qr_codes"=>[
                [
                    "amount"=>[
                        "value"=> (int)$dados[500]
                    ],
                    "expiration_date"=> (string)str_replace(" ","T",$dataExpiracaoFormatted)
                ]
            ],
            "shipping"=>[
                "address"=>[
                    "street"=> (string)$dados["Avenida Brigadeiro Faria Lima"],
                    "number"=> (int)$dados["1384"],
                    "complement"=> (string)$dados["apto 12"],
                    "locality"=> (string)$dados["Pinheiros"],
                    "city"=> (string)$dados["São Paulo"],
                    "region_code"=> (string)$dados["SP"],
                    "country"=> (string)$dados["BRA"],
                    "postal_code"=> (string)$dados["01452002"]
                ]
            ],
            "notification_urls"=>[
                (string)$dados["https://meusite.com/notificacoes"]
            ]
    
        ];  
        
        
        $curl = curl_init();
            
        curl_setopt_array($curl,[
            CURLOPT_URL=>URLHOMOLOG,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_ENCODING=>"",
            CURLOPT_MAXREDIRS=>10,
            CURLOPT_TIMEOUT=>30,
            CURLOPT_SSL_VERIFYPEER=>true,
            CURLOPT_CAINFO=>DIRREQ.'public/certificados/cacert.pem',
            CURLOPT_POSTFIELDS=>json_encode($arrayPix),
            CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST=>"POST",
            CURLOPT_HTTPHEADER=> [
                'Authorization: Bearer '.TOKENHOMLOGPAGSEGURO,
                'Content-type: application/json'
            ],
        ]);
    
        $response = curl_exec($curl);
        
        $error = curl_error($curl);
        
        curl_close($curl);
        
        
        if($error){
            $this->setError("Qr code não gerado");
            return false;
        }else {
            return $arrayPix;
        }
        
    }
    
    public function gerarPagamentoCartaoCredito(){
            $body = [
            "token"=> (string)"c1c84bf9-f8a8-4bb1-965b-f9c632513479",
            "cpf_cnpj"=> (int)"48196905000105",
            "fullname"=> (string)"Isor Heymebye",
            "costumer_type"=> (string)"pj",
            "email"=> (string)"dairye@gmail.com",
            "birthdate"=> (string)"1991-01-01",
            "address"=> [
                "street"=> (string)"Tayrob Grikreareu",
                "complement"=> (string)"Finxundîr Guabaiash",
                "district"=> (string)"Vaudin",
                "number"=> (int)"2587",
                "state"=> (string)"PE",
                "postal_code"=> (int)"50030200",
                "city"=> (string)"Recife",
                "country"=> (string)"BR"
            ],
            "phone"=> [
                "countryCode"=> (int)"55",
                "areaCode"=> (int)"81",
                "number"=> (int)"958528545"
            ],
            "phone2"=> [
                "countryCode"=> (int)"55",
                "areaCode"=> (int)"81",
                "number"=> (int)"99452123"
            ],
            "description"=> (string)"Additional information about the payment, free use field",
            "payment_method"=> (string)"credit", 
            "credit_card"=> [
                "card_number"=> (int)"5142926288779899",
                "cvc"=> (int)"268",
                "expirationMonth"=>(int)"10", 
                "expirationYear"=>(int)"2023", 
                "holder"=> (string)"Tayrob Grikreareu",
                "installmentCount"=> (int)"6"
            ],
            "products"=> [
                [
                  "quantity"=> (int)"5",
                  "value"=> (float)"5.85",
                  "title"=> (string)"Tinie Anfo"
                ],
                [
                  "quantity"=> (int)"1",
                  "value"=>(float)"5.85",
                  "title"=>(string)"Tinie Anfo"                
                ]
            ]
        ];
        
        //Resposta do array da chez
    
        $respose = [
            "url"=> (string)"61e9a75bb34dce2240c3b5e2",
            "amount"=> (string)"60e89e14235c6f001fdc93d9",
            "gateway_name"=> false,
            "created_at"=> (string)"admin",
            "barcode"=> (string)"email@domain.com",
            "expiration_date"=> (string)"2022-01-20T18:18:03.133Z",
            "description"=> (string)"2022-01-20T18:18:03.133Z",
            "instruction_lines"=> [
                [
                  "line1"=> null
                ],
                [
                  "line2"=> null
                ]
            ],
            "products"=> [
                [
                  "title"=> (string)"sss",
                  "quantity"=> (int)1,
                  "value"=> (int)1
                ],
                [
                  "title"=> (string)"sss",
                  "quantity"=> (int)1,
                  "value"=> (int)1
                ]
            ]
        ];
    }
}