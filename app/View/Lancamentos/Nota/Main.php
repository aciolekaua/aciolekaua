<main class="mt-5 pt-3 mb-2">
    <div class="container-fluid">
        <div id='mensage'></div>
        <div class='card'>
            <div class='card-header'>
                <span class='me-2'><i class="bi bi-receipt"></i></span>
                <span>Nota</span>
            </div>
            <div class='card-body'>
                <form id='formNota' action="" 
                method='post' enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label class='form-label' for="PJ">Escolha a PJ*</label>
                        <select id="PJ" name="PJ" class='dselect' required>
                            <option value="">Selecione uma opção</option>
                        </select>
                    </div>
                    
        			<fieldset id='FieldsetComum'>
        			    <div class='form-group'>
        			        <label class='form-label' for="Prestador">Nome do Prestador*</label>
                			<input class="form-control" id="Prestador" type="text" name="Prestador" placeholder="Digite o nome do beneficiário" 
                			pattern="[a-z A-Z À-ú]{2,}" required/>
        			    </div>
        			    <div class='form-group'>
        			        <label class='form-label' for='Nota'>Nº da Nota*</label>
            			    <input class="form-control" id="Nota" type="text" name="Nota" placeholder="Digite o numero da nota"  maxlength="15" required/>
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
                        <input type='button' class='btn btn-success mt-3' onclick='registro();' name="Submit" value="Salvar"/>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</main>