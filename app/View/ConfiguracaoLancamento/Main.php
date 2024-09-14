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

        <section class="grid-boxin">
            <div class="boxin-skills">
                <div class="boxin-card">
                    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/pagamento.svg"); ?>"></span>
                    <h3 class="text-matrix">Grupo de contas</h3>
                    <p class="text-matrix">inserir dados do Grupo de contas</p>
                    <button class="text-matrix acessar" data-target="acessar1">Visualizar</button>
                </div>
            </div>
            <div class="boxin-skills">
                <div class="boxin-card">
                    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/recebimento.svg"); ?>"></span>
                    <h3 class="text-matrix">Lista de contas</h3>
                    <p class="text-matrix">Listar nas contas do grupo de contas</p>
                    <button class="text-matrix acessar"  data-target="acessar2">Visualizar</button>
                </div>
            </div>
        </section>
    
        <!--<div class="card mb-3">
            <div class='card-header'>
                <span class='me-2'>
                    <i class="bi bi-table me-2"></i>Layout CSV
                </span>
            </div>
            <div class='card-body'>
                <form class="row" id="formLayoutCSV" method="post" action="">
                    <div class="col-11">
                        <label class='form-label text-matrix' for="layoutCSV">Arquivo</label>
                        <input class='form-control' type="file" id="layoutCSV" name="layoutCSV" />
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-end">
                        <button class="btn btn-primary" type="button" onclick="insertPlanoDeContas();"><i class="bi bi-upload"></i></button>
                    </div>
                </form>
            </div>
        </div>-->

        <div class='transactionBoxi'id="acessar1" style="display:none;">
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-list-ul me-2"></i>
                    Grupo de Contas
                </span>
                <div class="juntar">
                    
                    <a href="<?php echo(DIRPAGE."lancamentos-pagamento");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-file-bar-graph-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."lancamentos-recebimento");?>">
                        <div class="iconi">
                            <i class="bi bi-file-break-fill"></i>
                        </div>
                    </a>
                    
                </div>
            </div>
            <div class='container mt-4'>
                <form class='row' id='formCadastraGrupoContas' action='' method='post'>
                    <div class='col-7 mb-3'>
                        <label class='form-label text-matrix' for="nomeGrupo">Nome*</label>
                        <input class='form-control' placeholder='' type="text" id="nomeGrupo" name="nomeGrupo" />
                    </div>
                    <div class='col-4 mb-3'>
                        <label class='form-label text-matrix' for="acao">Ação*</label>
                        <!-- <input class='form-control' placeholder='' type="text" id="acao" name="acao" /> -->
                        <select class="form-select" name="acao" id="">
                            <option value="1">Pagamento</option>
                            <option value="2">Recebimento</option>
                            <!-- <option value="3">Geral</option> -->
                        </select>
                    </div>
                    <div class="col-1 mb-3 d-flex justify-content-center align-items-end">
                        <button type='button' class='btn btn-orange' onclick='registroGrupo();'><i class="bi bi-plus-lg"></i></button>
                    </div>
                </form>
                <div class='row mt-4'>
                    <div class="table-responsive">
                        <table id='tabelaGrupoContasContabil' class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Ação</th>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class='transactionBoxi' id="acessar2" style="display:none;">
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-list-ul me-2"></i>
                    Lista de Serviços
                </span>
                <div class="juntar">
                    
                    <a href="<?php echo(DIRPAGE."lancamentos-pagamento");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-file-bar-graph-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."lancamentos-recebimento");?>">
                        <div class="iconi">
                            <i class="bi bi-file-break-fill"></i>
                        </div>
                    </a>
                    
                </div>
            </div>
            <div class='container mt-4'>
                <form class='row' id='formCadastraContasContabil' action='' method='post'>
                    <div class='col-md-4 mb-2'>
                        <label class='form-label testeLabel text-matrix' for="CodigoContabil">Código Contábil*</label>
                        <input class='form-control' placeholder='' type="text" id="CodigoContaContabil" name="CodigoContabil" />
                    </div>
                    <div class='col-md-4 mb-2'>
                        <label class='form-label testeLabel text-matrix' for="NomeConta">Nome da Conta*</label>
                        <input class='form-control' placeholder='' type="text" id="NomeContabil" name="NomeContabil" />
                    </div>
                    <div class='col-md-4 mb-2'>
                        <label class='form-label text-matrix' for="DescricaoServico">Descrição da Conta*</label>
                        <input class='form-control' placeholder='' type='text' name="DescricaoConta" />
                    </div>
                    <div class='col-md-6 mb-2'>
                        <label class='form-label text-matrix' for="DescricaoServico">Palavra Chave*</label>
                        <input class='form-control' placeholder='' type='text' name="PalavraChave" />
                    </div>
                    <div class='col-md-6 mb-2'>
                        <label class='form-label text-matrix' for="GrupoContas">Grupo de Contas*</label>
                        <select class="form-select selectGrupoContas" name="GrupoContas"></select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type='button' class='btn btn-orange' onclick='registroContasContabil();'>Salvar</button>
                    </div>
                </form>
                <div class='row mt-4'>
                    <div class="table-responsive">
                        <table id='tabelaContasContabil' class="table table-light table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Conta</th>
                                    <th>Palavra Chave</th>
                                    <th>Descrição</th>
                                    <th>Grupo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id='tBodyContasContabil'>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarContas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form class='row' id='formUpdateContaContabil' action='' method='post'>
                            <div class='col-md-4 mb-2'>
                                <label class='form-label' for="CodigoContabil">Código Contábil*</label>
                                <input class='form-control' placeholder='' type="text" id="CodigoContaContabil" name="CodigoContabil" />
                            </div>
                            <div class='col-md-4 mb-2'>
                                <label class='form-label' for="NomeConta">Nome da Conta*</label>
                                <input class='form-control' placeholder='' type="text" id="NomeContabil" name="NomeContabil" />
                            </div>
                            <div class='col-md-4 mb-2'>
                                <label class='form-label' for="DescricaoServico">Descrição*</label>
                                <input class='form-control' placeholder='' type='text' name="DescricaoConta" />
                            </div>
                            <div class='col-md-6 mb-2'>
                                <label class='form-label' for="DescricaoServico">Palavra Chave*</label>
                                <input class='form-control' placeholder='' type='text' name="PalavraChave" />
                            </div>
                            <div class='col-md-6 mb-2'>
                                <label class='form-label' for="GrupoContas">Grupo de Contas*</label>
                                <select class="form-select selectGrupoContas" name="GrupoContas"></select>
                            </div>
                            <input type='hidden' name='IdConta'/>
                            <!--<div class="col-md-12 mt-3">
                                <button type='button' class='btn btn-orange' onclick='registroContasContabil();'>Salvar</button>
                            </div>-->
                        </form>
                    </div>

                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <button type="button" class="btn btn-orange" onclick='updateContaContabil();' data-bs-dismiss="modal">Salvar</button>
                    </div>

                </div>

            </div>
        </div>

        <div class="modal fade" id="modalEditarGrupo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form class='row' id='formUpdateGrupoContabil' action='' method='post'>
                            <div class='col-md-6 mb-2'>
                                <label class='form-label' for="Nome">Nome*</label>
                                <input class='form-control' placeholder='' type="text" id="Nome" name="Nome" />
                            </div>
                            <div class='col-md-6 mb-2'>
                                <label class='form-label' for="Acao">Grupo de Contas*</label>
                                <select class="form-select" name="Acao">
                                    <option value="1">Pagamento</option>
                                    <option value="2">Recebimento</option>
                                </select>
                            </div>
                            <input type='hidden' name='IdGrupo'/>
                            <!--<div class="col-md-12 mt-3">
                                <button type='button' class='btn btn-orange' onclick='registroContasContabil();'>Salvar</button>
                            </div>-->
                        </form>
                    </div>

                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <button type="button" class="btn btn-orange" onclick='updateGrupoContabil();' data-bs-dismiss="modal">Salvar</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>