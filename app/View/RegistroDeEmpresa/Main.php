<main class="mt-3 pt-3">
    <div class="container-fluid">
        <div id='menssage'></div>

        <div class='card'>
            <h5 class='card-header'>Extrato</h5>
            <div class='card-body'>
                <form id="formExtrato" action="#" method="post" enctype="multipart/form-data">
                <div class='row'>
                    <div class='col-md-6'>
                        <label class='form-label'>Arquivo de extrato</label>
                        <input class="form-control" name='extrato' type='file' accept="image/*, .pdf, .ofx"/>
                    </div>
                    <div class='col-md-3'>
                        <label class='form-label'>Mês</label>
                        <select class="form-select" name='mes'>
                            <option value="" disabled selected>Selecione uma das Opções</option>
                            <option value="1">Janeiro</option>
                            <option value="2">Fevevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                    </div> 
                    <div class='col-md-3'>
                        <label class='form-label'>Ano</label>
                        <select class="form-select" name='ano'>
                        </select>
                    </div>
                    <div class='col-12 mt-3'>
                        <button type="button" class='btn btn-orange' onclick='uploadExtrato();'>Evnviar</button>
                    </div> 
                </div>
                </form>
            </div>
        </div>

        <div class='card mt-4'>
            <div class='card-header'>
                <span class='me-2'>
                    <i class="bi bi-table me-2"></i>Tabela de Extrato
                </span>
            </div>
            <div class='card-body'>
                <div class='row'>
                    <div class="table-responsive">
                        <table id='tabelaExtrato' class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Data Emitida</th>
                                    <th>Data de Competência</th>
                                    <th>Arquivo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalConfirmaExclusaoExtrato" tabindex="-1" aria-labelledby="modalConfirmaExclusaoExtrato" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Excluir Extrato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Você deseja excluir?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="btnConfirmaExclusaoExtrato">Sim</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarExtrato" tabindex="-1" aria-labelledby="modalEditarExtrato" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Extrato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class='row' id='formUpdateExtrato' action='' method='post'>
                            <input type='hidden' name='IdExtrato'/>
                            <input type='hidden' name='cnpjEditar'/>
                            <div class='col-md-12 mb-2'>
                                <label class='form-label'>Arquivo de extrato</label>
                                <input class="form-control" name='extratoEditar' type='file' accept=".jpeg, .png, .jpg, .pdf, .ofx, .csv, .xml, .xlsx"/>
                            </div>
                            <div class='col-md-6 mb-2'>
                                <label class='form-label'>Mês</label>
                                <select class="form-select" name='mesEditar'>
                                    <option value="" disabled selected>Selecione uma das Opções</option>
                                    <option value="1">Janeiro</option>
                                    <option value="2">Fevevereiro</option>
                                    <option value="3">Março</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Maio</option>
                                    <option value="6">Junho</option>
                                    <option value="7">Julho</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div> 
                            <div class='col-md-6 mb-2'>
                                <label class='form-label'>Ano</label>
                                <select class="form-select" name='anoEditar'>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnEditarExtrato">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>