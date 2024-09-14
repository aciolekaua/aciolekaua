<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassPerfil extends ClassCrud{

    public function insertGrupo(array $dados):bool{

        $this->insertDB(
            'GrupoDeContas',
            ":id,:tipoAcao,:codConta,:nome,:cnpj",
            [
                ":id"=>$dados['id'],
                ":tipoAcao" => $dados['tipoAcao'],
                ":codConta"=>$dados['codConta'],
                ":nome"=>$dados['nome'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        $select = $this->selectDB(
            '*',
            "GrupoDeContas",
            "WHERE str_id_GrupoDeContas = :id",
            [":id"=>$dados['id']]
        );

        return $select->rowCount()>0;
    }

    public function updateGrupo(array $dados):bool{
        //exit(json_encode($dados));
        $this->updateDB(

            'GrupoDeContas',

            "int_tipoAcao_GrupoDeContas = :tipoAcao,
            str_descricao_GrupoDeContas = :descricao",

            "str_id_GrupoDeContas = :id 
            AND str_cnpj_GrupoDeContas = :cnpj",

            [
                ":tipoAcao"=>$dados['tipoAcao'],
                ":descricao"=>$dados['descricao'],
                ":id"=>$dados['id'],
                ":cnpj"=>$dados['cnpj']
            ]

        );

        $select = $this->selectDB(

            '*',

            'GrupoDeContas',

            "WHERE int_tipoAcao_GrupoDeContas = :tipoAcao
            AND str_id_GrupoDeContas = :id
            AND str_descricao_GrupoDeContas = :descricao
            AND str_cnpj_GrupoDeContas = :cnpj",

            [
                ":tipoAcao"=>$dados['tipoAcao'],
                ":descricao"=>$dados['descricao'],
                ":id"=>$dados['id'],
                ":cnpj"=>$dados['cnpj']
            ]

        );

        return $select->rowCount()>0;

    }

    public function issetGrupo(array $dados):array{
        
        $select = $this->selectDB(
            "str_id_GrupoDeContas as Id",
            "GrupoDeContas",
            "WHERE str_cnpj_GrupoDeContas = :cnpj AND int_codigoConta_GrupoDeContas = :codConta",
            [
                ":cnpj" => $dados["cnpj"],
                ":codConta" => $dados["codConta"]
            ]
        );

        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    public function getGrupo(array $dados):array{
        if(!isset($dados['Acao'])){
            $where = "WHERE str_cnpj_GrupoDeContas = :tomador ORDER BY str_descricao_GrupoDeContas ASC";
            $exec = [
                ":tomador"=>$dados['Tomador']
            ];
        }else{
            $where = "WHERE str_cnpj_GrupoDeContas = :tomador AND int_tipoAcao_GrupoDeContas = :acao ORDER BY str_descricao_GrupoDeContas ASC";
            $exec = [
                ":tomador"=>$dados['Tomador'],
                ":acao"=>$dados['Acao']
            ];
        }
        $select = $this->selectDB(
            "str_id_GrupoDeContas as Id,
            int_codigoConta_GrupoDeContas as CodigoConta,
            int_tipoAcao_GrupoDeContas as TipoAcao,
            str_descricao_GrupoDeContas as Descricao,
            str_cnpj_GrupoDeContas as Tomador",
            "GrupoDeContas",
            $where,
            $exec
        );

        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }
    
    public function deleteGrupo(array $dados):bool{
        
        $this->deleteDB(
            "GrupoDeContas",
            "str_cnpj_GrupoDeContas = :tomador AND str_id_GrupoDeContas = :id",
            [
                ":tomador"=>$dados['Tomador'],
                ":id"=>$dados['Id']
            ]
        );
        
        $select = $this->selectDB(
            '*',
            "GrupoDeContas",
            "WHERE str_cnpj_GrupoDeContas = :tomador AND str_id_GrupoDeContas = :id",
            [
                ":tomador"=>$dados['Tomador'],
                ":id"=>$dados['Id']
            ]
        );

        return $select->rowCount()<=0;
    }

    public function issetContasContabil(array $dados):bool{
        
        $select = $this->selectDB(
            "*",
            "PlanoDeContas",
            "WHERE int_numeroConta_PlanoDeContas = :numeroconta AND str_cnpj_PlanoDeContas = :cnpj",
            [
                ":numeroconta"=>$dados['numeroconta'],
                ":cnpj"=>$dados['cnpj']
            ]
        );
 
        return $select->rowCount()>0;
    }

    public function insertContasContabil(array $dados):bool{
        
        //exit(json_encode($dados));

        $this->insertDB(
            'PlanoDeContas',
            ":id,:numeroconta,:nome,:descricao,:palavrachave,:grupoconta,:cnpj",
            [
                ":id"=>$dados['id'],
                ":numeroconta"=>$dados['numeroconta'],
                ":nome"=>$dados['nome'],
                ":descricao"=>$dados['descricao'],
                ":palavrachave"=>$dados['palavrachave'],
                ":grupoconta"=>$dados['grupoconta'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        $select = $this->selectDB(
            "*",
            "PlanoDeContas",
            "WHERE
            str_idContas_PlanoDeContas = :id AND str_cnpj_PlanoDeContas = :cnpj",
            [
                ":id"=>$dados['id'],
                ":cnpj"=>$dados['cnpj']
            ]
        );
        
        return $select->rowCount()>0;
    }

    public function updateContasContabil(array $dados):bool{
        
        $this->updateDB(

            'PlanoDeContas',

            "int_numeroConta_PlanoDeContas = :numeroConta,
            str_nome_PlanoDeContas = :nomeConta,
            str_descricao_PlanoDeContas = :descricaoConta,
            str_palavraChave_PlanoDeContas = :palavraCahve,
            str_idGrupoDeContas_PlanoDeContas = :idGrupo",

            "str_idContas_PlanoDeContas = :idConta 
            AND str_cnpj_PlanoDeContas = :cnpj",

            [
                ":numeroConta"=>$dados['NumeroConta'],
                ":nomeConta"=>$dados['NomeConta'],
                ":descricaoConta"=>$dados['Descricao'],
                ":palavraCahve"=>$dados['PalavraChave'],
                ":idGrupo"=>$dados['GrupoContas'],
                ":idConta"=>$dados['IdConta'],
                ":cnpj"=>$dados['Cnpj']
            ]

        );

        $select = $this->selectDB(

            '*',

            'PlanoDeContas',

            "WHERE int_numeroConta_PlanoDeContas = :numeroConta
            AND str_nome_PlanoDeContas = :nomeConta
            AND str_descricao_PlanoDeContas = :descricaoConta
            AND str_palavraChave_PlanoDeContas = :palavraCahve 
            AND str_idGrupoDeContas_PlanoDeContas = :idGrupo 
            AND str_idContas_PlanoDeContas = :idConta 
            AND str_cnpj_PlanoDeContas = :cnpj",

            [
                ":numeroConta"=>$dados['NumeroConta'],
                ":nomeConta"=>$dados['NomeConta'],
                ":descricaoConta"=>$dados['Descricao'],
                ":palavraCahve"=>$dados['PalavraChave'],
                ":idGrupo"=>$dados['GrupoContas'],
                ":idConta"=>$dados['IdConta'],
                ":cnpj"=>$dados['Cnpj']
            ]

        );

        return $select->rowCount()>0;

    }
    public function deleteContasContabil(string $id):bool{
        //exit(json_encode($id));
        $this->deleteDB(
            'PlanoDeContas',
            'str_idContas_PlanoDeContas = :id',
            [":id"=>$id]
        );

        $select = $this->selectDB(
            '*',
            'PlanoDeContas',
            'WHERE str_idContas_PlanoDeContas = :id',
            [":id"=>$id]
        );

        return $select->rowCount()<=0;
    }

    public function getContasContabil(string $cnpj, string $idGrupo=""):array{
        //exit(json_encode([$cnpj,$idGrupo]));
        if(!empty($idGrupo)){
            $query="str_idContas_PlanoDeContas as Id,
            int_numeroConta_PlanoDeContas as NumeroConta,
            str_nome_PlanoDeContas as NomeConta,
            str_descricao_PlanoDeContas as Descricao,
            str_palavraChave_PlanoDeContas as PalavraChave,
            str_descricao_GrupoDeContas as Grupo,
            str_id_GrupoDeContas as IdGrupo ";
            $where = "INNER JOIN GrupoDeContas
            ON str_id_GrupoDeContas = str_idGrupoDeContas_PlanoDeContas
            WHERE str_cnpj_PlanoDeContas = :cnpj
            AND str_cnpj_GrupoDeContas = :cnpj
            AND str_id_GrupoDeContas = :idGrupo
            AND str_idGrupoDeContas_PlanoDeContas = :idGrupo";
            $array=[":cnpj"=>$cnpj,":idGrupo"=>$idGrupo];
            //exit(json_encode([$cnpj,$idGrupo]));
        }else{
            $query = "str_idContas_PlanoDeContas as Id,
            int_numeroConta_PlanoDeContas as NumeroConta,
            str_nome_PlanoDeContas as NomeConta,
            str_descricao_PlanoDeContas as Descricao,
            str_palavraChave_PlanoDeContas as PalavraChave,
            str_descricao_GrupoDeContas as Grupo,
            str_id_GrupoDeContas as IdGrupo";
            $where = "INNER JOIN GrupoDeContas
            ON str_id_GrupoDeContas = str_idGrupoDeContas_PlanoDeContas
            WHERE str_cnpj_PlanoDeContas = :cnpj";
            $array = [":cnpj"=>$cnpj];
        }
        
        $select = $this->selectDB(
            $query,
            "PlanoDeContas",
            $where,
            $array
        );
        
        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];

    }

    function updateNome($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = :id";
            $set = "str_nome_PF = :nome";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = :id";
            $set = "str_nomeFantasia_PJ = :nome";
        }
        
        $update = $this->updateDB(
            "{$dados['tabela']}",
            $set,
            $where,
            [":nome"=>$dados['nome'],":id"=>$dados['ID']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE {$set} AND {$where}",
            [":nome"=>$dados['nome'],":id"=>$dados['ID']]
        );
        
        return $select->rowCount();
    }
    
    function updateEmail($dados){
       
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }

        $this->updateDB(
            "{$dados['tabela']}",
            "str_email_{$dados['tabela']} = :email",
            "{$where}",
            [":email"=>$dados['email']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_email_{$dados['tabela']} = ? AND {$where}",
            [":email"=>$dados['email']]
        );

        if(isset($_SESSION['email'])){$_SESSION['email'] = $dados['email'];} 
        
        return $select->rowCount();
    }
    
    function updateTelefone($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = :id";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = :id";
        }

        $this->updateDB(
            "{$dados['tabela']}",
            "str_telefone_{$dados['tabela']} = :telefone",
            "{$where}",
            [":telefone"=>$dados['telefone'],":id"=>$dados['ID']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_telefone_{$dados['tabela']} = :telefone AND {$where}",
            [":telefone"=>$dados['telefone'],":id"=>$dados['ID']]
        );
        
        return $select->rowCount();
    }
    
    function updateCEP($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "str_cep_{$dados['tabela']} = :cep",
            "{$where}",
            [":cep"=>$dados['cep']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_cep_{$dados['tabela']} = :cep AND {$where}",
            [":cep"=>$dados['cep']]
        );
        
        return $select->rowCount();
    }
    
    function updateEndereco($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "str_endereco_{$dados['tabela']} = :endereco",
            "{$where}",
            [":endereco"=>$dados['endereco']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_endereco_{$dados['tabela']} = :endereco AND {$where}",
            [":endereco"=>$dados['endereco']]
        );
        
        return $select->rowCount();
    }
    
    function updateNumero($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "str_numero_{$dados['tabela']} = ?",
            "{$where}",
            [$dados['numero']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_numero_{$dados['tabela']} = ? AND {$where}",
            [$dados['numero']]
        );
        
        return $select->rowCount();
    }
    
    function updateComplemento($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "str_complemento_{$dados['tabela']} = ?",
            "{$where}",
            [$dados['complemento']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_complemento_{$dados['tabela']} = ? AND {$where}",
            [$dados['complemento']]
        );
        
        return $select->rowCount();
    }
    
    function updateBairro($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "str_bairro_{$dados['tabela']} = ?",
            "{$where}",
            [$dados['bairro']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_bairro_{$dados['tabela']} = ? AND {$where}",
            [$dados['bairro']]
        );
        
        return $select->rowCount();
    }
    
    function updateCidade($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "str_cidade_{$dados['tabela']} = ?",
            "{$where}",
            [$dados['cidade']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_cidade_{$dados['tabela']} = ? AND {$where}",
            [$dados['cidade']]
        );
        
        return $select->rowCount();
    }
    
    function updateUF($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }else if($dados['TipoCliente']=="PJ"){
            $where="str_cnpj_PJ = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "str_uf_{$dados['tabela']} = ?",
            "{$where}",
            [$dados['uf']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE str_uf_{$dados['tabela']} = ? AND {$where}",
            [$dados['uf']]
        );
        
        return $select->rowCount();
    }
    
    function updateNascimento($dados){
        if($dados['TipoCliente']=="PF"){
            $where="str_cpf_PF = '{$dados['ID']}'";
        }
        $this->updateDB(
            "{$dados['tabela']}",
            "dt_nascimento_PF = ?",
            "{$where}",
            [$dados['nascimento']]
        );
        
        $select=$this->selectDB(
            '*',
            "{$dados['tabela']}",
            "WHERE dt_nascimento_PF = ? AND {$where}",
            [$dados['nascimento']]
        );
        
        return $select->rowCount();
    }
    
    function updateSenha($dados){
        
        if($dados['TipoCliente']=="PF"){
            $tabela='PF';
        }else if($dados['TipoCliente']=="PJ"){
            $tabela='PJ';
        }
        
        $this->updateDB(
           "{$tabela}",
           "str_senha_{$tabela} = ?",
           "str_email_{$tabela} = ?",
           [$dados['novaSenha'],$dados['email']]
        );
        
        $select = $this->selectDB(
            "*",
            "{$tabela}",
            "WHERE str_senha_{$tabela} = ? AND str_email_{$tabela} = ?",
            [$dados['novaSenha'],$dados['email']]
        );
        
        $linhas = $select->rowCount();
        
        return $linhas>0;
    }

}
?>