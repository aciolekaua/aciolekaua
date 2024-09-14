<main class="my-2">
    <div class="container-fluid">
        <div id='menssage'></div>
        <!--<form class='shadow p-3 rounded mb-3' id='formRegistroPonto'>-->
        <!--    <div class='row'>-->
              
        <!--        <div class='col-sm-6 mb-2'>-->
        <!--            <label class='form-label'>Ação</label>-->
        <!--            <select class='form-select' name='status'></select>-->
        <!--        </div>-->
                
        <!--        <div class='col-sm-12 mt-2'>-->
        <!--            <button class='btn btn-primary' type='button' onclick='insertRegistroPonto();'>Registrar</button>-->
        <!--        </div>-->
                
        <!--    </div>-->
        <!--</form>-->
        <!--<form class='shadow p-3 rounded' id='formRegistrarHorario'>-->
        <!--    <div class='row'>-->
              
        <!--        <div class='col-sm-4 mb-2'>-->
        <!--            <label class='form-label'>Dias da semana</label>-->
        <!--            <select class='form-select' name='diasSemana'>-->
        <!--                <option value='1'>Domingo</option>-->
        <!--                <option value='2'>Segunda</option>-->
        <!--                <option value='3'>Terça</option>-->
        <!--                <option value='4'>Quarta</option>-->
        <!--                <option value='5'>Quinta</option>-->
        <!--                <option value='6'>Sexta</option>-->
        <!--                <option value='7'>Sábado</option>-->
        <!--            </select>-->
        <!--        </div>-->
                
        <!--        <div class='col-sm-4 mb-2'>-->
        <!--            <label class='form-label'>Tempo de Trabalho</label>-->
        <!--            <input class='form-control' type='text' name='tempTrabalho' />-->
        <!--        </div>-->
                
        <!--        <div class='col-sm-4 mb-2'>-->
        <!--            <label class='form-label'>Tempo de Descanço</label>-->
        <!--            <input class='form-control' type='text' name='tempDescanco' />-->
        <!--        </div>-->
                
        <!--        <div class='col-sm-12 mt-2'>-->
        <!--            <button class='btn btn-primary' type='button'>Registrar</button>-->
        <!--        </div>-->
                
        <!--    </div>-->
        <!--</form>-->
        <button id='btnLogin' type="button" class="" data-bs-toggle="modal" data-bs-target="#loginModal">Acessar</button>
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style='pointer-events:none;'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Autenticação</h5>
                        <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                    </div>
                    <div class="modal-body">
                        <form id='formLogin'>
                            <div class='row'>
                                <div class='col-12'>
                                    <label class='form-label'>CPF</label>
                                    <input class='form-control' type='text' name='cpf' onkeypress="mascaraCpf(this, cpf)" onblur="mascaraCpf(this, cpf)" minlength="14" maxlength="14"/>
                                </div>
                                <div class='col-12'>
                                    <label class='form-label'>Código</label>
                                    <input class='form-control' type='text' name='codigo'autocomplete='off' minlength="4" maxlength="4"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick='login();'>Autenticar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>