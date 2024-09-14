<main class="my-2">
    <div class="container-fluid">
        <div id='mensage'></div>
        <div class='card'>
            <div class='card-header'>
                <span class='me-2'><i class="bi bi-receipt"></i></span>
                <span><b>Calculo Aliquotas</b></span>
            </div>
            <div class='card-body'>
                <form id='formAliquota' action="" method='post' enctype="multipart/form-data">
                    <div class='row mb-2'>
                        <div class="form-group col-sm">
                            <label class='form-label' for="RBT12">RBT12*</label>
                    		<input class="form-control" id="RBT12" type="text" name="RBT12" oninput="mascaraDinheiro(this);" onkeypress="mascaraDinheiro(this);" maxlength='18' placeholder="" autocomplete=off required/>
                        </div>
                        
                        <div class="form-group col-sm">
                            <label class='form-label' for="anexo">Anexo*</label>
                            <input class="form-control" type='text' id='anexo' name='anexo' oninput="mask(this,numeroMask);" maxlength='1'/>
                        </div>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</main>