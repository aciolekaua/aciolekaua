<main class="my-2">
    <div class="container-fluid">
        <div id='mensage'></div>
        
        <div class='card'>
            <div class='card-header'>
                <span class='me-2'><i class="bi bi-receipt"></i></span>
                <span><b>Consultar Status da Nota</b></span>
            </div>
            <div class='card-body'>
                <form id='formConsultaNota' action="" method='post' enctype="multipart/form-data">
                    
                    <div class='row mb-2'>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="PJ">Escolha a PJ*</label>
                            <select id="PJ" name="PJ" class='form-select' onchange='' required>
                                <option value="">Selecione uma opção</option>
                                <option value="03.902.161/0001-69">VMPE</option>
                                <option value="11.316.866/0001-22">PERNAMBUCONT</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="PJ">Data Inicial de Emissão</label>
                            <input class='form-control' type='date' name='dtInicialEmissao'/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="PJ">Data Final de Emissão</label>
                            <input class='form-control' type='date' name='dtFinalEmissao'/>
                        </div>
                    </div>
                    
                    <div class='row mb-2'>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="numeroInicial">Numero Inicial</label>
                    		<input class="form-control" id="numeroInicial" type="text" name="numeroInicial" oninput="mask(this,numeroMask);" maxlength='20' placeholder="" required/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="numeroFinal">Numero Final</label>
                    		<input class="form-control" id="numeroFinal" type="text" name="numeroFinal" oninput="mask(this,numeroMask);" maxlength='20' placeholder="" required/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="serie">Série</label>
                    		<input class="form-control" id="serie" type="text" name="serie" oninput="mask(this,numeroMask);" maxlength='20' placeholder="" required/>
                        </div>
                    </div>
                    
                    <div class='row mb-2'>
                        <div class="form-group col-sm-6">
                            <label class="form-label">Status do Documento</label>
                            <select class='form-select' name='statusDocumento'>
                                <option value=''>Selecione uma opção</option>
                                <option value='1'>Pendente</option>
                                <option value='2'>Autorizado</option>
                                <option value='3'>Rejeitado</option>
                                <option value='4'>Necessita Interação</option>
                                <option value='5'>Cancelado</option>
                                <option value='6'>Inutilizado</option>
                                <option value='7'>Aguardando Consulta</option>
                                <option value='8'>Encerrado</option>
                                <option value='9'>Em Conflito</option>
                                <option value='10'>EPEC</option>
                                <option value='11'>Contigência Offline</option>
                                <option value='12'>Denegado</option>
                                <option value='13'>Contigência FS-DA</option>
                                <option value='19'>Aguardando Cancelamento</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="form-label">Tipo de Nota*</label>
                            <select class='form-select' name='EmitidoRecebido'>
                                <option value=''>Selecione uma opção</option>
                                <option value='E'>Emitido</option>
                                <option value='R'>Recebido</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class='row mt-3'>
                        <div class='col-12'>
                            <button id='btnConsultar' class='btn btn-success' type='button' onclick='consultarNota();'>Consultar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <span><i class="bi bi-table me-2"></i>Tabela de Notas Fiscais</span> 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table
                        id="tabela_notafiscal"
                        class="table table-striped data-table"
                        style="width: 100%"
                        data-excel-name="Tabela de Nostas Fiscais"
                    >
                        <thead id='theadTabela'>
                            <tr>
                                <th>Status</th>
                                <th>Modelo</th>
                                <th>Número</th>
                                <th>NFS-e</th>
                                <th>Série</th>
                                <th>Data de emissão	</th>
                                <th>Destinatário/Tomador</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyTabela"></tbody>
                        <tfoot id='tfootTabela'>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>