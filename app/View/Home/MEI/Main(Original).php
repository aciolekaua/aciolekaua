<?php
use Src\Classes\ClassValidate;
$Validate = new ClassValidate;

if($_SESSION['TipoCliente']=="PJ"){$TipoJuridico = $_SESSION['TipoJuridico'];}
if($_SESSION['TipoCliente']=="PF"){$display="style='display:none;'";}
?>
<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div <?php echo($display);?> class="row">
      <div class="col-md mb-3">
        <div class="card bg-success text-white h-100">
            <h5 class="card-header">Entradas desse Mês</h5>
           
            <div class="card-body">
                <?php
                $recebimento = $Validate->validateGetValorRecebimento([
                    'ID'=>$_SESSION['ID'],
                    'TipoCliente'=>$_SESSION['TipoCliente'],
                    'DataAtual'=>date("Y-m-d")
                ]);
                echo("Total: R$ <span id='recebimento'>".number_format($recebimento, 2, ',', '.')."</span>"); 
                ?>
            </div>
            
             <div class='card-footer'>
                <button type="button" class="btn text-white" style="background-color:#356338;" data-bs-toggle="modal" data-bs-target="#Recebimento">
                  Lista de Grupos
                </button>
                <div class="modal fade" id="Recebimento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLabel">Lista de Grupos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                            <div class='table-responsive'>
                                
                                <div class='mb-3'>
                                    <button class='btn btn-success' onclick="exportExcel('tabelaModal1','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>
                                    <button class='btn btn-danger' onclick="exportPDF('tabelaModal1','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>
                                </div>
                           
                                <?php 
                                    $grupos=$Validate->validateGrupos([
                                        'ID'=>$_SESSION['ID'],
                                        'TipoCliente'=>$_SESSION['TipoCliente'],
                                        'Tabela'=>"Recebimento",
                                        'DataAtual'=>date("Y-m-d")
                                    ]);
                                    echo"<table id='tabelaModal1' class='table'>";
                                     echo"<tr><th>Recebimento</th></tr>";
                                    foreach($grupos as $key => $value){echo("<tr><td>{$value['Historico']}: R$ ".number_format($value['Valor'],2, ',', '.')."</td></tr>");}
                                    echo"</table>";
                                 ?>
                            </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-md mb-3">
        <div class="card bg-danger text-white h-100">
            <h5 class="card-header">Gastos desse Mês</h5>
            <div class="card-body">
                <?php
                
                $pagamento = (float)$Validate->validateGetValorPagamento([
                    "ID"=>$_SESSION['ID'],
                    "TipoCliente"=>$_SESSION['TipoCliente'],
                    "DataAtual"=>date("Y-m-d")
                ]);
                $nota = (float)$Validate->validateGetValorNota([
                    "ID"=>$_SESSION['ID'],
                    "TipoCliente"=>$_SESSION['TipoCliente'],
                    "DataAtual"=>date("Y-m-d")
                ]);
                $contrato = (float)$Validate->validateGetValorContrato([
                    "ID"=>$_SESSION['ID'],
                    "TipoCliente"=>$_SESSION['TipoCliente'],
                    "DataAtual"=>date("Y-m-d")
                ]);
                echo("Total: R$ <span id='pagamento'>".number_format(($pagamento + $nota + $contrato), 2, ',', '.')."</span>"); 
                ?>
            </div>
            <div class='card-footer'>
                <button type="button" class="btn text-white" style="background-color:#A21D1D;" data-bs-toggle="modal" data-bs-target="#Pagamento">
                  Lista de Grupos
                </button>
                <div class="modal fade" id="Pagamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLabel">Lista de Grupos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                        <div class="modal-body">
                            <div class='table-responsive'>
                                <div class='mb-3'>
                                    <button class='btn btn-success' onclick="exportExcel('tabelaModal2','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>
                                    <button class='btn btn-danger' onclick="exportPDF('tabelaModal2','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>
                                </div>
                                
                                <?php 
                                    $gruposPagamento = $Validate->validateGrupos([
                                        'ID'=>$_SESSION['ID'],
                                        'TipoCliente'=>$_SESSION['TipoCliente'],
                                        'Tabela'=>"Pagamento",
                                        'DataAtual'=>date("Y-m-d")
                                    ]);
                                    
                                    $gruposContrato = $Validate->validateGrupos([
                                        'ID'=>$_SESSION['ID'],
                                        'TipoCliente'=>$_SESSION['TipoCliente'],
                                        'Tabela'=>"Contrato",
                                        'DataAtual'=>date("Y-m-d")
                                    ]);
                                    echo"<table id='tabelaModal2' class='table'>";
                                    echo"<tr><th>Nota</th></tr>";
                                    echo"<tr><td>Total de Nota: R$ ".number_format($nota,2, ',', '.')."</td></tr>";
                                    
                                    echo"<tr><th>Pagamento</th></tr>";
                                    foreach($gruposPagamento as $key => $value){$totalPagamento+=(float)$value['Valor'];echo("<tr><td>{$value['Historico']}: R$ ".number_format($value['Valor'],2, ',', '.')."</td></tr>");}
                                    echo"<tr><td>Total de Pagamento: R$ ".number_format($totalPagamento,2, ',', '.')."</td></tr>";
                                    
                                    echo"<tr><th>Contrato</th></tr>";
                                    foreach($gruposContrato as $key => $value){$totalContrato+=(float)$value['Valor'];echo("<tr><td>{$value['Historico']}: R$ ".number_format($value['Valor'],2, ',', '.')."</td></tr>");}
                                    echo"<tr><td>Total de Contrato: R$ ".number_format($totalContrato,2, ',', '.')."</td></tr>";
                                    echo"</table>";
                                ?>
                            </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            
        </div>
      </div>
      
      <div class="col-md mb-3">
        <div class="card bg-primary text-white h-100">
            <h5 class="card-header">Saldo</h5>
            <div class="card-body">
                Total: R$ 
                <span id='saldoOutput'>
                    <?php
                    
                        $saldoRecebimento = $Validate->validateGetValorRecebimento([
                            'ID'=>$_SESSION['ID'],
                            'TipoCliente'=>$_SESSION['TipoCliente'],
                            'DataAtual'=>date("Y-m-d"),
                            "Saldo"=>true
                        ]);
                        
                        $saldoPagamento = (float)$Validate->validateGetValorPagamento([
                            "ID"=>$_SESSION['ID'],
                            "TipoCliente"=>$_SESSION['TipoCliente'],
                            "DataAtual"=>date("Y-m-d"),
                            "Saldo"=>true
                        ]);
                        
                        $saldoNota = (float)$Validate->validateGetValorNota([
                            "ID"=>$_SESSION['ID'],
                            "TipoCliente"=>$_SESSION['TipoCliente'],
                            "DataAtual"=>date("Y-m-d"),
                            "Saldo"=>true
                        ]);
                        
                        $saldoContrato = (float)$Validate->validateGetValorContrato([
                            "ID"=>$_SESSION['ID'],
                            "TipoCliente"=>$_SESSION['TipoCliente'],
                            "DataAtual"=>date("Y-m-d"),
                            "Saldo"=>true
                        ]);
                        $saldoAtual = $saldoRecebimento-($saldoPagamento + $saldoNota + $saldoContrato);
                        echo("<span>".number_format($saldoAtual,2, ',', '.')."</span>");
                    ?>
                </span>
            </div>
            <div class='card-footer'>
                
            </div>
        </div>
      </div>
    </div>
    
    <?php if($_SESSION['TipoJuridico']=="302066064"){ include_once("MEI/MainMEI.php");}?>
    
    <div <?php echo($display);?> class="row">
      <div class="col-md mb-3">
        <div class="card h-100">
          <div class="card-header">
            <span class="me-2"><i class="bi bi-cash-stack"></i><i class="ms-1 bi bi-arrow-up-circle"></i></span>
            Entradas Anuais
          </div>
          <div class="card-body">
            <canvas id="recebimentoChats" class="chart recebimento" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <div <?php echo($display);?> class="row">
        <div class="col-md mb-3">
            <div class="card h-100">
                <div class="card-header">
                    <span class="me-2"><i class="bi bi-cash-stack"></i><i class="ms-1 bi bi-arrow-down-circle"></i></span>
                    Gastos Anuais
                 </div>
                <div class="card-body">
                    <canvas class="chart gastos" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    
  </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>-->