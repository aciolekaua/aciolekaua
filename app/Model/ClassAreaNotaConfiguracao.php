<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassAreaNotaConfiguracao extends ClassCrud{

    public function insertRBT12(array $dados):bool{

        $this->insertDB(
            "RBT12",
            ":id,:valor,:tpNota,:anexo,:cnpj",
            [
                ":id"=>$dados['id'],
                ":valor"=>$dados['valor'],
                ":tpNota"=>$dados['tpNota'],
                ":anexo"=>$dados['anexo'],
                ":cnpj"=>$dados['cnpj']

            ]
        );

        $select = $this->selectDB(
            "*",
            "RBT12",
            "WHERE str_idRBT12_RBT12 = :id
            AND flt_valor_RBT12 = :valor
            AND int_tpNota_RBT12 = :tpNota,
            AND int_anexo_RBT12	= :anexo,
            AND str_cnpj_RBT12 = :cnpj",
            [
                ":id"=>$dados['id'],
                ":valor"=>$dados['valor'],
                ":tpNota"=>$dados['tpNota'],
                ":anexo"=>$dados['anexo'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        return ($select->rowCount()>0 && $select->rowCount()==1);
    }
    
    public function insertChaveNotasHomologacao($dados){
        $this->insertDB(
            'ChavesNotasHomologacao',
            '?,?',
            [
                $dados['cnpj'],
                $dados['chaveAcesso']
            ]
        );
        $select = $this->selectDB(
            "*",
            "ChavesNotasHomologacao",
            "WHERE str_cnpj_ChavesNotasHomologacao = ? AND str_chaveAcesso_ChavesNotasHomologacao = ?",
            [
                $dados['cnpj'],
                $dados['chaveAcesso']
            ]
        );
        return $select->rowCount()>0;
    }

    public function issetChaveNotasHomologacao($dados){
        $select = $this->selectDB(
            "*",
            "ChavesNotasHomologacao",
            "WHERE str_cnpj_ChavesNotasHomologacao = ?",
            [
                $dados['cnpj']
            ]
        );
        return $select->rowCount()>0;
    }

    public function updateChaveNotasHomologacao($dados){
        $this->updateDB(
            "ChavesNotasHomologacao",
            "str_chaveAcesso_ChavesNotasHomologacao = ?",
            "str_cnpj_ChavesNotasHomologacao = ?",
            [
                $dados['chaveAcesso'],
                $dados['cnpj']
            ]
        );
        $select = $this->selectDB(
            "*",
            "ChavesNotasHomologacao",
            "WHERE str_cnpj_ChavesNotasHomologacao = ? AND str_chaveAcesso_ChavesNotasHomologacao = ?",
            [
                $dados['cnpj'],
                $dados['chaveAcesso']
            ]
        );
        return $select->rowCount()>0;
    }

    public function insertChaveNotas($dados){
        $this->insertDB(
            'ChavesNotas',
            '?,?',
            [
                $dados['cnpj'],
                $dados['chaveAcesso']
            ]
        );
        $select = $this->selectDB(
            "*",
            "ChavesNotas",
            "WHERE str_cnpj_ChavesNotas = ? AND str_chaveAcesso_ChavesNotas = ?",
            [
                $dados['cnpj'],
                $dados['chaveAcesso']
            ]
        );
        return $select->rowCount()>0;
    }

    public function issetChaveNotas($dados){
        $select = $this->selectDB(
            "*",
            "ChavesNotas",
            "WHERE str_cnpj_ChavesNotas = ?",
            [
                $dados['cnpj']
            ]
        );
        return $select->rowCount()>0;
    }

    public function updateChaveNotas($dados){
        $this->updateDB(
            "ChavesNotas",
            "str_chaveAcesso_ChavesNotas = ?",
            "str_cnpj_ChavesNotas = ?",
            [
                $dados['chaveAcesso'],
                $dados['cnpj']
            ]
        );
        $select = $this->selectDB(
            "*",
            "ChavesNotas",
            "WHERE str_cnpj_ChavesNotas = ? AND str_chaveAcesso_ChavesNotas = ?",
            [
                $dados['cnpj'],
                $dados['chaveAcesso']
            ]
        );
        return $select->rowCount()>0;
    }

    public function insertConfiguracaoEmissaoNota($dados){
        
        $this->insertDB(
            'ConfiguracaoNotaFiscalNFSE',
            '?,?,?,?,?,?',
            [
                $dados['cnpj'],
                $dados['inscricaoEstadual'],
                $dados['inscricaoMunicipal'],
                $dados['incentivadorCultural'],
                $dados['codigoCRT'],
                $dados['regime']
            ]
        );
        
        $select = $this->selectDB(
            '*',
            'ConfiguracaoNotaFiscalNFSE',
            'WHERE str_cnpj_ConfiguracaoNotaFiscalNFSE = ?',
            [$dados['cnpj']]
        );
        
        return $select->rowCount();
    }

    public function issetConfiguracaoEmissaoNota($dados){
        $select = $this->selectDB(
            '*',
            'ConfiguracaoNotaFiscalNFSE',
            'WHERE str_cnpj_ConfiguracaoNotaFiscalNFSE = ?',
            [$dados['cnpj']]
        );
        
        return $select->rowCount();
    }

    public function updateConfiguracaoEmissaoNota($dados){
        
        $this->updateDB(
            
            'ConfiguracaoNotaFiscalNFSE',
            
            'str_inscricaoEstadual_ConfiguracaoNotaFiscalNFSE = ?,
            str_inscricaoMunicipal_ConfiguracaoNotaFiscalNFSE = ?,
            bool_incentivadorCultural_ConfiguracaoNotaFiscalNFSE = ?,
            int_codigoCRT_ConfiguracaoNotaFiscalNFSE = ?,
            int_regime_ConfiguracaoNotaFiscalNFSE = ?',
            
            'str_cnpj_ConfiguracaoNotaFiscalNFSE = ?',
            
            [
                $dados['inscricaoEstadual'],
                $dados['inscricaoMunicipal'],
                $dados['incentivadorCultural'],
                $dados['codigoCRT'],
                $dados['regime'],
                $dados['cnpj']
            ]
            
        );
        
        $select = $this->selectDB(
            '*',
            'ConfiguracaoNotaFiscalNFSE',
            'WHERE str_cnpj_ConfiguracaoNotaFiscalNFSE = ?
            AND str_inscricaoEstadual_ConfiguracaoNotaFiscalNFSE = ?
            AND str_inscricaoMunicipal_ConfiguracaoNotaFiscalNFSE = ?
            AND bool_incentivadorCultural_ConfiguracaoNotaFiscalNFSE = ?
            AND int_codigoCRT_ConfiguracaoNotaFiscalNFSE = ?
            AND int_regime_ConfiguracaoNotaFiscalNFSE = ?',
            [
                $dados['cnpj'],
                $dados['inscricaoEstadual'],
                $dados['inscricaoMunicipal'],
                $dados['incentivadorCultural'],
                $dados['codigoCRT'],
                $dados['regime']
            ]
        );
        // exit(json_encode($dados));
        return $select->rowCount();
    }

    public function insertListaServico($dados){
         
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

    public function issetListaServico($dados){
        $select = $this->selectDB(
            '*',
            'ListaServico',
            'WHERE flt_cod_ListaServico = ? AND str_cnpj_ListaServico = ?',
            [$dados['cod'],$dados['cnpj']]
        );
        
        return $select->rowCount()>0;
    }

    public function getListaServico($cnpj){
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

    public function deleteListaServico($dados){
        $this->deleteDB(
            'ListaServico ',
            'str_cnpj_ListaServico = ? AND flt_cod_ListaServico = ?',
            [$dados['cnpj'],$dados['codigo']]
        );
        $select = $this->selectDB(
            '*',
            'ListaServico',
            'WHERE str_cnpj_ListaServico = ? AND flt_cod_ListaServico = ?',
            [$dados['cnpj'],$dados['codigo']]
        );
        
        return $select->rowCount()<0;
    }

    public function insertModuloPJ($dados){
        $this->insertDB(
            "ModulosPJ",
            "?,?",
            [$dados['cnpj'],$dados['nfse']]
        );
        
        $select = $this->selectDB(
            "*",
            "ModulosPJ",
            "WHERE str_cnpj_ModulosPJ = ? AND int_nfse_ModulosPJ = ?",
            [$dados['cnpj'],$dados['nfse']]
        );
        
        return $select->rowCount()>0;
    }

    public function issetModuloPJ($dados){
        
        $select = $this->selectDB(
            "int_nfse_ModulosPJ as NFSE",
            "ModulosPJ",
            "WHERE str_cnpj_ModulosPJ = ?",
            [$dados['cnpj']]
        );
        
        return $select->rowCount()>0;
        
    }

    public function getModuloPJ($dados){
        $select = $this->selectDB(
            "
            int_nfse_ModulosPJ as IdNFSE,
            str_descricao_ModulosDescricao as DescricaoNFSE
            ",
            "ModulosPJ",
            "
            INNER JOIN ModulosDescricao
            ON int_nfse_ModulosPJ = int_id_ModulosDescricao
            WHERE str_cnpj_ModulosPJ = ?
            ",
            [$dados['cnpj']]
        );
        
        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function updateModuloPJ($dados){
        $this->updateDB(
            "ModulosPJ",
            "int_nfse_ModulosPJ = ?",
            "str_cnpj_ModulosPJ = ?",
            [
                $dados['nfse'],
                $dados['cnpj']
            ]
        );
        
        $select = $this->selectDB(
            "*",
            "ModulosPJ",
            "WHERE str_cnpj_ModulosPJ = ? AND int_nfse_ModulosPJ = ?",
            [
                $dados['cnpj'],
                $dados['nfse']
            ]
        );
        
        return $select->rowCount() > 0;
    }

}
?>