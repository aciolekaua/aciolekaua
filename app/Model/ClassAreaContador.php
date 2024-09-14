<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassAreaContador extends ClassCrud{
    
    public function insertCodigoHistoricoContador($dados){
        $this->insertDB(
            'CodigoHistoricoContador',
            "?,?,?,?,?",
            [
                $dados['ID'],
                $dados['IdHistorico'],
                $dados['CHP'],
                $dados['CP'],
                $dados['cnpj']
            ]
        );
        $select = $this->selectDB(
            "*",
            "CodigoHistoricoContador",
            "WHERE str_id_CodigoHistoricoContador = ?",
            [$dados['ID']]
        );
        return $select->rowCount();
    }
    
    public function issetCodigoHistoricoContador($dados){
        $select = $this->selectDB(
            "*",
            "CodigoHistoricoContador",
            "WHERE 
            int_historico_CodigoHistoricoContador = ? 
            AND str_cnpj_CodigoHistoricoContador = ?",
            [
                $dados['IdHistorico'],
                $dados['cnpj']
            ]
        );
        return $select->rowCount();
    }
    
    public function updateCodigoHistoricoContador($dados){
        $this->updateDB(
            "CodigoHistoricoContador",
            "int_HP_CodigoHistoricoContador = ?, int_P_CodigoHistoricoContador = ?",
            " str_cnpj_CodigoHistoricoContador = ? AND int_historico_CodigoHistoricoContador = ? ",
            [
                 $dados['CHP'],
                $dados['CP'],
                $dados['cnpj'],
                $dados['IdHistorico'],
            ]
        );
        
        $select = $this->selectDB(
            "*",
            "CodigoHistoricoContador",
            "WHERE str_cnpj_CodigoHistoricoContador = ? 
            AND int_historico_CodigoHistoricoContador = ? 
            AND int_HP_CodigoHistoricoContador = ? 
            AND int_P_CodigoHistoricoContador = ?",
            [
                $dados['cnpj'],
                $dados['IdHistorico'],
                $dados['CHP'],
                $dados['CP']
            ]
        );
        
        return $select->rowCount();
    }
    
    public function getCodigoHistoricoContador($dados){
        
        $select = $this->selectDB(
            "int_id_TipoDeHistorico as ID,
            str_historico_TipoDeHistorico as Historico,
            int_HP_CodigoHistoricoContador as HP,
            int_P_CodigoHistoricoContador as P",
            
            "TipoDeHistorico",
            
            "INNER JOIN CodigoHistoricoContador
            ON int_historico_CodigoHistoricoContador = int_id_TipoDeHistorico
            WHERE str_cnpj_CodigoHistoricoContador = ? AND int_idAcao_TipoDeHistorico = ? OR int_idAcao_TipoDeHistorico = 2",
            
            [
                $dados['cnpj'],
                $dados['TipoHistorico']
            ]
        );

        return[
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    
}
?>