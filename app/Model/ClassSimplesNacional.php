<?php 
namespace App\Model;
use App\Model\ClassCrud;

class ClassSimplesNacional extends ClassCrud {

    /*public function insertRBT12(array $dados){
        
        $this->insertDB(
            'RBT12',
            ":id,:competencia,:rpa,:rbt12,:anexo,:cnpj",
            [
                ':id'=>$dados['id'],
                ':competencia'=>$dados['competencia'],
                ':rpa'=>$dados['rpa'],
                ':rbt12'=>$dados['rbt12'],
                ':anexo'=>$dados['anexo'],
                ':cnpj'=>$dados['cnpj']
            ]
        );

        $select = $this->selectDB(
            'count(*)',
            'RBT12',
            "WHERE str_idRBT12_RBT12 = :id",
            [':id'=>$dados['id']]
        );

        return $select->rowCount() > 0;
    }

    public function issetRBT12(array $dados){
        
        if(isset($dados['id'])){
            $where = "WHERE str_idRBT12_RBT12 = :id AND str_cnpj_RBT12 = :cnpj";
            $exec = [':id'=>$dados['id'],':cnpj'=>$dados['cnpj']];
        }else if(isset($dados['competencia'])){
            $where = "WHERE dt_competencia_RBT12 = :competencia AND str_cnpj_RBT12 = :cnpj";
            $exec = [':competencia'=>$dados['competencia'],':cnpj'=>$dados['cnpj']];
        }else{
            return false;
        }

        $select = $this->selectDB(
            '*',
            'RBT12',
            $where,
            $exec
        );

        //exit(json_encode($select));

        return $select->rowCount() > 0;
    }*/

    public function insertDadosSimples(array $dados){
        //exit(json_encode($dados));
        $this->insertDB(
            'SimplesNacional',
            ':id,:data,:valor,:anexo,:cnpj',
            [
                ':id'=>$dados['id'],
                ':data'=>$dados['data'],
                ':valor'=>$dados['valor'],
                ':anexo'=>$dados['anexo'],
                ':cnpj'=>$dados['cnpj']
            ]

        );
        //exit(json_encode($dados));
        $select = $this->selectDB(
            '*',
            'SimplesNacional',
            "WHERE str_id_SimplesNacional = :id",
            [':id'=>$dados['id']]
        );

        return $select->rowCount()>0;
        
    }

    public function issetSimples(array $dados):bool{
        
        $select = $this->selectDB(
            '*',
            'SimplesNacional',
            'WHERE 
            YEAR(dt_dataCompetencia_SimplesNacional) = YEAR(:data)
            AND MONTH(dt_dataCompetencia_SimplesNacional) = MONTH(:data)
            AND int_anexo_SimplesNacional = :anexo
            AND str_cnpj_SimplesNacional = :cnpj',
            [
                ':data'=>$dados['data'],
                ':anexo'=>$dados['anexo'],
                ":cnpj"=>$dados['cnpj']
            ]
        );
        //exit(json_encode($select->rowCount()>0));
        return $select->rowCount()>0;
    }

    public function getSimples(array $dados):array{

        $select = $this->selectDB(
            'str_id_SimplesNacional as Id,
            YEAR(dt_dataCompetencia_SimplesNacional) as AnoCompetencia,
            MONTH(dt_dataCompetencia_SimplesNacional) as MesCompetencia,
            FORMAT(dec_valor_SimplesNacional, 2, \'de_DE\') as Valor,
            int_anexo_SimplesNacional as Anexo,
            str_cnpj_SimplesNacional as Tomador',
            'SimplesNacional',
            'WHERE str_cnpj_SimplesNacional = :tomador AND int_anexo_SimplesNacional = :anexo
            ORDER BY dt_dataCompetencia_SimplesNacional DESC',
            [":tomador"=>$dados['tomador'],":anexo"=>$dados['anexo']]
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];

    }

    public function deleteSimples(string $id):bool{
        $this->deleteDB(
            'SimplesNacional',
            'str_id_SimplesNacional = :id',
            [
                ":id"=>$id
            ]
        );

        $select = $this->selectDB(
            '*',
            'SimplesNacional',
            'WHERE str_id_SimplesNacional = :id',
            [
                ":id"=>$id
            ]
        );

        return $select->rowCount()<=0;
    }

    public function updateSimples(array $dados):bool{

        $this->updateDB(
            'SimplesNacional',
            'dt_dataCompetencia_SimplesNacional = :data,
            dec_valor_SimplesNacional = :valor,
            int_anexo_SimplesNacional = :anexo',
            'str_id_SimplesNacional = :id',
            [
                ':id'=>$dados['Id'],
                ':data'=>$dados['Data'],
                ':anexo'=>$dados['Anexo'],
                ':valor'=>$dados['Valor']
            ]
        );

        $select = $this->selectDB(
            '*',
            'SimplesNacional',
            'WHERE dt_dataCompetencia_SimplesNacional = :data
            AND dec_valor_SimplesNacional = :valor
            AND int_anexo_SimplesNacional = :anexo
            AND str_id_SimplesNacional = :id',
            [
                ':id'=>$dados['Id'],
                ':data'=>$dados['Data'],
                ':anexo'=>$dados['Anexo'],
                ':valor'=>$dados['Valor']
            ]
        );

        return $select->rowCount()<=0;

    }

    public function calculaSimples(array $dados):array{
        
        $select = $this->selectDB(
            'SUM(dec_Valor_SimplesNacional) as Valor, COUNT(*) Meses',
            'SimplesNacional',
            'WHERE 
            str_cnpj_SimplesNacional = :tomador AND int_anexo_SimplesNacional = :anexo
            AND dt_dataCompetencia_SimplesNacional 
            BETWEEN DATE_SUB(:data, INTERVAL 12 MONTH) AND DATE_SUB(:data, INTERVAL 1 MONTH)',
            [
                ":tomador"=>$dados['Tomador'],
                ":data"=>$dados['Data'],
                ":anexo"=>$dados['Anexo']
            ]
        );
        
        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetch(\PDO::FETCH_ASSOC)
        ];

    }

}
?>