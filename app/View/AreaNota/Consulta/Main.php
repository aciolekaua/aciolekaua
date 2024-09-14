<main class="my-2">
    <div class='row ms-2' id="top_main">
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
    </div>
    <div class="container-fluid">
        <div id='menssage'>
            
        </div>
        <!--<div class="overlayk-loading">-->
        <!--    <img src="" alt="gif">-->
        <!--</div>-->
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-funnel"></i>
                    Filtro
                </span>
                <div class="juntar">
                    
                    <a href="<?php echo(DIRPAGE."area-nota-consulta");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."area-nota-configuracao");?>">
                        <div class="iconi">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                    </a>
                    
                </div>
            </div>
            <div class='container mt-4'>
                <form id='consultarNotas' method='post' action=''>
                    
                    <div class='row'>
                        <div class='col-sm-6 mb-2'>
                            <label class='form-label text-matrix'>PJ</label>
                            <select class='form-select' name='PJ'></select>
                        </div>
                        <div class='col-sm-6 mb-2'>
                            <label class='form-label text-matrix'>Modulo</label>
                            <select class='form-select' name='tipoModulo'>
                                <option value='nfse'>NFS-e</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class='row mt-2'>
                        <div class="col-sm-6 mb-1">
                            <input class="form-check-input" type="radio" name="dataRadio" id="dataRadio1" value='4' checked>
                            <label class="form-check-label text-matrix" for="dataRadio1">Todas as datas</label>
                        </div>
                        <div class="col-sm-6 mb-1">
                          <input class="form-check-input" type="radio" name="dataRadio" id="dataRadio2" value='3'>
                          <label class="form-check-label text-matrix" for="dataRadio2">
                            Desse ano
                          </label>
                        </div>
                        <div class="col-sm-6 mb-1">
                          <input class="form-check-input" type="radio" name="dataRadio" id="dataRadio3" value='2'>
                          <label class="form-check-label text-matrix" for="dataRadio3">
                            Desse mês
                          </label>
                        </div>
                        <div class="col-sm-6 mb-1">
                          <input class="form-check-input" type="radio" name="dataRadio" id="dataRadio4" value='1'>
                          <label class="form-check-label text-matrix" for="dataRadio4">
                            Desse dia
                          </label>
                        </div>
                        <div class="col-sm-6 mb-1">
                          <input class="form-check-input" type="radio" name="dataRadio" id="dataRadio5" value='0'>
                          <label class="form-check-label text-matrix" for="dataRadio4">
                            Personalizada
                          </label>
                        </div>
                    </div>
                    <fieldset id='fieldsetData' class='row mt-2' disabled>
                        <div class='col-sm-6 mb-2'>
                            <label class='form-label text-matrix'>Data de Início</label>
                            <input class='form-control' type='date' name='dataInicio'/>
                        </div>
                        <div class='col-sm-6 mb-2'>
                            <label class='form-label text-matrix'>Data de Fim</label>
                            <input class='form-control' type='date' name='dataFim'/>
                        </div>
                    </fieldset>
                    
                    <div class='row mt-2'>
                        <div class='col-sm-4 mb-2'>
                            <label class='form-label text-matrix'>Número Inicial</label>
                            <input class='form-control' type='text' name='numeroInicial'/>
                        </div>
                        <div class='col-sm-4 mb-2'>
                            <label class='form-label text-matrix'>Número Final</label>
                            <input class='form-control' type='text' name='numeroFinal'/>
                        </div>
                        <div class='col-sm-4 mb-2'>
                            <label class='form-label text-matrix'>Série</label>
                            <input class='form-control' type='text' name='serie'/>
                        </div>
                    </div>
                    
                    <div class='row mt-2'>
                        <div class="form-group col-sm-6 mb-2">
                            <label class="form-label text-matrix">Status da Nota</label>
                            <select class='form-select' name='statusNota'>
                                <option value='0'>Todas</option>
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
                        <div class="form-group col-sm-6 mb-2">
                            <label class="form-label text-matrix">Emissão ou Incluido?</label>
                            <select class='form-select' name='emissaoInclusao'>
                                <option value='1'>Emitidos</option>
                                <option value='2' selected>Incluidos</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class='row mt-3'>
                        <div class='col-2'>
                            <button class='btn btn-orange' onclick='consultarNotas(this);' type='button'>Consultar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class='transactionBoxi testeListUI'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-list-task"></i>
                    Lista
                </span>
                <div class="juntar">
                    
                    <a href="<?php echo(DIRPAGE."area-nota-consulta");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."area-nota-configuracao");?>">
                        <div class="iconi">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                    </a>
                    
                </div>
            </div>
            <div  id="testebodyUI" class='container mt-4'>
                
                <div class="table-responsive">
                    <table id='tabelaNotas' class="table table-striped w-100">
                        <thead>
                            <th>Status</th>
                            <th>Modelo</th>
                            <th>Número</th>
                            <th>NFS-e</th>
                            <th>Série</th>
                            <th>Data de Emissão</th>
                            <th>Destinatário</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                
                
            </div>
        </div>
    </div>
    
    <div class="modal" id='modalCancelaNota' tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancelamento de Nota</h5>
                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                </div>
                <div class="modal-body">
                   <form id='formModalCancelaNota' method='post' action=''>
                       <div class='row'>
                           <div class='col-6 mb-2'>
                                <label class='form-label'>Tipo de Documento</label>
                                <input style='display:block;boder:none;border-width:0;outline:none;pointer-events:none;' type='text' name='modelo'/>
                           </div>
                           <div class='col-6 mb-2'>
                                <label class='form-label'>Numero</label>
                                <input style='display:block;boder:none;border-width:0;outline:none;pointer-events:none;' type='text' name='numero'/>
                           </div>
                           <div class='col-6 mb-2'>
                                <label class='form-label'>Numero NFSE</label>
                                <input style='display:block;boder:none;border-width:0;outline:none;pointer-events:none;' type='text' name='numeroNFSE'/>
                           </div>
                           <div class='col-6 mb-2'>
                                <label class='form-label'>Série</label>
                                <input style='display:block;boder:none;border-width:0;outline:none;pointer-events:none;' type='text' name='serie'/>
                           </div>
                       </div>
                       <div class='row mb-2'>
                            <div class='col-12'>
                                <label class='form-label'>Tipo de Cancelamento</label>
                                <select class='form-select' name='tpCodEvento'>
                                    <option value='1'>Erro de emissão</option>
                                    <option value='2'>Serviço não prestado</option>
                                    <option value='4'>Duplicidade da nota</option>
                                </select>
                            </div>
                       </div>
                       <div class='row mt-2'>
                           <div class='col-12'>
                                <label class='form-label'>Motivo do Cancelamento</label>
                                <textarea class="form-control w-100" name="motivoCancelamento" rows="4" cols="50"></textarea>
                           </div>
                       </div>
                   </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" onclick="cancelarNota();">Cancelar Documento</button>
                </div>
            </div>
        </div>
    </div>
</main>