<main class="my-2">
    <div class="container-fluid">
        <div id='mensage'></div>
        <div class='card'>
            <div class='card-header'>
                <span class='me-2'><i class="bi bi-receipt"></i></span>
                <span><b>Emissão de notas</b></span>
            </div>
            <div class='card-body'>
                <form id='formEmitirNota' action="" method='post' enctype="multipart/form-data">
                    
                    <div class='row mb-2'>
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="PJ">Escolha a PJ*</label>
                            <select id="PJ" name="PJ" class='form-select' onchange='getAtividade(this.value);getServico(this.value);getTributosMunicipais(this.value);' required>
                                <option value="">Selecione uma opção</option>
                                <option value="03.902.161/0001-69">VMPE</option>
                                <option value="11.316.866/0001-22">PERNAMBUCONT</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="simplesNacional">Optante Simples Nacional*</label>
                            <select id="simplesNacional" name="simplesNacional" class='form-select' onchange='optanteNacional();' required>
                                <option value="">Selecione uma opção</option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class='row mb-2'>
                        
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="incentivadorCultural">Incentivador Cultural*</label>
                            <select id="incentivadorCultural" name="incentivadorCultural" class='form-select' required>
                                <option value="">Selecione uma opção</option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="localPrestacaoServico">Local de Seviço*</label>
                            <select id="localPrestacaoServico" name="localPrestacaoServico" class='form-select' required>
                                <option value="">Selecione uma opção</option>
                                <option value="1">No Município(Com Retenção)</option>
                                <option value="2">No Município(Sem Retenção)</option>
                                <option value="3">Fora do Município(Com Retenção)</option>
                                <option value="4">Fora do Município(Sem Retenção)</option>
                                <option value="5">Fora do Município(Com Pagamento no Local)</option>
                                <option value="6">Outro Município(Exterior)</option>
                            </select>
                        </div>
                        
                    </div>
                    
                    <div class='row mb-2'>
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="cepServico">CEP do Serviço*</label>
                    		<input class="form-control" id="cepServico" type="text" name="cepServico" oninput="mask(this,cepMask);" maxlength='9' placeholder="" required/>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="cepIncidencia">CEP de Incidência</label>
                    		<input class="form-control" id="cepIncidencia" type="text" name="cepIncidencia" oninput="mask(this,cepMask);" maxlength='9' placeholder="" required/>
                        </div>
                        
                        
                    </div>
                    
                    <div class='row mb-2'>
                        
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="inscricaoMunicipal">Inscrição Municipal*</label>
                            <input class="form-control" type='text' id='inscricaoMunicipal' name='inscricaoMunicipal' oninput="mask(this,inscricaoMunicipalMask);getNaturezaOperacao(this);" maxlength='9'/>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="atividade">Atividade*</label>
                            <select id="atividade" name="atividade" class='form-select' onchange='getCNAE();' required>
                                <option value="">Selecione uma opção</option>
                            </select>
                        </div>
                        
                    </div>
                    
                    <div class='row mb-2'>
                        
                        <div class="form-group col-sm-6">
                            <label class='form-label' for="naturezaOperacao">Natureza da Operação*</label>
                            <select class="form-select" id="naturezaOperacao" name="naturezaOperacao">
                                <option value=''>Selecione uma opção</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <fieldset class='' id="selectServicoFieldset">
                                <label class='form-label' for="servico">Serviço*</label>
                                <select class="form-select" id="selectServico" name="codServico">
                                    <option value=''>Selecione uma opção</option>
                                </select>
                            </fieldset>
                        </div>
                        
                    </div>
                    
                    <div class='row mb-2'>
                        
                        <div class="form-group col-sm-6">
                            <fieldset class='' id="selectTributacaoMunicipalFieldset">
                                <label class='form-label' for="codTribMunicipal">Tributo Municipal*</label>
                                <select class="form-select" id="codTribMunicipal" name="codTribMunicipal">
                                    <option value=''>Selecione uma opção</option>
                                </select>
                            </fieldset>
                        </div>
        			    
        			    <div class='form-group col-sm-6'>
        			        <label class='form-label' for="Data de Emissão do RPS">Data da Competência</label>
        			        <input class='form-control' type='date' name="dataCompetencia" />
        			    </div>
        			    
        			    <div class='form-group col-sm-6'>
        			        <label class='form-label' for="N° do RPS">N° do RPS</label>
        			        <input class='form-control' type='text' name="NdoRPS" />
        			    </div>
        			    
        			    <div class='form-group col-sm-6'>
        			        <label class='form-label' for="Série do RPS">Série do RPS</label>
        			        <input class='form-control' type='text' name="SerieDoRPS" />
        			    </div>
        			    
        			    <div class='form-group col-sm-12'>
            			    <label class='form-label' for="Descriminação dos serviços">Descriminação dos serviços</label>
            			    <textarea class="form-control" type='text' name="DescriminacaoDosServicos" rows="3"></textarea>
            			</div>
        			    
        			</div>
                    
                    <div id='divServico' class="form-group">
                        <legend>Cadastrar Serviço:</legend>
        			    <input class="form-check-input"  type="radio" name="radioServico" value=1 id="radioServico1"/>Sim
            			<input class="form-check-input" type="radio" name="radioServico" value=0 id="radioServico2" checked />Não
            			
        			    <fieldset class='row my-2' id="fieldsetServicos" disabled>
            			    <div class='col-sm-4 mb-2'>
            			        <label class='form-label' for="CodigoDeServico">Codigo de Servico*</label>
                			    <input class='form-control' placeholder='' id="CodigoDeServico" oninput='mask(this,listaServicoMask);' maxlength='5' type='text' name="CodigoDeServico" />
            			    </div>
                			
                			<div class='col-sm-8 mb-2'>
                			    <label class='form-label' for="DescricaoServico">Descrição do Serviço*</label>
                			    <input class='form-control' placeholder='' type='text' name="DescricaoServico" />
                			</div>
            			</fieldset>
                    </div>
                    
                    <div id='divTribMunicipal' class="form-group">
                        <legend>Cadastrar Tributo Municipal:</legend>
        			    <input class="form-check-input"  type="radio" name="radioTribMunicipal" value=1 id="radioTribMunicipal1"/>Sim
            			<input class="form-check-input" type="radio" name="radioTribMunicipal" value=0 id="radioTribMunicipal2" checked />Não
            			
        			    <fieldset class='row my-2' id="fieldsetTribMunicipal" disabled>
                			<div class='col-sm-4 mb-2'>
            			        <label class='form-label' for="codTribMunicipal">Codigo de Tributação*</label>
                			    <input class='form-control' placeholder='' type='text' name="codTribMunicipalCad" />
                			</div>
                			
                			<div class='col-sm-8 mb-2'>
                			    <label class='form-label' for="DescricaoTribMunicipal">Descrição do Tributo Municipal*</label>
                			    <input class='form-control' placeholder='' type='text' name="DescricaoTribMunicipal" />
                			</div>
            			</fieldset>
                    </div>
        			
        			<div class='row mb-2'>
        			    
        			    <legend class='form-label' for="Descriminação dos serviços">Dados do Tomador</legend>
        			    
        			    <div class='form-group col-md-4'>
        			        <label class='form-label' for="CpfCnpjTomador">CPF/CNPJ do Tomador*</label>
                			<input class="form-control" id="CpfCnpjTomador" type="text" name="CpfCnpjTomador" oninput="mask(this,cpfCnpjMask);" maxlength='18' placeholder="" required/>
        			    </div>
        			    
        			    <div class='form-group col-md-4'>
        			        <label class='form-label' for="nomeTomador">Nome Tomador*</label>
                			<input class="form-control" id="nomeTomador" type="text" name="nomeTomador" oninput="" maxlength='50' placeholder="" required/>
        			    </div>
        			    
        			    <div class='form-group col-md-4'>
        			        <label class='form-label' for="cepTomador">CEP*</label>
                			<input class="form-control" id="cepTomador" type="text" name="cepTomador" oninput="mask(this,cepMask);" maxlength='9' placeholder="" required/>
        			    </div>
        			    
        			</div>
        			  
        			<div class='row mb-2'>
        			 <legend class='form-label'>Valores da Nota</legend> 
        			    <div class='form-group col-xl-12 mb-3 mx-3'>
    			            
    			            <div class='row'>
    			                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name='issRetido' id="issRetido" value='1'>
                                  <label class="form-check-label" for="issRetido">ISS Retido</label>
                                </div>
                                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name='cofinsRetido' id="cofinsRetido" value='1'>
                                  <label class="form-check-label" for="cofinsRetido">COFINS Retido</label>
                                </div>
                                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name="csllRetido" id="csllRetido" value='1'>
                                  <label class="form-check-label" for="csllRetido">CSLL Retido</label>
                                </div>
                                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name='irpjRetido' id="irpjRetido" value='1'>
                                  <label class="form-check-label" for="irpjRetido">IRPJ Retido</label>
                                </div>
                                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name='pisRetido' id="pisRetido" value='1'>
                                  <label class="form-check-label" for="pisRetido">PIS Retido</label>
                                </div>
                                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name='cppRetido' id="cppRetido" value='1'>
                                  <label class="form-check-label" for="cppRetido">CPP Retido</label>
                                </div>
                                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name='ipiRetido' id="ipiRetido" value='1'>
                                  <label class="form-check-label" for="ipiRetido">IPI Retido</label>
                                </div>
                                <div class="form-check form-switch col-sm-4">
                                  <input class="form-check-input checkboxRetido" type="checkbox" name='icmsRetido' id="icmsRetido" value='1'>
                                  <label class="form-check-label" for="icmsRetido">ICMS Retido</label>
                                </div>
                                
    			            </div>
    			            
    			        </div>
    			        
        			</div>
        			
        			<div class='row mb-2'>
  
        			    <div class='form-group col-md-4'>
    			            <label class='form-label' for="Valor total dos Serviços">Valor total do Serviço(R$)</label>
    			            <input class="form-control" type='text' name="ValorTotalDosServicos"
    			            maxlength="18" size="18"
    			            oninput="mascaraDinheiro(this);"
    			            onkeypress="mascaraDinheiro(this);"
    			            autocomplete=off />
        			    </div>

    			        <div class='form-group col-md-4'>
			                <label class='form-label' for="Descontos Condicionados">Descontos Condicionados(R$)</label>
			                <input class='form-control' type='text' name="DescontosCondicionados"
			                maxlength="18" size="18"
    			            oninput="mascaraDinheiro(this);"
    			            onkeypress="mascaraDinheiro(this);"
    			            autocomplete=off />
    			        </div>
        			        
    			        <div class='form-group col-md-4'>
			                <label class='form-label' for="Descontos Incondicionados">Descontos Incondicionados(R$)</label>
			                <input class='form-control' type='text' name="DescontosIncondicionados"
			                maxlength="18" size="18"
    			            oninput="mascaraDinheiro(this);"
    			            onkeypress="mascaraDinheiro(this);"
    			            autocomplete=off />
    			        </div>
        
            			</div>
            			
            		<div class='row mb-2'>
        			    <fieldset id='fieldsetRBT12' class='col-12 mb-3' disabled>
    			            
            		        <div class='row'>
            		            
            		            <div class='form-group col-md-6'>
            			            <label class='form-label' for="RBT12">Total Dos Ultimos 12 Meses(R$)</label>
            			            <input class="form-control" type='text' name="RBT12"
            			            maxlength="18" size="18"
            			            onblur='getInformacoesAnexo();'
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
                			    </div>
            		            
            		            <div class='form-group col-md-6'>
            			            <label class='form-label' for="anexo">Anexo</label>
            			            <select class="form-select" id="anexo" name="anexo" onchange='getInformacoesAnexo();'>
                                        <option value=''>Selecione uma opção</option>
                                    </select>
                			    </div>
                			   
            		        </div>
            		        
            		        <div class='row mt-2'>
            		            
            		            <div class='form-group col-md-6'>
            			            <label class='form-label' for="aliquota">Aliquota</label>
            			            <input class="form-control" type='text' name="aliquota"
            			            maxlength="5" size="4"
            			            oninput="mask(this,aliquotaMask);"
            			            autocomplete=off />
                			    </div>
                			    
                			    <div class='form-group col-md-6'>
            			            <label class='form-label' for="Valor Total das Deduções">Valor Total das Deduções(R$)</label>
            			            <input class='form-control' type='text' name="ValorTotalDasDeducoes"
            			            maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
            			        </div>
      
            			        <div class='form-group col-12 mt-3'>
                			        <button type='button' class='btn btn-primary' onclick='calcularSimples();'>Calcular</button>
                			    </div>
            		        </div>
            		        
            		    </fieldset>
        			</div>
        			
        			<div class='row mb-2'>
        			    
        			    <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
    			                    <label class='form-label' for="ISSValor">ISS(R$)</label>
        		                    <input class='form-control' type='text' name="ISSValor"
        			                maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="ISSPercentual">ISS(%)</label>
        		                    <input class='form-control' type='text' name="ISSPercentual"
        			                maxlength="5" size="5" value='5' oninput="percentualDecimal(this,ISSDecimal);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="ISSDecimal">ISS(%)</label>
        		                    <input class='form-control' type='text' name="ISSDecimal"
        			                maxlength="18" size="18" value='0.05'
            			            autocomplete=off />
    			                </div>
    			            </div>
    			        </div>
    			        
    			        <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
    			                    <label class='form-label' for="COFINSValor">COFINS(R$)</label>
        		                    <input class='form-control' type='text' name="COFINSValor"
        			                maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="COFINSPercentual">COFINS(%)</label>
        		                    <input class='form-control' type='text' name="COFINSPercentual"
        			                maxlength="5" size="5" oninput="percentualDecimal(this,COFINSDecimal);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="COFINSDecimal">COFINS(%)</label>
        		                    <input class='form-control' type='text' name="COFINSDecimal"
        			                maxlength="18" size="18"
            			            autocomplete=off />
    			                </div>
    			            </div>
			                
    			        </div>
        			  
    			        <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
            			            <label class='form-label' for="CSLLValor">CSLL(R$)</label>
            			            <input class='form-control' type='text' name="CSLLValor" 
        			                maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="CSLLPercentual">CSLL(%)</label>
        		                    <input class='form-control' type='text' name="CSLLPercentual"
        			                maxlength="5" size="5" oninput="percentualDecimal(this,CSLLDecimal);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="CSLLDecimal">CSLL(%)</label>
        		                    <input class='form-control' type='text' name="CSLLDecimal"
        			                maxlength="18" size="18"
            			            autocomplete=off />
    			                </div>
    			            </div>
    			        </div>
    			        
    			        <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
            			            <label class='form-label' for="IRPJValor">IRPJ(R$)</label>
            			            <input class='form-control' type='text' name="IRPJValor" 
            			            maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="IRPJPercentual">IRPJ(%)</label>
        		                    <input class='form-control' type='text' name="IRPJPercentual"
        			                maxlength="5" size="5" oninput="percentualDecimal(this,IRPJDecimal);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="IRPJDecimal">IRPJ(%)</label>
        		                    <input class='form-control' type='text' name="IRPJDecimal"
        			                maxlength="18" size="18"
            			            autocomplete=off />
    			                </div>
    			            </div>
    			        </div>
    			        
    			        <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
            		                <label class='form-label' for="PISValor">PIS(R$)</label>
            		                <input class='form-control' type='text' name="PISValor" 
            		                maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="PISPercentual">PIS(%)</label>
        		                    <input class='form-control' type='text' name="PISPercentual"
        			                maxlength="5" size="5" oninput="percentualDecimal(this,PISDecimal);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="PISDecimal">PIS(%)</label>
        		                    <input class='form-control' type='text' name="PISDecimal"
        			                maxlength="18" size="18"
            			            autocomplete=off />
    			                </div>
    			            </div>
    			        </div>
    			        
    			        <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
        			                <label class='form-label' for="CPPValor">CPP(R$)</label>
        			                <input class='form-control' type='text' name="CPPValor" 
        			                maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="CPPPercentual">CPP(%)</label>
        		                    <input class='form-control' type='text' name="CPPPercentual"
        			                maxlength="5" size="5" oninput="percentualDecimal(this,CPPDecimal);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="CPPDecimal">CPP(%)</label>
        		                    <input class='form-control' type='text' name="CPPDecimal"
        			                maxlength="18" size="18"
            			            autocomplete=off />
    			                </div>
    			            </div>
    			        </div>
    			        
    			        <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
        			                <label class='form-label' for="IPIVAlor">IPI(R$)</label>
        			                <input class='form-control' type='text' name="IPIValor" 
        			                maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="IPIPercentual">IPI(%)</label>
        		                    <input class='form-control' type='text' name="IPIPercentual"
        			                maxlength="5" size="5" oninput="percentualDecimal(this,IPIPercentual);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="IPIDecimal">IPI(%)</label>
        		                    <input class='form-control' type='text' name="IPIDecimal"
        			                maxlength="18" size="18"
            			            autocomplete=off />
    			                </div>
    			            </div>
    			        </div>
    			        
    			        <div class='form-group col-md-6'>
    			            <div class='row'>
    			                <div class='col-8'>
        			                <label class='form-label' for="ICMSValor">ICMS(R$)</label>
        			                <input class='form-control' type='text' name="ICMSValor" 
        			                maxlength="18" size="18"
            			            oninput="mascaraDinheiro(this);"
            			            onkeypress="mascaraDinheiro(this);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-4'>
    			                    <label class='form-label' for="ICMSPercentual">ICMS(%)</label>
        		                    <input class='form-control' type='text' name="ICMSPercentual"
        			                maxlength="5" size="5" oninput="percentualDecimal(this,ICMSPercentual);"
            			            autocomplete=off />
    			                </div>
    			                <div class='col-3' style="display:none;">
    			                    <label class='form-label' for="ICMSDecimal">ICMS(%)</label>
        		                    <input class='form-control' type='text' name="ICMSDecimal"
        			                maxlength="18" size="18"
            			            autocomplete=off />
    			                </div>
    			            </div>
    			        </div>
    			        
    			        <div class='form-group col-sm-6'>
    			            <label class='form-label' for="ValorRecolhidoAliquota">Valor Total(R$)</label>
    		                <input class='form-control' type='text' name="ValorRecolhidoAliquota" 
    		                maxlength="18" size="18"
    			            oninput="mascaraDinheiro(this);"
    			            onkeypress="mascaraDinheiro(this);"
    			            autocomplete=off />
    			         </div>
    			         
        			</div>
        			
        			<div style='display:none;' class="form-group mb-2">
        			    
        			    <legend>Parcelas:</legend>
        			    
        			    <input class="form-check-input"  type="radio" name="simParcela" value="sim" id="parcelasim"/>Sim
            			<input class="form-check-input" type="radio" name="simParcela" value="não" id="parcelanao" checked />Não
            			
            			<fieldset class='row' id="parcelas" disabled>
            			    <div class='col-sm-6'>
                			    <label class='form-label' for="forma Pagamento">Forma de Pagamento</label>
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
                			
            			    <div class='col-sm-6'>
            			        <label class='form-label' for="qtd parcelas">Quantas Parcelas?</label>
                			    <input class='form-control' type='text' name="QuantasParcelas" />
            			    </div>
                			   
                			<div class='col-sm-6'>
                			    <label class='form-label' for="valor Parcela">Valor da Parcela (R$)</label>
                			    <input class='form-control' type='text' name="ValorDaParcela" 
                			    maxlength="18" size="18"
        			            oninput="mascaraDinheiro(this);"
        			            onkeypress="mascaraDinheiro(this);"
        			            autocomplete=off />
                			</div>
                			    
                			<div class='col-sm-6'>
                			    <label class='form-label' for="N° fatura">Numero da Fatura</label>
                			    <input class='form-control' type='text'name="NumeroDaFatura" />
                			</div> 
            			</fieldset>
        			</div>
        			
                    <div class='form-group my-3'>
                        <input type='button' class='btn btn-success' onclick='EmitirNotas();' name="Submit" value="Salvar"/>
                    </div>
                    
                </form>
            </div>
        </div>
        
    </div>
</main>