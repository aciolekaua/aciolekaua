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
        
        <div id='menssage'></div>
        
        <div class='transactionBoxi'>
            <div class='main-texti'>
                <span class='text-matrix me-2'>
                    <i class="bi bi-receipt"></i>
                    Emissão de NFS-e
                </span>
                <div class="juntar">
                    
                    <a href="<?php echo(DIRPAGE."area-nota-consulta");?>" class="me-3">
                        <div class="iconi">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </a>
                    <a href="<?php echo(DIRPAGE."area-nota-configuracao");?>">
                        <div class="iconi">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                    </a>
                    
                </div>
            </div>
            <div class='container mt-4'>
                
                <form id='formEmitirNota' action="" method='post' enctype="multipart/form-data">
                    
                    <div class='row mb-2'>
                        <div class="col-6 mb-2">
                            <label class='form-label text-matrix' for="PJ">Escolha a PJ*</label>
                            <select id="PJ" name="PJ" class='form-select' onchange='getAtividade(this.value);getNaturezaOperacao(this.value);getServico(this.value);getNotasClonadas(this.value);getUltimaSerie(this.value);' required>
                                <option value="">Selecione uma opção</option>
                            </select>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <label class='form-label text-matrix' for="atividade">Atividade*</label>
                            <select id="atividade" name="atividade" class='form-select' required>
                                <option value="">Selecione uma opção</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class='row mb-2'>
                        
                        <div class="form-group col-sm-6 mb-2">
                            <label class='form-label text-matrix' for="naturezaOperacao">Natureza da Operação*</label>
                            <select class="form-select" id="naturezaOperacao" name="naturezaOperacao">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-sm-6 mb-2">
                            <fieldset class='' id="selectServicoFieldset">
                                <label class='form-label text-matrix' for="servico">Serviço*</label>
                                <select class="form-select" id="selectServico" name="codServico">
                                    <option value=''>Selecione uma opção</option>
                                </select>
                            </fieldset>
                        </div>
                        
                    </div>
                    
                    <div class='row mb-2'>
                        
        			    <div class='form-group col-sm-4 mb-2'>
        			        <label class='form-label text-matrix' for="Data de Emissão do RPS">Data da Competência*</label>
        			        <input class='form-control' type='date' name="dataCompetencia" />
        			    </div>
        			    
        			    <div class='form-group col-sm-4 mb-2'>
        			        <label class='form-label text-matrix' for="N° do RPS">N° do RPS*</label>
        			        <input class='form-control' type='text' name="NdoRPS" />
        			    </div>
        			    
        			    <div class='form-group col-sm-4 mb-2'>
        			        <label class='form-label text-matrix' for="Série do RPS">Série do RPS*</label>
        			        <input class='form-control' type='text' name="SerieDoRPS" />
        			    </div>
        			    
        			    <div class='form-group col-sm-12 mb-2'>
            			    <label class='form-label text-matrix' for="Descriminação dos serviços">Descriminação dos serviços*</label>
            			    <textarea class="form-control" type='text' name="DescriminacaoDosServicos" rows="3"></textarea>
            			</div>
        			    
        			</div>
        			
        			<div class='row mb-2'>
        			    
        			    <legend class='form-label text-matrix' for="Descriminação dos serviços">Dados do Tomador</legend>
        			    
        			    <div class='form-group col-md-5 mb-2'>
        			        <label class='form-label text-matrix' for="CpfCnpjTomador">CPF/CNPJ do Tomador*</label>
                			<input class="form-control" id="CpfCnpjTomador" type="text" name="CpfCnpjTomador" oninput="mask(this,cpfCnpjMask);" onblur='buscaCNPJ(this);' maxlength='18' placeholder="" required/>
        			    </div>
        			    
        			    <div class='form-group col-md-4 mb-2'>
        			        <label class='form-label text-matrix' for="nomeTomador">Nome Tomador*</label>
                			<input class="form-control" id="nomeTomador" type="text" name="nomeTomador" oninput="" maxlength='50' placeholder="" required/>
        			    </div>
        			    
        			    <div class='form-group col-md-3 mb-2'>
        			        <label class='form-label text-matrix' for="cepTomador">CEP*</label>
                			<input class="form-control" id="cepTomador" type="text" name="cepTomador" oninput="mask(this,cepMask);" maxlength='9' placeholder="" required/>
        			    </div>
        			    
        			</div>
        
        			<div class='row mb-2'>
                        <legend class='form-label text-matrix'>Valores da Nota</legend> 
        			    <div class='form-group col-md-8 mb-2'>
    			            <label class='form-label text-matrix' for="Valor total dos Serviços">Valor total do Serviço(R$)*</label>
    			            <input class="form-control" type='text' name="ValorTotalDosServicos"
    			            maxlength="18" size="18"
    			            oninput="mascaraDinheiro(this);"
    			            onkeypress="mascaraDinheiro(this);"
    			            autocomplete=off />
        			    </div>
        			    <div class='col-md-4 mb-2'>
		                    <label class='form-label text-matrix' for="ISSPercentual">ISS(%)*</label>
		                    <input class='form-control' type='text' name="ISSPercentual"
			                maxlength="5" size="5" value='5' oninput="percentualDecimal(this,ISSDecimal);" onblur='this.value=5;'
    			            autocomplete=off style='pointer-events:none;opacity:0.45;'/>
		                </div>

            		</div>

        			<div class="form-group mb-2">
        			    
        			    <legend class="text-matrix">Parcelas</legend>
        			    
        			    <div class='row'>
        			        <div class='col-lg-1 mb-2'>
        			            <input class="form-check-input"  type="radio" name="Parcela" value="s" id="parcelasim"/><span class="text-matrix">Sim</span>
        			        </div>
        			        <div class='col-lg-1 mb-2'>
        			            <input class="form-check-input" type="radio" name="Parcela" value="n" id="parcelanao" checked /><span class="text-matrix">Não</span>
        			        </div>
            			    
        			    </div>
        			    
            			
            			<fieldset class='row' id="parcelas" disabled>
            			    <div class='col-sm-6 mb-2'>
                			    <label class='form-label text-matrix' for="forma Pagamento">Forma de Pagamento</label>
                			    <select class='form-select' name="FormaDePagamento">
                			        <option value=''>Selecione uma opção</option>
                			        <option value="1">Data Certa</option>
                			        <option value="2">Apresentação</option>
                			        <option value="3">Á Vista</option>
                			        <option value="4">Outros</option>
                			        <option value="5">A Prazo</option>
                			        <option value="6">Cartão de Credito</option>
                			        <option value="7">Cartão de Débito</option>
                			    </select>
                			</div>    
                			
            			    <div class='col-sm-6 mb-2'>
            			        <label class='form-label text-matrix' for="qtd parcelas">Quantas Parcelas?</label>
                			    <input class='form-control' type='text' name="QuantasParcelas" />
            			    </div>
                			   
                			<div class='col-sm-6 mb-2'>
                			    <label class='form-label text-matrix' for="valor Parcela">Valor da Parcela (R$)</label>
                			    <input class='form-control' type='text' name="ValorDaParcela" 
                			    maxlength="18" size="18"
        			            oninput="mascaraDinheiro(this);"
        			            onkeypress="mascaraDinheiro(this);"
        			            autocomplete=off />
                			</div>
                			    
                			<div class='col-sm-6 mb-2'>
                			    <label class='form-label text-matrix' for="N° fatura">Numero da Fatura</label>
                			    <input class='form-control' type='text'name="NumeroDaFatura" />
                			</div> 
            			</fieldset>
        			</div>
        			
                    <div class='form-group my-3'>
                        <button type='button' class='btn btn-orange' onclick='escreverNota();' data-bs-toggle="modal" data-bs-target="#emitirNotaModal">
                            Emitir
                        </button>
                    </div>
                
                </form>
                
            </div>
        </div>
        
        <div class="modal fade" id="emitirNotaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        
                        <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                        <h5 class="modal-title" >Emitir nota?</h5>
                        <button type='button' class='btn btn-danger' onclick='printPHP(divPrintNota);'>PDF</button>
                    </div>
                    <div class="modal-body">
                        
                        
                        <div id='divPrintNota' class="container-fluid border">
                            <div class='row border pt-2'>
                                <div class='col-12 mb-2 text-center'><h3><u class="text-decoration-underline">Prestador do Seviço</u></h3></div>
                                <div class='col-lg-5 mb-2'>CPF/CNPJ: <span id='cpfCnpjPrestadorSpan'></span></div>
                                <div class='col-lg-7 mb-2'>Nome/Razão Social: <span id='nomePrestadorSpan'></span></div>
                            </div>
                            
                            <div class='row border pt-2'>
                                <div class='col-12 mb-2 text-center'><h3><u class="text-decoration-underline">Tomador do Seviço</u></h3></div>
                                <div class='col-lg-5 mb-2'>CPF/CNPJ: <span id='cpfCnpjTomadorSpan'></span></div>
                                <div class='col-lg-7 mb-2'>Nome/Razão Social: <span id='nomeTomadorSpan'></span></div>
                            </div>
                            
                            <div class='row border pt-2'>
                                <div class='col-12 mb-2 text-center'><h3><u class="text-decoration-underline">Valor do Seviço</u></h3></div>
                                <div class='col-12 mb-2'>Valor: <span id='valorSpan'></span></div>
                            </div>

                            <div class='row border pt-2'>
                                <div class='col-12 mb-2 text-center'><h3><u class="text-decoration-underline">Informações do Seviço</u></h3></div>
                                <div class='col-12 mb-2'>Atividade: <span id='atividadeSpan'></span></div>
                                <!--<div class='col-12 mb-2'>Cod. Trib. Municipal: <span id='codTribMunicipalSpan'></span></div>-->
                                <div class='col-12 mb-2'>CNAE: <span id='cnaeSpan'></span></div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-orange" onclick='EmitirNotas();' data-bs-dismiss="modal">Confirmar</button>
                        <button type="button" class="btn btn-orange" onclick="PagarNota();" data-bs-dismiss="modal">Pagar Nota?</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!--<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>-->
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>-->
    <!--<script src="<?php //echo(DIRJS."HtmlToPdf/html2pdf.bundle.min.js"); ?>"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
    <script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.5/base64.min.js"></script>
    <script>
        
        function printPHP(element){
            
            html = '<html>';
            html += '<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>'
            html += '<body class="p-4">';
            html+='<div class="container-fluid border ">';
            html += element.innerHTML;
            html+='</div>';
            html += '</body>';
            html += '</html>';
            
            var url=btoa(unescape(encodeURIComponent(html))).replaceAll('+','-').replaceAll('/','_').replaceAll('=','');
            janela = window.open(getRoot(getURL()+"/printNota?file="+url),'_blank');
            
            //console.log(html)
        }
        
       
    </script>
</main>