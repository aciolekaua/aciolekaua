<!-- INICIO MODAL: CONFIRMAR EXCLUSAO -->
<div class="modal fade" id="modalConfirmaExclusaoPagamento" tabindex="-1" aria-labelledby="modalConfirmaExclusaoPagamento" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmaExclusaoPagamento">Excluir Pagamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Você confirma a exclusão desse pagamento?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button id="btnConfirmaExclusaoPagamento" type="button" class="btn btn-danger" data-bs-dismiss="modal">Sim</button>
      </div>
    </div>
  </div>
</div>
<!--FIM MODAL-->

<!-- INICIO MODAL: COMPROVANTES -->
<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="modalArquivos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comprovantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="lista-comprovante" class="modal-body">
                
                <!--<div id="lista-comprovante" class="list-group list-group-flush">
                </div>-->
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!--FIM MODAL-->

<div class='position-fixed' style="z-index:1" id='mensage'></div>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        
        <div class="row">

            <div class="col-12 mb-3">
                <div id='cardFormPJ' class="card"  style="display:none;">
                    <div class='card-header'>
                        <span><i class="bi bi-building-fill-check"></i> Selecione a Pessoa Juridica</span>
                    </div>
                    <div class="card-body">
                        <form class='w-100' id='formPJ' action='' method='post'>
                            <select class='form-select w-50 mx-auto' name='pj' required>
                                <option value="">Selecione uma opção</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form class='row' id="formFiltro" action="" method="post">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Mês</label>
                                <select name="mes" id="" class="form-select">
                                    <option value="99">Todos</option>
                                    <option value="1">Janeiro</option>
                                    <option value="2">Fevereiro</option>
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
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Ano</label>
                                <select name="ano" id="" class="form-select">
                                    <option value="99">Todos</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-orange" type="button" id="btnFiltrar">Filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <form id='formTabela' action="" method="post">
                    <!--<a href="<?php echo(DIRPAGE."lancamentos-pagamento"); ?>" class='btn btn-orange mb-3'>Formulário</a>-->
                    <div class="card">
                        <div class="card-header">
                            <span><i class="bi bi-table me-2"></i>Tabela de Pagamento</span> 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    id="tabela_pagamento"
                                    class="table table-striped w-100"
                                >
                                    <thead id='theadTabela'>
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyTabela"></tbody>
                                    
                                </table>
                            </div>
                        </div>
                        
                        <div id='divbutton' class='card-footer d-flex align-items-center justify-content-around'></div>
                        
                    </div>
                </form>
            
            </div>
        </div>

        <div class="modal fade" id="modalEditarPagamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form class='row' id='formUpdatePagamento' action='' method='post'>
                            <input type='hidden' name='IdPagamento'/>
                            <div class='col-sm-12 mb-1'>
                                <label class='form-label text-dark' for="PJUpdate">PJ*</label>
                                <select class='form-select' id="PJUpdate" name="PJUpdate">
                                    <option value=''>Selecione uma opção</option>
                                </select>
                            </div>
                            <div class='col-sm-4 mb-1'>
                                <label class='form-label text-dark' for="Grupo">Grupo*</label>
                                <select class='form-select' id="Grupo" name="Grupo">
                                    <option value=''>Selecione uma opção</option>
                                </select>
                            </div>
                            <div class='col-sm-4 mb-1'>
                                <label class='form-label text-dark' for="SubGrupo">Sub Grupo*</label>
                                <select class='form-select' id="SubGrupo" name="SubGrupo">
                                    <option value=''>Selecione uma opção</option>
                                </select>
                            </div>
                            <div class="col-sm-4 mb-1">
                                <label class='form-label text-dark' for="FormaDePagamento">Escolha uma forma de pagamento *</label>
                                <select class='form-select' id="FormaDePagamento" name="FormaDePagamento" required>
                                    <option value="">Selecione uma opção</option>
                				</select>
                            </div>
                            <div class='col-sm-12 mb-1'>
                			    <label class='form-label text-dark' for="Descricao">Descreva*</label>
                    			<textarea class="form-control" id="Descricao" name="Descricao" placeholder="Descreva aqui" rows="5"></textarea>
            			    </div>
                                <div class='form-group col-sm-4 mb-2'>
                                <label class='form-label text-dark' for="">Nome do Beneficiário*</label>
                                <input class="form-control" id="Beneficiario" type="text" name="Beneficiario" placeholder="Digite o nome do beneficiário" 
                                pattern="[a-z A-Z À-ú]{2,}"/>
                            </div>
                            <div class='form-group col-sm-4 mb-2'>
                                <label class='form-label text-dark' for='Nota'>Nº da Nota</label>
                                <input class="form-control" id="Nota" type="text" name="Nota" placeholder="Digite o numero da nota"  maxlength="15"/>
                            </div>
                            <div class='form-group col-sm-4 mb-2'>
                                <label class='form-label text-dark' for="Data">Data de Competência*</label>
                                <input class="form-control" id="Data" type="date" name="Data" required/>
                            </div>
                            <div class='form-group col-sm-6 mb-2'>
                                <label class='form-label text-dark' for="Valor">Valor*</label>
                                <input 
                                class="form-control"
                                id="Valor"
                                name="Valor" 
                                type="text" 
                                placeholder="Digite o valor"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off
                                required/>
                            </div>
                            <div class='form-group col mb-2'>
                                <label class="formFile form-label text-dark" for="Comprovante">Anexar o documento(Imagem ou PDF)</label>
                                <input class="form-control" id="Comprovante" type="file" name="Comprovante[]" accept=".jpeg, .png, .jpg, .pdf"/>
                            </div>
                            
                            <!--<div class="col-md-12 mt-3">
                                <button type='button' class='btn btn-orange' onclick='registroContasContabil();'>Salvar</button>
                            </div>-->
                        </form>
                    </div>

                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <button type="button" class="btn btn-orange" onclick='atualizarPagamento();' data-bs-dismiss="modal">Salvar</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>