<div id='msgTeste'></div>
<div id="page" class="site">
        <div class="container">
            <div class="form-box">
                <div class="progresso">
                    <div class="logo"><a href="/"><span>i</span>vici</a></div>
                        <ul class="progresso-steps">
                            <li class="step active">
                                <span>1</span>
                                <p>Cadastro de Empresa<br></p>
                            </li>
                            <li class="step">
                                <span>2</span>
                                <p>Certificado<br></p>
                            </li>
                            <!--<li class="step">
                                <span>3</span>
                                <p>Caixa de Email<br></p>
                            </li>
                            <li class="step">
                                <span>4</span>
                                <p>Usuários<br></p>
                            </li>
                            <li class="step">
                                <span>3</span>
                                <p>Módulos NFs-e<br></p>
                            </li>-->
                            <li class="step">
                                <span>3</span>
                                <p>Módulos de Emissão<br></p>
                            </li>
                        </ul> 
                </div>
                <?php //echo(DIRPAGE."teste/cadastroempresaapi")?>
                <form id='formCadastro' active="" action='' method='post' enctype="multipart/form-data">
                    <div class="form-one form-step active">
                        <div class="bg-svg"></div>
                        
                        <h2>Informações da Empresa</h2>
                        <p>Insira suas informações corretamente</p>
                        
                        <div>
                            <label>CNPJ</label>
                            <input name="CNPJ" id="CNPJ" type="text" data-mask="00.000.000/0000-00" onblur="checkCNPJ(this.value)"  required/>
                            <span class="focus-input-form" data-placeholder="CNPJ" placeholder='xx.xxx.xxx/xxxx-xx'></span>
                        </div>
                        <div>
                            <label>Razão Social</label>
                            <input name='RazaoSocial' id="nome" type="text" onblur="mascaraNome" required/>
                        </div>
                        <div>
                            <label>Apelido</label>
                            <input name='Apelido' type="text" id="Apelido" onblur="mascaraNome" required/>
                        </div>
                        <div>
                            <label>Nome Fantazia</label>
                            <input name='NomeFantazia' type="text" id="NomeFantazia" onblur="mascaraNome" required/>
                        </div>
                        <div>
                            <label>Email</label> 
                            <input name='Email' id="email" type="email" maxlength="60" placeholder="Ex: exemplo@gmail.com"
                			pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required/>
                        </div>
                        <div>
                            <label>Telefone</label>
                        	<input name='Tel' id="Tel" type="tel" minlength="13" maxlength="15" 
                            placeholder="Ex: (xx) x-xxxx-xxxx" onkeypress="mascaraTel(this, tel)" 
                            onblur="mascaraTel(this, tel)" required/>
                        </div>
                        <div>
                            <label>Cep</label>
                            <input name='Cep' id="Cep" type="text" class="mascCEP" 
                            value="" size="11" maxlength="10" placeholder='xx.xxx-xxx' required/>
                        </div>
                        <div>
                            <label>Endereco</label>
                            <input name='Endereco' id="Endereco" placeholder='Ex: Rua Firmino Oliveira' type="text" size="60" required/>
                        </div>
                        <div>
                            <label>Tipo do endereço</label>
                            <input name='TipoEndereco' id="TipoEndereco" type="text" size="60" placeholder='EX: Avenida, Rua, Travessa, etc.' required/>
                        </div>
                        <div>
                            <label>Numero</label>
                            <input name="Numero" id="Numero" type="text" size="60" placeholder='Ex: 62' required/>
                        </div>
                        <div>    
                            <label>Complemento</label>
                            <input name='Complemento' id="Complemento" type="text" size="40" placeholder='Ex: Lote 2B' required/>
                        </div>
                        <div>    
                            <label>Bairro</label>
                            <input name="Bairro" id="Bairro" type="text" size="40" placeholder='Ex: Casa Forte' required/>
                        </div>
                        <div>
                            <label>Cidade</label>
                            <input name="Cidade" id="Cidade" type="text" size="40" placeholder='Ex: Paulista' required />
                        </div>
                        <div>
                            <label>UF</label>
                            <input name="Uf" id="Uf" type="text" size="2" placeholder='Ex: PE' required/>
                        </div>
                        <div>
                            <label>Filial</label>
                            <select name='filial' required>
                                <option value='n'>NÃO</option>
                                <option value='s'>SIM</option>
                            </select>
                        </div>
                        <div>
                            <label>CNAE</label>
                            <input type='text' name='cnaeText' required/>
                            <input type='hidden' name='cnaeCode' minlength='7' maxlength='7' required/>
                            <!--<input type='text' name='cnae' minlength='7' maxlength='7'/>-->
                        </div>
                        <div>
                            <label>Matriz</label>
                            <input type="text" name="Matriz" id="Matriz" data-mask="00.000.000/0000-00" onblur="checkCNPJMatriz(this)" placeholder='xx.xxx.xxx/xxxx-xx'/>
                        </div>
                        <div>
                            <label>Inscrição Estadual</label>
                            <input type="text" name="InscricaoEstadual" id="InscricaoEstadual" data-mask="0000000-00" placeholder='xxxxxxx-xx' minlength='10' maxlength='10'/>
                        </div>
                        <div>
                            <label>Inscrição Municipal</label>
                            <input type="text" name="InscricaoMunicipal" id="InscricaoMunicipal"   minlength='7' maxlength='10'/>
                        </div>
                        <div>
                            <label>CRT</label>
                            <select type="text" name="CRT" id="CRT" required>
                                <option value='SN'>Simples Nacional</option>
                                <option value='RN'>Regime Nacional</option>
                            </select>
                        </div>
                        <div>
                            <label>Você ultrapassou o limete do simples?</label>
                            <select type="text" name="CRT" id="CRT" required>
                                <option value='N'>NÃO</option>
                                <option value='S'>SIM</option>
                            </select>
                        </div>
                        <!--<div>
                            <label>Grupo de Empresas</label>
                            <input type='text' name='ge'/>
                        </div>-->
                            <!--<div class="birth">-->
                            <!--    <label>date of birth</label>-->
                            <!--    <div class="grouping">-->
                            <!--        <input type="text" patter="[0-9]*" name="day" velue="" min="0" max="31" placeholder="DD">-->
                            <!--        <input type="text" patter="[0-9]*" name="month" velue="" min="0" max="12" placeholder="MM">-->
                            <!--        <input type="text" patter="[0-9]*" name="year" velue="" min="0" max="2050" placeholder="YYYY">-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        <div class="form-two form-step">
                            <div class="bg-svg"></div>
                            <h2>Certificado</h2>
                            <!--<div id='certificado'>
                                <div>
                                    <input type='radio' name='certificado'/>
                                    <label>Cadastrar novo certificado</label> 
                                </div>
                                <div>
                                    <input type='radio' name='certificado'/>
                                    <label>Usar certificado de matirz</label>
                                </div>
                                <div>
                                    <input type='radio' name='certificado'/>
                                    <label>Usar certificado já cadastrado</label>   
                                </div>
                            </div>-->
                            <div id='tipoCertificado'>
                                <div>
                                    <input type='radio' name='TipoCertificado' value='1' onclick='certificadoA1()'/>
                                    <label>Certificado A1</label> 
                                </div>
                                <div>
                                    <input type='radio' name='TipoCertificado' value='3' onclick='certificadoA3()'/>
                                    <label>Certificado A3</label>
                                </div>
                            </div>
                            <div>
                                <label>Apelido</label>
                                <input type="text" name='ApelidoGE' />
                            </div>
                            <div id='divA1'>
                                <div>
                                    <label>Senha</label>
                                    <input type="text" name='Senha' />
                                </div>
                            </div>
                                <div>
                                    <label>Arquivo PFX</label>
                                    <input name="arqCertificado" id="arqCertificado" type="file" accept='.pfx'/>
                                </div>
                           
                        </div>
                        <!--<div class="form-four form-step">
                            <div class="bg-svg"></div>
                            <h2>Caixa de Email</h2>
                            <p>Insira suas informações pessoais corretamente</p>
                            <div>
                                <label>Apelido</label>
                                <input type="text" name="ApelidoCE"/>
                            </div>
                            <div>
                                <label>Nome remetente</label>
                                <input type="text" name="nomeRemetente" minlength="20" maxlength="150" pattern="[a-z A-Z À-ú]{2,}" />
                            </div>
                            <div>
                                <label>E-mail remetente</label>
                                <input type="text" name='emailRemetente'/>
                            </div>
                            <div>
                                <label>Usuário*</label>
                                <input name="UsuárioCE" type="text" required/>
                            </div>
                            <div>
                                <label>Senha</label>
                                <input name="SenhaCE" type="text"/>
                            </div>
                        </div>
                        <div class="form-five form-step">
                            <div class="bg-svg"></div>
                            <h2>Usuários</h2>
                            <div>
                                <button type='button' >Novo Usuário</button>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox"> 
                                <label>Receba nossa notificações e ofertas especiais</label>
                            </div>
                        </div>-
                        <div class="form-six form-step">
                            <div class="bg-svg"></div>
                            
                        </div>-->
                    <div class="form-three form-step">
                        <div class="bg-svg"></div>
                        <h2>Módulos de Emissão</h2>
                        <div class='modulo'>
                            <label><input type="checkbox" name="ModuloNFSe"> NFSe</label>
                        </div>
                        <div class='modulo'>
                            <label><input type="checkbox" name="ModuloNFe"> NFe</label>
                        </div>
                        <div class='modulo'>
                            
                            <label><input type="checkbox" name="ModuloMDFe"> MDFe</label>
                        </div>
                        <div class='modulo'>
                            <label><input type="checkbox" name="ModuloNFCe"> NFCe</label>
                        </div>
                        <div class='modulo'>
                            <label><input type="checkbox" name="ModuloCTe"> CTe</label>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn-prev" disabled>Voltar</button>
                        <button type="button" class="btn-next">Proxímo</button>
                        <button type="button" onclick='cadastro(); spinnerStart();' class="btn-submit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    