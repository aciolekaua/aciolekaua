<?php 
namespace App\Model;
use App\Model\ClassCrud;
class ClassTeste extends ClassCrud{
    
    function getInformacoesAnexo($dados){
        $select = $this->selectDB(
            "af.int_anexo_AnexoFaixa as Anexo,
            af.int_numeroFaixa_AnexoFaixa as Faixa,
            af.flt_aliquota_AnexoFaixa as Aliquota,
            af.flt_desconto_AnexoFaixa as Deducao,
            ap.flt_ISS_AnexoPercentual as ISS,
            ap.flt_COFINS_AnexoPercentual as COFINS,
            ap.flt_CSLL_AnexoPercentual as CSLL,
            ap.flt_IR_AnexoPercentual as IR,
            ap.flt_PIS_AnexoPercentual as PIS,
            ap.flt_CPP_AnexoPercentual as CPP,
            ap.flt_IPI_AnexoPercentual as IPI,
            ap.flt_ICMS_AnexoPercentual as ICMS",
            
            "AnexoFaixa af",
            
            "INNER JOIN 
                AnexoPercentual ap
            ON 
                ap.int_anexo_AnexoPercentual = af.int_anexo_AnexoFaixa 
                AND 
                ap.int_numeroFaixa_AnexoPercentual = af.int_numeroFaixa_AnexoFaixa
            WHERE
                :RBT12 >= af.flt_valorMin_AnexoFaixa AND :RBT12 <= af.flt_valorMax_AnexoFaixa
                AND 
                af.int_anexo_AnexoFaixa = :anexo AND ap.int_anexo_AnexoPercentual = :anexo",
                
            [
                ":RBT12"=>$dados['RBT12'],
                ":anexo"=>$dados['anexo']
            ]
        );
        
        return[
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    
    function getCNAE($cnae){
        $select = $this->selectDB(
            'str_cnae_CNAE as cnae,
            str_descricao_CNAE as decricao,
            str_anexo_CNAE as anexo,
            bool_fatorR_CNAE as fatorR,
            str_aliquota_CNAE as aliquota',
            'CNAE',
            'WHERE str_cnae_CNAE = ?',
            [$cnae]
        );
        
        return[
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC),
        ];
    }
    
    function getPJ($cnpj){
        $select = $this->selectDB(
            "str_nome_PJ as Nome,
            str_email_PJ as Email,
            str_cnpj_PJ as CNPJ,
            str_telefone_PJ as Telefone, 
            str_cep_PJ as CEP,
            str_endereco_PJ as Endereco,
            str_numero_PJ as NumeroEndereco,
            str_complemento_PJ as Complemento,
            str_bairro_PJ as Bairro,
            str_cidade_PJ as Cidade,
            str_uf_PJ as UF",
            "PJ",
            "WHERE str_cnpj_PJ = ?",
            [$cnpj]
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }
    
    function insertListaServico($dados){
         
        $this->insertDB(
            'ListaServico',
            'MD5(FLOOR(RAND()*99999)),?,?,?',
            [$dados['cod'],$dados['descricao'],$dados['cnpj']]
        );
       
        $select = $this->selectDB(
            '*',
            'ListaServico',
            'WHERE flt_cod_ListaServico = ? AND str_cnpj_ListaServico = ?',
            [$dados['cod'],$dados['cnpj']]
        );
        
        return $select->rowCount()>0;
    }
    
    function issetListaServico($dados){
        $select = $this->selectDB(
            '*',
            'ListaServico',
            'WHERE flt_cod_ListaServico = ? AND str_cnpj_ListaServico = ?',
            [$dados['cod'],$dados['cnpj']]
        );
        
        return $select->rowCount()>0;
    }
    
    function getListaServico($cnpj){
        $select = $this->selectDB(
            'flt_cod_ListaServico as Codigo,
            str_descricao_ListaServico as Descricao',
            'ListaServico',
            'WHERE str_cnpj_ListaServico = ?',
            [$cnpj]
        );
        
        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    
    function insertTributosMunicipais($dados){
        $this->insertDB(
            'TributosMunicipais',
            'MD5(FLOOR(RAND()*99999)),?,?,?',
            [$dados['cod'],$dados['descricao'],$dados['cnpj']]
        );
        
        $select = $this->selectDB(
            '*',
            'TributosMunicipais',
            'WHERE str_cod_TributosMunicipais = ? AND str_cnpj_TributosMunicipais = ?',
            [$dados['cod'],$dados['cnpj']]
        );
        
        return $select->rowCount()>0;
    }
    
    function issetTributosMunicipais($dados){
        $select = $this->selectDB(
            '*',
            'TributosMunicipais',
            'WHERE str_cod_TributosMunicipais = ? AND str_cnpj_TributosMunicipais = ?',
            [$dados['cod'],$dados['cnpj']]
        );
        
        return $select->rowCount()>0;
    }
    
    function getTributosMunicipais($cnpj){
        $select = $this->selectDB(
            'str_cod_TributosMunicipais as Codigo,
            str_descricao_TributosMunicipais as Descricao',
            'TributosMunicipais',
            'WHERE str_cnpj_TributosMunicipais = ?',
            [$cnpj]
        );
        
        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    
    function insertDadosLancamento(){
        $this->insertDB();
    }
}
?>