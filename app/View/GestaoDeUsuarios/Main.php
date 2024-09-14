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
        
    
        <!--<div class="juntar-card">-->
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-people-fill"></i>
                    Regras do Conselho Fiscal
                </span>
            </div>
            <div class='container mt-4'>
                <form id='formRegrasConselho' class='row' action="" method='post'>
                    
                    <div id="formConselho" class='form-group  col-4 '>
                        <label class='form-label text-matrix'>Número máximo de conselheiros</label>
                        <select class="form-select" name='nMaxConselheiros' required>
                            <option value=''>Selecione uma opção</option>
                        </select>
                    </div>
                    
                    <div id="formConselho" class='form-group col-4'>
                        <label class='form-label text-matrix'>Número mínimo de votos</label>
                        <select class="form-select" name='nMinVotos' required>
                            <option value=''>Selecione uma opção</option>
                        </select>
                    </div>
                    
                    <div id="formConselho" class='form-group col-4'>
                        <label class='form-label text-matrix'>Número máximo de votos</label>
                        <select class="form-select" name='nMaxVotos' required>
                            <option value=''>Selecione uma opção</option>
                        </select>
                    </div>
                    
                    <div class='form-group'>
                        <input class='btn btn-orange' type='button' name='conselho' value='Salvar' onclick='salvarRegrasConselho();'/>
                    </div>
                </form>
            </div>
        </div>
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-people-fill"></i>
                    Regras do Conselho Fiscal
                </span>
                <div class="legend-boxi">
                    <button id='btnRegistrarFieldset' id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" class="first">Registrar Conselheiro</button>
                    <button id='btnAtualizarFieldset' id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" class="second">Atualizar Conselheiro</button>
                </div>
            </div>
            <!--<div class='card-header'>-->
            <!--    <ul class="nav nav-tabs card-header-tabs" role="tablist">-->
            <!--      <li class="nav-item" role="presentation">-->
            <!--        <button id='btnRegistrarFieldset' class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Registrar</button>-->
            <!--      </li>-->
            <!--      <li class="nav-item" role="presentation">-->
            <!--        <button id='btnAtualizarFieldset' class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Atualizar</button>-->
            <!--      </li>-->
            <!--    </ul>-->
            <!--</div>-->
            <div class='container mt-4'>
                <form id="formRegistra_Atualiza_Usuario" class="" action="" method="post">
                    <div class='row'>
                        <div class='col-12'>
                            <div class="form-check form-check-inline">
                                <input class='form-check-input' type="radio" name="Email_CPF" id='Email_CPF1' value='cpf' checked/>
                                <label class='form-check-label text-matrix' for="Email_CPF1">CPF</label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                                <input class='form-check-input' type="radio" name="Email_CPF" id='Email_CPF2' value='email' />
                                <label class='form-check-label text-matrix' for="Email_CPF2">Email</label>
                            </div>
                        </div>
                        <div id="formRegistrar" class="col-sm-4">
                            <fieldset class='fieldsetCPF_Email'>
                                <label class='form-label text-matrix'>CPF</label>
                                <input class="form-control" type="text" name="cpf" minlength="14" maxlength="14"
                                onkeypress="mascaraCpf(this, cpf)" onblur="mascaraCpf(this, cpf)" autocomplete="off"/>
                            </fieldset>
                        </div>
                        <div id="formRegistrar" class="col-sm-4">
                            <fieldset class='fieldsetCPF_Email' disabled>
                                <label class='form-label text-matrix'>Email</label>
                                <input class="form-control" type="email" name="email" />
                            </fieldset>
                        </div>
                        <div id="formRegistrar" class="col-sm-4">
                            <label class='form-label text-matrix'>Tipo de Usuário</label>
                            <select class="form-select" id="selectPermissoes" name="permissao" required>
                                <option value="">Selecione uma opção</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button id='btnRegistrar_Atualizar_Usuario' class="btn btn-orange" type="button" onclick='salvarUsuarios();'>Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--</div>-->
        <div class='transactionBoxi'>
            <form id='formusuarios' action="" method="post">
                <div class='main-texti'>
                    <span class='text-matrix me-2'>
                        <i class="bi bi-person-x-fill"></i>
                        Exclusão e Visualização de Usuários
                    </span>
                </div>
                <div class='container mt-4'>
                    <div class="table-responsive">
                        <table
                            id="tabelaUsuarios"
                            class="table table-striped data-table"
                            style="width: 100%"
                        >
                            <thead>
                              <tr>
                                <th></th>
                                <th>Usuário</th>
                                <th>Cargo</th>
                              </tr>
                            </thead>
                            <tbody id="tbodyTabela"></tbody>
                            <!--<tfoot>-->
                            <!--  <tr>-->
                            <!--    <th></th>-->
                            <!--    <th>Usuário</th>-->
                            <!--    <th>Cargo</th>-->
                            <!--  </tr>-->
                            <!--</tfoot>-->
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <input class="btn btn-danger" type="button" name="excluir" onclick='excluirUsuarios()' value="Excluir"/>
                </div>
            </form>
    </div>
        <!--<div class='card mb-3'>
            <div class='card-header'>
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button id='btnRegistrarFieldset' class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Registrar</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button id='btnAtualizarFieldset' class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Atualizar</button>
                  </li>
                </ul>
            </div>
            <div class='card-body'>
                <form id="formRegistra_Atualiza_Usuario" class="row mb-3 p-3 bg-white" action="" method="post">
                    <fieldset style='display:none;' class='col-sm-12 mb-3 registrarFieldset' disabled>
                        
                        <div class="form-check form-check-inline">
                            <input class='form-check-input' type="radio" name="Email_CPF" id='Email_CPF1' value='cpf' checked/>
                            <label class='form-check-label' for="Email_CPF1">CPF</label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                            <input class='form-check-input' type="radio" name="Email_CPF" id='Email_CPF2' value='email' />
                            <label class='form-check-label' for="Email_CPF2">Email</label>
                        </div>
                        
                    </fieldset>
                    
                    <fieldset class='col-sm-6 mb-3 registrarFieldset'>
                        <div class="form-group">
                            <label class='form-label'>Nome</label>
                            <input class='form-control' 
                            type="text" name="nome" minlength="2" maxlength="150" pattern="[a-z A-Z À-ú]{2,}" 
                            onkeypress="maskName(this, nome);" onblur="maskName(this, nome);" required/>
                        </div>
                    </fieldset>
                    
                    <fieldset class='col-sm-6 mb-3 fieldsetCPF_Email'>
                        <div class="form-group">
                            <label class='form-label'>CPF</label>
                            <input class="form-control" type="text" name="cpf" minlength="14" maxlength="14"
                            onkeypress="mascaraCpf(this, cpf)" onblur="mascaraCpf(this, cpf)" autocomplete="off"/>
                        </div>
                    </fieldset>
                    
                    <fieldset class='col-sm-6 mb-3 fieldsetCPF_Email'>
                        <div class="form-group">
                            <label class='form-label'>Email</label>
                            <input class="form-control" type="email" name="email" />
                        </div>
                    </fieldset>
                    
                    <div class="form-group col-sm-6 mb-3">
                        <label class='form-label'>Tipo de Usuário</label>
                        <select class="form-select" id="selectPermissoes" name="permissao" required>
                            <option value="">Selecione uma opção</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button id='btnRegistrar_Atualizar_Usuario' class="btn btn-orange" type="button" onclick='salvarUsuarios();'>Registrar</button>
                    </div>
                </form>
            </div>
        </div>-->
   
</main>