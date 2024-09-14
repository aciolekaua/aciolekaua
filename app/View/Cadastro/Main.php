<main class="h-100 mt-4 d-flex align-items-center">
<div id='divMensage'></div>
<div class="card w-75 h-75 mt-5 mx-auto">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button id='btnPFForm' class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Pessoa Física</button>
      </li>
      <li class="nav-item" role="presentation">
        <button id='btnPJForm' class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pessoa Jurídica</button>
      </li>
    </ul>
  </div>
  
  <div class="card-body">
    <h5 class="card-title">Cadastro</h5>
    <p class="card-text">Os campos que contem "<b>*</b>" são obrigatórios</p>
    <form class="" id='FormularioCad' name="FormularioCad" method="post" action="" >
    
        <fieldset class='row' id='PF' name='PF'>
            
            <!--codigo wallacy inicio-->
            <div class="containeres1">
            <div class="steps1">
                <span class="circle1 active1" data-title="dados">1</span>
                <span class="circle1"  data-title="endereço">2</span>
                <span class="circle1"  data-title="enviar">3</span>
                <div class="progress-bar1">
                    <span class="indicator1"></span>
                </div>
            </div>
            </div>  
            <!--codigo wallacy fim-->
            <div class="form-step1 form-step-active1">
            
                <div class='row' id='comum'>
                    
                    <div class='col-12 mb-2'>
                        <label class='form-label'>Nome Completo* </label>
                        <input class='form-control' 
                        type="text" name="nome" minlength="2" maxlength="150" 
                        placeholder="Nome" pattern="[a-z A-Z À-ú]{2,}" 
                        onkeypress="maskName(this, nome);" onblur="maskName(this, nome);" required/>
                    </div>
                    <div class='col-md-6 mb-2'>
                        <label class='form-label'>CPF*</label>
                        <input class='form-control' id="cpf" type="text" name="cpf" minlength="14" maxlength="14" placeholder="CPF"
                        onkeypress="mascaraCpf(this, cpf)" onblur="mascaraCpf(this, cpf)" required/>
                    </div>
                    
                    <div class='col-md-6 mb-2'>
                        <label class='form-label'>Data de Nascimento*</label>
                        <input class='form-control' type="date" name="dtnascimento" required/>
                    </div>
                    <input type='hidden' name='tipoCliente' value='PF'/>
                    
                    <div class='col-md-6 mb-2'>
                        <label class='form-label'>Email*</label>
                        <input class='form-control' id="emailPF" type="email" name="emailPF" maxlength="60" placeholder="Email"
            			pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/>
                    </div>
                    
                    <div class='col-md-6 mb-2'>
                        <label class='form-label'>Senha*</label>
                        <div class="input-group mb-2">
                            <input type="password" id="senha2" name="senha" minlength="6" maxlength="12" 
                            pattern="^.{6,}$"  required class="form-control" placeholder="" aria-label="" aria-describedby="bntMostrarSenha">
                            <button class="btn btn-secondary" type="button" id="bntMostrarSenha"><i class="bi bi-eye"></i></button>
                        </div>
                        
                    </div>
                    <!--codigo wallacy incio-->
                    <div class='col-12'>
                        <div class='row p-2' id='comum'>
                            <div class='d-flex justify-content-between' id="dvbotao">
                                <!--codigo wallacy inicio-->
                                <a class="btn-laranja" id="voltar" href="<?php echo DIRPAGE.'login'; ?>">Voltar</a>
                                <button type='button' class="btn-laranja button1" id="next1">Próximo</button>
                               
                            </div>
                        </div>
                    </div>
                    <!--codigo wallacy fim-->
                </div>
            </div>
            
            <div class="form-step1">
            <div class='row' id='comum'>
            
            <div class="col-sm-6 mb-2">
                <label class='form-label' for="cep">CEP*</label>
        	    <input name="Cep1" id="Cep1" class="mascCEP  form-control"   value="" size="10" maxlength="9"
                                    onblur="pesquisacep(this.value);" />
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Endereço*</label>
                <input class="form-control" name="enderecoPF" type="text" size="60" required/>
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Bairro*</label>
                <input class="form-control" name="bairroPF" type="text" size="40" required/>
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Cidade*</label>
                <input class="form-control" name="cidadePF" type="text" size="40" required />
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Complemento</label>
                <input class="form-control" name="complementoPF" type="text" size="60"/>
            </div>
                
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Nº*</label>
                <input class="form-control" name="numeroPF" type="text" size="60" required/>
            </div>
            
            <div class='col-sm-6 mb-3'>
                <label class='form-label'>UF*</label>
                <input class="form-control" name="ufPF" type="text" size="2" required/>
                </div>
                <div class='col-sm-6 mb-2'>
                <label class='form-label'>Telefone*</label>
                <input class="form-control" id="tel" type="tel" name="telPF"  minlength="13" maxlength="15" 
                placeholder="(XX)9XXXX-XXXX" onkeypress="mascaraTel(this, tel)" onblur="mascaraTel(this, tel)" required/>
            </div>
            
            </div>
                <div class='row p-2' id='comum'>
                <div class='d-flex justify-content-between' id="dvbotao">
                <!--codigo wallacy inicio-->
                <button type='button' class="btn-laranja button1" id="prev1">Anterior</button>
                <button type='button' class="btn-laranja button1" id="next1">Próximo</button>
                <!--codigo wallacy fim-->
                </div>
                </div>
        </div>
            <div class="form-step1">
        <div class='d-flex justify-content-between' id="dvbotao">
            <button class="btn-laranja button1" id="prev1">Anterior</button>
            <button class="btn-laranja" onclick='cadastrarPF(this);' id="btcadastro" type="button" name="enviar">Cadastrar</button>
        </div>
            </div>  
            </div>
        </fieldset>
        
        <fieldset class='row m-0' id='PJ'  style='display:none; background:#F9F9F9;' name='PJ' disabled>
            <!--codigo wallacy inicio-->
                <div class="containeres">
            <div class="steps">
                <span class="circle active" data-title="dados">1</span>
                <span class="circle"  data-title="endereço">2</span>
                <!-- <span class="circle">3</span> -->
                <span class="circle"  data-title="enviar">3</span>
                <div class="progress-bar">
                    <span class="indicator"></span>
                </div>
            </div>
            </div>  
            <!--codigo wallacy fim-->
            <!--codigo wallacy incio-->
            <div class="form-step form-step-active">
            <!--codigo wallacy fim-->
        <div class='row'>
    		<div class='col-sm-6 mb-2'>
    		    <label class='form-label'>Tipo Jurídico*</label>
    	        <select id="selectPJ" class='dselect' name="tipoJuri" required >
    	            <option value="">Selecione uma opção</option>
    	        </select>
    		</div>
    		<div class='col-sm-6 mb-2'>
    		    <label class='form-label'>CNPJ*</label>
        		<input class='form-control' id="cnpj" type="text" name="cnpj" minlength="18" maxlength="18" placeholder="CNPJ" 
                onkeypress="mascaraCnpj(this, cnpj)" onblur="mascaraCnpj(this, cnpj);buscaCNPJ(this);" required/>
    		</div>
    		
    		<div class='col-sm-12 mb-2'>
    		    <label class='form-label'>Nome Fantazia*</label>
    		    <input class='form-control' id="nomeFantazia" type="text" name="nomeFantazia"  minlength="2" maxlength="150" required/>
    		</div>
    		
    		<div class='col-sm-12 mb-2'>
    		    <label class='form-label'>Razão Social*</label>
    		    <input class='form-control' id="razaoSocial" type="text" name="razaoSocial"  minlength="2" maxlength="150" required/>
    		</div>
    		
            <input type='hidden' name='tipoCliente' value='PJ'/>
        
            
            <div class='col-md-6 mb-2'>
                <label class='form-label'>Email*</label>
                <input class='form-control' id="emailPJ" type="email" name="emailPJ" maxlength="60" placeholder="Email"
    			pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/>
            </div>
            
            <div class='col-md-6 mb-2'>
                <label class='form-label'>Senha*</label>
                <div class="input-group mb-2">
                    <input type="password" id="senha2" name="senha" minlength="6" maxlength="12" 
                    pattern="^.{6,}$"  required class="form-control" placeholder="" aria-label="" aria-describedby="bntMostrarSenha">
                    <button class="btn btn-secondary" type="button" id="bntMostrarSenha"><i class="bi bi-eye"></i></button>
                </div>
            </div>
        <!--codigo wallacy incio-->
                    <div class='d-flex justify-content-between buttons p-3' id="dvbotao">
                        <!--codigo wallacy inicio-->
                        <a class="btn-laranja" id="voltar" href="<?php echo DIRPAGE.'login'; ?>">Voltar</a>
                        <button class="btn-laranja button" id="next" type="button">Próximo</button>
                       
                    </div>
        <!--codigo wallacy fim-->
            <!--codigo walllacy inicio-->
        </div>
          </div>
            <!--codigo walllacy fim-->
        
            <!--codigo wallacy inicio-->
            <div class="form-step">
            <!--codigo wallacy fim-->
            <div class='row p-2' id='comum'>
             <div class='col-sm-6 mb-2'>
                <label class='form-label'>CEP*</label>
                <input class="form-control" onblur='buscaCep(this, "PJ");' oninput="mask(this,cepMask);" name="cepPJ" type="text" size="10" maxlength="10" required/>
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Telefone*</label>
                <input class="form-control" id="tel" type="tel" name="telPJ"  minlength="13" maxlength="15" 
                placeholder="(XX)9XXXX-XXXX" onkeypress="mascaraTel(this, tel)" onblur="mascaraTel(this, tel)" required/>
            </div>
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Endereço*</label>
                <input class="form-control" name="enderecoPJ" type="text" size="60" required/>
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Nº*</label>
                <input class="form-control" name="numeroPJ" type="text" size="60" required/>
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Bairro*</label>
                <input class="form-control" name="bairroPJ" type="text" size="40" required/>
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Cidade*</label>
                <input class="form-control" name="cidadePJ" type="text" size="40" required />
            </div>
            
            <div class='col-sm-6 mb-2'>
                <label class='form-label'>Complemento</label>
                <input class="form-control" name="complementoPJ" type="text" size="60"/>
            </div>
                
            <div class='col-sm-6 mb-3'>
                <label class='form-label'>UF*</label>
                <input class="form-control" name="ufPJ" type="text" size="2" required/>
            </div>
            </div>
            <!--codigo wallacy incio-->
            <div class='row p-2' id='comum'>
            <div class='d-flex justify-content-between p-3' id="dvbotao">
                <!--codigo wallacy inicio-->
                <button type="button" class="btn-laranja button" id="prev">Anterior</button>
                <button type="button" class="btn-laranja button" id="next">Próximo</button>
                <!--codigo wallacy fim-->
                </div>
            </div>
   
        <!--codigo wallacy inicio-->
        </div>
        <!--codigo wallacy fim-->
        <!--codigo wallacy inicio-->

            <div class="form-step">
              <div class='d-flex justify-content-between p-3' id="dvbotao">
            <button type="button" class="btn-laranja button" id="prev">Anterior</button>
            <button class="btn-laranja" onclick='cadastrarPJ(this);' id="btcadastro" type="button" name="enviar">Cadastrar</button>
              </div>
            </div>

            <!--codigo wallacy fim-->
        </fieldset>

    </form>
</div>
</div>
</main>