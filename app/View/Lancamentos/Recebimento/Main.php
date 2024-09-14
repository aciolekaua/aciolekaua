<div class='position-fixed' style="z-index:1" id='mensage'></div>
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
        <!--<a href="<?php //echo(DIRPAGE."tabelas-recebimento"); ?>" class="btn btn-orange mb-3">Lista</a>-->
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-cash-stack"></i>
                    Lançar Recebimento
                </span>
                <div class="juntar">
                    
                    <a href="<?php echo(DIRPAGE."tabelas-recebimento");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-table"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."configuracao-lancamento");?>">
                        <div class="iconi">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                    </a>
                    
                </div>
            </div>
            <div class='container mt-4'>
                <form id='formRecebimento' action="" method='post' enctype="multipart/form-data">
                    <div class='row'>
                        <div class="form-group col-md-4 mb-3">
                            <label class='form-label' for="PJ">Escolha a PJ*</label>
                            <select class='form-select' id="PJ" name="PJ" required>
                                <option value="">Selecione uma opção</option>
                            </select>
                        </div>
                        
                        <fieldset class='col-md-4 mb-3' id="FieldsetFormaDeRecebimento">
                             <div class="form-group">
                                <label class='form-label' for="FormaDeRecebimento">Escolha uma forma de recebimento *</label>
                                <select class='form-select' id="FormaDeRecebimento" name="FormaDeRecebimento" required>
                                    <option value="">Selecione uma opção</option>
                				</select>
                            </div>
                        </fieldset>
                    <div class='col-md-4 mb-1'>
                        <div class='col-12'>
                            <label class='form-label'>Nova forma de recebimento</label>
                        </div>
                        
                        <div class='col-12 mt-2'>
                            <div class="form-check form-check-inline">
                                <input class='form-check-input' type="radio" id='NovaConta1' name="NovaFormaDeRecebimento" value=false checked  />
                                <label class='form-check-label' for="NovaConta1">Não</label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                                <input class='form-check-input' type="radio" id='NovaConta2' name="NovaFormaDeRecebimento" value=true />
                                <label class='form-check-label' for="NovaConta2">Sim</label>
                            </div>
                        </div>
                        
                    </div>
                    </div>
                    
                    
                    
                    <fieldset class='row mb-1' id='FieldsetNovaFormaDeRecebimento' disabled>
                        <div class='col-sm-6 mb-1'>
                            <label class='form-label' for="TipoDeRecebimento">Tipo de recebimento*</label>
            				<select class='form-select' id="TipoDeRecebimento" name="TipoDeRecebimento">
            				    <option value=''>Selecione uma opção</option>
            				</select>
                        </div>
                        <fieldset class='col-sm-6' id="FieldsetAgencia_Conta" disabled>
                            <div class='row'>
                                <div class='form-group col-sm-6 mb-1'>
                                    <label class='form-label' for="Agencia">Agência*</label>
                    				<input class="form-control" id="Agencia" type="text" name="Agencia"/>
                                </div>
                                <div class='form-group col-sm-6 mb-1'>
                                    <label class='form-label' for="Conta">Conta*</label>
                    				<input class="form-control" id='Conta' type="text" name="Conta"/>
                                </div>
                            </div>
                        </fieldset>
                    </fieldset>
                    
                    <div class='row'>
                        <!-- <div class='form-group col-sm-6 mb-1'>
                            <label class='form-label' for="Historico">Descrição do recebimento*</label>
                            <select class='form-select'  id="Historico" name="Historico">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div> -->

                        <div class='col-sm-6'>
                            <label class='form-label text-matrix' for="Grupo">Grupo*</label>
                            <select class='form-select' id="Grupo" name="Grupo">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div>
                        <div class='col-sm-6'>
                            <label class='form-label text-matrix' for="SubGrupo">Sub Grupo*</label>
                            <select class='form-select' id="SubGrupo" name="SubGrupo">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div>
                        
                        <div class='col-sm-12 mb-1'>
                			    <label class='form-label text-matrix' for="Descricao">Descreva*</label>
                    			<textarea class="form-control" id="Descricao" name="Descricao" placeholder="Descreva aqui" rows="5" style="height:74px"></textarea>
            			</div>
                    </div>
        		
        			<fieldset id='FieldsetComum'>
        			    <div class='row'>
        			        <div class='form-group col-sm-6 mb-1'>
            			        <label class='form-label' for="">Nome (Cliente, Ofertante, etc)*</label>
                    			<input class="form-control" id="Ofertante" type="text" name="Ofertante" placeholder="Digite o nome" 
                    			pattern="[a-z A-Z À-ú]{2,}"/>
            			    </div>
            	
            			    <div class='form-group col-sm-6 mb-1'>
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
        			    </div>
        			    
        			    <div class='row'>
        			        <div class='form-group col-sm-6 mb-1'>
            			        <label class='form-label' for="Data">Data de Competência*</label>
                			    <input class="form-control"  id="Data" type="date" name="Data" required/>
            			    </div>
            			    
            			    <div class='form-group col-sm-6 mb-1'>
                    			<label class="formFile form-label" for="Comprovante">Anexar o documento(Imagem ou PDF)</label>
                    			<input class="form-control" id="Comprovante" type="file" name="Comprovante[]" accept=".jpeg, .png, .jpg, .pdf" multiple/>
            			    </div>
        			    </div>
        			    
        			    
        			</fieldset>
                    
                    <div class='form-group'>
                        <input type='button' class='btn btn-orange mt-3' onclick='registro();' name="Submit" value="Salvar"/>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</main>
