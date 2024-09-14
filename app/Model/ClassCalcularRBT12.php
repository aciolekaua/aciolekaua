<?php 
namespace App\Model;
use App\Model\ClassCrud;

class ClassCalcularRBT12 extends ClassCrud {

    public function getEmpresasDAS(){
        $select = $this->selectDB(
            'str_cnpj_EmpresasDAS as cnpj, 
            str_razao_EmpresasDAS as razao',
            'EmpresasDAS',
            '',
            []
        );

        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    public function updateEmpresasDAS(array $dados){
        $update = $this->updateDB(
            'EmpresasDAS',
            "str_razao_EmpresasDAS = :razao, str_fantasia_EmpresasDAS = :fantasia",
            "str_cnpj_EmpresasDAS = :cnpj",
            [
                ":razao"=>$dados['razao'],
                ":fantasia"=>$dados['fantasia'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        return $update->rowCount();
    }

    public function insertEmpresasDAS(array $dados){
        $insert = $this->insertDB(
            'EmpresasDAS(
                str_cnpj_EmpresasDAS, 
                str_razao_EmpresasDAS
            )',
            ':cnpj,:razao',
            [
                ":cnpj"=>$dados['cnpj'],
                ":razao"=>$dados['razao']
            ]
        );

        return $insert->rowCount() > 0;
    }

    public function updateRBT12(array $dados){
        $query = "";
        $exec = [];
        if(isset($dados['rpa'])){
            $query .= "flt_rpa_RBT12 = :rpa";
            $exec += [":rpa"=>$dados['rpa']];
        }else if(isset($dados['rbt12']) && isset($dados['rba'])){
            $query .= "flt_rbt12_RBT12 = :rbt12,";
            $exec += [":rbt12"=>$dados['rbt12']];
            $query .= " flt_rba_RBT12 = :rba";
            $exec += [":rba"=>$dados['rba']];
        }

        $exec += [
            ':cnpj'=>$dados['cnpj'],
            ':competencia'=>$dados['competencia']
        ];

        $update = $this->updateDB(
            'RBT12',
            $query,
            "str_cnpj_RBT12 = :cnpj 
            AND dt_competencia_RBT12 = :competencia",
            $exec
        );

        return $update->rowCount() > 0;
    }

    public function insertRBT12(array $dados){
        
        $this->insertDB(
            'RBT12(
                str_idRBT12_RBT12,
                dtm_envio_RBT12,
                dt_competencia_RBT12,
                flt_rpa_RBT12,
                flt_rba_RBT12,
                flt_rbt12_RBT12,
                int_anexo_RBT12,
                str_cnpj_RBT12
            )',
            ":id,
            :envio,
            :competencia,
            :rpa,
            :rba,
            :rbt12,
            :anexo,
            :cnpj",
            [
                ':id'=>$dados['id'],
                ':envio'=>date("Y-m-d H:i:s"),
                ':competencia'=>$dados['competencia'],
                ':rpa'=>$dados['rpa'],
                ':rba'=>$dados['rba'],
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
    }

    public function getRBT12(array $dados){

        $select = $this->selectDB(

            'str_idRBT12_RBT12 as id,
            dt_competencia_RBT12 as competencia,
            flt_rpa_RBT12 as rpa,
            flt_rba_RBT12 as rba,
            flt_rbt12_RBT12 as rbt12,
            int_anexo_RBT12 as anexo,
            str_cnpj_RBT12 as cnpj',

            'RBT12',

            'WHERE dt_competencia_RBT12 = :competencia AND str_cnpj_RBT12 = :cnpj',

            [
                ':competencia'=>$dados['competencia'],
                ':cnpj'=>$dados['cnpj']
            ]

        );

        return [
            "linhas"=>$select->rowCount(),
            'dados'=>$select->fetch(\PDO::FETCH_ASSOC)
        ];

    }

    public function getFaturamento(array $dados){
        //exit(json_encode($dados));
        $select = $this->selectDB(
            "c.str_descricao_CNAE as descricao_cnae,
            c.str_anexo_CNAE as anexo,
            c.str_cnae_CNAE as cnae,
            c.bool_fatorR_CNAE as fator_r,
            f.dtm_envio_FaturamentoDAS as envio,
            f.str_nome_FaturamentoDAS as nome_empresa,
            f.dt_competencia_FaturamentoDAS as competencia,
            f.flt_faturamentoRetido_FaturamentoDAS as faturamento_retido,
            f.flt_faturamentoNaoRetido_FaturamentoDAS as faturamento_nao_retido",
            "FaturamentoDAS AS f",
            "INNER JOIN CNAE AS c ON c.str_cnae_CNAE = f.str_cnae_FaturamentoDAS
            WHERE f.str_cnpj_FaturamentoDAS = :cnpj AND f.dt_competencia_FaturamentoDAS = :competencia",
            [
                ':cnpj'=>$dados['cnpj'],
                ':competencia'=>$dados['competencia']
            ]
        );

        return [
            "linhas"=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    public function getEmpresasFaturamentoDAS(){
        $select = $this->selectDB(
            "*",
            "Empresas_FaturamentoDAS",
            "",
            []
        );

        return [
            "linhas"=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    public function getRBT12_Empresas(string $competencia){
        $select = $this->selectDB(
            '
                str_idRBT12_RBT12 AS id,
                dt_competencia_RBT12 AS competencia,
                flt_rpa_RBT12 AS rpa,
                flt_rba_RBT12 as rba,
                flt_rbt12_RBT12 AS rbt12,
                int_anexo_RBT12 AS anexo,
                str_razao_EmpresasDAS as razao,
                str_cnpj_RBT12 AS cnpj
            ',
            'RBT12',
            'INNER JOIN EmpresasDAS 
            ON str_cnpj_EmpresasDAS = str_cnpj_RBT12
            WHERE YEAR(dt_competencia_RBT12) = YEAR(:competencia) 
            AND MONTH(dt_competencia_RBT12) = MONTH(:competencia)
            ORDER BY str_razao_EmpresasDAS ASC',
            [
                ":competencia"=>$competencia
            ]
        );

        return[
            "linhas"=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    public function insertCronJobs(){
        
    }
    
}