<main class="customers_table">
    <!--<div class="topSearchi">-->
    <!--    <div class="searchBox">-->
    <!--        <i class="bi bi-search"></i>-->
    <!--        <input type="text" placeholder="Pesquisar...">-->
    <!--    </div>-->
    <!--</div>-->
    <div class='row' id="top_main">
        <div class="col-sm-4">
            <div class="switch-themei">
                <div class="switch-iconsi">
                    <span class="suni active">
                        <i class="bi bi-sun-fill"></i>
                    </span>
                    <span class="mooni">
                        <i class="bi bi-moon-fill"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="TipoClientePF">
                <form id='formEscolhePJ'>
                    <div class='row'>
                        <div class='col-sm-8'><select class='form-select' name='PJ' ></select></div>
                        <div class='col-sm-4'>
                        </div>    
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--<div class='row TipoClientePF' style=''>-->
        <!--<div class='col-md-3'></div>-->
            <!--<div class='col-md-6'>-->
                <!--<div class='card text-center'>-->
                    <!--<h5 id="" class="card-header"><span>Escolha o PJ</span></h5>-->
                    <!--<div id="" class='card-body modificar-estilo'>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        <!--<div class='col-md-3'></div>-->
    <!--</div>-->
    
    <div class="datails-boxi">
        <div class="contenti">
            <div class="outcomei">
                <div class="left-contenti">
                    <div class="badgei">
                        <i class="bi bi-arrow-up-left-circle-fill"></i>
                    </div>
                    <div class="infoi">
                        <span>Recebimento</span>
                        <strong id="recebimento">Total de: R$&nbsp;0,00</strong>
                    </div>
                </div>
                
                <div id="analize-recebimento" class="right-contenti">
                    <div class="topi">
                        <i class="bi bi-caret-up-fill"></i>
                        <p></p>
                    </div>
                    <span>30 Dias</span>
                </div>
                <div class="topIconsi">
                    <div class="iconi" style="background:#2fa52d">
                    <i type="button" id="entradabutton" data-bs-toggle="modal" data-bs-target="#Recebimento" class="bi bi-clipboard2-data-fill"></i>
                    </div>
                    <div class="modal fade" id="Recebimento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-dark" id="exampleModalLabel">Lista de Grupos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <button class="btn btn-success" onclick="exportExcel('tabelaReceita','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>
                                        <button class="btn btn-danger" onclick="exportPDF('tabelaReceita','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered w-75 mx-auto my-auto" id="tabelaReceita">
                                            <thead>
                                                <tr>
                                                    <th>Histórico</th>
                                                    <th>Valor</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tabelaReceitaBody"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <canvas id="myChartRecebimento" height="89" width="413" style="display: block; box-sizing: border-box; height: 98.8889px; width: 458.889px;"></canvas>
                <!--<iframe width="100%" height="180" src="https://lookerstudio.google.com/embed/reporting/e9c767ca-0dee-443a-9ca3-4666dff3fa92/page/TeeuD" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>-->
            </div>
        </div>
        <div class="contenti">
            <div class="incomei">
                <div class="left-contenti">
                    <div class="badgei">
                        <i class="bi bi-arrow-up-left-circle-fill"></i>
                    </div>
                    <div class="infoi">
                        <span>Pagamento</span>
                        <strong id="pagamento">Total de: R$&nbsp;0,00</strong>
                    </div>
                </div>

                <div id="analize-pagamento" class="right-contenti">
                    <div class="topi">
                        <i class="bi bi-caret-down-fill"></i>
                        <p></p>
                    </div>
                    <span>30 Dias</span>
                </div>
                <div class="topIconsi">
                    <div class="iconi" style="background:#f42d2d">
                    <i class="bi bi-clipboard2-data-fill" type="button" id="gastobutton" data-bs-toggle="modal" data-bs-target="#Pagamento"></i>
                    </div>
                    <div class="modal fade" id="Pagamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-dark" id="exampleModalLabel">Lista de Grupos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <div class="modal-body">
                                
                                <div class="mb-3">
                                    <button class="btn btn-success" onclick="exportExcel('tabelaDespesa','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>
                                    <button class="btn btn-danger" onclick="exportPDF('tabelaDespesa','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-sm w-75 mx-auto my-auto" id="tabelaDespesa">
                                        <thead>
                                            <tr>
                                                <th>Histórico</th>
                                                <th>Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabelaDespesaBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div>
                <canvas id="myChartPagamento" height="89" width="413" style="display: block; box-sizing: border-box; height: 98.8889px; width: 458.889px;"></canvas>
                <!--<iframe width="100%" height="180" src="https://lookerstudio.google.com/embed/reporting/f3f77538-7b17-47ba-805e-c2cab8dea9bf/page/TeeuD" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>-->
            </div>
        </div>
    </div>
    
    <div class="chartBoxi">
        <div class="main-texti">
            <h2 class="text-matrix">Nota Fiscal Emitida</h2>
            <div class="legend-boxi">
                <button onclick="toggleData(0)" class="first">Essa semana</button>
                <button onclick="toggleData(1)" class="second">Semana passada</button>
                <span>Semana <i class="bi bi-caret-down-fill"></i></span>
            </div>
        </div>
        <div>
            <canvas id="myCharttres" height="224" width="869" style="display: block; box-sizing: border-box; height: 248.889px; width: 965.556px;"></canvas>
            <!--<iframe width=1040" height="450" src="https://lookerstudio.google.com/embed/reporting/6b7d9c6c-7389-437b-a5c5-4e6fed4e6b1f/page/oSeuD" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>-->
        </div>
    </div>

    <!--<div class="chartBoxi">-->
    <!--    <div class="main-texti">-->
    <!--        <h2>Módulos de Emissão</h2>-->
            <!-- <div class="legend-boxi">
    <!-            <span>Semana <i class="bi bi-caret-down-fill"></i></span>-->
    <!--        </div> -->
    <!--        <div class="iconi">-->
    <!--            <i class="bi bi-gear-fill"></i>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <form class="testeNota" id="formModulosNotas">-->
    <!--        <div class="shadow-drop-center">-->
    <!--            <div id="cardNFSE" class="card shadow-sm text-center mb-2">-->
    <!--                <div class="card-body">-->
    <!--                    <h5 class="card-title">NFS-e</h5>-->
    <!--                    <p id="status" class="card-text">Desabilitado</p>-->
    <!--                    <div class="row">-->
    <!--                        <div class="col-12">-->
    <!--                            <input name="tipoModulo[0]" type="hidden" value="NFSe">-->
    <!--                            <select class="form-select" name="acaoModulo[0]">-->
    <!--                                <option value="1">Ativar</option>-->
    <!--                                <option value="2">Bloquear</option>-->
    <!--                                <option value="4">Cancelar</option>-->
    <!--                            </select>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div id="" class="card shadow-sm text-center mb-2">-->
    <!--            <div class="card-body">-->
    <!--                <h5 class="card-title">NF-e</h5>-->
    <!--                <p id="status" class="card-text">Desabilitado</p>-->
    <!--                <div class="row">-->
    <!--                    <div class="col-12">-->
    <!--                        <input name="tipoModulo[0]" type="hidden" value="NFSe">-->
    <!--                        <select class="form-select" name="acaoModulo[0]">-->
    <!--                            <option value="1">Ativar</option>-->
    <!--                            <option value="2">Bloquear</option>-->
    <!--                            <option value="4">Cancelar</option>-->
    <!--                        </select>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div id="" class="card shadow-sm text-center mb-2">-->
    <!--            <div class="card-body">-->
    <!--                <h5 class="card-title">NFC-e </h5>-->
    <!--                <p id="status" class="card-text">Desabilitado</p>-->
    <!--                <div class="row">-->
    <!--                    <div class="col-12">-->
    <!--                        <input name="tipoModulo[0]" type="hidden" value="NFSe">-->
    <!--                        <select class="form-select" name="acaoModulo[0]">-->
    <!--                            <option value="1">Ativar</option>-->
    <!--                            <option value="2">Bloquear</option>-->
    <!--                            <option value="4">Cancelar</option>-->
    <!--                        </select>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div id="" class="card shadow-sm text-center mb-2">-->
    <!--            <div class="card-body">-->
    <!--                <h5 class="card-title">MDF-e</h5>-->
    <!--                <p id="status" class="card-text">Desabilitado</p>-->
    <!--                <div class="row">-->
    <!--                    <div class="col-12">-->
    <!--                        <input name="tipoModulo[0]" type="hidden" value="NFSe">-->
    <!--                        <select class="form-select" name="acaoModulo[0]">-->
    <!--                            <option value="1">Ativar</option>-->
    <!--                            <option value="2">Bloquear</option>-->
    <!--                            <option value="4">Cancelar</option>-->
    <!--                        </select>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </form>-->
    <!--        <div class="form-group">-->
    <!--            <input type="button" class="btn btn-main mt-3" name="Submit" value="Salvar" onclick="acaoModuloNota();">-->
    <!--        </div>-->
    <!--</div>-->
</main>
<!--<main class="mt-3 pt-3">-->
    
<!--    <div class="container-fluid">-->
        
<!--        <div class='row TipoClientePF' style=''>-->
<!--            <div class='col-md-3'></div>-->
<!--                <div class='col-md-6'>-->
<!--                    <div class='card text-center'>-->
<!--                        <h5 id="" class="card-header"><span>Escolha o PJ</span></h5>-->
<!--                        <div id="" class='card-body modificar-estilo'>-->
<!--                            <form id='formEscolhePJ'>-->
<!--                                <div class='row'>-->
<!--                                    <div class='col-12'><select class='form-select' name='PJ' ></select></div>-->
<!--                                    <div class='col-12 mt-3'>-->
<!--                                        <button type='button' class='btn btn-secondary' onclick='buscarDadosPJ();'>Buscar Dados</button>-->
<!--                                    </div>    -->
<!--                                </div>-->
<!--                            </form>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            <div class='col-md-3'></div>-->
           
<!--        </div>-->
        
<!--        <div id='contentCardGastosMensais' class="row">-->
<!--            <div class="overlay"></div>-->
<!--            <div class="overlay-loading">-->
<!--            <img src="./Home/carregar.gif"/>-->
<!--            </div><overlay-loading-->

<!--            <div class="col-md-6 mb-3">-->
<!--                <div id='cardEntradas' class='card h-100'>-->
<!--                    <h5 id="entradas-header" class="card-header"><span>Entrada Mensal</span></h5>-->
<!--                    <div id="entradas-body" class="card-body">-->
                        
<!--                    </div>-->
<!--                    <div class='card-footer modificar-estilo'>-->
<!--                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Recebimento">-->
<!--                        <button type="button" id="entradabutton" data-bs-toggle="modal" data-bs-target="#Recebimento">-->
<!--                          Lista de Grupos-->
<!--                        </button>-->
                            
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="modal fade" id="Recebimento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--                    <div class="modal-dialog modal-fullscreen">-->
<!--                        <div class="modal-content">-->
<!--                            <div class="modal-header">-->
<!--                                <h5 class="modal-title text-dark" id="exampleModalLabel">Lista de Grupos</h5>-->
<!--                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--                            </div>-->
<!--                            <div class="modal-body">-->
<!--                                <div class='mb-3'>-->
<!--                                    <button class='btn btn-success' onclick="exportExcel('tabelaReceita','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>-->
<!--                                    <button class='btn btn-danger' onclick="exportPDF('tabelaReceita','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>-->
<!--                                </div>-->
<!--                                <div class='table-responsive'>-->
<!--                                    <table class='table table-sm table-bordered w-75 mx-auto my-auto' id='tabelaReceita'>-->
<!--                                        <thead>-->
<!--                                            <th>Entradas</th>-->
<!--                                        </thead>-->
<!--                                        <tbody id='tabelaReceitaBody'></tbody>-->
<!--                                    </table>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            
<!--            <div class="col-md-6 mb-3">-->
<!--                <div id='cardDespensas' class='card h-100'>-->
<!--                    <h5 id="gastos-header" class="card-header"><span>Gastos Mensais</span></h5>-->
<!--                    <div id="gastos-body" class="card-body">-->
                        
<!--                    </div>-->
<!--                    <div class='card-footer modificar-estilo'>-->
<!--                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#Pagamento">-->
<!--                        <button type="button" id="gastobutton" data-bs-toggle="modal" data-bs-target="#Pagamento">-->
<!--                          Lista de Grupos-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="modal fade" id="Pagamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--                    <div class="modal-dialog modal-fullscreen">-->
<!--                        <div class="modal-content">-->
<!--                            <div class="modal-header">-->
<!--                                <h5 class="modal-title text-dark" id="exampleModalLabel">Lista de Grupos</h5>-->
<!--                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--                            </div>-->
<!--                        <div class="modal-body">-->
                            
<!--                            <div class='mb-3'>-->
<!--                                <button class='btn btn-success' onclick="exportExcel('tabelaDespesa','Lista de Grupos','xlsx')"><i class="bi bi-file-excel"></i>Excel</button>-->
<!--                                <button class='btn btn-danger' onclick="exportPDF('tabelaDespesa','Lista de Grupos')"><i class="bi bi-file-earmark-pdf"></i>PDF</button>-->
<!--                            </div>-->
                            
<!--                            <div class='table-responsive'>-->
<!--                                <table class='table table-sm table-bordered w-75 mx-auto my-auto' id='tabelaDespesa'>-->
<!--                                    <thead>-->
<!--                                        <th>Gastos</th>-->
<!--                                    </thead>-->
<!--                                    <tbody id='tabelaDespesaBody'></tbody>-->
<!--                                </table>-->
<!--                            </div>-->
<!--                      </div>-->
<!--                    </div>-->
<!--                  </div>-->
<!--                </div>-->
<!--            </div>-->
            
<!--             <div class="col-md-4 mb-3">-->
<!--                <div id='cardSaldo' class='card h-100'>-->
<!--                    <h5 id="saldo-header" class="card-header"><span>Saldo</span></h5>-->
<!--                    <div class="card-body modificar-estilo"></div>-->
<!--                </div>-->
<!--            </div> -->
            
<!--        </div>-->
        
<!--        <div class="graficos">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-6 mb-3">-->
<!--                <div class="card h-100">-->
<!--                    <div id="entradas-header" class="card-header">-->
<!--                        <span class="me-2"><i class="bi bi-cash-stack"></i><i class="ms-1 bi bi-arrow-up-circle"></i></span>-->
<!--                        <span>Entradas Anuais</span>-->
<!--                    </div>-->
<!--                    <div class="card-body modificar-estilo">-->
<!--                        <canvas id="recebimentoChats" class="chart recebimento" width="400" height="200"></canvas>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-6 mb-3">-->
<!--                <div class="card h-100">-->
<!--                    <div id="gastos-header" class="card-header">-->
<!--                        <span class="me-2"><i class="bi bi-cash-stack"></i><i class="ms-1 bi bi-arrow-down-circle"></i></span>-->
<!--                        <span>Gastos Anuais</span>-->
<!--                     </div>-->
<!--                    <div class="card-body modificar-estilo">-->
<!--                        <canvas class="chart gastos" width="400" height="200"></canvas>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row TipoClientePJ">-->
<!--            </div>-->
<!--        </div>-->
            
<!--        </div>-->
        
<!--    </div>-->
    
<!--</main>-->
<!--<main>
        <section>

        <h3 class="section-head">visualização</h3>
        <div class="analytics">
            <div class="analytic">
                <div class="analytic-icon">
                    <span class="las la-eye"></span>
                </div>
                <div class="analytic-info">
                    <h4>Total</h4>
                    <h1>10.4K</h1>
                </div>
            </div>  

            <div class="analytic">
                <div class="analytic-icon">
                    <span class="las la-clock"></span>
                </div>
                <div class="analytic-info">
                    <h4>despesas</h4>
                    <h1>1.5K <small class="text-danger"> 5%</small></h1>
                </div>
            </div>


            <div class="analytic">
                <div class="analytic-icon">
                    <span class="las la-users"></span>
                </div>
                <div class="analytic-info">
                    <h4>Receitas</h4>
                    <h1>10.4K <small class="text-success"> 15%</small></h1>
                </div>
            </div>
            
            <div class="analytic">
                <div class="analytic-icon">
                    <span class="las la-users"></span>
                </div>
                <div class="analytic-info">
                    <h4>MEI</h4>
                    <h1>60K <small class="text-success"> 85%</small></h1>
                </div>
            </div>
        </div>
        </section>-->

        <!-- <section>
            <div class="block-grid">
                <div class="revenue-card">
                    <h3 class="section-head">Total Revenue</h3>
                    <div class="rev-content">
                        <img src="img/circle1.png"  alt="">
                            <div class="rev-info">
                                <h3>wallacy amauri</h3>
                                <h1>3.5M <small>Subscribers</small></h1>
                            </div>
                            <div class="rev sum">
                                <h4>Total vendas</h4>
                                <h2>R$70.326,00</h2>
                            </div>
                    </div>
                </div>
            </div>
        </section> -->
    <!--</main>-->