<main class="mt-5 pt-3">
  <div class="container-fluid">
      
    <div id='cardGastosMensais' class="row">
        
      <div class="col-md mb-3">
        <div id='cardEntradas'class="card bg-success text-white h-100">
            <h5 class="card-header">Entradas Mensais</h5>
           
            <div class="card-body"></div>
            
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
                            <div class='mb-3'>
                                <button class='btn btn-success' onclick="exportExcel('tabelaReceita','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>
                                <button class='btn btn-danger' onclick="exportPDF('tabelaReceita','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>
                            </div>
                            <div class='table-responsive'>
                                <table class='table table-sm table-bordered w-75 mx-auto my-auto' id='tabelaReceita'>
                                    <thead>
                                        <th>Entradas</th>
                                    </thead>
                                    <tbody id='tabelaReceitaBody'></tbody>
                                </table>
                            </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
      </div>
      
      <div class="col-md mb-3">
        <div id='cardDespensas' class="card bg-danger text-white h-100">
            <h5 class="card-header">Gastos Mensais</h5>
            
            <div class="card-body"></div>
            
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
                            
                            <div class='mb-3'>
                                <button class='btn btn-success' onclick="exportExcel('tabelaDespesa','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>
                                <button class='btn btn-danger' onclick="exportPDF('tabelaDespesa','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>
                            </div>
                            
                            <div class='table-responsive'>
                                <table class='table table-sm table-bordered w-75 mx-auto my-auto' id='tabelaDespesa'>
                                    <thead>
                                        <th>Gastos</th>
                                    </thead>
                                    <tbody id='tabelaDespesaBody'></tbody>
                                </table>
                            </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            
        </div>
      </div>
      
      <div class="col-md mb-3">
        <div id='cardSaldo' class="card bg-primary text-white h-100">
            <h5 class="card-header">Saldo</h5>
            <div class="card-body"></div>
            <div class='card-footer'></div>
        </div>
      </div>
    </div>
    
    <div class="row">
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
    
    <div class="row">
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