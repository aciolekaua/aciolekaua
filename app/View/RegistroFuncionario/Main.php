<main class="mt-1 pt-1">
    <div class="container">
        <header>Registro de funcionario</header>
            <div class="progressbar">
                <div class="progress" id="progress"></div>
                
                <div
                  class="progress-step progress-step-active"
                  data-title="Pessoal">
                </div>
                <div class="progress-step" data-title="Profissional"></div>
                <div class="progress-step" data-title="Depedente"></div>
            </div>
        <form action="#">

            <div class="form form-step form-step-active">
                <div class="details personal">
                    <span class="title">Dados Pessoais</span>

                    <div class="fields">
                        <div class="input-field">
                            <label for="">N° do CPF</label>
                            <input class='form-control' id="cpf" type="text" name="cpf" minlength="14" maxlength="14" placeholder="CPF"
                            onkeypress="mascaraCpf(this, cpf)" onblur="mascaraCpf(this, cpf)" />
                        </div>

                        <div class="input-field">
                            <label for="">Nome Completo</label>
                            <input class='form-control' 
                            type="text" name="nome" minlength="2" maxlength="150" 
                            placeholder="Nome" pattern="[a-z A-Z À-ú]{2,}" 
                            onkeypress="maskName(this, nome);" onblur="maskName(this, nome);"/>
                        </div>

                        <!--<div class="input-field">-->
                            <div class="select-menu">
                            <label for="" id="Etnia">Etnia</label>
                                <div class="select-btn">
                                    <span class="sBtn-text">Selecione uma Etnia</span>
                                    <!--<i class="bx bx-chevron-down"></i>-->
                                </div>
                                <ul class="options">
                                    <li class="option">
                                        <!--<i class="bx bxl-github" style="color: #171515;"></i>-->
                                        <span class="option-text">Pardos</span>
                                    </li>
                                    <li class="option">
                                        <!--<i class="bx bxl-instagram-alt" style="color: #E1306C;"></i>-->
                                        <span class="option-text">Brancos</span>
                                    </li>
                                    <li class="option">
                                        <!--<i class="bx bxl-linkedin-square" style="color: #0E76A8;"></i>-->
                                        <span class="option-text">Negros</span>
                                    </li>
                                    <li class="option">
                                        <!--<i class="bx bxl-facebook-circle" style="color: #4267B2;"></i>-->
                                        <span class="option-text">Indígenas</span>
                                    </li>
                                    <li class="option">
                                        <!--<i class="bx bxl-twitter" style="color: #1DA1F2;"></i>-->
                                        <span class="option-text">Amarelos</span>
                                    </li>
                                </ul>
                            </div>
                        <!--</div>-->
                            <div class="input-field">
                                <label for="">Email</label>
                                <input class='form-control' id="emailPF" type="email" name="emailPF" maxlength="60" placeholder="Email"
                			    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>
                            </div>

                             <div class="input-field">
	                            <label id="labelCep">CEP</label>
                                <input class="form-control" id="cep" type="text" name="cep" oninput="mask(this,cepMask);" onblur='buscaCep(this);' maxlength='9' placeholder=""/>
	                        </div>
	                        <div class="input-field">
                                <label id="labelEndereco" for="endereco">Endereço</label>
                                <input name="enderecoPF" id="enderecoPF"  class="form-control" size="60"/>
	                        </div>
	                        <div class="input-field">
	                            <label id="labelNumero" for="numeroEndereco">Numero</label>
                                <input  name="cepNumero" id="cepNumero"  class="form-control"  size="60" onkeypress="return maskNumber(event);" />
	                        </div>
	                        <div class="input-field">
	                            <label id="labelBairro" for="bairro">Bairro</label>
                                <input name="bairroPF" type="text" id="bairroPF"  class="form-control" size="40" />
	                        </div>
	                        <div class="input-field">
	                            <label id="labelComplemento" for="complemento">Complemento</label>
                                <input  name="complementoPF" id="complementoPF"  class="form-control" size="40"/>
	                        </div>
	                        <div class="input-field">
                                <label id="labelCidade" for="cidade">Municipio</label>
                                <input name="cidadePF" type="text" id="cidadePF"  class="form-control" size="40"  />
	                        </div>
	                        <div class="input-field">
	                            <label id="labelUf" for="uf">UF</label>
                                <input name="ufPF" type="text" id="ufPF" class="form-control" size="2" />
	                        </div>
                        <div class="input-field">
                           <label for="">Data de Admissão</label>
                            <input type="date" name="dataAdmissaoPessoal" id="dataAdmissaoPessoal"  class="form-control"/>
                        </div>

                        <div class="input-field">
                            <label for="">Sindicalizado</label>
	                            <input type="text" name="Sindicalizado" id="Sindicalizado" class="form-control" minlength="20" maxlength="150" 
    			                    pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>

                        <!--<div class="input-field">-->
                        <!--    <label>Occupation</label>-->
                        <!--    <input type="text" placeholder="Enter your ccupation" >-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Informações do PIS</span>

                    <div class="fields">
                        <div class="input-field2">
                            <label for="">PIS/NIS</label>
	                           <input type="text" name="pis" id="pis" class="form-control" onkeyup="mascara(this, pispasep);" maxlength="14" />
                        </div>

                        <div class="input-field2">
                            <label for="">Data de Cadastro</label>
	                           <input type="date" name="dataPIS" id="dataPIS" class="form-control" />
                        </div>
                    </div>
                </div> 
                <div class="details ID">
                    <span class="title">Pagamento</span>
                    
                    <div class="fields">
                        <div class="payment-method">
                            <button id="Banco" class="method selected">
                                <i class="bi bi-credit-card"></i>
                                <span>Conta Bancaria</span>
                                
                                <i class="bi bi-check-circle-fill cartao-btn"></i>
                            </button>
                            <button id="pix" class="method selected">
                                <i class="bi bi-cash"></i>
                                <span>Pix</span>
                                
                                <i class="bi bi-check-circle pix-btn"></i>
                            </button>
                        </div>
                    </div>
                    <div class="fields" id="Banco-div" style="display:none;">
                            <div class="input-field2">
                                    <label for="">Banco</label>
        	                        <input type="text" name="BancoPagamento"  id="BancoPagamento" class="form-control" onkeypress="return onlynumber();"
        	                           maxlength="4" minlength="1" /> 
                            </div>
    
                            <div class="input-field2">
                                <label for="">Agência</label>
    	                           <input type="text" name="AgenciaPagamento"  id="AgenciaPagamento" class="form-control" class="estado form-control" 
                                      pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);"
    	                           maxlength="6" minlength="1" /> 
                            </div>
                            <div class="input-field2">
                               <label for="">Conta</label>
    	                           <input type="text" name="ContaPagamento"  id="ContaPagamento" class="form-control"  onkeypress="return onlynumber();"
    	                           maxlength="8" minlength="1" /> 
                            </div>
    
                            <div class="input-field2">
                                <label for="">Código de Operação</label>
                                   <input 	type="text" name="CodigoPagamento"  id="CodigoPagamento" class="form-control" onkeypress="return onlynumber();" />
                            </div>
                    </div>
                    <div class="fields" id="pix-div" style="display:none;">
                        <div class="input-field">
                            <label for="nome-pix" class="form-label">PIX</label>
                            <input type="text" id="pixPagamento" class="form-control" name="pixPagamento">
                        </div>
                    </div>
                </div> 
                <div class="details ID">
                    <span class="title">Anexos</span>
                    <span>Não e Obrigado colocar os anexos, o que tiver pode está adicionando</span><br>
                    <div class="fields" id="">
                        <div class="input-field2">
                            <label for="">Foto 3x4</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control"/>
                        </div>
                        <div class="input-field2">
                            <label for="">Cpf</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control"/>
                        </div>

                        <div class="input-field2">
                            <label for="">Carteira de Indentidade</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control"/>
                        </div>
                        <div class="input-field2">
                            <label for="">Titulo de Eleitor</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control"/>
                        </div>

                        <div class="input-field2">
                            <label for="">Certidão de Casamento ou nascimento</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control" />
                        </div>
                        <div class="input-field2">
                            <label for="">Carteira de Reservista</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control" />
                        </div>
                        <div class="input-field2">
                            <label for="">Comprovante de Residência</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control" />
                        </div>
                        <div class="input-field2">
                            <label for="">Atestado Médico (Admissional)</label>
	                        <input type="file" name="arquivo" id="arquivo" class="form-control" />
                        </div>
                    </div>
                    <div class="fields" id="pix-div" style="display:none;">
                        <div class="input-field">
                            <label for="nome-pix" class="form-label">PIX</label>
                            <input type="text" id="pixPagamento" class="form-control" name="pixPagamento">
                        </div>
                    </div>
                        
                    <button href="#" class="btn-next">
                        <span class="btnText">Próximo</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>

            <div class="form form-step">
                <div class="details ID">
                    <span class="title">Dados Extra</span>
                    <div class="fields">
                        
                        <div class="input-field">
                            <label for="">Nome da Mãe</label>
	                            <input type="text" name="NomeDaMae" id="NomeDaMae" class="form-control" minlength="3" maxlength="3" 
    			                pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>
                        <div class="input-field">
                            <label for="">Nome do Pai</label>
	                            <input type="text" name="nomeDoPai" id="nomeDoPai" class="form-control" minlength="3" maxlength="3" 
    			                pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>
                        <div class="input-field">
                            <label for="">Local de Nascimento</label>
	                            <input type="text" name="conselhoProfissional" id="conselhoProfissional" class="form-control" minlength="3" maxlength="3" 
    			                pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>
                    </div>
                </div>
                <div class="details address">
                    <span class="title">Passaporte</span>

                    <div class="fields">
                        <div class="input-field">
                            <label for="">Número</label>
                            <input type="text" name="numeroPassaporte"  id="numeroPassaporte" class="form-control"  onkeypress="return onlynumber();" 
	                           maxlength="18" minlength="3" />
                        </div>

                        <div class="input-field">
                            <label for="">Emissor:</label>
	                               <input type="text" name="EmissorPassaporte" id="EmissorPassaporte" class="form-control" size="3" 
    			                   pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>

                        <div class="input-field">
                            <label id="labelUf" for="uf">UF</label>
                                  <input type="text" id="estadoPassaporte" name="estadoPassaporte" class="estado form-control" 
                                  pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>

                        <div class="input-field">
                            <label for="">Data de Expedição</label>
                                   <input type="date" name="dataExpedicaoPassaporte" id="dataExpedicaoPassaporte" class="form-control" />
                        </div>

                        <div class="input-field">
                            <label for="">Data de Vencimento</label>
                                   <input type="date" name="dataVencimentoNascimento" id="dataVencimentoNascimento" class="form-control" />
                        </div>

                        <div class="input-field">
                             <label for="">Pais de emissão</label>
	                                    <input type="text" name="paisEmissao"  id="paisEmissao" class="form-control" class="estado form-control" 
                                  pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" 
	                           maxlength="10" minlength="1" /> 
                        </div>
                    </div>
                </div>

                <div class="details family">
                    <span class="title">Carteira de Motorista</span>

                    <div class="fields">
                        <div class="input-field">
                            <label for="">Número</label>
                                   <input type="text" name="numeroMotorista"  id="numeroMotorista" class="form-control"  onkeypress="return onlynumber();" 
	                                maxlength="10" minlength="1" />
                        </div>
                        <div class="input-field">
                            <label for="">Primeira Habilitação</label>
                            <input type="date" name="dataHabilitacaoMotorista" id="dataHabilitacaoMotorista" class="form-control" />
                        </div>
                        <div class="input-field">
                            <label id="labelUf" for="uf">UF</label>
                                    <input type="text" id="estadoMotorista" name="estadoMotorista" class="estado form-control" 
                                  pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>
                        <div class="input-field2">
                            <label for="">Categoria</label>
	                               <input type="text" name="categoriaMotorista" id="categoriaMotorista" class="form-control" size="1"
    			                   pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>

                        <div class="input-field2">
                            <label for="">Orgão Emissor</label>
	                               <input type="text" name="orgaoEmissorMotorista" id="orgaoEmissorMotorista" class="form-control" size="10" 
    			                   pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
                        </div>

                        <div class="input-field2">
                            <label for="">Data de Expedição</label>
                            <input type="date" name="dataExpedicaoMotorista" id="dataExpedicaoMotorista" class="form-control" />
                        </div>
                        <div class="input-field2">
                            <label for="">Data de Vencimento</label>
                            <input type="date" name="dataVencimentoMotorista" id="dataVencimentoMotorista" class="form-control" />
                        </div>
                    </div>
                </div> 
                <div class="details family">
                    <span class="title">Titulo de Eleitor</span>

                    <div class="fields">
                        <div class="input-field">
                            <label for="">Número</label>
                            <input type="text" name="numeroEleitor"  id="numeroEleitor" class="form-control"  onkeypress="return onlynumber();" 
                                maxlength="10" minlength="1" /> 
                        </div>

                        <div class="input-field">
                            <label for="">Zona Eleitoral</label>
                            <input type="text" name="zonaEleitoral"  id="zonaEleitoral" class="form-control"  size="10" pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" 
                               maxlength="10" minlength="1" /> 
                        </div>

                        <div class="input-field">
                           <label for="">Seção</label>
                           <input type="text" name="SecaoEleitor"  id="SecaoEleitor" class="form-control"  size="10" pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);"
	                           maxlength="10" minlength="1" /> 
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="btn-prev">
                            <i class="uil uil-navigator"></i>
                            <span class="btnText">Anterior</span>
                        </div>
                        
                        <button class="sumbit">
                            <span class="btnText">Salvar</span>
                            <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                        
                        <button href="#" class="btn-next">
                        <span class="btnText">Próximo</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                    </div>
                </div> 
            </div>
            <div class="form-step">
    	       <div class="details family">
                    <span class="title">Dependente</span>
                    <div class="fields">
        	            <div class="input-field2">
    	                    <button type="button" class="btn btn-primary" id="addmorebtn" onclick="adicionarCampo()"> <i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i> Cadastrar novo Depedente</button>
    	                </div>
    	                <div class="input-field2">
                            <!--<input type="button" value="Excluir" class="btn btn-danger btn-remove" />-->
                           <button type="button" class="btn btn-remove"> <i class="fa-solid fa-trash-can" aria-hidden="true"></i>Excluir</button>
    	                </div>    
                    </div>
                    <div id="form-dependente">
    	                <fildset action="" class="fields">
	                        
	                        
	                        <div class="input-field">
	                            <label for="">N° do CPF</label>
	                           <input type="text" name="cpfDepedentes1"  id="cpfDepedentes1" class="form-control" maxlength="14" minlength="14" 
                 onkeypress="mascaraCpf(this, cpf)" 
                onblur="mascaraCpf(this, cpf)" /> 
	                        </div>
	                        
	                        <div class="input-field">
	                            <label for="">Nome</label>
	                            <input type="text" name="nomeDepedentes1" id="nomeDepedentes1" class="form-control" minlength="20" maxlength="150" 
    			 pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
	                        </div>
	                        
	                        <div class="input-field">
	                            <label for="">Data de Nascimento</label>
	                            <input type="date" name="dataNascimentoDepedentes1" id="dataNascimentoDepedentes1" class="form-control"/>
	                        </div>
	                        <div class="radio-field">
    	                        <span>Você possui alguma deficiencia</span><br>
                                 <input type="radio" id="sim" name="radio_depedente" class="radio" value="sim">
                                 <label for="">Sim</label><br>
                                 <input type="radio" id="nao" name="radio_depedente" class="radio" value="nao">
                                 <label for="">Não</label><br>
                            </div>
	                         <div class="input-field">
	                            <label for="">Local do Nascimento</label>
	                            <input type="text" name="localNascimentoDepedentes1" id="localNascimentoDepedentes1" class="form-control" minlength="10" maxlength="40" 
    			 pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" />
	                        </div>
	                        <div class="input-field">
	                            <label for="">Tipo de Depedencia</label>
	                            <input type="text" name="tipoDepedencia1" id="tipoDepedencia1" class="form-control" />
	                        </div>
	                        
	                        <div class="input-field2">
	                            <label for="">Matricula Cartório</label>
	                            <input type="text" name="matriculaCartorio1" id="matriculaCartorio1" class="form-control" onkeypress="return maskNumber(event);" />
	                        </div>
	                        <div class="input-field2">
	                            <label for="">Número Registro Cartório</label>
	                            <input type="text" name="registroCartorio1" id="registroCartorio1" class="form-control" onkeypress="return maskNumber(event);" />
	                        </div>
	                        <div class="input-field">
	                            <label for="">Número Livro</label>
	                            <input type="text" name="numeroLivro1" id="numeroLivro1" class="form-control" onkeypress="return maskNumber(event);" />
	                        </div>
	                        <div class="input-field">
	                            <label for="">Número Folha</label>
	                            <input type="text" name="numeroFolha1" id="numeroFolha1" class="form-control" onkeypress="return maskNumber(event);" />
	                        </div>
	                        <div class="input-field">
	                            <label for="">Número da D.N.V</label>
	                            <input type="text" name="numeroDNV1" id="numeroDNV1" class="form-control" onkeypress="return maskNumber(event);" />
	                        </div>
    	                </fildset>
                    </div>
                   <div class="buttons">
                        <div class="btn-prev">
                            <i class="uil uil-navigator"></i>
                            <span class="btnText">Anterior</span>
                        </div>
                        
                        <button class="sumbit">
                            <span class="btnText">Salvar</span>
                            <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                    </div>
	                        
        </div>
</div>
        </form>
    </div>
</main>