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

        <div id='mensage'></div>

        <div class='transactionBoxi'>

            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-person-fill"></i>
                    Edição de perfil
                </span>
            </div>

            <div class='container mt-4'>
                <form id='formPerfil' action="" method="post">

                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-matrix" for="nome">Nome</label>
                            <input class="form-control" type='text' id='nome' name='nome'/>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-matrix" for="email">Email</label>
                            <input class="form-control" type='email' id='email' name='email'/>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-matrix" for="telefone">Telefone</label>
                            <input class="form-control" type='tel' id='telefone' name='telefone'/>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-matrix" for="cep">CEP</label>
                            <input class="form-control" type='text' id='cep' name='cep'/>
                        </div>  
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-matrix" for="endereco">Endereço</label>
                            <input class="form-control" type='text' id='endereco' name='endereco'/>
                        </div>  
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-matrix" for="numero">Numero</label>
                            <input class="form-control" type='text' id='numero' name='numero'/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-matrix" for="complemento">Complemento</label>
                            <input class="form-control" type='text' id='complemento' name='complemento'/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-matrix" for="bairro">Bairro</label>
                            <input class="form-control" type='text' id='bairro' name='bairro'/>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-matrix" for="cidade">Cidade</label>
                            <input class="form-control" type='text' id='cidade' name='cidade'/>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-matrix" for="uf">UF</label>
                            <input class="form-control" type='text' id='uf' name='uf'/>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <div class="col-md-6 mt-2">
                            <button class="btn btn-orange" type='button' onclick='atuaizar();'>Salvar</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

        <!--<div class='transactionBoxi'>-->
        <!--    <div class='main-texti'>-->
        <!--        <span class='text-matrix me-2'>-->
        <!--            <i class="bi bi-list-ul me-2"></i>-->
        <!--            Grupo de Contas-->
        <!--        </span>-->
        <!--    </div>-->
        <!--    <div class='container mt-4'>-->
        <!--        <form class='row' id='formCadastraGrupoContas' action='' method='post'>-->
        <!--            <div class='col-11 mb-3'>-->
        <!--                <label class='form-label text-matrix' for="nomeGrupo">Nome*</label>-->
        <!--                <input class='form-control' placeholder='' type="text" id="nomeGrupo" name="nomeGrupo" />-->
        <!--            </div>-->
        <!--            <div class="col-1 mb-3 d-flex justify-content-center align-items-end">-->
        <!--                <button type='button' class='btn btn-orange' onclick='registroGrupo();'><i class="bi bi-plus-lg"></i></button>-->
        <!--            </div>-->
        <!--        </form>-->
        <!--        <div class='row mt-4'>-->
        <!--            <div class="table-responsive">-->
        <!--                <table id='tabelaGrupoContasContabil' class="table table-striped table-bordered text-center">-->
        <!--                    <thead>-->
        <!--                        <tr>-->
        <!--                            <th>Nome</th>-->
        <!--                            <th>Ações</th>-->
        <!--                        </tr>-->
        <!--                    </thead>-->
        <!--                    <tbody>-->
                                
        <!--                    </tbody>-->
        <!--                </table>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

        <!--<div class='transactionBoxi'>-->
        <!--     <div class='main-texti'>-->
        <!--        <span class='text-matrix me-2'>-->
        <!--            <i class="bi bi-list-ul me-2"></i>-->
        <!--            Lista de Serviços-->
        <!--        </span>-->
        <!--    </div>-->
        <!--    <div class='container mt-4'>-->
        <!--        <form class='row' id='formCadastraContasContabil' action='' method='post'>-->
        <!--            <div class='col-md-4 mb-2'>-->
        <!--                <label class='form-label testeLabel text-matrix' for="CodigoContabil">Código Contábil*</label>-->
        <!--                <input class='form-control' placeholder='' type="text" id="CodigoContaContabil" name="CodigoContabil" />-->
        <!--            </div>-->
        <!--            <div class='col-md-4 mb-2'>-->
        <!--                <label class='form-label testeLabel text-matrix' for="NomeConta">Nome da Conta*</label>-->
        <!--                <input class='form-control' placeholder='' type="text" id="NomeContabil" name="NomeContabil" />-->
        <!--            </div>-->
        <!--            <div class='col-md-4 mb-2'>-->
        <!--                <label class='form-label text-matrix' for="DescricaoServico">Descrição da Conta*</label>-->
        <!--                <input class='form-control' placeholder='' type='text' name="DescricaoConta" />-->
        <!--            </div>-->
        <!--            <div class='col-md-6 mb-2'>-->
        <!--                <label class='form-label text-matrix' for="DescricaoServico">Palavra Chave*</label>-->
        <!--                <input class='form-control' placeholder='' type='text' name="PalavraChave" />-->
        <!--            </div>-->
        <!--            <div class='col-md-6 mb-2'>-->
        <!--                <label class='form-label text-matrix' for="GrupoContas">Grupo de Contas*</label>-->
        <!--                <select class="form-select selectGrupoContas" name="GrupoContas"></select>-->
        <!--            </div>-->
        <!--            <div class="col-md-12 mt-3">-->
        <!--                <button type='button' class='btn btn-orange' onclick='registroContasContabil();'>Salvar</button>-->
        <!--            </div>-->
        <!--        </form>-->
        <!--        <div class='row mt-4'>-->
        <!--            <div class="table-responsive">-->
        <!--                <table id='tabelaContasContabil' class="table table-light table-bordered text-center">-->
        <!--                    <thead>-->
        <!--                        <tr>-->
        <!--                            <th>Numero</th>-->
        <!--                            <th>Conta</th>-->
        <!--                            <th>Palavra Chave</th>-->
        <!--                            <th>Descrição</th>-->
        <!--                            <th>Grupo</th>-->
        <!--                            <th>Ações</th>-->
        <!--                        </tr>-->
        <!--                    </thead>-->
        <!--                    <tbody id='tBodyContasContabil'>-->
                                
        <!--                    </tbody>-->
        <!--                </table>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->

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

    </div>

    
</main>