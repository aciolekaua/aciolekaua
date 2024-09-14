<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassTabelas extends ClassCrud{
    
    public function getPermissao(array $dados):array{
        $select=$this->selectDB(
            "int_permissao_Associados as Permissao,
            str_cargo_NiveisDePermissoes as Cargo",
            "Associados assoc",
            "
            INNER JOIN NiveisDePermissoes
            ON int_id_NiveisDePermissoes = int_permissao_Associados
            
            WHERE str_empresa_Associados = ? AND str_cpf_Associados = ?",
            [
                $dados['cnpj'],
                $dados['cpf']
            ]
        );
        $dados=$select->fetch(\PDO::FETCH_ASSOC);
        $linhas=$select->rowCount();
        return [
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function getPagamento(array $dados):array{
        
        if($dados['TipoCliente']=="PF"){
            //exit(json_encode($dados));
            $tabela="Pagamento";
            $exec =  [
                ":id"=>$dados['Id'],
                ":empresa"=>$dados['Empresa']
            ];

            if($dados['TipoPermissao']=="147031419" || $dados['TipoPermissao']=="948880538"){
                $filtro="
                DISTINCT
                str_id_Pagamento as ID,
                DATE_FORMAT(dtm_dataDeEnvio_Pagamento,'%d/%m/%Y %H:%i') as DataDeEnvio,
                str_nomeFantasia_PJ as PJ,
                str_nome_PF as PF,
                str_nome_PlanoDeContas as Historico,
                str_nome_TiposDePagamento as TipoDePagamento,
                str_agencia_Contas as Agencia,
                str_conta_Contas as Conta,
                str_descricao_Pagamento as Descricao,
                str_beneficiario_Pagamento as Beneficiario,
                int_nota_Pagamento as Nota,
                FORMAT(flt_valor_Pagamento, 2, 'de_DE') as Valor,
                DATE_FORMAT(dt_data_Pagamento,'%d/%m/%Y') as Data,
                str_idGrupoComprovante_Pagamento as GrupoComprovante,
                str_linkQRCode_Pagamento as LinkQRCode,
                str_idPagamento_VotacaoConselhoPagamento as IDConselho,
                str_descricao_StatusVotacaoConselho as Status,
                int_id_StatusVotacaoConselho as IDStatus
                ";
                $where="
                INNER JOIN Associados ON str_cpf_Associados = :id

                LEFT JOIN PF ON str_cpf_PF = str_cpf_Pagamento

                LEFT JOIN Contas ON str_idConta_Pagamento = str_id_Contas

                LEFT JOIN TiposDePagamento ON int_idBanco_Contas = int_id_TiposDePagamento

                INNER JOIN PJ ON str_cnpj_PJ = str_empresa_Pagamento

                LEFT JOIN PlanoDeContas ON str_idContas_PlanoDeContas = str_idHistorico_Pagamento

                LEFT JOIN VotacaoConselhoPagamento ON str_cpf_VotacaoConselhoPagamento = :id AND str_id_Pagamento = str_idPagamento_VotacaoConselhoPagamento

                LEFT JOIN StatusVotacaoConselho ON int_id_StatusVotacaoConselho = int_status_VotacaoConselhoPagamento
                
                WHERE
                    str_empresa_Pagamento = :empresa";
                
                
            }if($dados['TipoPermissao']=="804064473"){
                //exit(json_encode($dados));
                $filtro="
                DISTINCT
                str_id_Pagamento as ID,
                DATE_FORMAT(dtm_dataDeEnvio_Pagamento,'%d/%m/%Y %H:%i') as DataDeEnvio,
                str_nomeFantasia_PJ as PJ,
                str_nome_PF as PF,
                int_codigoConta_GrupoDeContas as HistoricoCodigo,
                str_descricao_GrupoDeContas as HistoricoDescricao,
                int_idBanco_Contas as TipoDePagamento,
                REPLACE(str_agencia_Contas,str_agencia_Contas,'') as Agencia,
                REPLACE(str_conta_Contas,str_conta_Contas,'') as Conta,
                str_descricao_Pagamento as Descricao,
                str_beneficiario_Pagamento as Beneficiario,
                int_nota_Pagamento as Nota,
                FORMAT(flt_valor_Pagamento, 2, 'de_DE') as Valor,
                DATE_FORMAT(dt_data_Pagamento,'%d/%m/%Y') as Data,
                str_idGrupoComprovante_Pagamento as GrupoComprovante,
                str_linkQRCode_Pagamento as LinkQRCode
                ";
                
                $where="
                INNER JOIN PF ON str_cpf_PF = :id

                INNER JOIN Associados ON str_cpf_Associados = :id

                LEFT JOIN Contas ON str_idConta_Pagamento = str_id_Contas

                LEFT JOIN TiposDePagamento ON int_idBanco_Contas = int_id_TiposDePagamento

                INNER JOIN PJ ON str_cnpj_PJ = str_empresa_Pagamento

                LEFT JOIN PlanoDeContas ON str_idContas_PlanoDeContas = str_idHistorico_Pagamento

                LEFT JOIN GrupoDeContas ON str_id_GrupoDeContas = str_idGrupoDeContas_PlanoDeContas

                WHERE
                    str_empresa_Pagamento = :empresa";
               
            }else{
                
                $filtro="
                DISTINCT
                str_id_Pagamento as ID,
                DATE_FORMAT(dtm_dataDeEnvio_Pagamento,'%d/%m/%Y %H:%i') as DataDeEnvio,
                str_nomeFantasia_PJ as PJ,
                str_nome_PF as PF,
                str_nome_PlanoDeContas as Historico,
                str_nome_TiposDePagamento as TipoDePagamento,
                str_agencia_Contas as Agencia,
                str_conta_Contas as Conta,
                str_descricao_Pagamento as Descricao,
                str_beneficiario_Pagamento as Beneficiario,
                int_nota_Pagamento as Nota,
                FORMAT(flt_valor_Pagamento, 2, 'de_DE') as Valor,
                DATE_FORMAT(dt_data_Pagamento,'%d/%m/%Y') as Data,
                str_idGrupoComprovante_Pagamento as GrupoComprovante,
                str_linkQRCode_Pagamento as LinkQRCode
                ";
                
                $where="
                INNER JOIN PF ON str_cpf_PF = :id

                INNER JOIN Associados ON str_cpf_Associados = :id

                LEFT JOIN Contas ON str_idConta_Pagamento = str_id_Contas

                LEFT JOIN TiposDePagamento ON int_idBanco_Contas = int_id_TiposDePagamento

                INNER JOIN PJ ON str_cnpj_PJ = str_empresa_Pagamento

                LEFT JOIN PlanoDeContas ON str_idContas_PlanoDeContas = str_idHistorico_Pagamento

                WHERE
                    str_empresa_Pagamento = :empresa";
                
            }

            if(
                isset($dados['Mes'])
                && isset($dados['Ano'])
            ){
                //exit(json_encode($dados));
                if($dados['Mes']==99 && $dados['Ano']==99){
                    $where .= " AND (dt_data_Pagamento BETWEEN '2000-01-01' AND NOW()) ";
                }else if($dados['Mes']==99){
                    $where .= " AND YEAR(dt_data_Pagamento) = :ano ";
                    $exec += [":ano"=>$dados['Ano']];
                }else if($dados['Ano']==99){
                    $where .= " AND MONTH(dt_data_Pagamento) = :mes ";
                    $exec += [":mes"=>$dados['Mes']];
                }else{

                    $where .= " AND MONTH(dt_data_Pagamento) = :mes ";
                    $exec += [":mes"=>$dados['Mes']];

                    $where .= " AND YEAR(dt_data_Pagamento) = :ano ";
                    $exec += [":ano"=>$dados['Ano']];

                }
            }


            $where .= " ORDER BY
                dtm_dataDeEnvio_Pagamento
            DESC";
                 
            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                $exec
            );

            return[
                "linhas"=>$select->rowCount(),
                "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
            ];
        }else if($dados['TipoCliente']=="PJ"){
            $exec = array();
            $tabela="Pagamento";
            $filtro="
                DISTINCT
                str_id_Pagamento as ID,
                DATE_FORMAT(dtm_dataDeEnvio_Pagamento,'%d/%m/%Y %H:%i') as DataDeEnvio,
                str_nomeFantasia_PJ as PJ,
                str_nome_PF as PF,
                str_nome_PlanoDeContas as Historico,
                str_nome_TiposDePagamento as TipoDePagamento,
                str_agencia_Contas as Agencia,
                str_conta_Contas as Conta,
                str_descricao_Pagamento as Descricao,
                str_beneficiario_Pagamento as Beneficiario,
                int_nota_Pagamento as Nota,
                FORMAT(flt_valor_Pagamento, 2, 'de_DE') as Valor,
                DATE_FORMAT(dt_data_Pagamento,'%d/%m/%Y') as Data,
                str_idGrupoComprovante_Pagamento as GrupoComprovante,
                str_linkQRCode_Pagamento as LinkQRCode
            ";
            $where="
                LEFT JOIN PJ
                ON :cnpj = str_empresa_Pagamento AND str_cnpj_PJ = :cnpj
                
                LEFT JOIN Contas 
                ON str_idConta_Pagamento = str_id_Contas
                    
                LEFT JOIN TiposDePagamento 
                ON int_idBanco_Contas = int_id_TiposDePagamento
                
                LEFT JOIN PlanoDeContas 
                ON str_idContas_PlanoDeContas = str_idHistorico_Pagamento
                
                LEFT JOIN PF
                ON str_cpf_PF = str_cpf_Pagamento
                
                WHERE
                str_empresa_Pagamento  = :cnpj
            ";

            if(
                isset($dados['Mes'])
                && isset($dados['Ano'])
            ){
                if($dados['Mes']==99 && $dados['Ano']==99){
                    $where .= " AND (dt_data_Pagamento BETWEEN '2000-01-01' AND NOW()) ";
                }else if($dados['Mes']==99){
                    $where .= " AND YEAR(dt_data_Pagamento) = :ano";
                    $exec += [":ano"=>$dados['Ano']];
                }else if($dados['Ano']==99){
                    $where .= " AND MONTH(dt_data_Pagamento) = :mes";
                    $exec += [":mes"=>$dados['Mes']];
                }else{

                    $where .= " AND MONTH(dt_data_Pagamento) = :mes";
                    $exec += [":mes"=>$dados['Mes']];

                    $where .= " AND YEAR(dt_data_Pagamento) = :ano";
                    $exec += [":ano"=>$dados['Ano']];

                }
            }

            $where .= " ORDER BY 
            dtm_dataDeEnvio_Pagamento DESC";

            
            $exec += [":cnpj"=>$dados['Id']];

            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                $exec
            );
            
            return[
                "linhas"=>$select->rowCount(),
                "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
            ];
            
        }
            
    }
    
    public function getRecebimento($ID,$TipoJuri,$TipoPermissao=null,$Empresa=null){
        
        if($TipoJuri=="PF"){
            $tabela="Recebimento";
            
            if($TipoPermissao=="147031419" || $TipoPermissao=="948880538"){
                $filtro="
                DISTINCT
                str_id_Recebimento as ID,
                DATE_FORMAT(dtm_dataDeEnvio_Recebimento,'%d/%m/%Y %H:%i') as DataDeEnvio,
                str_nomeFantasia_PJ as PJ,
                str_nome_PF as PF,
                str_nome_PlanoDeContas as Historico,
                str_nome_TiposDePagamento as TipoDePagamento,
                str_agencia_Contas as Agencia,
                str_conta_Contas as Conta,
                str_descricao_Recebimento as Descricao,
                str_ofertante_Recebimento as Ofertante,
                FORMAT(flt_valor_Recebimento, 2, 'de_DE') as Valor,
                DATE_FORMAT(dt_data_Recebimento,'%d/%m/%Y') as Data,
                str_idGrupoComprovante_Recebimento as GrupoComprovante,
                str_idRecebimento_VotacaoConselhoRecebimento as IDConselho,
                str_descricao_StatusVotacaoConselho as Status,
                int_id_StatusVotacaoConselho as IDStatus
                ";
                $where="
                INNER JOIN Associados ON str_cpf_Associados = ?
                INNER JOIN PF ON str_cpf_PF = str_cpf_Recebimento
                LEFT JOIN Contas ON str_idConta_Recebimento = str_id_Contas
                INNER JOIN PJ ON str_cnpj_PJ = str_empresa_Recebimento
                LEFT JOIN TiposDePagamento ON int_idBanco_Contas = int_id_TiposDePagamento
                LEFT JOIN PlanoDeContas ON str_idContas_PlanoDeContas = str_idHistorico_Recebimento
                LEFT JOIN VotacaoConselhoRecebimento ON str_cpf_VotacaoConselhoRecebimento = ? AND str_id_Recebimento = str_idRecebimento_VotacaoConselhoRecebimento
                LEFT JOIN StatusVotacaoConselho ON int_id_StatusVotacaoConselho = int_status_VotacaoConselhoRecebimento
                
                WHERE
                     str_empresa_Recebimento = ?
                ORDER BY
                    dtm_dataDeEnvio_Recebimento
                DESC";
                
            }else{
                $filtro="
                DISTINCT
                str_id_Recebimento as ID,
                DATE_FORMAT(dtm_dataDeEnvio_Recebimento,'%d/%m/%Y %H:%i') as DataDeEnvio,
                str_nomefantasia_PJ as PJ,
                str_nome_PF as PF,
                str_nome_PlanoDeContas as Historico,
                str_nome_TiposDePagamento as TipoDePagamento,
                str_agencia_Contas as Agencia,
                str_conta_Contas as Conta,
                str_descricao_Recebimento as Descricao,
                str_ofertante_Recebimento as Ofertante,
                FORMAT(flt_valor_Recebimento, 2, 'de_DE') as Valor,
                DATE_FORMAT(dt_data_Recebimento,'%d/%m/%Y') as Data,
                str_idGrupoComprovante_Recebimento as GrupoComprovante
                ";
                $where="
                INNER JOIN PF
                ON str_cpf_PF = ?
                
                LEFT JOIN Contas 
                ON str_idConta_Recebimento = str_id_Contas
                
                LEFT JOIN TiposDePagamento 
                ON int_idBanco_Contas = int_id_TiposDePagamento
                
                LEFT JOIN PJ
                ON str_cnpj_PJ = str_empresa_Recebimento
                
                LEFT JOIN PlanoDeContas 
                ON str_idContas_PlanoDeContas = str_idHistorico_Recebimento
                
                WHERE
                str_cpf_Recebimento = ? AND str_empresa_Recebimento = ?
                ORDER BY 
                dtm_dataDeEnvio_Recebimento DESC";
                
            }
            
            
            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                [$ID,$ID,$Empresa]
            );
            
            $linhas=$select->rowCount();
            $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
                
            return[
                "linhas"=>$linhas,
                "dados"=>$dados
            ];
        }else if($TipoJuri=="PJ"){
            $tabela="Recebimento";
            $filtro="
                DISTINCT
                str_id_Recebimento as ID,
                DATE_FORMAT(dtm_dataDeEnvio_Recebimento,'%d/%m/%Y %H:%i') as DataDeEnvio,
                str_nomeFantasia_PJ as PJ,
                str_nome_PF as PF,
                str_nome_PlanoDeContas as Historico,
                str_nome_TiposDePagamento as TipoDePagamento,
                str_agencia_Contas as Agencia,
                str_conta_Contas as Conta,
                str_descricao_Recebimento as Descricao,
                str_ofertante_Recebimento as Ofertante,
                FORMAT(flt_valor_Recebimento, 2, 'de_DE') as Valor,
                DATE_FORMAT(dt_data_Recebimento,'%d/%m/%Y') as Data,
                str_idGrupoComprovante_Recebimento as GrupoComprovante
            ";
            
            $where="
                LEFT JOIN Contas 
                ON str_idConta_Recebimento = str_id_Contas
                    
                LEFT JOIN TiposDePagamento 
                ON int_idBanco_Contas = int_id_TiposDePagamento
                
                LEFT JOIN PJ
                ON ? = str_empresa_Recebimento AND str_cnpj_PJ = ?
                
                LEFT JOIN PlanoDeContas 
                ON str_idContas_PlanoDeContas = str_idHistorico_Recebimento
                
                LEFT JOIN PF
                ON str_cpf_PF = str_cpf_Recebimento
                
                WHERE
                str_empresa_Recebimento  = ? 
                ORDER BY 
                dtm_dataDeEnvio_Recebimento DESC
            ";
            
            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                [$ID,$ID,$ID]
            );
            
            $linhas=$select->rowCount();
            $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
            
            return[
                "linhas"=>$linhas,
                "dados"=>$dados
            ];
            
        }
    }
    
    public function getNota($ID,$TipoJuri,$TipoPermissao=null,$Empresa=null){
        if($TipoJuri=="PF"){
            $tabela="Nota";
            $filtro="
            DISTINCT
            str_id_Nota as ID,
            dtm_dataDeEnvio_Nota as DataDeEnvio,
            str_nomeFantasia_PJ as PJ,
            str_nome_PF as PF,
            str_prestador_Nota as Prestador,
            flt_valor_Nota as Valor,
            dt_data_Nota as Data,
            str_url_LancamentosArquivos as Arquivo
            ";
            $where="
            
            INNER JOIN Associados ON str_cpf_Associados = ?
            
            INNER JOIN 
            PF
            ON
            str_cpf_PF = str_cpf_Nota
            
            LEFT JOIN
            PJ
            ON
            str_cnpj_PJ = str_empresa_Nota
        
            LEFT JOIN
            LancamentosArquivos
            ON
            str_id_LancamentosArquivos = str_idComprovante_Nota
            
            WHERE
                str_cpf_Associados = ? AND str_empresa_Nota = ?
            ORDER BY 
                dtm_dataDeEnvio_Nota 
            DESC";
            
            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                [$ID,$ID,$Empresa]
            );
            
            $linhas=$select->rowCount();
            $dados=$select->fetchAll();
                
            return[
                "linhas"=>$linhas,
                "dados"=>$dados
            ];
        }else if($TipoJuri=="PJ"){
            $tabela="Nota";
            
            $filtro="
            DISTINCT
            str_id_Nota as ID,
            dtm_dataDeEnvio_Nota as DataDeEnvio,
            str_nomeFantasia_PJ as PJ,
            str_nome_PF as PF,
            str_prestador_Nota as Prestador,
            flt_valor_Nota as Valor,
            dt_data_Nota as Data,
            str_url_LancamentosArquivos as Arquivo
            ";
            
            $where="
    
            LEFT JOIN
            PJ
            ON
            ? = str_empresa_Nota AND str_cnpj_PJ = ?
            
            LEFT JOIN
            LancamentosArquivos
            ON
            str_id_LancamentosArquivos = str_idComprovante_Nota
            
            LEFT JOIN
            PF
            ON
            str_cpf_PF = str_cpf_Nota
            
            WHERE
            str_empresa_Nota  = ? 
            ORDER BY 
            dtm_dataDeEnvio_Nota DESC";
            
            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                [$ID,$ID,$ID]
            );
            
            $linhas=$select->rowCount();
            $dados=$select->fetchAll();
            
            return[
                "linhas"=>$linhas,
                "dados"=>$dados
            ];
            
        }
    }
    
    public function getContrato($ID,$TipoJuri,$TipoPermissao=null,$Empresa=null){
        if($TipoJuri=="PF"){
            $tabela="Contrato";
            $filtro="
            DISTINCT
            str_id_Contrato as ID,
            dtm_dataDeEnvio_Contrato as DataDeEnvio,
            str_nomeFantasia_PJ as PJ,
            str_nome_PF as PF,
            str_historico_TipoDeHistorico as Historico,
            str_nome_TiposDePagamento as TipoDePagamento,
            str_agencia_Contas as Agencia,
            str_conta_Contas as Conta,
            str_descricao_Contrato as Descricao,
            int_nota_Contrato as Nota,
            flt_valor_Contrato as Valor,
            dt_data_Contrato as Data,
            str_url_LancamentosArquivos as Arquivo
            ";
            $where="
            
            INNER JOIN 
            PF
            ON
            str_cpf_PF = ?
            
            LEFT JOIN Contas ON str_idConta_Contrato = str_id_Contas
                
            LEFT JOIN TiposDePagamento ON int_idBanco_Contas = int_id_TiposDePagamento
            
            LEFT JOIN
            PJ
            ON
            str_cnpj_PJ = str_empresa_Contrato
            
            LEFT JOIN
            TipoDeHistorico
            ON
            int_id_TipoDeHistorico = int_idHistorico_Contrato
            
            LEFT JOIN
            LancamentosArquivos
            ON
            str_id_LancamentosArquivos = str_idComprovante_Contrato
            
            WHERE
            str_cpf_Contrato = ? AND str_empresa_Contrato = ?
            ORDER BY 
            dtm_dataDeEnvio_Contrato DESC";
            
            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                [$ID,$ID,$Empresa]
            );
                
            $linhas=$select->rowCount();
            $dados=$select->fetchAll();
            
            return[
                "linhas"=>$linhas,
                "dados"=>$dados
            ];
        }else if($TipoJuri=="PJ"){
            
            $tabela="Contrato";
            $filtro="
            DISTINCT
            str_id_Contrato as ID,
            dtm_dataDeEnvio_Contrato as DataDeEnvio,
            str_nomeFantasia_PJ as PJ,
            str_nome_PF as PF,
            str_historico_TipoDeHistorico as Historico,
            int_idBanco_Contas as TipoDePagamento,
            str_agencia_Contas as Agencia,
            str_conta_Contas as Conta,
            str_descricao_Contrato as Descricao,
            int_nota_Contrato as Nota,
            flt_valor_Contrato as Valor,
            dt_data_Contrato as Data,
            str_url_LancamentosArquivos as Arquivo
            ";
            $where="
            
            LEFT JOIN Contas ON str_idConta_Contrato = str_id_Contas
                
            LEFT JOIN TiposDePagamento ON int_idBanco_Contas = int_id_TiposDePagamento
            
            LEFT JOIN
            PJ
            ON
            ? = str_empresa_Contrato AND str_cnpj_PJ = ?
            
            LEFT JOIN
            TipoDeHistorico
            ON
            int_id_TipoDeHistorico = int_idHistorico_Contrato
            
            LEFT JOIN
            LancamentosArquivos
            ON
            str_id_LancamentosArquivos = str_idComprovante_Contrato
            
            LEFT JOIN
            PF
            ON
            str_cpf_PF = str_cpf_Contrato
            
            WHERE
            str_empresa_Contrato  = ? 
            ORDER BY 
            dtm_dataDeEnvio_Contrato DESC";
            
            $select=$this->selectDB(
                $filtro,
                $tabela,
                $where,
                [$ID,$ID,$ID]
            );
            
            $linhas=$select->rowCount();
            $dados=$select->fetchAll();
            
            return[
                "linhas"=>$linhas,
                "dados"=>$dados
            ];
            
        }
            
    }
    
    public function getCaminhoDoArquivo_Pagemento($id):array{

        $select=$this->selectDB(
            "str_id_LancamentosArquivos as ID,str_path_LancamentosArquivos as Caminho",
            "Pagamento",
            "INNER JOIN LancamentosArquivos
            ON
            :id = str_id_LancamentosArquivos
            WHERE 
            str_id_Pagamento = :id",
            [":id"=>$id]
        );

        return[
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }
    
    public function getCaminhoDoArquivo_Recebimento($id):array{
        $select=$this->selectDB(
            "str_id_LancamentosArquivos as ID,str_path_LancamentosArquivos as Caminho",
            "Recebimento",
            "INNER JOIN LancamentosArquivos
            ON
            :id = str_id_LancamentosArquivos
            WHERE 
            str_id_Recebimento = :id",
            [":id"=>$id]
        );
        
        return[
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }
    
    public function getCaminhoDoArquivo_Nota($ID){
        $select=$this->selectDB(
            "str_id_LancamentosArquivos,str_path_LancamentosArquivos",
            "Nota",
            "INNER JOIN LancamentosArquivos
            ON
            str_idComprovante_Nota = str_id_LancamentosArquivos
            WHERE 
            str_id_Nota = ?",
            [$ID]
        );
        $dados=$select->fetch();
        return $dados;
    }
    
    public function getCaminhoDoArquivo_Contrato($ID){
        $select=$this->selectDB(
            "str_id_LancamentosArquivos,str_path_LancamentosArquivos",
            "Contrato",
            "INNER JOIN LancamentosArquivos
            ON
            str_idComprovante_Contrato = str_id_LancamentosArquivos
            WHERE 
            str_id_Contrato = ?",
            [$ID]
        );
        $dados=$select->fetch();
        return $dados;
    }
    
    public function deleteArquivo($id):bool{
        
        $delete = $this->deleteDB(
            "LancamentosArquivos",
            "str_id_LancamentosArquivos = ?",
            [$id]
        );
        
        return $delete->rowCount() > 0;
    }
    
    public function deletePagamento($ID):bool{
        
        $this->deleteDB(
            "Pagamento",
            "str_id_Pagamento = ?",
            [$ID]
        );
      
        $select=$this->selectDB(
            "*",
            "Pagamento",
            "WHERE str_id_Pagamento = ?",
            [$ID]
        );
        
        $linhas=$select->rowCount();
        return $linhas<=0;
    }

    public function updatePagamento(array $dados){
        //exit(json_encode($dados));

        $exec = [
            ":descricao"=>$dados['Descricao'],
            ":beneficiario"=>$dados['Beneficiario'],
            ":nota"=>$dados['Nota'],
            ":valor"=>$dados['Valor'],
            ":data"=>$dados['Data'],
            ":conta"=>$dados['Conta'],
            ":historico"=>$dados['Historico'],
            ":idPagamento"=>$dados['IdPagamento'],
            ":cnpj"=>$dados['PJ']
        ];

        $query = "
            str_descricao_Pagamento = :descricao, 
            str_beneficiario_Pagamento = :beneficiario, 
            int_nota_Pagamento = :nota,
            flt_valor_Pagamento = :valor,
            dt_data_Pagamento = :data,
            str_idConta_Pagamento = :conta,
            str_idHistorico_Pagamento = :historico";

        if(isset($dados['IdComprovante'])){
            $query.=",str_idComprovante_Pagamento = :idComprovante";
            $exec += [":idComprovante"=>$dados['IdComprovante']];
        }

        $update = $this->updateDB(
            "Pagamento",
            $query,
            "str_id_Pagamento = :idPagamento AND str_empresa_Pagamento = :cnpj",
            $exec
        );

        

        /*$select = $this->selectDB(
            "*",
            "Pagamento",
            "WHERE str_descricao_Pagamento = :descricao 
            AND str_beneficiario_Pagamento = :beneficiario 
            AND int_nota_Pagamento = :nota
            AND flt_valor_Pagamento = :valor
            AND dt_data_Pagamento = :data
            AND str_idConta_Pagamento = :conta
            AND str_idHistorico_Pagamento = :historico
            AND str_id_Pagamento = :idPagamento 
            AND str_empresa_Pagamento = :cnpj",
            [
                ":descricao"=>$dados['Descricao'],
                ":beneficiario"=>$dados['Beneficiario'],
                ":nota"=>$dados['Nota'],
                ":valor"=>$dados['Valor'],
                ":data"=>$dados['Data'],
                ":conta"=>$dados['Conta'],
                ":historico"=>$dados['Historico'],
                ":idPagamento"=>$dados['IdPagamento'],
                ":cnpj"=>$dados['PJ']
            ]
        );*/

        /*return [
            "linhas"=>$update->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];*/
        //exit(json_encode($update->rowCount()));
        return $update->rowCount() > 0;
    }
    
    public function deleteRecebimento($ID):bool{
        
        $this->deleteDB(
            "Recebimento",
            "str_id_Recebimento = ?",
            [$ID]
        );
      
        $select=$this->selectDB(
            "*",
            "Recebimento",
            "WHERE str_id_Recebimento = ?",
            [$ID]
        );
        
        $linhas=$select->rowCount();
        return $linhas<=0;
    }

    public function updateRecebimento(array $dados):array{
        //exit(json_encode($dados));
    
        $this->updateDB(
            "Recebimento",
            "str_descricao_Recebimento = :descricao, 
            str_ofertante_Recebimento = :ofertante, 
            flt_valor_Recebimento = :valor,
            dt_data_Recebimento = :data,
            str_idConta_Recebimento = :conta,
            str_idHistorico_Recebimento = :historico",
            "str_id_Recebimento = :idRecebimento AND str_empresa_Recebimento = :cnpj",
            [
                ":descricao"=>$dados['Descricao'],
                ":ofertante"=>$dados['Ofertante'],
                ":valor"=>$dados['Valor'],
                ":data"=>$dados['Data'],
                ":conta"=>$dados['Conta'],
                ":historico"=>$dados['Historico'],
                ":idRecebimento"=>$dados['IdRecebimento'],
                ":cnpj"=>$dados['PJ']
            ]
        );       

        $select = $this->selectDB(
            "*",
            "Recebimento",
            "WHERE str_descricao_Recebimento = :descricao 
            AND str_ofertante_Recebimento = :ofertante 
            AND flt_valor_Recebimento = :valor
            AND dt_data_Recebimento = :data
            AND str_idConta_Recebimento = :conta
            AND str_idHistorico_Recebimento = :historico
            AND str_id_Recebimento = :idRecebimento 
            AND str_empresa_Recebimento = :cnpj",
            [
                ":descricao"=>$dados['Descricao'],
                ":ofertante"=>$dados['Ofertante'],
                ":valor"=>$dados['Valor'],
                ":data"=>$dados['Data'],
                ":conta"=>$dados['Conta'],
                ":historico"=>$dados['Historico'],
                ":idRecebimento"=>$dados['IdRecebimento'],
                ":cnpj"=>$dados['PJ']
            ]
        );

        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function updateArquivoRecebimento(array $dados){
        //exit(json_encode($dados));
        $update = $this->updateDB(
            "Recebimento",
            "str_idGrupoComprovante_Recebimento = :idGrupoComprovante",
            "str_id_Recebimento = :idRecebimento",
            [
                ":idRecebimento"=>$dados['IdRecebimento'],
                ":idGrupoComprovante"=>$dados['IdGrupoComprovante']
            ]
        );

        return $update->rowCount() > 0;
    }

    public function updateArquivoPagamento(array $dados){
        //exit(json_encode($dados));
        $update = $this->updateDB(
            "Pagamento",
            "str_idGrupoComprovante_Pagamento = :idGrupoComprovante",
            "str_id_Pagamento = :idPagamento",
            [
                ":idPagamento"=>$dados['IdPagamento'],
                ":idGrupoComprovante"=>$dados['IdGrupoComprovante']
            ]
        );

        return $update->rowCount() > 0;
    }
    
    public function deleteNota($ID){
        
        $this->deleteDB(
            "Nota",
            "str_id_Nota = ?",
            [$ID]
        );
      
        $select=$this->selectDB(
            "*",
            "Nota",
            "WHERE str_id_Nota = ?",
            [$ID]
        );
        
        $linhas=$select->rowCount();
        return $linhas<=0;
    }
    
    public function deleteContrato($ID){
        
        $this->deleteDB(
            "Contrato",
            "str_id_Contrato = ?",
            [$ID]
        );
      
        $select=$this->selectDB(
            "*",
            "Contrato",
            "WHERE str_id_Contrato = ?",
            [$ID]
        );
        
        $linhas=$select->rowCount();
        return $linhas<=0;
    }

    public function getPagamentoById(array $dados){
        $select = $this->selectDB(
            'str_id_Pagamento as idPagamento,
            str_idComprovante_Pagamento as idComprovante',
            'Pagamento',
            'WHERE str_id_Pagamento = :id AND str_empresa_Pagamento = :cnpj',
            [
                ":id"=>$dados['id'],
                ":cnpj"=>$dados['cnpj']
            ]
        );

        return [
            'linhas'=>$select->rowCount(),
            'dados'=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function getArquivoLancamentoById($id){
        $select = $this->selectDB(
            "str_id_LancamentosArquivos	as id,
            str_url_LancamentosArquivos	as url,
            str_path_LancamentosArquivos as path,
            str_extencao_LancamentosArquivos as extensao,	
            str_nome_LancamentosArquivos as nome,	
            str_uniqid_LancamentosArquivos as uniqid",
            'LancamentosArquivos',
            'WHERE str_id_LancamentosArquivos = :id',
            [":id"=>$id]
        );

        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }

    public function updateArquivo(array $dados){
        //exit(json_encode($dados));
        $update = $this->updateDB(
            "LancamentosArquivos",

            "str_url_LancamentosArquivos = :url,
            str_path_LancamentosArquivos = :path,
            str_extencao_LancamentosArquivos = :extensao_new,
            str_nome_LancamentosArquivos = :nome,
            str_uniqid_LancamentosArquivos = :uniqid_new",

            "str_id_LancamentosArquivos = :id 
            AND str_uniqid_LancamentosArquivos = :uniqid_old",

            [
                ":url"=>$dados['url'],
                ":path"=>$dados['path'],
                ":extensao_new"=>$dados['extensao_new'],
                ":nome"=>$dados['nome'],
                ":uniqid_new"=>$dados['uniqid_new'],
                ":uniqid_old"=>$dados['uniqid_old'],
                ":id"=>$dados['id']
            ]
        );

        //exit(json_encode($update->rowCount()));

        /*$select = $this->selectDB(
            "*",
            "LancamentosArquivos",
            "WHERE str_id_LancamentosArquivos = :id
            AND str_url_LancamentosArquivos = :url
            AND str_path_LancamentosArquivos = :path
            AND str_extencao_LancamentosArquivos = :extensao
            AND str_uniqid_LancamentosArquivos = :uniqid
            AND str_nome_LancamentosArquivos = :nome",
            [
                ":url"=>$dados['URL'],
                ":path"=>$dados['Caminho'],
                ":extensao"=>$dados['Extensao'],
                ":nome"=>$dados['Nome'],
                ":uniqid"=>$dados['Uniqid'],
                ":id"=>$dados['Id']
            ]
        );*/

        return $update->rowCount()>0;
    }

    public function getArquivoByGrupo(string $grupo){
        $select = $this->selectDB(
            'str_id_LancamentosArquivos as id,
            dtm_criacao_LancamentosArquivos as criacao,
            str_url_LancamentosArquivos as url,
            str_path_LancamentosArquivos as path,
            str_extencao_LancamentosArquivos as extensao,
            str_nome_LancamentosArquivos as nome,
            str_uniqid_LancamentosArquivos as uniqid,
            str_grupo_LancamentosArquivos as grupo',

            'LancamentosArquivos',

            "WHERE str_grupo_LancamentosArquivos = :grupo",

            [":grupo"=>$grupo]
        );

        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetchAll(\PDO::FETCH_ASSOC)
        ];
    }

    /*public function deleteArquivo(array $dados){
        /*exit(json_encode($dados));
        $delete = $this->deleteDB(
            "LancamentosArquivos",
            "str_id_LancamentosArquivos = :idComprovante 
            AND str_grupo_LancamentosArquivos = :idGrupoComprovante",
            [
                ":idComprovante"=>$dados['idComprovante'],
                ":idGrupoComprovante"=>$dados['idGrupoComprovante']
            ]
        );

        return $delete->rowCount() > 0;
    }*/
}
?>