<?php 
namespace App\Model;
use App\Model\ClassCrud;

class ClassExtrato extends ClassCrud {

    public function insertExtrato(array $dados):bool{
    	//exit(json_encode($dados));
    	$this->insertDB(
    		'Extrato',
    		'
    		:idExtrato,
    		NOW(),
    		:dataCompetencia,
    		:url,
    		:path,
    		:extensao,
    		:nome,
    		:uniqid,
    		:tomador
    		',
    		[
    			":idExtrato"=>$dados['idExtrato'],
    			":dataCompetencia"=>$dados["dataCompetencia"],
    			":url"=>$dados['url'],
    			":path"=>$dados['path'],
    			":extensao"=>$dados['extensao'],
    			":nome"=>$dados['nome'],
    			":uniqid"=>$dados['uniqid'],
    			":tomador"=>$dados['tomador']
    		]

    	);

    	$select = $this->selectDB(
    		'*',
    		'Extrato',
    		"WHERE str_id_Extrato = :idExtrato",
    		[":idExtrato"=>$dados['idExtrato']]
    	);

    	return $select->rowCount()>0;
    }

    public function getExtrato(array $dados):array{
        $select = $this->selectDB(
            "str_id_Extrato as id,
            DATE_FORMAT(dtm_dataEmissao_Extrato, '%d/%m/%Y %H:%i') as dataEmissao,
            DATE_FORMAT(dt_dataCompetencia_Extrato, '%m/%Y') as dataCompetencia,
            str_url_Extrato as url,
            str_tomador_Extrato as cnpj",
            'Extrato',
            "WHERE str_tomador_Extrato = :tomador 
            ORDER BY dtm_dataEmissao_Extrato DESC",
            [
                ":tomador"=>$dados['tomador']
            ]
        );

        return [
            "linhas"=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    public function getExtratoId(array $dados):array{
        $select = $this->selectDB(
            "str_id_Extrato as id,
            str_path_Extrato as path",
            "Extrato",
            "WHERE str_id_Extrato = :id 
            AND str_tomador_Extrato = :cnpj",
            [
                ":id"=>$dados['id'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        return[
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function deleteExtrato(array $dados):bool{
        $this->deleteDB(
            'Extrato',
            'str_id_Extrato = :id AND str_tomador_Extrato = :cnpj',
            [
                ":id"=>$dados['id'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        $select = $this->selectDB(
            '*',
            'Extrato',
            "WHERE str_id_Extrato = :id AND str_tomador_Extrato = :cnpj",
            [
                ":id"=>$dados['id'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        return $select->rowCount()<=0;
    }

    public function updateExtrato(array $dados):bool{

        $this->updateDB(
            'Extrato',

            "dt_dataCompetencia_Extrato = :competencia, 
            str_url_Extrato = :url,
            str_path_Extrato = :path,
            str_extensao_Extrato = :extensao,
            str_nome_Extrato = :nome,
            str_uniqid_Extrato = :uniqid",

            "str_tomador_Extrato = :cnpj AND
            str_id_Extrato = :idExtrato",

            [
                ":idExtrato"=>$dados['idExtrato'],
                ":competencia"=>$dados['competencia'],
                ":cnpj"=>$dados['cnpj'],
                ":url"=>$dados['url'],
                ":path"=>$dados['path'],
                ":extensao"=>$dados['extensao'],
                ":nome"=>$dados['nome'],
                ":uniqid"=>$dados['uniqid']
            ]
        );

        $select = $this->selectDB(
            "(count(*) > 0) as retorno",

            "Extrato",

            "WHERE dt_dataCompetencia_Extrato = :competencia
            AND str_url_Extrato = :url
            AND str_path_Extrato = :path
            AND str_extensao_Extrato = :extensao
            AND str_nome_Extrato = :nome
            AND str_uniqid_Extrato = :uniqid
            AND str_tomador_Extrato = :cnpj
            AND str_id_Extrato = :idExtrato",

            [
                ":idExtrato"=>$dados['idExtrato'],
                ":competencia"=>$dados['competencia'],
                ":cnpj"=>$dados['cnpj'],
                ":url"=>$dados['url'],
                ":path"=>$dados['path'],
                ":extensao"=>$dados['extensao'],
                ":nome"=>$dados['nome'],
                ":uniqid"=>$dados['uniqid']
            ]
        );

        return $select->rowCount()>0;
    }

}

?>