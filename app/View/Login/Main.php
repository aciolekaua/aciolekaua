<div class="overlayk-loading">
        <!--<img src="" alt="gif" height="180" width="180">-->
    <div class="loader">Carregando
        <span></span>
    </div>
</div>
<main class="h-100 d-flex align-items-center">
    <!--<div class="container-fluid">-->
      <section class="home">
         <div class='w-25 mx-auto text-center' id='divMSG'></div>
        <div class="form_container">
        <!--<i class="fa-solid fa-xmark"></i>-->
        <!-- Login From -->
        <div class="form login_form">
            <form id='formLogin' action="" method='post'>
                <h2>Login</h2>
                <br>
            <div class=''>
                <input class='form-check-input' id='tipoCliente1' type='radio' name='tipoCliente' value='PF'required/>
                <label for='tipoCliente1' class='form-check-label'>Pessoa Física</label>
            </div>
            <div class=''>
                <input class='form-check-input' id="tipoCliente2" type='radio' name='tipoCliente' value='PJ' required/>
                <label for="tipoCliente2" class='form-check-label'>Pessoa Jurídica</label>
            </div>
                <div class="input_box">
                    <input type="email" id="email" name='email' placeholder="digite seu e-mail" required>
                    <i class="fa-solid fa-envelope email"></i>
                </div>
                <div class="input_box">
                    <input type="password" id="senha" name='senha' placeholder="digite sua senha"required>
                    <i class="fa-solid fa-lock password"></i>
                </div>
                <br>
                 <div class='form-group d-flex justify-content-between mb-0' id="bottons">
                <button id='login' class='btn-laranja' type='button'>Entrar</button>
                <a class='btn-laranja' href='<?php echo DIRPAGE."cadastro";?>'>Cadastrar-se</a>
                </div>
                <div class='form-group mt-3'>
                    <a href='<?php echo DIRPAGE."recuperar-senha";?>' id="esqueceu">Esqueceu a senha?</a>
                </div>
            </form>
        </div>
    </div>
</section>
    <!--</div>-->
</main>