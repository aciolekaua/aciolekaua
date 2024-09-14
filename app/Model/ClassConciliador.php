<?php 
namespace App\Model;
use App\Model\ClassCrud;

class ClassConciliador extends ClassCrud {
    public function apagarId($id){
        $this->deleteDB("consulta_banco","id=:id",array(":id"=>(int)$id));
        $select = $this->selectDB(
            "*",
            'consulta_banco',
            'WHERE id=:id',
            [":id"=>(int)$id]
        );
        return $select->rowCount()<=0;
    }
    
    public function atualizarHistorico($array){
        
        $this->updateDB(
            "consulta_banco VALUES(historicoEditado)",
            ":historicoEditado",
            "id=:id",
            [
                ":id"=>(int)$array['id'],
                ":historicoEditado"=>(string)$array['historicoEditado']
            ]
        );
        
        $select = $this->selectDB(
            "*",
            'consulta_banco',
            'WHERE id=:id AND historicoEditado = :historicoEditado',
            [
                ":id"=>(int)$array['id'],
                ":historicoEditado"=>(string)$array['historicoEditado']
            ]
        );
        
        return $select->rowCount()>0;
    }
    
    public function insertHistoricoSituacao($array){
        
        $this->insertDB(
            "HistoricoConsulta",
            ":HistoricoAtual",
            array(
                ":HistoricoAtual"=>(string)$array['HistoricoAtual']
            )
        );
        
        $select = $this->selectDB(
            "*",
            "HistoricoConsulta",
            "WHERE HistoricoAtual = :HistoricoAtual",
            [
                ":HistoricoAtual"=>(string)$array['HistoricoAtual']
            ]
        );
        
        return $select->rowCount()>0;
    }
    
    public function selectHistoricoAtual(){
        $select = $this->selectDB("id, HistoricoAtual ","HistoricoConsulta","ORDER BY HistoricoAtual ASC",array());
        return [
            "linhas"=>$select->rowCount(),
            'dados'=>$seletc->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    
    public function insertArquivos($array){
        $this->insertDB(
            "`consulta_banco` (`data`, historico, documento, historicoEditado, valor, tipo)",
            ":data, :historico, :documento, :historicoEditado, :valor, :tipo",
            array(
            ":data"=>(string)$array['data'], 
            ":historico"=>(string)$array['historico'], 
            ":documento"=>(int)$array['documento'],
            ":historicoEditado"=>(string)$array['historicoEditado'],
            ":valor"=>(float)$array['valor'], 
            ":tipo"=>(string)$array['tipo']
            )
        );
        $select = $this->selectDB(
        "*",
        "consulta_banco",
        "WHERE `data` = :data 
            AND 
        historico = :historico 
            AND 
        documento = :documento 
            AND
        historicoEditado = :historicoEditado 
            AND 
        valor = :valor 
            AND 
        tipo = :tipo",
        array(
            ":data"=>(string)$array['data'], 
            ":historico"=>(string)$array['historico'], 
            ":documento"=>(int)$array['documento'],
            ":historicoEditado"=>(string)$array['historicoEditado'],
            ":valor"=>(float)$array['valor'], 
            ":tipo"=>(string)$array['tipo']
            )
        );
        return $select->rowCount()>0;
    }
    
    public function listarUsuarios($array){
        
        $select = $this->selectDB(
            "COUNT(id) AS qnt_usuarios",
            "consulta_banco",
            "id LIKE :id OR `data` LIKE :data OR historico LIKE :historico OR historicoEditado LIKE :historicoEditado OR valor LIKE :valor",
            [
                ":id"=>(string)"%{$array['id']}%",
                ":data"=>(string)"%{$array['data']}%",
                ":historico"=>(string)"%{$array['historico']}%",
                ":historicoEditado"=>(string)"%{$array['historicoEditado']}%",
                ":valor"=>(string)"%{$array['valor']}%"
            ]
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
        
    }
    
    public function desenharTabela($array){
        $select = $this->selectDB(
            "id, `data`, historico, historicoEditado, valor, tipo",
            "consulta_banco",
            "id LIKE :id 
            OR data LIKE :data 
            OR historico LIKE :historico 
            OR historicoEditado LIKE :historicoEditado 
            OR valor LIKE :valor 
            ORDER BY :colunas, :order LIMIT :inicio, :quantidade",
            [
                ":id"=>(string)"%{$array['id']}%",
                ":data"=>(string)"%{$array['data']}%",
                ":historico"=>(string)"%{$array['historico']}%",
                ":historicoEditado"=>(string)"%{$array['historicoEditado']}%",
                ":valor"=>(string)"%{$array['valor']}%",
                ":colunas"=>(int)$colunas[$dados_requisicao['order'][0]['column']],
                ":order"=>(int)$dados_requisicao['order'][0]['dir'],
                ":inicio"=>(int)$dados_requisicao['start'],
                ":quantidade"=>(int)$dados_requisicao['length']
            ]
            
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
        
    }
    
}
?>