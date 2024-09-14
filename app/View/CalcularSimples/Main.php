<div class="container">
    <div class="content">
        <!-- <div class="image-box">
            <img src="<?php //echo(DIRIMG."CalcularSimples/teste.svg"); ?>" alt="">
        </div> -->
        <form id="formCalcSimples" action="#">
            <div class="topic">Calculo do Simples Nacional</div>
            <!-- <div class="page-form-content"> -->
            <div class="row">
                <div class="col-md-12 mb-4">
                <label for="opcao1">Anexos</label>
                    <div class="radio-container">
                      <input type="checkbox" id="checkbox-1" class="checkbox" name="radio" value="I">
                      <label for="opcao1">I</label>
                      <input type="checkbox" id="checkbox-2" class="checkbox" name="radio" value="II">
                      <label for="opcao2">II</label>
                      <input type="checkbox" id="checkbox-3" class="checkbox" name="radio" value="III">
                      <label for="opcao2">III</label>
                      <input type="checkbox" id="checkbox-4" class="checkbox" name="radio" value="IV">
                      <label for="opcao2">IV</label>
                      <input type="checkbox" id="checkbox-5" class="checkbox" name="radio" value="V">
                      <label for="opcao2">V</label>
                    </div>
                </div>    
                <!-- <div class="button-container"> -->
                <div class='col-md-12 mb-4'>
                    <div class="text-fields">
            		    <label>CNPJ</label>
                		<input class='form-input' id="cnpj" type="text" name="cnpj" minlength="18" maxlength="18"
                        onkeypress="mascaraCnpj(this, cnpj);" onblur="mascaraCnpj(this, cnpj);" required/>
                    </div>
        		</div>
                <div class="col-md-6 mb-4">
                    <div class="text-fields">
                        <label>RBT12</label>
                        <input 
                            name='rbt12' 
                            type="text" 
                            class="form-input"  
                            maxlength="18"
            			    size="18"
            			    oninput="mascaraDinheiro(this);"
            			    onkeypress="mascaraDinheiro(this);"
            			    autocomplete=off 
                            required
                        />
                    </div>
                </div>

                <!-- <div class="button-container"> -->
                <div class="col-md-6 mb-4">
                    <div class="text-fields">
                        <label> Folha</label>
                        <input 
                            name='folha' 
                            type="text" 
                            class="form-input"
                            maxlength="18"
            			    size="18"
            			    oninput="mascaraDinheiro(this);"
            			    onkeypress="mascaraDinheiro(this);"
            			    autocomplete=off  
                            required
                        />
                    </div>
                </div>

                <div class="col-md-6 mb-4 check" id='1' style="display: none;">
                    <label>Faturamento | Anexo I</label>
                    <div class="text-fields">  
                        <div>
                            <label>Sem Retenção</label>
                            <input 
                                name="faturamento_anexo1_sem_retencao" 
                                type="text" 
                                class="form-input" 
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off 
                                required
                            />
                        </div>
                        <div>
                            <label>Com Retenção</label>
                            <input 
                                name="faturamento_anexo1_com_retencao" 
                                type="text" 
                                class="form-input" 
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off 
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4 check" id='2' style="display: none;">
                    <label>Faturamento | Anexo II</label>
                    <div class="text-fields">
                        <div>
                            <label>Sem Retenção</label>
                            <input 
                                name="faturamento_anexo2_sem_retencao" 
                                type="text" 
                                class="form-input"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off  
                                required
                            />
                        </div>
                        <div>
                            <label>Com Retenção</label>
                            <input 
                                name="faturamento_anexo2_com_retencao" 
                                type="text" 
                                class="form-input"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off  
                                required
                            />
                        </div>  
                    </div>
                </div>

                <div class="col-md-6 mb-4 check" id='3' style="display: none;">
                    <label>Faturamento | Anexo III</label>
                    <div class="text-fields">
                        <div>
                            <label>Sem Retenção</label>
                            <input 
                                name="faturamento_anexo3_sem_retencao" 
                                type="text" 
                                class="form-input" 
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off 
                                required
                            />
                        </div>
                        <div>
                            <label>Com Retenção</label>
                            <input 
                                name="faturamento_anexo3_com_retencao" 
                                type="text" 
                                class="form-input"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off  
                                required
                            />
                        </div>  
                    </div>
                </div>

                <div class="col-md-6 mb-4 check" id='4' style="display: none;">
                    <label>Faturamento | Anexo IV</label>
                    <div class="text-fields">  
                        <div>
                            <label>Sem Retenção</label>
                            <input 
                                name="faturamento_anexo4_sem_retencao" 
                                type="text" 
                                class="form-input"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off  
                                required
                            />
                        </div>
                        <div>
                            <label>Com Retenção</label>
                            <input 
                                name="faturamento_anexo4_com_retencao" 
                                type="text" 
                                class="form-input"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off  
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="col-md-6 check" id='5' style="display: none;">
                    <label>Faturamento | Anexo V</label>
                    <div class="text-fields">  
                        <div>
                            <label>Sem Retenção</label>
                            <input 
                                name="faturamento_anexo5_sem_retencao" 
                                type="text" 
                                class="form-input"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off  
                                required
                            />
                        </div>
                        <div>
                            <label>Com Retenção</label>
                            <input 
                                name="faturamento_anexo5_com_retencao" 
                                type="text" 
                                class="form-input"
                                maxlength="18"
                                size="18"
                                oninput="mascaraDinheiro(this);"
                                onkeypress="mascaraDinheiro(this);"
                                autocomplete=off  
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="button-containe">
                    <div class="input-box">
                        <input id='enviar' type="button" class="button" value="Enviar valores">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div style="display:none;" class="container_table">
    <div class="heading">
      <h1>Tabela do simples nacional</h1>
      <!-- <button id="get-unique-values" onclick="getUniqueValuesFromColumn()">Get unique column values</button> -->
    </div>
    
    <div class='d-flex mx-5 mt-3 justify-content-between'>
        <button class="btn btn-primary" id="btnVoltar" type='button'>Voltar</button>
        <button class="btn btn-danger" type="button" id="btnPrint">Imprimir</button>
    </div>

    <div class="content_table">
        <div class="outer-wrapper">
            <div>
                <h4>Valor Total DAS: <span id="valorTotalDAS"></span> </h4>
            </div>
            <!--<div class="button-container">-->
            <!--    <div class="radio-container">-->
            <!--        <input type="radio" id="radio1" name="radio" value="Imposto">-->
            <!--        <label for="opcao1">Valor Imposto</label>-->
                    
            <!--        <input type="radio" id="radio2" name="radio" value="Efetiva">-->
            <!--        <label for="opcao2">Alíquota Efetiva</label>-->
            <!--        <input type="radio" id="radio2" name="radio" value="Partilha">-->
            <!--        <label for="opcao2">Partilha</label>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="table-wrapper" id="Imposto">
                <h1>Valor tributario aparecendo</h1>
                <table id="emp-table1">
                    <thead>
                        <th col-index = 1>Anexo</th>
                        <th col-index = 2>Imposto</th>
                        <th col-index = 3>IRPJ</th>
                        <th col-index = 4>CSLL</th>
                        <th col-index = 5>COFINS</th>
                        <th col-index = 6>PIS</th>
                        <th col-index = 7>CPP</th>
                        <th col-index = 8>ICMS</th>
                        <th col-index = 9>IPI</th>
                        <th col-index = 10>ISS</th>
                        <th col-index = 11>Total</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>15.435,78</td>
                            <td>12.437,99</td>
                            <td>15.20,89</td>
                            <td>19.73,00</td>
                            <td>4.27,00</td>
                            <td>19.73,00</td>
                            <td>20.80,00</td>
                            <td>4.27,00</td>
                            <td>19.73,00</td>
                            <td>Total</td>
                          </tr>
                        <tr>
                            <td>2</td>
                            <td>19.73,00</td>
                            <td>20.80,00</td>
                            <td>15.20,00</td>
                            <td>19.73,00</td>
                            <td>4.27,00</td>
                            <td>19.73,08</td>
                            <td>20.80,00</td>
                            <td>4.27,00</td>
                            <td>19.73,00</td>
                            <td>Total</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>10%</td>
                            <td>20.8000%</td>
                            <td>15.2000%</td>
                            <td>19.7300%</td>
                            <td>4.2700%</td>
                            <td>19.7300%</td>
                            <td>20.8000%</td>
                            <td>4.2700%</td>
                            <td>19.7300%</td>
                            <td>Total</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>14%</td>
                            <td>20.8000%</td>
                            <td>15.2000%</td>
                            <td>19.7300%</td>
                            <td>4.2700%</td>
                            <td>19.7300%</td>
                            <td>20.8000%</td>
                            <td>4.2700%</td>
                            <td>19.7300%</td>
                            <td>Total</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>21%</td>
                            <td>20.8000%</td>
                            <td>15.2000%</td>
                            <td>19.7300%</td>
                            <td>4.2700%</td>
                            <td>19.7300%</td>
                            <td>20.8000%</td>
                            <td>4.2700%</td>
                            <td>19.7300%</td>
                            <td>Total</td>
                    </tbody>
                    <!--<tfoot>-->
                    <!--    <tr>-->
                    <!--      <td>total</td>-->
                    <!--      <td>84%</td>-->
                    <!--      <td>284.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--        <td>Total</td>-->
                    <!--        <td>Total</td>-->
                    <!--    </tr>-->
                    <!--</tfoot>-->
                </table>
            </div>
            <!--<div class="table-wrapper" id="Efetiva" style="display: none;">-->
            <!--    <h1>Aliquota aparecendo</h1>-->
            <!--    <table id="emp-table2">-->
            <!--        <thead>-->
            <!--            <th col-index = 1>Anexo</th>-->
            <!--            <th col-index = 2>Aliquota</th>-->
            <!--            <th col-index = 3>IRPJ</th>-->
            <!--            <th col-index = 4>CSLL</th>-->
            <!--            <th col-index = 5>COFINS</th>-->
            <!--            <th col-index = 6>PIS</th>-->
            <!--            <th col-index = 7>CPP</th>-->
            <!--            <th col-index = 8>ICMS</th>-->
            <!--            <th col-index = 9>IPI</th>-->
            <!--            <th col-index = 10>ISS</th>-->
            <!--            <th col-index = 11>Total</th>-->
            <!--        </thead>-->
            <!--        <tbody>-->
            <!--            <tr>-->
            <!--                <td>1</td>-->
            <!--                <td>11%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--              </tr>-->
            <!--            <tr>-->
            <!--                <td>2</td>-->
            <!--                <td>1%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>3</td>-->
            <!--                <td>10%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>4</td>-->
            <!--                <td>14%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>5</td>-->
            <!--                <td>21%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--        </tbody>-->
                    <!--<tfoot>-->
                    <!--    <tr>-->
                    <!--        <td>Total</td>-->
                    <!--      <td>total</td>-->
                    <!--      <td>84%</td>-->
                    <!--      <td>284.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--      <td>15.848,45</td>-->
                    <!--    </tr>-->
                    <!--</tfoot>-->
            <!--    </table>-->
            <!--</div>-->
            <!--<div class="table-wrapper" id="Partilha" style="display: none;">-->
            <!--    <h1>Partilha aparecendo</h1>-->
            <!--    <table id="emp-table3">-->
            <!--        <thead>-->
            <!--            <th col-index = 1>Anexo</th>-->
            <!--            <th col-index = 2>Partilha</th>-->
            <!--            <th col-index = 4>IRPJ</th>-->
            <!--            <th col-index = 5>CSLL</th>-->
            <!--            <th col-index = 6>COFINS</th>-->
            <!--            <th col-index = 7>PIS</th>-->
            <!--            <th col-index = 8>CPP</th>-->
            <!--            <th col-index = 9>ICMS</th>-->
            <!--            <th col-index = 10>IPI</th>-->
            <!--            <th col-index = 11>ISS</th>-->
            <!--            <th col-index = 12>Total</th>-->
            <!--        </thead>-->
            <!--        <tbody>-->
            <!--            <tr>-->
            <!--                <td>1</td>-->
            <!--                <td>11%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--              </tr>-->
            <!--            <tr>-->
            <!--                <td>2</td>-->
            <!--                <td>1%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>3</td>-->
            <!--                <td>10%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>4</td>-->
            <!--                <td>14%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--            </tr>-->
            <!--            <tr>-->
            <!--                <td>5</td>-->
            <!--                <td>21%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>15.2000%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>20.8000%</td>-->
            <!--                <td>4.2700%</td>-->
            <!--                <td>19.7300%</td>-->
            <!--                <td>Total</td>-->
            <!--          </tbody>-->
                      <!--<tfoot>-->
                      <!--  <tr>-->
                      <!--    <td>total</td>-->
                      <!--    <td>84%</td>-->
                      <!--    <td>284.848,45</td>-->
                      <!--    <td>15.848,45</td>-->
                      <!--    <td>15.848,45</td>-->
                      <!--    <td>15.848,45</td>-->
                      <!--    <td>15.848,45</td>-->
                      <!--    <td>15.848,45</td>-->
                      <!--    <td>15.848,45</td>-->
                      <!--    <td>15.848,45</td>-->
                      <!--  </tr>-->
                      <!--</tfoot>-->
            <!--    </table>-->
            <!--</div>-->
        </div>
    </div>
</div>
