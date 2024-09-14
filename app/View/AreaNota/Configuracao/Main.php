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
        
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-building-fill-gear me-2"></i>
                    Dados da Empresa
                </span>
                <div class="juntar">
                    <a  href="<?php echo(DIRPAGE."area-nota-nfse");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-file-break-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."area-nota-consulta");?>">
                        <div class="iconi">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class='container mt-4 testecard'>
                <form class='row' id='formCadastraPJ' action='' method='post' enctype="multipart/form-data">
                    <div class="col-lg-4 mb-3">
                        <label class='form-label text-matrix' for="IncentivadorCultural">Incentivador Cultural*</label>
                        <select class='form-select' id="IncentivadorCultural" name="IncentivadorCultural" required>
                            <option value="0">Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class='form-label text-matrix' for="CodigoCRT">Código CRT*</label>
                        <select class='form-select' id="CodigoCRT" name="CodigoCRT" required>
                            <option value="">Selecione uma opção</option>
                            <option value="1">Simples Nacional</option>
                            <option value="2">Simples Nacional (excesso de sublimite da receita bruta)</option>
                            <option value="3" disabled>Regime Normal</option>
                        </select>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class='form-label text-matrix' for="Regimento">Regimento*</label>
                        <select class='form-select' id="Regimento" name="Regimento" required>
                            <option value="">Selecione uma opção</option>
                            <option value="1">Simples Nacional</option>
                            <option value="2" disabled>Lucro Presumido</option>
                            <option value="3" disabled>Lucro Real</option>
                            <option value="4" disabled>MEI</option>
        				</select>
                    </div>
                     
                    <div class='col-lg-4 mb-3'>
                        <label class='form-label text-matrix' for="InscricaoEstadual">Inscrição Estadual*</label>
                    	<input class="form-control" id="InscricaoEstadual" type="text" name="InscricaoEstadual" maxlength='9' autocomplete='off'/>
                    </div>
                    <div class='col-lg-4 mb-3'>
                        <label class='form-label text-matrix' for="InscricaoMunicipal">Inscrição Municipal*</label>
                    	<input class="form-control" id="InscricaoMunicipal" type="text" name="InscricaoMunicipal" maxlength='11' autocomplete='off'/>
                    </div>
                    
                    <div class='col-sm-12 mb-3'>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="certificadoDigital" id="CD1" value="1" onclick='senhaCertificado(this);' checked/>
                          <label class="form-check-label text-matrix" for="CD1">Certificado A1</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="certificadoDigital" id="CD3" value="3" onclick='senhaCertificado(this);'/>
                          <label class="form-check-label text-matrix" for="CD3">Certificado A3</label>
                        </div>
                    </div>
                    
                    <div class='col-lg-6 mb-3'>
                        <label class='form-label text-matrix' for="arquivoCD">Arquivo PFX*</label>
                    	<input class="form-control" name="arquivoCD" id="arquivoCD" type="file" accept='.pfx'/>
                    </div>
                    
                    <div class='col-lg-6 mb-3'>
                        <label class='form-label text-matrix' for="SenhaCD">Senha*</label>
                    	<input class="form-control" id="SenhaCD" type="text" name="SenhaCD" autocomplete='off'/>
                    </div>
                    
                    <div class="col-sm-12 mt-3">
                        <button type='button' class='btn btn-orange' onclick='cadastrarPJ();'>Salvar</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!--<div class="teste">-->
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-list-ul me-2"></i>
                    Lista de Serviços
                </span>
                <div class="juntar">
                    <a  href="<?php echo(DIRPAGE."area-nota-nfse");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-file-break-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."area-nota-consulta");?>">
                        <div class="iconi">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class='container mt-4'>
                <form class='row' id='formCadastraServico' action='' method='post'>
                    <div class='col-sm-4 mb-2'>
    			        <label class='form-label testeLabel text-matrix' for="CodigoDeServico">Código de Servico*</label>
        			    <input class='form-control' placeholder='' id="CodigoDeServico" oninput='mask(this,listaServicoMask);' maxlength='5' type='text' name="CodigoDeServico" />
    			    </div>
        			
        			<div class='col-sm-8 mb-2'>
        			    <label class='form-label text-matrix' for="DescricaoServico">Descrição do Serviço*</label>
        			    <input class='form-control' placeholder='' type='text' name="DescricaoServico" />
        			</div>
        			<div class="col-sm-12 mt-3">
                        <button type='button' class='btn btn-orange' onclick='cadastrarServico();'>Salvar</button>
                    </div>
                </form>
                <div class='row mt-4'>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Descrição</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody id='tBodyServicos'>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-list-task me-2"></i>
                    Lista de Códigos Tributários do Município
                </span>
                <div class="juntar">
                    <a  href="<?php echo(DIRPAGE."area-nota-nfse");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-file-break-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."area-nota-consulta");?>">
                        <div class="iconi">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class='container mt-4'>
                <form class='row' id='formCadastraServico' action='' method='post'>
                    <div class='col-sm-4 mb-2'>
    			        <label class='form-label testeLabel text-matrix' for="CodigoDeServico">Código do Tributo*</label>
        			    <input class='form-control' placeholder='' id="CodTribMunicipio" maxlength='25' type='text' name="CodTribMunicipio" />
    			    </div>
        			
        			<div class='col-sm-8 mb-2'>
        			    <label class='form-label text-matrix' for="DescricaoServico">Descrição do Tributo*</label>
        			    <input class='form-control' placeholder='' type='text' name="DescCodTribMunicipio" />
        			</div>
        			<div class="col-sm-12 mt-3">
                        <button type='button' class='btn btn-orange' onclick=''>Salvar</button>
                    </div>
                </form>
                <div class='row mt-4'>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Descrição</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody id=''>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>-->
        
        
        <!--<div class='card mb-3'>
            <div class='card-header'>
                <span class='me-2'>
                    <i class="bi bi-file-earmark-check-fill me-2"></i>Certificado Digital
                </span>
            </div>
            <div class='card-body'>
                <form id='formRegistrarModulo' class='row' id='formCertificadoDigital' action='' method='post' enctype="multipart/form-data">
                    <div class='col-sm-12 mb-3'>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="certificadoDigital" id="CD1" value="1" onclick='senhaCertificado(this);' checked/>
                          <label class="form-check-label" for="CD1">Certificado A1</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="certificadoDigital" id="CD3" value="3" onclick='senhaCertificado(this);'/>
                          <label class="form-check-label" for="CD3">Certificado A3</label>
                        </div>
                    </div>
                    
                    <div class='col-lg-6 mb-3'>
                        <label class='form-label' for="arquivoCD">Arquivo PFX*</label>
                    	<input class="form-control" name="arquivoCD" id="arquivoCD" type="file" accept='.pfx'/>
                    </div>
                    
                    <div class='col-lg-6 mb-3'>
                        <label class='form-label' for="SenhaCD">Senha*</label>
                    	<input class="form-control" id="SenhaCD" type="text" name="SenhaCD"/>
                    </div>
                    
                    <div class="col-12 mt-3">
                        <button type='button' class='btn btn-primary' onclick='registrarCeretificadoDigital();'>Salvar</button>
                    </div>
                </form>
            </div>
        </div>-->
    </div>
</main>
    