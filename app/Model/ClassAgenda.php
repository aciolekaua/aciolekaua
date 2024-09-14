<?php
namespace App\Model;
use App\Model\ClassCrud;

class ClassAgenda extends ClassCrud {
    
    public function insertEvento($dados){
        //exit(json_encode($dados));
        $this->insertDB(
            'AgendaPJ',
            ':id,:descricao,:data,:inicio,:fim,:cnpj',
            [
                ":id"=>$dados['id'],
                ":data"=>$dados['data'],
                ":descricao"=>$dados['descricao'],
                ":inicio"=>$dados['inicio'],
                ":fim"=>$dados['fim'],
                ":cnpj"=>$dados['cnpj']
            ]
        );
        
        $select = $this->selectDB(
            '*',
            'AgendaPJ',
            'WHERE str_id_AgendaPJ = :id',
            [":id"=>$dados['id']]
        );
        
        return $select->rowCount() > 0;
        
    }
    public function issetEvento($dados){
        
        $select = $this->selectDB(
            '*',
            'AgendaPJ',
            'WHERE str_data_AgendaPJ = :data && str_inicio_AgendaPJ = :inicio && str_fim_AgendaPJ = :fim && str_cnpj_AgendaPJ = :cnpj',
            [
                ":data"=>$dados['data'],
                ":inicio"=>$dados['inicio'],
                ":fim"=>$dados['fim'],
                ":cnpj"=>$dados['cnpj']
            ]
        );
        
        return $select->rowCount() > 0;
        
    }
    public function selectEventoPJ($dados){
        $select = $this->selectDB(
            '
                DAY(str_data_AgendaPJ) as dia,
                MONTH(str_data_AgendaPJ) as mes,
                YEAR(str_data_AgendaPJ) as ano,
                TIME_FORMAT(str_inicio_AgendaPJ, "%H:%i") as inicio,
                TIME_FORMAT(str_fim_AgendaPJ, "%H:%i") as fim,
                str_descricao_AgendaPJ as descricao,
                str_cnpj_AgendaPJ as cnpj
            ',
            'AgendaPJ',
            'WHERE DAY(str_data_AgendaPJ) = :dia && str_cnpj_AgendaPJ = :cnpj',
            [
                ":dia"=>$dados['dia'],
                ":cnpj"=>$dados['cnpj']
            ]
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    public function deleteEvento(){
        
    }
}