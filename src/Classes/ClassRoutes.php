<?php
    namespace Src\Classes;
    
    use Src\Traits\TraitUrlParser;
    
    class ClassRoutes{
        
        use TraitUrlParser;
        
        private $Rota;
        
        public function getRota(){
            
            $Url=$this->parseUrl();
            $I=$Url[0];
            
            $this->Rota=array(
                ""=>"ControllerLogin",
                "home"=>"ControllerHome",
                "cadastro"=>"ControllerCadastro",
                "login"=>"ControllerLogin",
                "logout"=>"ControllerLogout",
                "perfil"=>"ControllerPerfil",
                "mudar-senha"=>"ControllerMudaSenha",
                "recuperar-senha"=>"ControllerRecuperarSenha",
                "confirma-cadastro"=>"ControllerConfirmaCadastro",
                "teste"=>"ControllerTestes",
                "teste2"=>"ControllerTestes2",
                "gestao-de-usuarios"=>"ControllerGestaoDeUsuarios",
                "lancamentos-pagamento"=>"ControllerLancamento_Pagamento",
                "lancamentos-recebimento"=>"ControllerLancamento_Recebimento",
                "lancamentos-nota"=>"ControllerLancamento_Nota",
                "lancamentos-contrato"=>"ControllerLancamento_Contrato",
                "tabelas-pagamento"=>"ControllerTabela_Pagamento",
                "tabelas-recebimento"=>"ControllerTabela_Recebimento",
                "tabelas-nota"=>"ControllerTabela_Nota",
                "tabelas-contrato"=>"ControllerTabela_Contrato",
                "area-contador"=>"ControllerAreaContador",
                "area-nota-configuracao"=>"ControllerAreaNota_Configuracao",
                "area-nota-nfse"=>"ControllerAreaNota_LancamentoNFSE",
                "area-nota-consulta"=>"ControllerAreaNota_Consulta",
                "conciliador"=>"ControllerEmDesenvolvimento",
                "agenda"=>"ControllerAgenda",
                "registroponto"=>"ControllerRegistroPonto",
                "clima"=>"ControllerClima",
                "emdesenvolvimento"=>"ControllerEmDesenvolvimento",
                "checkout-pagamento"=>"ControllerCheckoutPagamento",
                "eventos"=>"ControllerEmDesenvolvimento",
                "extrato"=>"ControllerExtrato",
                "gerador-contratos"=>"ControllerGeradorContratos",
                "simples-nacional"=>"ControllerSimplesNacional",
                "jwt-node-red"=>"ControllerNodeRed",
                "app-sing"=>"ControllerAppSing",
                "calcular-simples"=>"ControllerCalcularSimples",
                "configuracao-lancamento"=>"ControllerConfiguracaoLancamento",
                "gerenciador"=>"ControllerGerenciador",
                "registro-funcionario"=>"ControllerRegistroFuncionario",
                "registro-empresa"=>"ControllerRegistroEmpresa",
                "calcular-simples-rbt12"=>"ControllerCalcularRBT12"
            );
            
            if(array_key_exists($I,$this->Rota)){
                
                if(file_exists(DIRREQ."app/Controller/{$this->Rota[$I]}.php")){
                    return $this->Rota[$I];           
                }else{
                    return "ControllerHome";
                }
                
            }else{
                return "Controller404";
            }
            
        }
        
    }
?>