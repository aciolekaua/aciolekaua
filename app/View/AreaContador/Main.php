<main class="mt-5 pt-3">
    <div id='msgDiv'></div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Codigos Contábeis</div>
            <div class="card-body">
                <form id='formCodigosContabeis' method='post'>
                    <div class='row'>
                        <div class="col mb-3">
                            <label class='form-label' for="PJ">Escolha a PJ*</label>
                            <select class='form-select' name='PJ' onchange='getHistoricos();'>
                                <option value=''>Selecione uma opção</option>
                                <option value="03.902.161/0001-69">VMPE</option>
                                <option value="11.316.866/0001-22">PERNAMBUCONT</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label class='form-label' for="PJ">Tipo de Histórico*</label>
                            <select class='form-select' name='TipoHistorico' onchange='getHistoricos();'>
                                <option value=''>Selecione uma opção</option>
                                <option value="0">Despesas</option>
                                <option value="1">Receitas</option>
                            </select>
                        </div>
                    </div>
                    
                        
                        <!--<div class="card">-->
                            <h5 class="codigo">Codigo Contábel</h5>
                            <!--<div class="card-body">-->
                    <div class="form-group">
                                <div id='cardCodigoContabel' class='row'></div>
                            <!--</div>-->
                        <!--</div>-->
                                
                    </div>
                    
                    <div class="form-group mt-3">
                        <button id='btnSalvar' class='btn btn-success' type='button'>Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
  