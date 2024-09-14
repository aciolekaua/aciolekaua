<main class="mt-5 h-100 d-flex align-items-center">
<div class='mt-5 container-fluid d-flex flex-column align-items-center justify-content-center h-100 w-100'>
    <div id='divMSG'></div>
    <form id='formRecuperaSenha1'  action='' method='post'>
        
        <div class='form_container'>
            <label class="form-label d-block">Tipo de Pessoa</label>
            <div class="">
                <input class="form-check-input" type="radio" name="PFPJ" id="PFPJ" value="PJ">
                <label class="form-check-label" for="PFPJ">Jurídica</label>
            </div>
            <div class="">
                <input class="form-check-input" type="radio" name="PFPJ" id="PFPJ" value="PF">
                <label class="form-check-label" for="PFPJ">Física</label>
            </div>
        
        <div class='input_box'>
            <input type='email' name='email' placeholder="digite seu e-mail" />
            <i class="fa-solid fa-envelope email"></i>
        </div>
        
        <div class='div-group d-flex flex-row justify-content-between mt-3'>
            <a class='btn-laranja' href='<?php echo(DIRPAGE."login"); ?>'>Voltar</a>
            <input id='btnEnviarEmail' class='btn-laranja' type='button' name='enviar' value='Enviar'/>
        </div>
        
        </div>
    </form>
  
    <form id='formRecuperaSenha2' class='border rounded p-3' action='' method='post'>
        <input type='hidden' name='PFPJTemp'/>

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
            <a class='btn-laranja' href='<?php echo(DIRPAGE."login"); ?>'>Voltar</a>
            <input id='btnMudarSenha' class='btn-laranja' type='button' name='salvar' value='Salvar'/>
        </div>
    </form>
    
</div>
</main>