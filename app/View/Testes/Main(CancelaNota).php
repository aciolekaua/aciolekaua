<main class="my-2">
    <div class="container-fluid">
        <div id='mensage'></div>
        <div class='card'>
            <div class='card-header'>
                <span class='me-2'><i class="bi bi-receipt"></i></span>
                <span><b>Cancelamento de Notas</b></span>
            </div>
            <div class='card-body'>
                <form id='formCancelementoNota' action="" method='post' enctype="multipart/form-data">
                    <div class='row mb-2'>
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="PJ">Escolha a PJ*</label>
                            <select id="PJ" name="PJ" class='form-select' onchange='' required>
                                <option value="">Selecione uma opção</option>
                                <option value="03.902.161/0001-69">VMPE</option>
                                <option value="11.316.866/0001-22">PERNAMBUCONT</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="tpCodEvento">Tipo de Evento*</label>
                            <select id="tpCodEvento" name="tpCodEvento" class='form-select' onchange='' required>
                                <option value="">Selecione uma opção</option>
                                <option value=1>Erro na emissão</option>
                                <option value=2>Serviço não prestado</option>
                                <option value=4>Nota duplicada</option>
                            </select>
                        </div>
                    </div>
                    <div class='row mb-2'>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="numeroNFSe">Numero da NFS-e*</label>
                    		<input class="form-control" id="numeroNFSe" type="text" name="numeroNFSe" oninput="mask(this,numeroMask);" maxlength='20' placeholder="" required/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="numeroRPS">Numero do RPS*</label>
                    		<input class="form-control" id="numeroRPS" type="text" name="numeroRPS" oninput="mask(this,numeroMask);" maxlength='20' placeholder="" required/>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class='form-label' for="serieRPS">Série do RPS*</label>
                    		<input class="form-control" id="serieRPS" type="text" name="serieRPS" oninput="mask(this,numeroMask);" maxlength='20' placeholder="" required/>
                        </div>
                    </div>
                    <div class='row mb-3'>
                        <div class="form-group col-sm-12">
                            <label class='form-label' for="tpCodEvento">Motivo do cancelamento*</label>
                            <textarea class='form-control' name='motivoCencelamento' row='3' required></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <button class='btn btn-success' type='button' onclick='cancelarNota()'>Enviar</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</main>