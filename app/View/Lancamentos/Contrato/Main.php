<main class="mt-5 pt-3 mb-2">
    <div class="container-fluid">
        <div id='mensage'></div>
        <div class='card'>
            <div class='card-header'>
                <span class='me-2'><i class="bi bi-pen"></i></span>
                <span>Contrato</span>
            </div>
            <div class='card-body'>
                <form id='formContrado' action="<?php echo(DIRPAGE."lancamentos-contrato/salvar"); ?>" 
                class='p-3 m-3 bg-white' 
                method='post' enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label class='form-label' for="PJ">Escolha a PJ*</label>
                        <select id="PJ" name="PJ" class='dselect' required>
                            <option value="">Selecione uma opção</option>
                        </select>
                    </div>
                    
                    <fieldset id="FieldsetFormaDePagamento">
                         <div class="form-group">
                            <label class='form-label' for="FormaDePagamento">Escolha uma forma de pagamento *</label>
                            <select id="FormaDePagamento" class='dselect' name="FormaDePagamento" required>
                                <option value="">Selecione uma opção</option>
            				</select>
                        </div>
                    </fieldset>
                    
                    <div class='form-group'>
                        <label class='form-label'>Nova forma de pagamento</label>
                        
                        <div class="form-check">
                            <input class='form-check-input' type="radio" id='NovaConta1' name="NovaFormaDePagamento" value=false checked  />
                            <label class='form-check-label' for="NovaConta1">Não</label>
                        </div>
                        
                        <div class="form-check">
                            <input class='form-check-input' type="radio" id='NovaConta2' name="NovaFormaDePagamento" value=true />
                            <label class='form-check-label' for="NovaConta2">Sim</label>
                        </div>
                    </div>
                    
                    <fieldset id='FieldsetNovaFormaDePagamento' disabled>
                        <div class='form-group'>
                            <label class='form-label' for="TipoDePagamento">Tipo de pagamnto</label>
            				<select class="dselect" id="TipoDePagamento" name="TipoDePagamento">
            				    <option value=''>Selecione uma opção</option>
            				</select>
                        </div>
                        <fieldset id="FieldsetAgencia_Conta" disabled>
                             <div class='form-group'>
                                <label class='form-label' for="Agencia">Agência*</label>
                				<input class="form-control" id="Agencia" type="text" name="Agencia"/>
                            </div>
                            <div class='form-group'>
                                <label class='form-label' for="Conta">Conta*</label>
                				<input class="form-control" id='Conta' type="text" name="Conta"/>
                            </div>
                        </fieldset>
                    </fieldset>
                    
                    <div class='form-group'>
                        <label class='form-label' for="Historico">Beneficiário*</label>
                        <select class="dselect"  id="Historico" name="Beneficiario">
                            <option value=''>Selecione uma opção</option>
                        </select>
                    </div>
                    
                    <fieldset id='FieldsetDescricao' disabled>
                        <div class='form-group'>
            			    <label class='form-label' for="Descricao">Descreva*</label>
                			<input class="form-control"  id="Descricao" type="text" name="Descricao" placeholder="Descreva aqui" 
                			pattern="[a-z A-Z À-ú 0-9]{2,}" />
        			    </div>
                    </fieldset>
        			
        			<fieldset id='FieldsetComum'>
        			    <div class='form-group'>
        			        <label class='form-label' for='Nota'>Nº da Nota</label>
            			    <input class="form-control" id="Nota" type="text" name="Nota" placeholder="Digite o numero da nota"  maxlength="15"/>
        			    </div>
        			    <div class='form-group'>
        			        <label class='form-label' for="Valor">Valor*</label>
            			    <input 
            			    class="form-control"
            			    id="Valor"
            			    name="Valor" 
            			    type="text" 
            			    placeholder="Digite o valor"
            			    maxlength="18"
            			    size="18"
            			    oninput="mascaraDinheiro(this);"
            			    onkeypress="mascaraDinheiro(this);"
            			    autocomplete=off
            			    required/>
        			    </div>
        			    <div class='form-group'>
        			        <label class='form-label' for="Data">Data*</label>
            			    <input class="form-control"  id="Data" type="date" name="Data" required/>
        			    </div>
        			    <div class='form-group'>
                			<label class="formFile form-label" for="Comprovante">Anexar o documento(Imagem ou PDF)</label>
                			<input class="form-control" id="Comprovante" type="file" name="Comprovante" accept="image/jpeg, image/pnj, .pdf"/>
        			    </div>
        			</fieldset>
                    
                    <div class='form-group'>
                        <input type='button' class='btn btn-success mt-3' onclick='registro()' name="Submit" value="Salvar"/>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</main>