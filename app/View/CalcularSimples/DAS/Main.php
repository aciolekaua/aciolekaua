<!-- Modal Cailcular Simples -->
<?php //echo(DIRIMG."CalcularSimples/DAS/excel.svg"); ?>
<div class="modal fade" id="modal_calcular_simples" tabindex="-1" aria-labelledby="modal_calcular_simples" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
        <div class="modal-header">
            <h1 id="div_nome_empresa" class='h1'></h1>
            <!--<h5 class="modal-title" id="exampleModalLabel">Calcular Simples</h5> -->
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!--<div class="row mb-2"><h1 id="div_nome_empresa" class='h1'></h1></div>-->
            <div class="container-details">
                   <div class="contenti">
                    <div class="incomei">
                        <div class="left-contenti">
                            <div class="badgei faturamento-info">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                            <div class="infoi">
                                <span>Faturamento</span>
                                <h2 id="div_valor_faturamento_sem_rentencao_total" class="col-lg-12 mb-4 text-orange">Total do Faturamento Sem Retenção: R$ 0,00</h2>
                                <!--<div id="div_valor_totalizada_DAS" class="col-lg-12 mb-4 h2 text-success"></div>-->
                            </div>
                        </div>

                        <div class="right-contenti">
                            <div class="topi">
                                <i class="bi bi-calendar-event-fill text-orange"></i>
                                <!--<p>- 0.3 %</p>-->
                            </div>
                            <span>08/2024</span>
                        </div>
                    </div>
                    <div>
                        <div class="row m-3">
                            <h2 id="div_valor_faturamento_sem_rentencao_anexo_1" class="col-lg-6 mb-3 h2 text-muted">Anexo 1: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_sem_rentencao_anexo_2" class="col-lg-6 mb-3 h2 text-muted">Anexo 2: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_sem_rentencao_anexo_3" class="col-lg-6 mb-3 h2 text-muted">Anexo 3: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_sem_rentencao_anexo_4" class="col-lg-6 mb-3 h2 text-muted">Anexo 4: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_sem_rentencao_anexo_5" class="col-lg-6 mb-2 h2 text-muted">Anexo 5: R$ 0,00</h2>
                        </div>
                    </div>
                </div>
                    <div class="contenti">
                    <div class="incomei">
                        <div class="left-contenti">
                            <div class="badgei text-azul">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                            <div class="infoi">
                                <span class="text-azul">Faturamento Com Reteção</span>
                                <h2 id="div_valor_faturamento_com_rentencao_total" class="col-lg-12 mb-4 text-azul">Total FAT Com Retenção: R$ 0,00</h2>
                                <!--<div id="div_valor_totalizada_DAS" class="col-lg-12 mb-4 h2 text-success"></div>-->
                            </div>
                        </div>

                        <div class="right-contenti">
                            <div class="topi">
                                <i class="bi bi-calendar-event-fill text-azul"></i>
                                <!--<p>- 0.3 %</p>-->
                            </div>
                            <span>08/2024</span>
                        </div>
                    </div>
                    <div>
                        <div class="row m-3">
                            <h2 id="div_valor_faturamento_com_rentencao_anexo_1" class="col-lg-6 mb-3 h2 text-muted">Anexo 1: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_com_rentencao_anexo_2" class="col-lg-6 mb-3 h2 text-muted">Anexo 2: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_com_rentencao_anexo_3" class="col-lg-6 mb-3 h2 text-muted">Anexo 3: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_com_rentencao_anexo_4" class="col-lg-6 mb-3 h2 text-muted">Anexo 4: R$ 0,00</h2>
                            <h2 id="div_valor_faturamento_com_rentencao_anexo_5" class="col-lg-6 mb-2 h2 text-muted">Anexo 5: R$ 0,00</h2>
                        </div>
                    </div>
                </div>
                   <div class="contenti">
                    <div class="outcomei">
                        <div class="left-contenti">
                            <div class="badgei">
                                <i class="bi bi-bank2"></i>
                            </div>
                            <div class="infoi">
                                <span>DAS</span>
                                <div id="div_valor_totalizada_DAS" class="col-lg-12 mb-4 h2 text-success"></div>
                            </div>
                        </div>
                        
                        <div class="right-contenti">
                            <div class="topi">
                                <i class="bi bi-calendar-event-fill text-success"></i>
                                <!--<p>+ 0.7 %</p>-->
                            </div>
                            <span>08/2024</span>
                        </div>
                    </div>
                    <div>
                        <div class="row m-5">
                            <div id="div_valor_totalizado_anexo_1" class="col-lg-6 mb-4 h2 text-muted"></div>
                            <div id="div_valor_totalizado_anexo_2" class="col-lg-6 mb-4 h2 text-muted"></div>
                            <div id="div_valor_totalizado_anexo_3" class="col-lg-6 mb-4 h2 text-muted"></div>
                            <div id="div_valor_totalizado_anexo_4" class="col-lg-6 mb-4 h2 text-muted"></div>
                            <div id="div_valor_totalizado_anexo_5" class="col-lg-12 mb-2 h2 text-muted"></div>
                        </div>
                    </div>
                </div>
                   <div class="contenti">
                    <div class="incomei">
                        <div class="left-contenti">
                            <div class="badgei">
                                <i class="bi bi-file-break-fill"></i>
                            </div>
                            <div class="infoi">
                                <span>Folha</span>
                                <h2 class="col-lg-12 mb-4 h2 content-colo">Valor da Folha: R$ 0,00</h2>
                                <!--<div id="div_valor_totalizada_DAS" class="col-lg-12 mb-4 h2 text-success"></div>-->
                            </div>
                        </div>

                        <div class="right-contenti">
                            <div class="topi">
                                <i class="bi bi-calendar-event-fill content-colo"></i>
                                <!--<p>- 0.3 %</p>-->
                            </div>
                            <span>08/2024</span>
                        </div>
                    </div>
                    <div>
                        <div class="row m-3">
                            <h2 class="col-lg-12 mb-5 h2 text-muted">Valor dos ultimos (12 meses): R$ 0,00</h2>
                            <h2 id="h2_fatorR_card" class="col-lg-12 h2 text-muted">Fator R: 0,00%</h2>
                        </div>
                    </div>
                </div>
                   <div class="contenti">
                    <div class="outcomei">
                        <div class="left-contenti">
                            <div class="badgei rbt12info">
                                <i class="bi bi-speedometer"></i>
                            </div>
                            <div class="infoi">
                                <span>RBA</span>
                                <h2 class="col-lg-12 mb-2 h2 text-danger" id="h2_rba_card">Total do RBA: R$ 0,00</h2>
                                <!--<div id="div_valor_totalizada_DAS" class="col-lg-12 mb-4 h2 text-success"></div>-->
                            </div>
                        </div>
                        
                        <div class="right-contenti">
                            <div class="topi">
                                <i class="bi bi-calendar-event-fill text-danger"></i>
                                <!--<p>+ 0.7 %</p>-->
                            </div>
                            <span>08/2024</span>
                        </div>
                    </div>
                    <div>
                        <div class="limite_chart">
                            <canvas id="myChartLimite"></canvas>
                            <!--<h2 class="col-lg-12 mb-5 h2 text-muted">Anterior (RBA): R$ 230.222,50</h2>-->
                            <!--<h2 class="col-lg-12 h2 text-muted">Corrente (RBA): R$ 51.721,88</h2>-->
                            <!--<h2 class="col-lg-6 mb-3 h2 text-muted">Anexo 4: R$ 0,00</h2>-->
                            <!--<h2 class="col-lg-6 mb-3 h2 text-muted">Anexo 5: R$ 0,00</h2>-->
                        </div>
                    </div>
                </div>
                    <div class="card-infoi" id="card-info">
                   <div class="incomei">
                       <div class="badgei">
                           <i class="bi bi-clipboard2-data-fill"></i>
                        </div>
                       <h2  style="color:var(--colo-primary);">Analize a sua Aliquota</h2>
                       <div class="right-contenti">
                            <div class="topi">
                                <i class="bi bi-calendar-event-fill" style="color:var(--colo-primary);"></i>
                                <!--<p>+ 0.7 %</p>-->
                            </div>
                            <span>09/2024</span>
                        </div>
                   </div>
                   <div class="row">
                       <div class="col-lg-6" style="border-right:1px solid rgba(129, 88, 252, 0.1);">
                           <h2 class="col-lg-12 text-info" style="padding:.5rem;">Aliquota efetiva:</h2>
                           <h3 id="div_aliquota_efetiva_anexo_1" class="col-lg-12 h3 text-muted">Anexo 1: 0,00%</h3>
                           <h3 id="div_aliquota_efetiva_anexo_2" class="col-lg-12 h3 text-muted">Anexo 2: 0,00%</h3>
                           <h3 id="div_aliquota_efetiva_anexo_3" class="col-lg-12 h3 text-muted">Anexo 3: 0,00%</h3>
                           <h3 id="div_aliquota_efetiva_anexo_4" class="col-lg-12 h3 text-muted">Anexo 4: 0,00%</h3>
                           <h3 id="div_aliquota_efetiva_anexo_5" class="col-lg-12 h3 text-muted">Anexo 5: 0,00%</h3>
                       </div>
                       <div class="col-lg-6">
                           <h2 class="col-lg-12 text-info" style="padding:.5rem;">Aliquota de retenção:</h2>
                           <div class="row ms-3">
                               <h3 id="div_aliquota_retencao_anexo_1" class="col-lg-12 h3 text-muted">Anexo 1: 0,00%</h3>
                               <h3 id="div_aliquota_retencao_anexo_2" class="col-lg-12 h3 text-muted">Anexo 2: 0,00%</h3>
                               <h3 id="div_aliquota_retencao_anexo_3" class="col-lg-12 h3 text-muted">Anexo 3: 0,00%</h3>
                               <h3 id="div_aliquota_retencao_anexo_4" class="col-lg-12 h3 text-muted">Anexo 4: 0,00%</h3>
                               <h3 id="div_aliquota_retencao_anexo_5" class="col-lg-12 h3 text-muted">Anexo 5: 0,00%</h3>
                           </div>
                       </div>
                   </div>
                   
                </div>
                <!--<div class="datails-boxi">-->
                <!--</div>-->
                <!--<div class="datails-boxi">-->
                <!--</div>-->
                <!--<div class="datails-boxi">-->
                <!--</div>-->
                </div>
            <div class="row mb-4 mt-2">
                <div class="col-lg-4 mb-2">
                    <label class="form-label h3" for="">RBT12</label>
                    <input 
                        class="form-control fs-3" 
                        type="text" 
                        name="rbt12" 
                        maxlength="18"
                        size="18"
                        oninput="mascaraDinheiro(this);"
                        onkeypress="mascaraDinheiro(this);"
                        autocomplete=off
                    />
                </div>

                <div class="col-lg-4 mb-2">
                    <label class="form-label h3" for="">Folha</label>
                    <input 
                        class="form-control fs-3" 
                        type="text" 
                        name="folha" 
                        maxlength="18"
                        size="18"
                        oninput="mascaraDinheiro(this);"
                        onkeypress="mascaraDinheiro(this);"
                        autocomplete=off
                    />
                </div>
                
                <!--<div class="col-lg-4 mb-2 d-flex align-items-end justify-content-start">
                    <button id="btn_calcular_simples" type="button" class="btn btn-primary fs-3">Calcular</button>
                </div>-->
                
            </div>

            <div class="accordion" id="acordeon_simples">
                <!-- Início Anexo 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="painel_titulo_anexo_1">
                        <button style="font-size: 100%;" class="accordion-button collapsed fs3" type="button" data-bs-toggle="collapse" data-bs-target="#painel_anexo_1" aria-expanded="false" aria-controls="painel_anexo_1">
                            Anexo 1(Comércio)
                        </button>
                    </h2>

                    <div id="painel_anexo_1" class="accordion-collapse collapse" aria-labelledby="painel_titulo_anexo_1">
                        <div class="accordion-body">
                            <form class="row mb-3">
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" for="">Folha:</label>
                                    <input name="folha_anexo_1" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>-->
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor sem retenção:</label>
                                    <input name="faturamento_sem_retencao_anexo_1" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor com retenção:</label>
                                    <input name="faturamento_com_retencao_anexo_1" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" >RBT12:</label>
                                    <input name="rbt12" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2 d-flex align-items-end justify-content-start">
                                    <button id="btn_calcular_simples_anexo_1" type="button" class="btn btn-primary fs-3">Calcular</button>
                                </div>-->
                            </form>

                            <div class="row">
                                
                                <!--<div class="row">
                                    <div id="div_anexo">Anexo: 0</div>
                                </div>-->
                                <div class="row mb-3">
                                    <div class='col-4' id="div_aliquota_anexo_1">Aliquota: 0%</div>
                                    <div class='col-4' id="div_aliquota_retencao_anexo_1">Aliquota: 0%</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Tipo</div>
                                    <div class="col border">COFINS</div>
                                    <div class="col border">IRPJ</div>
                                    <div class="col border">CSLL</div>
                                    <div class="col border">IPI</div>
                                    <div class="col border">CPP</div>
                                    <div class="col border">ICMS</div>
                                    <div class="col border">ISS</div>
                                    <div class="col border">PIS</div>
                                    <div class="col border">Total</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Sem Retenção</div>
                                    <div id="col_sem_retencao_COFINS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IRPJ_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CSLL_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IPI_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CPP_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ICMS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ISS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_PIS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_Total_anexo_1" class="col border">R$ 0,00</div>
                                </div>  

                                <div class="row">
                                    <div class="col border">Com Retenção</div>
                                    <div id="col_com_retencao_COFINS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IRPJ_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CSLL_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IPI_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CPP_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ICMS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ISS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_PIS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_Total_anexo_1" class="col border">R$ 0,00</div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col border">DAS</div>
                                    <div id="col_DAS_COFINS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IRPJ_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CSLL_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IPI_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CPP_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ICMS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ISS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_PIS_anexo_1" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_Total_anexo_1" class="col border">R$ 0,00</div>
                                </div>    
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Anexo 1 -->

                <!-- Início Anexo 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="painel_titulo_anexo_2">
                        <button style="font-size: 100%;" class="accordion-button collapsed fs3" type="button" data-bs-toggle="collapse" data-bs-target="#painel_anexo_2" aria-expanded="false" aria-controls="painel_anexo_2">
                            Anexo 2(Indústria)
                        </button>
                    </h2>
                    <div id="painel_anexo_2" class="accordion-collapse collapse" aria-labelledby="painel_titulo_anexo_2">
                        <div class="accordion-body">
                            <form class="row mb-3">
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" for="">Folha</label>
                                    <input name="folha_anexo_2" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>-->
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor sem retenção</label>
                                    <input name="faturamento_sem_retencao_anexo_2" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor com retenção</label>
                                    <input name="faturamento_com_retencao_anexo_2" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" >RBT12</label>
                                    <input name="rbt12" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2 d-flex align-items-end justify-content-start">
                                    <button id="btn_calcular_simples_anexo_2" type="button" class="btn btn-primary fs-3">Calcular</button>
                                </div>-->
                            </form>

                            <div class="row">
                                
                                <div class="row mb-3">
                                    <div id="div_aliquota_anexo_2">Aliquota: 0%</div>
                                    <div class='col-4' id="div_aliquota_retencao_anexo_2">Aliquota: 0%</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Tipo</div>
                                    <div class="col border">COFINS</div>
                                    <div class="col border">IRPJ</div>
                                    <div class="col border">CSLL</div>
                                    <div class="col border">IPI</div>
                                    <div class="col border">CPP</div>
                                    <div class="col border">ICMS</div>
                                    <div class="col border">ISS</div>
                                    <div class="col border">PIS</div>
                                    <div class="col border">Total</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Sem Retenção</div>
                                    <div id="col_sem_retencao_COFINS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IRPJ_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CSLL_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IPI_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CPP_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ICMS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ISS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_PIS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_Total_anexo_2" class="col border">R$ 0,00</div>
                                </div>  

                                <div class="row">
                                    <div class="col border">Com Retenção</div>
                                    <div id="col_com_retencao_COFINS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IRPJ_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CSLL_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IPI_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CPP_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ICMS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ISS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_PIS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_Total_anexo_2" class="col border">R$ 0,00</div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col border">DAS</div>
                                    <div id="col_DAS_COFINS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IRPJ_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CSLL_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IPI_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CPP_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ICMS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ISS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_PIS_anexo_2" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_Total_anexo_2" class="col border">R$ 0,00</div>
                                </div>    
                                
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Fim Anexo 2 -->

                <!-- Início Anexo 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="painel_titulo_anexo_3">
                        <button style="font-size: 100%;" class="accordion-button collapsed fs3" type="button" data-bs-toggle="collapse" data-bs-target="#painel_anexo_3" aria-expanded="false" aria-controls="painel_anexo_3">
                            Anexo 3(Serviços)
                        </button>
                    </h2>
                    <div id="painel_anexo_3" class="accordion-collapse collapse" aria-labelledby="painel_titulo_anexo_3">
                        <div class="accordion-body">
                            <form class="row mb-3">
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" for="">Folha</label>
                                    <input name="folha_anexo_3" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>-->
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor sem retenção</label>
                                    <input name="faturamento_sem_retencao_anexo_3" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor com retenção</label>
                                    <input name="faturamento_com_retencao_anexo_3" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" >RBT12</label>
                                    <input name="rbt12" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2 d-flex align-items-end justify-content-start">
                                    <button id="btn_calcular_simples_anexo_3" type="button" class="btn btn-primary fs-3">Calcular</button>
                                </div>-->
                            </form>

                            <div class="row">
                                
                                <div class="row mb-3">
                                    <div id="div_aliquota_anexo_3">Aliquota: 0%</div>
                                    <div class='col-4' id="div_aliquota_retencao_anexo_3">Aliquota: 0%</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Tipo</div>
                                    <div class="col border">COFINS</div>
                                    <div class="col border">IRPJ</div>
                                    <div class="col border">CSLL</div>
                                    <div class="col border">IPI</div>
                                    <div class="col border">CPP</div>
                                    <div class="col border">ICMS</div>
                                    <div class="col border">ISS</div>
                                    <div class="col border">PIS</div>
                                    <div class="col border">Total</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Sem Retenção</div>
                                    <div id="col_sem_retencao_COFINS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IRPJ_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CSLL_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IPI_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CPP_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ICMS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ISS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_PIS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_Total_anexo_3" class="col border">R$ 0,00</div>
                                </div>  

                                <div class="row">
                                    <div class="col border">Com Retenção</div>
                                    <div id="col_com_retencao_COFINS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IRPJ_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CSLL_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IPI_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CPP_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ICMS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ISS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_PIS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_Total_anexo_3" class="col border">R$ 0,00</div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col border">DAS</div>
                                    <div id="col_DAS_COFINS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IRPJ_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CSLL_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IPI_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CPP_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ICMS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ISS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_PIS_anexo_3" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_Total_anexo_3" class="col border">R$ 0,00</div>
                                </div>    
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Anexo 3 -->

                <!-- Início Anexo 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="painel_titulo_anexo_4">
                        <button style="font-size: 100%;" class="accordion-button collapsed fs3" type="button" data-bs-toggle="collapse" data-bs-target="#painel_anexo_4" aria-expanded="false" aria-controls="painel_anexo_4">
                            Anexo 4(Serviços)
                        </button>
                    </h2>
                    <div id="painel_anexo_4" class="accordion-collapse collapse" aria-labelledby="painel_titulo_anexo_4">
                        <div class="accordion-body">
                            <form class="row mb-3">
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" for="">Folha</label>
                                    <input name="folha_anexo_4" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>-->
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor sem retenção</label>
                                    <input name="faturamento_sem_retencao_anexo_4" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor com retenção</label>
                                    <input name="faturamento_com_retencao_anexo_4" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" >RBT12</label>
                                    <input name="rbt12" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2 d-flex align-items-end justify-content-start">
                                    <button id="btn_calcular_simples_anexo_4" type="button" class="btn btn-primary fs-3">Calcular</button>
                                </div>-->
                            </form>

                            <div class="row">
                                
                                <div class="row mb-3">
                                    <div id="div_aliquota_anexo_4">Aliquota: 0%</div>
                                    <div class='col-4' id="div_aliquota_retencao_anexo_4">Aliquota: 0%</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Tipo</div>
                                    <div class="col border">COFINS</div>
                                    <div class="col border">IRPJ</div>
                                    <div class="col border">CSLL</div>
                                    <div class="col border">IPI</div>
                                    <div class="col border">CPP</div>
                                    <div class="col border">ICMS</div>
                                    <div class="col border">ISS</div>
                                    <div class="col border">PIS</div>
                                    <div class="col border">Total</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Sem Retenção</div>
                                    <div id="col_sem_retencao_COFINS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IRPJ_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CSLL_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IPI_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CPP_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ICMS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ISS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_PIS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_Total_anexo_4" class="col border">R$ 0,00</div>
                                </div>  

                                <div class="row">
                                    <div class="col border">Com Retenção</div>
                                    <div id="col_com_retencao_COFINS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IRPJ_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CSLL_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IPI_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CPP_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ICMS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ISS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_PIS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_Total_anexo_4" class="col border">R$ 0,00</div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col border">DAS</div>
                                    <div id="col_DAS_COFINS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IRPJ_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CSLL_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IPI_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CPP_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ICMS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ISS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_PIS_anexo_4" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_Total_anexo_4" class="col border">R$ 0,00</div>
                                </div>    
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Anexo 4 -->

                <!-- Início Anexo 5 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="painel_titulo_anexo_5">
                        <button style="font-size: 100%;" class="accordion-button collapsed fs3" type="button" data-bs-toggle="collapse" data-bs-target="#painel_anexo_5" aria-expanded="false" aria-controls="painel_anexo_5">
                            Anexo 5(Serviços)
                        </button>
                    </h2>
                    <div id="painel_anexo_5" class="accordion-collapse collapse" aria-labelledby="painel_titulo_anexo_5">
                        <div class="accordion-body">
                            <form class="row mb-3">
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" for="">Folha</label>
                                    <input name="folha_anexo_5" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>-->
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor sem retenção</label>
                                    <input name="faturamento_sem_retencao_anexo_5" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2">
                                    <label class="form-label" >Valor com retenção</label>
                                    <input name="faturamento_com_retencao_anexo_5" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <!--<div class="col-lg mb-2">
                                    <label class="form-label" >RBT12</label>
                                    <input name="rbt12" class="form-control fs-3" type="text"
                                        maxlength="18"
                                        size="18"
                                        oninput="mascaraDinheiro(this);"
                                        onkeypress="mascaraDinheiro(this);"
                                        autocomplete=off
                                    />
                                </div>
                                <div class="col-lg mb-2 d-flex align-items-end justify-content-start">
                                    <button id="btn_calcular_simples_anexo_5" type="button" class="btn btn-primary fs-3">Calcular</button>
                                </div>-->
                            </form>

                            <div class="row">
                                
                                <div class="row mb-3">
                                    <div id="div_aliquota_anexo_5">Aliquota: 0%</div>
                                    <div class='col-4' id="div_aliquota_retencao_anexo_5">Aliquota: 0%</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Tipo</div>
                                    <div class="col border">COFINS</div>
                                    <div class="col border">IRPJ</div>
                                    <div class="col border">CSLL</div>
                                    <div class="col border">IPI</div>
                                    <div class="col border">CPP</div>
                                    <div class="col border">ICMS</div>
                                    <div class="col border">ISS</div>
                                    <div class="col border">PIS</div>
                                    <div class="col border">Total</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col border">Sem Retenção</div>
                                    <div id="col_sem_retencao_COFINS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IRPJ_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CSLL_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_IPI_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_CPP_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ICMS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_ISS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_PIS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_sem_retencao_Total_anexo_5" class="col border">R$ 0,00</div>
                                </div>  

                                <div class="row">
                                    <div class="col border">Com Retenção</div>
                                    <div id="col_com_retencao_COFINS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IRPJ_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CSLL_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_IPI_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_CPP_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ICMS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_ISS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_PIS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_com_retencao_Total_anexo_5" class="col border">R$ 0,00</div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col border">DAS</div>
                                    <div id="col_DAS_COFINS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IRPJ_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CSLL_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_IPI_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_CPP_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ICMS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_ISS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_PIS_anexo_5" class="col border">R$ 0,00</div>
                                    <div id="col_DAS_Total_anexo_5" class="col border">R$ 0,00</div>
                                </div>    
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Anexo 5 -->
            
            </div>

        </div>
    </div>
  </div>
</div>
<!-- Fim Modal -->
<div class="container-lg">
    <div class="container-fluid">
        <div class="transactionBoxi">
            <div class="main-texti">
                <h2>Simples Nacional Consulta</h2>
                <div class="legend-boxi">
                    <a href="">Anterior</a>
                    <a href="" class="active">Hoje</a>
                </div>
                <div class="input-group-search">
                    <input type="search" placeholder="Pesquisar na Tabela...">
                    <!--<i class="bi bi-search"></i>-->
                     <img src="<?php echo(DIRIMG."CalcularSimples/DAS/search.svg"); ?>" alt=""> 
                </div>
    
                <div class="export__file" id="export__file">
                    <div class="testeeee">
                        <label for="export-file" class="export__file-btn" title="Export File">
                            <img src="https://ivici.com.br/homolog/public/img/Home/folder.svg" alt="">
                        </label>
                    </div>
                    <div class="export__file-options" id="export__file-options">
                        <label>Export As <i class="bi bi-cloud-arrow-down-fill"></i></label>
                        <label for="export-file" id="toPDF">PDF <img src="https://ivici.com.br/homolog/public/img/Home/pdf.svg" alt=""></label>
                        <label for="export-file" id="toCSV">CSV <img src="https://ivici.com.br/homolog/public/img/Home/csv.svg" alt=""></label>
                        <label for="export-file" id="toJSON">JSON <img src="https://ivici.com.br/homolog/public/img/Home/json.png" alt=""></label>
                        <label for="export-file" id="toEXCEL">EXCEL <img src="https://ivici.com.br/homolog/public/img/Home/excel.svg" alt=""></label>
                    </div>
                </div>
            </div>
            <table id="tabela_RBT12">
                <thead>
                    <tr>
                        <th class="text-thead"> Status <span class="icon-arrow">&UpArrow;</span></th>
                        <th class="text-thead">Últ. Período <span class="icon-arrow">&UpArrow;</span></th>
                        <th class="text-thead"> RBT12 <span class="icon-arrow">&UpArrow;</span></th>
                        <th class="text-thead"> DAS <span class="icon-arrow">&UpArrow;</span></th>
                        <th class="text-thead"> CNPJ | CPF <span class="icon-arrow">&UpArrow;</span></th>
                        <th class="text-thead"> Razão social | Nome <span class="icon-arrow">&UpArrow;</span></th>
                        <!--<th class="text-thead"> Enviado <span class="icon-arrow">&UpArrow;</span></th>-->
                        <th class="text-thead"> Ultima Busca <span class="icon-arrow">&UpArrow;</span></th>
                        <th class="text-thead"> Ações <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table> 
        </div>
    </div>
</div>
<!--<div class="containeri">-->
<!--    <section class="table tabela customers_table">-->

<!--        <div class="table__header">-->
<!--            <h1 class="text-thead">PAG | REC | NT 1</h1>-->
<!--            <div class="input-group">-->
<!--                <input type="search" placeholder="Pesquisar na Tabela...">-->
                <!--<i class="bi bi-search"></i>-->
<!--                 <img src="<?php echo(DIRIMG."CalcularSimples/DAS/search.svg"); ?>" alt=""> -->
<!--            </div>-->
<!--            <div class="export__file">-->
<!--                <label for="export-file" class="export__file-btn" title="Export File"><img src="./img/folders.svg" alt="" width="32px"></label>-->
<!--                <input type="checkbox" id="export-file">-->
<!--                <div class="export__file-options">-->
<!--                    <label>baixar Em</label>-->
<!--                    <label for="export-file" id="toEXCEL">EXCEL <img src="<?php echo(DIRIMG."CalcularSimples/DAS/excel.svg"); ?>" alt=""></label>-->
<!--                    <label for="export-file" id="toPDF">PDF <img src="<?php echo(DIRIMG."CalcularSimples/DAS/pdf.svg"); ?>" alt=""></label>-->
<!--                    <label for="export-file" id="toCSV">CSV <img src="<?php echo(DIRIMG."CalcularSimples/DAS/csv.svg"); ?>" alt=""></label>-->
<!--                    <label for="export-file" id="toJSON">JSON <img src="<?php echo(DIRIMG."CalcularSimples/DAS/json.png"); ?>" alt=""></label>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

<!--        <div class="table__body">-->
<!--            <table>-->
<!--                <thead>-->
<!--                    <tr>-->
<!--                        <th class="text-thead"> Status <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                        <th class="text-thead">Últ. Período <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                        <th class="text-thead"> RBT12 <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                        <th class="text-thead"> DAS <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                        <th class="text-thead"> CNPJ | CPF <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                        <th class="text-thead"> Razão social | Nome <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                        <th class="text-thead"> Enviado <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                        <th class="text-thead"> Ultima Busca <span class="icon-arrow">&UpArrow;</span></th>-->
<!--                    </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
                    
<!--                </tbody>-->
<!--            </table> -->
<!--        </div>-->

<!--    </section>-->
<!--</div>-->