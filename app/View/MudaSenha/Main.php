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
        <div id='divMSG'></div>
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                <i class="bi bi-key-fill me-1"></i>
                Edição de Senha
                </span>
            </div>
            <div class='container mt-4'>
                <form class='' id='formMudaSenha' method='post'>
                    <div class="form-group">
                        <label class="form-label text-matrix" for="senhaAtual">Senha Atual</label>
                        <input class="form-control" type='text' id='senhaAtual' name='senhaAtual'/>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label text-matrix" for="novaSenha">Nova Senha</label>
                        <input class="form-control" id='novaSenha' name='novaSenha'/>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label text-matrix" for="confirmarSenha">Confirmar Nova Senha</label>
                        <input class="form-control" id='confirmarSenha' name='confirmarSenha'/>
                    </div>
                    
                    <div class="form-group mt-3">
                        <button class="btn btn-orange" type='button' id='btnMudarSenha'>Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>