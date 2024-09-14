<main class="mt-5 h-100 d-flex align-items-center">
    <div class='mt-5 container-fluid d-flex flex-column align-items-center justify-content-center h-100 w-100 P-5'>
        <div id='divMensage'></div>
        <form id='NovaSenha' class='border rounded p-3' action='<?php echo(DIRPAGE."recuperacao-senha2/registrar"); ?>' method='post'>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="PfPj" id="PF" value='PF' required>
                <label class="form-check-label" for="PF">PF</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="PfPj" id="PJ" value='PJ' required>
                <label class="form-check-label" for="PJ">PJ</label>
            </div>
            <div class='div-group'>
                <label class="form-label">Insira o código</label>
                <input class='form-control' type='text' name='codigo' autocomplete='off' required/>
            </div>
            <div class='div-group'>
                <label class="form-label">Insira a nova senha</label>
                <input class='form-control' type='text' name='senha' autocomplete='off' required/>
            </div>
            <div class='div-group'>
                <label class="form-label">Confirme a nova senha</label>
                <input class='form-control' type='text' name='cSenha' autocomplete='off' required/>
            </div>
            <div class='div-group d-flex flex-row justify-content-between mt-3'>
                <input class='btn btn-orange' type='submit' name='enviar' value='Enviar'/>
                <a class='btn btn-orange r-0' href='<?php echo(DIRPAGE."login"); ?>'>Voltar</a>
            </div>
        </form>
    </div>
</main>