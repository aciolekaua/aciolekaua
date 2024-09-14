<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassHome extends ClassCrud{
    
    public function getPagamentoMes($dados){
        $select = $this->selectDB(
            "str_descricao_GrupoDeContas as Historico,
            str_descricao_TipoDeAcao as Descrição,
            SUM(flt_valor_Pagamento) as ValorTotal",
            "Pagamento",
            "INNER JOIN PJ ON str_cnpj_PJ = str_empresa_Pagamento
            LEFT JOIN PlanoDeContas ON str_idContas_PlanoDeContas = str_idHistorico_Pagamento
            LEFT JOIN GrupoDeContas ON str_id_GrupoDeContas = str_idGrupoDeContas_PlanoDeContas
            INNER JOIN PF ON str_cpf_PF = str_cpf_Pagamento
            LEFT JOIN TipoDeAcao ON int_idAcao_TipoDeAcao = int_tipoAcao_GrupoDeContas
            WHERE
            str_empresa_Pagamento = ? AND MONTH(dtm_dataDeEnvio_Pagamento) = MONTH(?) AND YEAR(dtm_dataDeEnvio_Pagamento) = YEAR(?)
            GROUP BY
            str_descricao_GrupoDeContas 
            ORDER BY
            str_descricao_GrupoDeContas",
            [$dados['ID'],$dados['data'],$dados['data']]
        );
        $linhas = $select->rowCount();
        $dados = $select->fetchAll(\PDO::FETCH_ASSOC);
        return[
            'linhas'=>$linhas,
            'dados'=>$dados
        ];
    }
    
    public function getRecebimentoMes($dados){
        $select = $this->selectDB(
            "str_descricao_GrupoDeContas as Historico,
            str_descricao_TipoDeAcao as Descrição,
            SUM(flt_valor_Recebimento) as ValorTotal",
            "Recebimento",
            "INNER JOIN PJ ON str_cnpj_PJ = str_empresa_Recebimento
            LEFT JOIN PlanoDeContas ON str_idContas_PlanoDeContas = str_idHistorico_Recebimento
            LEFT JOIN GrupoDeContas ON str_id_GrupoDeContas = str_idGrupoDeContas_PlanoDeContas
            INNER JOIN PF ON str_cpf_PF = str_cpf_Recebimento
            LEFT JOIN TipoDeAcao ON int_idAcao_TipoDeAcao = int_tipoAcao_GrupoDeContas
            WHERE
            str_empresa_Recebimento = ? AND MONTH(dtm_dataDeEnvio_Recebimento) = MONTH(?) AND YEAR(dtm_dataDeEnvio_Recebimento) = YEAR(?)
            GROUP BY
            str_descricao_GrupoDeContas 
            ORDER BY
            str_descricao_GrupoDeContas",
            [$dados['ID'],$dados['data'],$dados['data']]
        );
        
        $linhas = $select->rowCount();
        $dados = $select->fetchAll(\PDO::FETCH_ASSOC);
        return[
            'linhas'=>$linhas,
            'dados'=>$dados
        ];
    }
    
    public function getRecebimentoTotal($dados){
        $select = $this->selectDB(
            "SUM(flt_valor_Recebimento) as RecebimentoTotal",
            "Recebimento",
            "WHERE str_empresa_Recebimento = ?",
            [$dados['ID']]
        );
        
        $linhas = $select->rowCount();
        $dados = $select->fetchAll(\PDO::FETCH_ASSOC);
        return [
            'linhas'=>$linhas,
            'dados'=>$dados
        ];
    }
    
    public function getPagamentoTotal($dados){
        $select = $this->selectDB(
            "SUM(flt_valor_Pagamento) as PagamentoTotal",
            "Pagamento",
            "WHERE str_empresa_Pagamento = ?",
            [$dados['ID']]
        );
        
        $linhas = $select->rowCount();
        $dados = $select->fetchAll(\PDO::FETCH_ASSOC);
        return [
            'linhas'=>$linhas,
            'dados'=>$dados
        ];
    }
    
    public function getReceitaAnual($dados){
        /*echo(json_encode($dados));
        exit();*/
        /*if($dados['TipoCliente']=="PJ"){
            $where="WHERE
            	str_empresa_Recebimento = ? AND YEAR(dt_data_Recebimento) = YEAR(?)
            GROUP BY 
            	MONTH(dt_data_Recebimento)
            ORDER BY 
            	MONTH(dt_data_Recebimento) ASC";
        }else if($dados['TipoCliente']=="PF"){
            
        }*/
        
         $where="WHERE
        	str_empresa_Recebimento = ? AND YEAR(dt_data_Recebimento) = YEAR(?)
        GROUP BY 
        	MONTH(dt_data_Recebimento)
        ORDER BY 
        	MONTH(dt_data_Recebimento) ASC";
        
        $select = $this->selectDB(
            "MONTH(dt_data_Recebimento) as Mes,
            SUM(flt_valor_Recebimento) as Valor",
            "Recebimento",
            "{$where}",
            [$dados['ID'],$dados['DataAtual']]
        ); 
        
        $linhas = $select->rowCount();
        $dados = $select->fetchAll(\PDO::FETCH_ASSOC);
        
        return[
            "linhas"=> $linhas,
            "dados"=>$dados
        ];
        
    } 
    
    public function getDespesaAnual($dados){
        
        /*if($dados['TipoCliente']=="PJ"){
            $where="WHERE
            	str_empresa_Pagamento = ? AND YEAR(dt_data_Pagamento) = YEAR(?)
            GROUP BY 
            	MONTH(dt_data_Pagamento)
            ORDER BY 
            	MONTH(dt_data_Pagamento) ASC";
        }else if($dados['TipoCliente']=="PF"){
            
        }*/
        $where="WHERE
            	str_empresa_Pagamento = ? AND YEAR(dt_data_Pagamento) = YEAR(?)
            GROUP BY 
            	MONTH(dt_data_Pagamento)
            ORDER BY 
            	MONTH(dt_data_Pagamento) ASC";
            	
        $select = $this->selectDB(
            "MONTH(dt_data_Pagamento) as Mes,
            SUM(flt_valor_Pagamento) as Valor",
            "Pagamento",
            "{$where}",
            [$dados['ID'],$dados['DataAtual']]
        ); 
        
        $linhas = $select->rowCount();
        $dados = $select->fetchAll(\PDO::FETCH_ASSOC);
        
        return[
            "linhas"=> $linhas,
            "dados"=>$dados
        ];
        
    } 
}
?>