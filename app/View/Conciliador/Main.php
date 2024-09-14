<main class="my-2">
    <div class="container-fluid">
        <div class="card mb-4" id="card">
            <div class="card-header">
                <span class="me-2">
                   <i class="bi bi-file-earmark-excel"></i> Ler Excel .csv
                </span>
        </div>
            <div class="card-body">
                <!--<div class="container">-->
                    <form id="formEnviarCSV" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class='form-label text-matrix' for='arquivoCsv'>Arquivo</label>
                                <input type="file" name="arquivo" class="form-control" id="arquivoCsv"><br><br>
                            </div>
                            <!--<div class="col-md-4 mb-3">-->
                            <!--    <label class='form-label' for="NomeBanco">Nome do Banco*</label>-->
                            <!--	<select class="form-select" id="NomeBanco" name="NomeBanco" aria-label="NomeBanco">-->
                            <!--        <option value="1">Inter</option>-->
                            <!--    </select>-->
                            <!--</div>-->
                            <!--<div class="col-md-4 mb-3">-->
                            <!--    <label class='form-label' for="DataAnual">data anual*</label>-->
                            <!--	<input class="form-control" id="DataAnual" type="text" name="DataAnual" autocomplete='off'/>-->
                            <!--</div>-->
                            <!--<div class="col-md-4 mb-3">-->
                            <!--    <label class='form-label' for="DataMes">data mes*</label>-->
                            <!--	<input class="form-control" id="DataMes" type="text" name="DataMes" autocomplete='off'/>-->
                            <!--</div>-->
                            <div class="col-lg-12 mb-3">
                                <input type="button" value="Enviar" name="btnCSV" id="btnEnviar" class="btn btn-primary"><br><br>
                            </div>
                        </div>
                    </form>
                <!--</div>-->
        </div>
        </div>
        <div class="card mb-2" id="card">
            <div class="card-header">
                <span class="me-2">
                   <i class="bi bi-table"></i> Tabela dos lançamentos
                </span>
            </div>
            <div class="card-body">
                <div class="container">
                <!--<div class="row mt-4">-->
                <!--    <div class="col-lg-12 d-flex justify-content-between align-items-center">-->
                        <!--<div>-->
                        <!--    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cadUsuarioModal" disabled>-->
                        <!--        Cadastrar-->
                        <!--    </button>-->
                        <!--</div>-->
                <!--    </div>-->
                <!--</div>-->
                    <span id="msgAlerta"></span>
                   <div class="table-responsive">
                        <form method="POST" id="form-tabela">
                            <table id="listar-dados" class="table table-striped table-hover display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>data</th>
                                        <th>historico</th>
                                        <th>historico Editado</th>
                                        <th>valor</th>
                                        <th>Açoes</th>
                                    </tr>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!--inicio modal cadastrar -->
        <div class="modal fade" id="cadUsuarioModal" tabindex="-1" aria-labelledby="cadUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadUsuarioModalLabel">Cadastrar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form id="cad-usuario-form" method="POST">
                        <span id="msgAlertaErroCad"></span>
                       
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
                            <!--<input type="submit" class="btn btn-outline-success btn-sm" id="cad-usuario-btn" value="Cadastrar" />-->
                        </div>
                    </form>
                </div>
    
            </div>
        </div>
</div>
    <!--fim modal cadastrar -->
    
    <!--Inicio Modal visualizar-->
        <div class="modal fade" id="visUsuarioModal" tabindex="-1" aria-labelledby="visUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visUsuarioModalLabel">Visualizar Dados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="msgAlertaErroVis"></span>
                        <form method="POST"  enctype="multipart/form-data" id="form-vis-dados">
                            
                            <h3>Dados do Excel</h3>
                            <div class="row">
                                    <input type="hidden" name="id" id="visuid">
                                <div class="col-6">
                                   <label for="">data</label>
                                   <input type="text" name="data"  id="data" class="form-control" disabled/> 
                                </div>
                                <div class="col-6">
                                    <label for="">historico</label>
                                    <input type="text" name="historico"  id="historico" class="form-control"disabled/> 
                                </div>
                                <div class="col-6">
                                    <label for="historicoEditado">historico Editado</label>
                                    <input name="historicoEditado"  id="historicoEditado" type="text" class="form-control" disabled/>
                                </div>
                                <div class="col-6">
                                    <label for="">valor</label>
                                    <input name="valor"  id="valor" type="text" class="form-control" disabled/>
                                </div>
                                <div class="col-6">
                                    <label for="">tipo</label>
                                    <input name="tipo"  id="tipo" type="text" class="form-control" disabled/>
                                </div>
                                
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</div>
        </div>
    <!--Fim Modal visualizar -->
    
    <!--Inicio Modal Editar-->
        <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span id="msgAlertErroEdit"></span>
                        <form method="POST" id="form-edit-usuario">
                            
                        <h3>Dados do Excel</h3>
                              
                        <div class="row">
                                <input type="hidden" name="id" id="editid">
                            <div class="col-6">
                               <label for="">data</label>
                               <input type="text" name="data"  id="editdata" class="form-control" disabled/> 
                            </div>
                            <div class="col-6">
                                <label for="">historico</label>
                                <input type="text" name="historico"  id="edithistorico" class="form-control"disabled/> 
                            </div>
                            <div class="col-6">
                                <label for="historicoEditado">historico Editado</label>
                                <input name="historicoEditado"  id="edithistoricoEditado" type="text" class="form-control" disabled/>
                            </div>
                            <div class="col-6">
                                <label for="">valor</label>
                                <input name="valor"  id="editvalor" type="text" class="form-control" disabled/>
                            </div>
                            <div class="col-6">
                                <label for="">tipo</label>
                                <input name="tipo"  id="edittipo" type="text" class="form-control" disabled/>
                            </div>
                            
                            
                        </div>
                        <div class="row">
                             <h3>Dados de edição</h3>
                            <div class="col-6">
                                <span id="msgAlertaSituacao"></span>
                                
                                <label>Situação: </label>
                                <select name="situacoe_id" id="situacoe_id" class="form-control">
                                    <option value="">selecione</option>
                                </select>
                            </div>        
                            <div class="col-6">
                                <label for="">discrição</label>
                                <input type="text" name="HistoricoAtual" id="HistoricoAtual" class="form-control"/>
                            </div>
                        </div>
                        <br>
        
                            <div class="butao">
                                <button type="submit" class="btn btn-outline-primary btn-sm" id="salvar" value="Salvar">Editar</button>
                                <input type="button" class="btn btn-outline-success btn-sm" id="btn" value="enviar">
                                <span></span>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!--Fim Modal Editar -->
</main>