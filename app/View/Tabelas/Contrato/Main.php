<?php
use Src\Classes\ClassValidate;
use App\Model\ClassGestaoDeConselho;
$GestaoDeConselho = new ClassGestaoDeConselho;
$Validate=new ClassValidate;
if($_SESSION['TipoCliente']=="PJ" || $_SESSION['TipoPermissao']=="687028677" || $_SESSION['TipoPermissao']=="948880538"){
    $numConselherios=$GestaoDeConselho->getConselheiros($_SESSION['ID'])['dados'];
    $exclusao=true;
}else{$exclusao=false;}

if($_SESSION['TipoPermissao']=="948880538" || $_SESSION['TipoPermissao']=="147031419"){
    $conselho=true;
}else{$conselho=false;}

if($_SESSION['TipoCliente']!="PF"){$display="style='display:none;'";}
?>

<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div id='mensage'></div>
        <div class='row mb-1'>
            <form class='row' <?php echo($display); ?> action='<?php echo(DIRPAGE."tabelas-contrato"); ?>' method='post'>
                
                <div class='form-group col'>
                    <select class='form-select w-50' name='pj' required>
                        <option value="">Selecione uma opção</option>
                            <?php
                                if($_SESSION['TipoCliente']=="PF"){
                                   $d=$Validate->validateGetAssociacao($_SESSION['ID']);
                                    $numL=(count($d)-1);
                                    for($l=0;$l<=$numL;$l++){
                                        echo"<option ";
                                        echo"value={$d[$l]['str_cnpj_PJ']}";
                                        echo" >";
                                        echo"{$d[$l]['str_nome_PJ']}";
                                        echo"</option>";
                                    } 
                                }
                                
                            ?>
                    </select>
                </div>
                
                <div class='form-group col'>
                    <input class='btn btn-primary' type='submit' value='Atualizar'/>
                </div>
                
            </form>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <form action="<?php echo(DIRPAGE."tabelas-contrato/executar"); ?>" method="post">
                <div class="form-group">
                    <div class="card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-table me-2"></i>Tabela de Contrato</span>
                        <button class='btn btn-primary ms-3' type='button' name='baixar' onclick=html_to_excel('#tabela_contrato','Tabela_de_Contrato'); >Baixar</button>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table
                            id="tabela_contrato"
                            class="table table-striped data-table"
                            style="width: 100%"
                            data-excel-name="Tabela de Contrato"
                          >
                            <thead>
                              <tr>
                                <?php if($exclusao || $conselho){echo("<th>Selecionar</th>");}?>
                                <th>Data de Envio</th>
                                <th>PJ</th>
                                <th>Lançador</th>
                                <th>Histórico</th>
                                <th>Pagamento</th>
                                <th>Agência</th>
                                <th>Conta</th>
                                <th>Descrição</th>
                                <th>Nº da Nota</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Arquivo</th>
                                <?php if($_SESSION['TipoCliente']=="PJ"){
                                    $i=1;
                                    if(is_array($numConselherios)){
                                        foreach($numConselherios as $key => $array){
                                            echo"<th>Conselheiro {$i}</th>";
                                            $i++;
                                        }
                                    }
                                    $i=0;
                                }?>
                              </tr>
                            </thead>
                            <tbody id="tbodyTabela">
                                <?php include_once("DadosTabela.php"); ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <?php if($exclusao || $conselho){echo("<th>Selecionar</th>");}?>
                                <th>Data de Envio</th>
                                <th>PJ</th>
                                <th>Lançador</th>
                                <th>Histórico</th>
                                <th>Pagamento</th>
                                <th>Agência</th>
                                <th>Conta</th>
                                <th>Descrição</th>
                                <th>Nº da Nota</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Arquivo</th>
                                <?php if($_SESSION['TipoCliente']=="PJ"){
                                    $i=1;
                                    if(is_array($numConselherios)){
                                        foreach($numConselherios as $key => $array){
                                            echo"<th>Conselheiro {$i}</th>";
                                            $i++;
                                        }
                                    }
                                    $i=0;
                                }?>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                        <div class='card-footer d-flex align-items-center justify-content-around'>
                            <?php if($conselho){echo("<input class='btn btn-success' type='submit' name='aprovar' value='Aprovar'>");} ?>
                            <?php if($exclusao){echo("<input class='btn btn-danger' type='submit' name='excluir' value='Excluir'>");} ?>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
</main>
