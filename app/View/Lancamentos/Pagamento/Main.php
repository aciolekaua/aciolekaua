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
        <!--<a href="<?php //echo(DIRPAGE."tabelas-pagamento"); ?>" class="btn btn-orange mb-3">Lista</a>-->
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-credit-card-fill"></i>
                    Lançar Pagamento
                </span>
                <div class="juntar">
                    
                    <a href="<?php echo(DIRPAGE."tabelas-pagamento"); ?>" class="me-3">
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
                <form id='formPagamento' action="" class='' method='post' enctype="multipart/form-data">
                    <div class='row mb-1'>
                        <div class="col-md-4 mb-1">
                            <label class='form-label text-matrix' for="PJ">Escolha a PJ*</label>
                            <select class='form-select' id="PJ" name="PJ" required>
                                <option value="">Selecione uma opção</option>
                            </select>
                        </div>
                        <!--<div class="col-md-12 mb-3">-->
                        <!--    <div class="form__group field">-->
                        <!--        <input required="" placeholder="Name" class="form__field" type="input">-->
                        <!--        <label class="form__label" for="name">Ask Ptah</label>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <fieldset class='col-md-4 mb-1' id="FieldsetFormaDePagamento">
                            <div class="form-group">
                                <label class='form-label text-matrix' for="FormaDePagamento">Escolha uma forma de pagamento *</label>
                                <select class='form-select' id="FormaDePagamento" name="FormaDePagamento" required>
                                    <option value="">Selecione uma opção</option>
                				</select>
                            </div>
                        </fieldset>
                    <div class='col-md-4 mb-1'>
                        <div class='col-12'>
                            <label class='form-label text-matrix'>Nova forma de pagamento</label>
                        </div>
                        
                        <div class='col-12 mt-2'>
                            <div class="form-check form-check-inline">
                                <input class='form-check-input' type="radio" id='NovaConta1' name="NovaFormaDePagamento" value=false checked />
                                <label class='form-check-label text-matrix ' for="NovaConta1">Não</label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                                <input class='form-check-input' type="radio" id='NovaConta2' name="NovaFormaDePagamento" value=true />
                                <label class='form-check-label text-matrix' for="NovaConta2">Sim</label>
                            </div>
                        </div>
                    </div>

                    </div>
                    
                    <fieldset class='row mb-1' id='FieldsetNovaFormaDePagamento' disabled>
                        <div class='col-sm-6'>
                            <label class='form-label text-matrix' for="TipoDePagamento">Tipo de pagamento</label>
            				<select class='form-control' id="TipoDePagamento" name="TipoDePagamento">
            				    <option value=''>Selecione uma opção</option>
            				</select>
                        </div>
                        <fieldset class='col-sm-6' id="FieldsetAgencia_Conta" disabled>
                            
                            <div class='row'>
                                <div class='col-sm-6'>
                                    <!--<div class="form__group field">-->
                                    <label class='form-label text-matrix' for="Agencia">Agência*</label>
                    				<input class="form-control " id="Agencia" type="input" name="Agencia"/>
                                    <!--</div>-->
                                </div>
                                <div class='col-sm-6'>
                                    <!--<div class="form__group field">-->
                                    <label class='form-label text-matrix' for="Conta">Conta*</label>
                    				<input class="form-control" id='Conta' type="text" name="Conta"/>
                                    <!--</div>-->
                                </div>
                            </div>
                            
                        </fieldset>
                    </fieldset>
                    
                    <div class='row mb-1'>
                        <!-- <div class='col-sm-6'>
                            <label class='form-label text-matrix' for="Historico">Descrição do Pagamento*</label>
                            <select class='form-select' id="Historico" name="Historico">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div> -->

                        <div class='col-sm-6 mb-1'>
                            <label class='form-label text-matrix' for="Grupo">Grupo*</label>
                            <select class='form-select' id="Grupo" name="Grupo">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div>
                        <div class='col-sm-6 mb-1'>
                            <label class='form-label text-matrix' for="SubGrupo">Sub Grupo*</label>
                            <select class='form-select' id="SubGrupo" name="SubGrupo">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div>
                        <div class='col-sm-12 mb-1'>
                			    <label class='form-label text-matrix' for="Descricao">Descreva*</label>
                    			<textarea class="form-control" id="Descricao" name="Descricao" placeholder="Descreva aqui" rows="5" style="height:72px"></textarea>
            			</div>
                    </div>
                    
        			
        			<div class='row'>
        			    
        			    <div class="col-md-4 mt-1">
            			    <div class='col-12'><label class='form-label text-matrix'>QRCODE</label></div>
            			    <div class='col-12'>
            			        <div class="form-check form-check-inline">
                			        <input class='form-check-input' type="radio" id='QRCodeN' name="QRCodeRadio" value=false checked />
                                    <label class='form-check-label text-matrix' for="QRCode">Não</label>
                			    </div>
                			    <div class="form-check form-check-inline">
                			        <input class='form-check-input' type="radio" id='QRCodeS' name="QRCodeRadio" value=true />
                                    <label class='form-check-label text-matrix' for="QRCodeS">Sim</label>
                			    </div>
            			    </div>
        			    </div>
                        <fieldset class="col-md-6 mb-2" id='FieldsetQRCode' disabled>
                            <div class='row justify-content-around'>
                                <div class='col-sm-3 mb-3 mt-3'>
                                    <!--<label class='form-label'>QRCODE</label>-->
                                    <button id='btnQRCode' type="button" class="btn btn-orange m-0" onclick='startQRCODE();' data-bs-toggle="modal" data-bs-target="#qrcode">
                                    <span class="text-matrix">QRCode</span>
                                    </button>
                                </div>
                                <div class='col-md-9 mb-3 mt-3'>
                                    <!--<label class='form-label' for='QRCodeLink'>Cole o QRCode aqui</label>-->
                                    <input 
                                        class="form-control" type="text" 
                                        id="QRCodeLink" name="QRCodeLink" 
                                        placeholder="Cole o link aqui" 
                                        minlength='144' maxlength='144' size='144' 
                                        autocomplete='off'
                                    />
                                </div>
                            </div>
                            <div class='form-group'>
                                <!--QRCODE-->
                                
                                <input type='hidden' name='QRCodeURL'/>
                                <p id='avisoQRCodeURL'></p>
                            </div>
                            
                        </fieldset>

                        <div class="col-sm-2 mb-3">
                            <div class=''><label class='form-label text-matrix'>Parcelado?</label></div>
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-check-input" type="radio" name="parcelasCheckBox" id="parcelasCheckBox1" value=0 checked/>
                                    <label class="form-check-label" for="parcelasCheckBox1">Não</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-check-input" type="radio" name="parcelasCheckBox" id="parcelasCheckBox2" value=1 />
                                    <label class="form-check-label" for="parcelasCheckBox2">Sim</label>
                                </div>
                            </div>
                        </div>
        			    
        			</div>
        			
        			
        			<fieldset class='row' id='FieldsetComum'>
        			    <div class='form-group col-sm-4 mb-2'>
        			        <label class='form-label text-matrix' for="">Nome do Beneficiário*</label>
                			<input class="form-control" id="Beneficiario" type="text" name="Beneficiario" placeholder="Digite o nome do beneficiário" 
                			pattern="[a-z A-Z À-ú]{2,}"/>
        			    </div>
        			    <div class='form-group col-sm-4 mb-2'>
        			        <label class='form-label text-matrix' for='Nota'>Nº da Nota</label>
            			    <input class="form-control" id="Nota" type="text" name="Nota" placeholder="Digite o numero da nota"  maxlength="15"/>
        			    </div>
        			    <div class='form-group col-sm-4 mb-2'>
        			        <label class='form-label text-matrix' for="Data">Data de Competência*</label>
            			    <input class="form-control" id="Data" type="date" name="Data" required/>
        			    </div>
        			    <div class='form-group col-sm-6 mb-2'>
        			        <label class='form-label text-matrix' for="Valor">Valor*</label>
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
        			    <div class='form-group col mb-2'>
                			<label class="formFile form-label text-matrix" for="Comprovante">Anexar o documento(Imagem ou PDF)</label>
                			<input class="form-control" id="Comprovante" type="file" name="Comprovante[]" accept=".jpeg, .png, .pdf, .jpg" multiple="multiple"/>
        			    </div>
        			</fieldset>
                    
                    <div class='form-group'>
                        <input type='button' class='btn btn-orange mt-3' name="Submit" value="Salvar" onclick='registro();dados();'/>
                    </div>
                </form>
            </div>
            
        </div>

        <div class="modal" id='qrcode' tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button id='btnCloseModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="qr-reader"></div>
                        <div id="qr-reader-results"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>