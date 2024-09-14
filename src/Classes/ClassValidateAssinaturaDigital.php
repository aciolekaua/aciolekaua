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

use App\Model\ClassAreaNotaLancamnetoNFSE;
use Src\Classes\ClassJWT;
use Src\Classes\ClassRequestJSON;

use Src\Traits\TraitUrlParser;
use App\Model\ClassTeste;

class ClassValidateAssinaturaDigital extends ClassValidate{
    
    private $JWT;
    private $RequestJSON;
    private $Validate;
    
    public function __construct(){
        parent::__construct();
        $this->JWT = new ClassJWT();
        $this->RequestJSON = new ClassRequestJSON();
        $this->Validate = new ClassValidate;
    }


    public function validateUpload($dados){
        $arrayAssinatura = [
            'data' => [
                'id' => (int)3116,
                'name' => (string)$dados['descricao'],
                'file_name' => (string)$dados['file_name'],
                'extension' => (string)$dados['extension'],
                'size' => (int)$dados['size'],
                'status' => (string)'Unsigned',
                'document_key' => (string)$dados['document_key'],
                'editted' => (string)$dados['editted'],
                'is_template' => (string)$dados['is_template'],
                'template_fields' => null,
                'accessibility' => (string)['accessibility'],
                'departments' => null,
                'folder' => [
                    'id' => (int)$dados['folder'],
                    'folder' => (string)$dados['folder'],
                    'accessibility' => (string)$dados['accessibility'],
                    'sub_folders' => [],
                    'created_on' => (string)str_replace(" ","T",date('Y-m-d H:i:s'))
                ],
                'uploaded_by' => [
                    'name' => (string)$dados['nome'],
                    'last_name' => (string)$dados['ultimo_nome']
                ],
                'uploaded_on' => (string)str_replace(" ","T",date('Y-m-d H:i:s')),
                'download' => (string)'https://app.plugsign.com.br/api/files/download/S0idsZwbtNcpfcFDGgYcw2GXblUGDpOI'
            ],
            'message' => (string)'Upload efetuado com sucesso!'
        ];

        return $arrayAssinatura;
    }
}