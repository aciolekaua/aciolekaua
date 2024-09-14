<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassAreaNotaLancamnetoNFSE extends ClassCrud{
    
    public function insertClonaNFSE($dados){
        
        $this->insertDB(
            'CloneNFSE',
            '?,?,?,?,?,?,?,?,?',
            [
                $dados['id'],
                $dados['PJ'],
                $dados['CpfCnpjTomador'],
                $dados['nomeTomador'],
                $dados['ValorTotalDosServicos'],
                $dados['atividade'],
                $dados['codServico'],
                $dados['naturezaOperacao'],
                $dados['DescriminacaoDosServicos']
            ]
        );
       
        $select = $this->selectDB(
            'count(*)',
            'CloneNFSE',
            'WHERE str_id_CloneNFSE = ? AND str_cnpj_CloneNFSE = ?',
            [
                $dados['id'],
                $dados['PJ'] 
            ]
        );
        
        return $select->rowCount()>0;
    }

    public function issetClonaNFSE($dados){
        $select = $this->selectDB(
            '*',
            'CloneNFSE',
            'WHERE 
            str_cnpj_CloneNFSE = ?
            AND str_cpfCnpj_CloneNFSE = ?
            AND str_nome_CloneNFSE = ?
            AND str_valor_CloneNFSE = ?
            AND str_atividade_CloneNFSE = ?
            AND str_servico_CloneNFSE = ?
            AND str_naturezaOperacao_CloneNFSE = ?
            AND str_descricao_CloneNFSE = ?',
            [
                $dados['PJ'],
                $dados['CpfCnpjTomador'],
                $dados['nomeTomador'],
                $dados['ValorTotalDosServicos'],
                $dados['atividade'],
                $dados['codServico'],
                $dados['naturezaOperacao'],
                $dados['DescriminacaoDosServicos']
            ]
        );
       
        return $select->rowCount()>0;
    }

    public function getClonaNFSE($cnpj){
        
        $select = $this->selectDB(
            'str_id_CloneNFSE as Id,
            str_cnpj_CloneNFSE as CNPJ,
            str_cpfCnpj_CloneNFSE as CpfCnpjTomador,
            str_nome_CloneNFSE as NomeTomador,
            str_valor_CloneNFSE as Valor,
            str_atividade_CloneNFSE as Atividade,
            str_servico_CloneNFSE as Servico,
            str_naturezaOperacao_CloneNFSE as NaturezaOperacao,
            str_descricao_CloneNFSE as Descricao',
            'CloneNFSE',
            'WHERE str_cnpj_CloneNFSE = ?
            ORDER BY str_nome_CloneNFSE',
            [$cnpj]
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
        
    }

    public function getDadosNotaClonata($notaClonada){
        $select = $this->selectDB(
            'str_id_CloneNFSE as Id,
            str_cnpj_CloneNFSE as CNPJ,
            str_cpfCnpj_CloneNFSE as CpfCnpjTomador,
            str_nome_CloneNFSE as NomeTomador,
            str_valor_CloneNFSE as Valor,
            str_atividade_CloneNFSE as Atividade,
            str_servico_CloneNFSE as Servico,
            str_naturezaOperacao_CloneNFSE as NaturezaOperacao,
            str_descricao_CloneNFSE as Descricao',
            'CloneNFSE',
            'WHERE str_id_CloneNFSE = ?',
            [$notaClonada]
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function getConfigEmissaoNFSE($cnpj){
        $select = $this->selectDB(
            'str_inscricaoEstadual_ConfiguracaoNotaFiscalNFSE as InscricaoEstadual,
            str_inscricaoMunicipal_ConfiguracaoNotaFiscalNFSE as InscricaoMunicipal,
            bool_incentivadorCultural_ConfiguracaoNotaFiscalNFSE as IncentivadorCultural,
            int_codigoCRT_ConfiguracaoNotaFiscalNFSE as CodigoCTR,
            int_regime_ConfiguracaoNotaFiscalNFSE as Regime',
            
            "ConfiguracaoNotaFiscalNFSE",
            
            "WHERE str_cnpj_ConfiguracaoNotaFiscalNFSE = ?",
            
            [$cnpj]
        );
        
        return[
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function getChavesNotas($cnpj){
        $select = $this->selectDB(
            'str_chaveAcesso_ChavesNotas as ChaveAcesso',
            
            "ChavesNotas",
            
            "WHERE str_cnpj_ChavesNotas = ?",
            
            [$cnpj]
        );
        
        return[
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function getChavesNotasHomologacao($cnpj){
        $select = $this->selectDB(
            'str_chaveAcesso_ChavesNotasHomologacao as ChaveAcesso',
            
            "ChavesNotasHomologacao",
            
            "WHERE str_cnpj_ChavesNotasHomologacao = ?",
            
            [$cnpj]
        );
        
        return[
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function getPJ($cnpj){
        $select = $this->selectDB(
            "str_nomeFantasia_PJ as NomeFantasia,
            str_razaoSocial_PJ as RazaoSocial,
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
}
?>