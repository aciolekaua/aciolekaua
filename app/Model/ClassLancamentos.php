<?php
namespace App\Model;
use App\Model\ClassCrud;
class ClassLancamentos extends ClassCrud{
    
    public function getAssociacao($param){
   
        $select=$this->selectDB(
            "str_cnpj_PJ as CNPJ,
            str_nomeFantasia_PJ as Nome",
            "Associados assoc",
            "INNER JOIN 
                PJ cadE
                ON
                cadE.str_cnpj_PJ = assoc.str_empresa_Associados
                
            INNER JOIN 
                PF cad
                ON
                cad.str_cpf_PF = ?
                
            INNER JOIN 
                NiveisDePermissoes perm
                ON
                perm.int_id_NiveisDePermissoes = assoc.int_permissao_Associados
            WHERE 
            	str_cpf_Associados = ?",
            	
            [$param,$param]
            
        );
        return $select->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
    public function tipoJuri($CNPJ){
        $select=$this->selectDB(
            "str_tipoJuridico_PJ",
            "PJ",
            "WHERE str_cnpj_PJ = ?",
            [$CNPJ]
            );
        $linha=$select->rowCount(); 
        $dados=$select->fetch(\PDO::FETCH_ASSOC);
        return [
            "dados"=>$dados["str_tipoJuridico_tbcadastroEmpresas"],
            "linhas"=>$linha
            ];
    }
    
    public function historicos($dados=null){
        
        $exec=array();
        $where="INNER JOIN TipoDeAcao ON int_idAcao_TipoDeAcao = int_idAcao_TipoDeHistorico ";
        
        if(isset($dados['PJ'])){
            /*$where.=" WHERE int_idAcao_TipoDeHistorico = ? OR int_idAcao_TipoDeHistorico = 2 ";
            array_push($exec,$dados['TipoHistorico']);*/
        }
        
        if(isset($dados['TipoHistorico'])){
            $where.=" WHERE int_idAcao_TipoDeHistorico = ? OR int_idAcao_TipoDeHistorico = 2 ";
            array_push($exec,$dados['TipoHistorico']);
        }
        
        $select=$this->selectDB(
            "int_id_TipoDeHistorico as ID,
            str_historico_TipoDeHistorico as Historico,
            str_descricao_TipoDeAcao as Descricao,
            int_idAcao_TipoDeAcao as IdDecricao",
            
            "TipoDeHistorico",
            
            $where." ORDER BY str_historico_TipoDeHistorico ASC",
            
            $exec
        );
        
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        return [
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
    }
    
    public function getTipoDePagamento(){
        $select=$this->selectDB(
            "int_id_TiposDePagamento as ID,
            str_nome_TiposDePagamento as Nome",
            "TiposDePagamento",
            "",
            []
            );
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        return[
            "linhas"=>$linhas,
            "dados"=>$dados
            ];
    }
    
    public function insertUpload($dados){
        
        $this->insertDB(
            "LancamentosArquivos(
                str_id_LancamentosArquivos,
                str_url_LancamentosArquivos,
                str_path_LancamentosArquivos,
                str_extencao_LancamentosArquivos,
                str_nome_LancamentosArquivos,
                str_uniqid_LancamentosArquivos,
                dtm_criacao_LancamentosArquivos,
                str_grupo_LancamentosArquivos 
            )",
            ":id_arquivo,
            :url,
            :path,
            :extensao,
            :nome,
            :uniqid,
            :criacao,
            :grupo",
            [
                ":id_arquivo"=>$dados['IdArquivo'],
                ":url"=>$dados['URL'],
                ":path"=>$dados['Caminho'],
                ":extensao"=>$dados['Extensao'],
                ":nome"=>$dados['Nome'],
                ":uniqid"=>$dados['Uniqid'],
                ":criacao"=>date('Y-m-d H:i:s'),
                ":grupo"=>$dados['Grupo']
            ]
        );
        $select=$this->selectDB(
            "*",
            "LancamentosArquivos",
            "WHERE str_id_LancamentosArquivos = ?",
            [
                $dados['IdArquivo']
            ]
        );
       
        return [
            "linhas"=>$select->rowCount(),
            "dados"=>$select->fetch(\PDO::FETCH_ASSOC)
        ];
    }
    
    public function getContas($ID){
        //exit(json_encode($ID));
        $select=$this->selectDB(
            "c.str_id_Contas as ID,
        	tp.str_nome_TiposDePagamento as Nome,
            c.str_agencia_Contas as Agencia,
            c.str_conta_Contas as Conta",
            "Contas c",
            "INNER JOIN 
        	TiposDePagamento tp
        	ON
            tp.int_id_TiposDePagamento = c.int_idBanco_Contas
            WHERE c.str_cpf_Contas = ? OR c.str_cnpj_Contas = ?",
            [$ID,$ID]
        );
            
        $linhas=$select->rowCount();
        $dados=$select->fetchAll(\PDO::FETCH_ASSOC);
        
        return [
            "linhas"=>$linhas,
            "dados"=>$dados
        ];
                    
        
    }
    
    public function issetSaldo($ID,$TipoCliente){
        if($TipoCliente=="PJ"){
            $tabela="SaldoPJ";
            $where="WHERE str_empresa_SaldoPJ = ?";
        }else if($TipoCliente=="PF"){
            
        }
        $select = $this->selectDB(
            "*",
            "{$tabela}",
            "{$where}",
            [$ID]
        );
        
        return $select->rowCount();
    }
    
    public function insertSaldo($dados){
        if($dados['TipoCliente']=="PJ"){
            $tabela="SaldoPJ";
            $where="WHERE str_empresa_SaldoPJ = ?";
        }else if($dados['TipoCliente']=="PF"){
            $tabela="";
        }
        
        $this->insertDB(
            "{$tabela}",
            "?,?",
            [$dados['ID'],$dados['Valor']]
        );
        
        $select = $this->selectDB(
            "*",
            "{$tabela}",
            "{$where}",
            [$dados['ID']]
        );
        
        return $select->rowCount();
    } 
    
    public function updateSaldo($dados){
       
    }
    
    public function insertConta($Dados){
        
        $this->insertDB(
            "Contas",
            "?,?,?,?,?,?",
            [
                $Dados['idConta'],
                $Dados['Banco'],
                $Dados['Agencia'],
                $Dados['Conta'],
                $Dados['CPF'],
                $Dados['CNPJ']
            ]
        );
        
        $select=$this->selectDB(
            "*",
            "Contas",
            "WHERE str_id_Contas = ?",
            [
                $Dados['idConta']
            ]
        );
        $linhas=$select->rowCount();
        return [
            "linhas"=>$linhas
        ];
    }
    
    public function issetConta($Dados){
        
        $select=$this->selectDB(
            "*",
            "Contas",
            "WHERE 
                int_idBanco_Contas = ? 
            AND 
                str_agencia_Contas = ? 
            AND 
                str_conta_Contas = ? 
            AND 
                str_cpf_Contas = ?",
            [
                $Dados['Banco'],
                $Dados['Agencia'],
                $Dados['Conta'],
                $Dados['CPF']
            ]
        );
        
        $linhas=$select->rowCount();
        
        return [
            "linhas"=>$linhas
        ];
    }

    public function insertPagamentoTeste($dados){

        //exit(json_encode($dados));
        
        $this->insertDB(
            "PagamentoTeste",
            "?,?,?,?,?,?,?,?,?,?,?,?,?",
            [
                $dados['IdRegistro'],
                $dados['DataAtual'],
                $dados['PJ'],
                $dados['FormaDePagamento'],
                $dados['Historico'],
                $dados['Descricao'],
                $dados['Beneficiario'],
                $dados['Nota'],
                $dados['Valor'],
                $dados['Data'],
                $dados['IdArquivo'],
                $dados['QRCodeLink'],
                $dados['ID']
            ]
            );
            
        $select=$this->selectDB(
            "*",
            "PagamentoTeste",
            "WHERE str_id_Pagamento = ?",
            [
                $dados['IdRegistro']
            ]
            );
        $linhas=$select->rowCount();
        return $linhas;
    }
    
    public function insertPagamento($Dados){

        //exit(json_encode($Dados));
        
        $this->insertDB(
            "Pagamento(
                str_id_Pagamento,
                dtm_dataDeEnvio_Pagamento,
                str_empresa_Pagamento,
                str_idConta_Pagamento,
                str_idHistorico_Pagamento,
                str_descricao_Pagamento,
                str_beneficiario_Pagamento,
                int_nota_Pagamento,
                flt_valor_Pagamento,
                dt_data_Pagamento,
                str_idGrupoComprovante_Pagamento,
                str_linkQRCode_Pagamento,
                str_cpf_Pagamento
            )",
            ":IdRegistro,
            :DataAtual,
            :PJ,
            :FormaDePagamento,
            :Historico,
            :Descricao,
            :Beneficiario,
            :Nota,
            :Valor,
            :Data,
            :IdGrupoComprovante,
            :QRCodeLink,
            :ID",
            [
                ":IdRegistro"=>$Dados['IdRegistro'],
                ":DataAtual"=>$Dados['DataAtual'],
                ":PJ"=>$Dados['PJ'],
                ":FormaDePagamento"=>$Dados['FormaDePagamento'],
                ":Historico"=>$Dados['Historico'],
                ":Descricao"=>$Dados['Descricao'],
                ":Beneficiario"=>$Dados['Beneficiario'],
                ":Nota"=>$Dados['Nota'],
                ":Valor"=>$Dados['Valor'],
                ":Data"=>$Dados['Data'],
                ":IdGrupoComprovante"=>$Dados['IdGrupoComprovante'],
                ":QRCodeLink"=>$Dados['QRCodeLink'],
                ":ID"=>$Dados['ID']
            ]
            );
            
        $select=$this->selectDB(
            "*",
            "Pagamento",
            "WHERE str_id_Pagamento = ?",
            [
                $Dados['IdRegistro']
            ]
            );
        $linhas=$select->rowCount();
        return $linhas;
    }
    
    public function insertRecebimento($Dados){
        
        /*if($TipoJuri=="PF"){
            $tabela="RecebimentoCPF";
            $where="";
        }*/
        
        $this->insertDB(
            "Recebimento(
                str_id_Recebimento,
                dtm_dataDeEnvio_Recebimento,
                str_empresa_Recebimento,
                str_idConta_Recebimento,
                str_idHistorico_Recebimento,
                str_descricao_Recebimento,
                str_ofertante_Recebimento,
                flt_valor_Recebimento,
                dt_data_Recebimento,
                str_idGrupoComprovante_Recebimento,
                str_cpf_Recebimento
            )",
            ":IdRegistro,
            :DataAtual,
            :PJ,
            :FormaDeRecebimento,
            :Historico,
            :Descricao,
            :Ofertante,
            :Valor,
            :Data,
            :IdGrupoComprovante,
            :ID",
            [
                ":IdRegistro"=>$Dados['IdRegistro'],
                ":DataAtual"=>$Dados['DataAtual'],
                ":PJ"=>$Dados['PJ'],
                ":FormaDeRecebimento"=>$Dados['FormaDeRecebimento'],
                ":Historico"=>$Dados['Historico'],
                ":Descricao"=>$Dados['Descricao'],
                ":Ofertante"=>$Dados['Ofertante'],
                ":Valor"=>$Dados['Valor'],
                ":Data"=>$Dados['Data'],
                ":IdGrupoComprovante"=>$Dados['IdGrupoComprovante'],
                ":ID"=>$Dados['ID']
            ]
        );
        
        $select=$this->selectDB(
            "*",
            "Recebimento",
            "WHERE str_id_Recebimento = ?",
            [
               $Dados['IdRegistro'] 
            ]
        );
        
        $linhas=$select->rowCount();
        return $linhas;
    }
    
    public function insertNota($Dados){
        
        $this->insertDB(
            "Nota",
            "?,?,?,?,?,?,?,?,?",
            [
                $Dados['IdRegistro'],
                $Dados['dataAtual'],
                $Dados['PJ'],
                $Dados['Prestador'],
                $Dados['Nota'],
                $Dados['Valor'],
                $Dados['Data'],
                $Dados['IdArquivo'],
                $Dados['ID']
            ]
        );
        
        $select=$this->selectDB(
            "*",
            "Nota",
            "WHERE str_id_Nota = ?",
            [
                $Dados['IdRegistro']
            ]
        );
        
        $linhas=$select->rowCount();
        return $linhas;
    }
    
    public function insertContrato($Dados){
        
        $this->insertDB(
            "Contrato",
            "?,?,?,?,?,?,?,?,?,?,?",
            [
                $Dados['IdRegistro'],
                $Dados['DataAtual'],
                $Dados['PJ'],
                $Dados['FormaDePagamento'],
                $Dados['Beneficiario'],
                $Dados['Descricao'],
                $Dados['Nota'],
                $Dados['Valor'],
                $Dados['Data'],
                $Dados['IdArquivo'],
                $Dados['ID']
            ]
        );
        $select=$this->selectDB(
            "*",
            "Contrato",
            "WHERE str_id_Contrato = ?",
            [
                $Dados['IdRegistro'],
            ]
        );
        
        $linhas=$select->rowCount();
        
        return $linhas;
    }
    
    public function issetPagamento($dados){
        $select=$this->selectDB(
            "*",
            "Pagamento",
            "WHERE 	str_empresa_Pagamento = ? AND int_nota_Pagamento = ?",
            [$dados['PJ'],$dados['Nota']]
        );
        return $select->rowCount()>0;
    }

    public function issetRecebimento($dados){
        $select=$this->selectDB(
            "*",
            "Recebimento",
            "WHERE 	str_empresa_Recebimento = ? AND int_nota_Recebimento = ?",
            [$dados['PJ'],$dados['Nota']]
        );
        return $select->rowCount()<=0;
    }
    
    public function issetNota($dados){
        $select=$this->selectDB(
            "*",
            "Nota",
            "WHERE 	str_empresa_Nota = ? AND int_numero_Nota = ?",
            [$dados['PJ'],$dados['Nota']]
        );
        return $select->rowCount()<=0;
    }

    public function issetContrato($dados){
        $select=$this->selectDB(
            "*",
            "Contrato",
            "WHERE 	str_empresa_Contrato = ? AND int_nota_Contrato = ?",
            [$dados['PJ'],$dados['Nota']]
        );
        return $select->rowCount()<=0;
    }
}
?>