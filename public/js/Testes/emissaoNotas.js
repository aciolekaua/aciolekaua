//AJAX
function EmitirNotas() {
    let form = $('#formEmitirNota')[0];
    let formData = new FormData(form);
    $.ajax({
        url:getRoot("cash/teste/nfseAPI"),
        type:"POST",
        datatype:"json",
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            console.log(data)
        },
        error: function(texto1, texto2, texto3){
            console.log(texto1+" "+texto2+" "+texto3 );
        }
    });
}

function getInformacoesAnexo(){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    if(formData.get("RBT12")=="" || formData.get("anexo")==""){
        
    }else{
        $.ajax({
            'url':getRoot('cash/teste/getInformacoesAnexo'),
            'type':"POST",
            'dataType':'json',
            data: formData,
            timeout:(1*60*1000),
            cache:false,
            processData: false,
            contentType:false,
            'success': function(data){
                console.log(data);
                if(data.dados!=false){
                    form.querySelector('input[name=aliquota]').value=data.dados[0].Aliquota.replace('.',',');
                    var deducao = form.querySelector('input[name=ValorTotalDasDeducoes]');
                    deducao.value=data.dados[0].Deducao.replace('.','');
                    mascaraDinheiro(deducao);
                }
            },
            error:function(p1,p2,p3){
                console.log(p1+" "+p2+" "+p3);
            }
        });    
    }
    
}

function getAtividade(cnpj){
    $.ajax({
        'url':'https://receitaws.com.br/v1/cnpj/'+ cnpj.replace(/[^0-9]/g, ''),
        'type':"GET",
        'dataType':'jsonp',
        'success': function(data){
            console.log(data);
            const servico = document.querySelector("select#atividade");
            servico.innerHTML='';
            servico.innerHTML='<option value="">Selecione uma opção</option>';
            //console.log(servico);
            if(data.atividade_principal.length>0){
                for(let i=0;i<=(data.atividade_principal.length-1);i++){
                    option = document.createElement("option");
                    option.value=data.atividade_principal[i].code.replace(/[^0-9]/g, '');
                    option.innerHTML=data.atividade_principal[i].text;
                    servico.appendChild(option);
                }
            }
            if(data.atividades_secundarias.length>0){
                for(let i=0;i<=(data.atividades_secundarias.length-1);i++){
                    option = document.createElement("option");
                    option.value=data.atividades_secundarias[i].code.replace(/[^0-9]/g, '');
                    option.innerHTML=data.atividades_secundarias[i].text;
                    servico.appendChild(option);
                }
            }
        }
    });
}

function Atividade(servico){
    //console.log(servico.slice(0,-2));
    $.ajax({
        'url':'https://servicodados.ibge.gov.br/api/v2/cnae/classes/'+servico.slice(0,-2),
        'type':"GET",
        'dataType':'json',
        'success': function(data){
            console.log(data);
        }
    });
}

function getNaturezaOperacao(element){
    var tamanho = parseInt(element.getAttribute("maxlength"));
    if(element.value.length==(tamanho-1)){
            
        var form = $('#formEmitirNota')[0];
        var formData = new FormData(form);
        $.ajax({
            'url':getRoot('cash/teste/getNaturezaOperacao'),
            'type':"POST",
            'dataType':'json',
            data: formData,
            timeout:(60*1000),
            cache:false,
            processData: false,
            contentType:false,
            'success': function(data){
                console.log(data);
                const naturezaOperacao = document.querySelector("select#naturezaOperacao");
                naturezaOperacao.innerHTML="<option value=''>Selecione uma opção</option>";
                if(data.Codigo==null){
                    for(let i=0;i<=(data.NaturezaOperacao.length-1);i++){
                        naturezaOperacao.innerHTML+="<option value='"+data.NaturezaOperacao[i].CodigoNaPrefeitura+"'>"+data.NaturezaOperacao[i].DescricaoNatureza+"</option>";
                    }
                }
                //naturezaOperacao
            },
             error:function(p1,p2,p3){
                console.log(p1+" "+p2+" "+p3);
            }
        });
        
    }
}

function getServico(value){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    $.ajax({
        'url':getRoot('cash/teste/getServico'),
        'type':"POST",
        'dataType':'json',
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData: false,
        contentType:false,
        'success': function(data){
            console.log(data);
            const selectServico = document.querySelector("select#selectServico");
            if(data.erros.length>0){
                
            }
            if(data.dados!=false){
                selectServico.innerHTML='';
                selectServico.innerHTML+="<option value=''>Selecione uma opção</option>";
                for(let i=0;i<=(data.dados.length-1);i++){
                    selectServico.innerHTML+="<option value='"+data.dados[i].Codigo+"'>"+data.dados[i].Codigo+" - "+data.dados[i].Descricao+"</option>";
                }
            }else{
                selectServico.innerHTML='';
                selectServico.innerHTML+="<option value=''>Selecione uma opção</option>";
            }
        },
        error:function(p1,p2,p3){
            console.log(p1+" "+p2+" "+p3);
        }
    });
}

function getTributosMunicipais(value){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    $.ajax({
        'url':getRoot('cash/teste/getTributosMunicipais'),
        'type':"POST",
        'dataType':'json',
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData: false,
        contentType:false,
        'success': function(data){
            console.log(data);
            const selectTribMunicipal = document.querySelector("select#codTribMunicipal");
            if(data.erros.length>0){
                
            }
            if(data.dados!=false){
                selectTribMunicipal.innerHTML='';
                selectTribMunicipal.innerHTML+="<option value=''>Selecione uma opção</option>";
                for(let i=0;i<=(data.dados.length-1);i++){
                    selectTribMunicipal.innerHTML+="<option value='"+data.dados[i].Codigo+"'>"+data.dados[i].Codigo+" - "+data.dados[i].Descricao+"</option>";
                }
            }else{
                selectTribMunicipal.innerHTML='';
                selectTribMunicipal.innerHTML+="<option value=''>Selecione uma opção</option>";
            }
        },
        error:function(p1,p2,p3){
            console.log(p1+" "+p2+" "+p3);
        }
    });
}

function getCNAE(){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    $.ajax({
        'url':getRoot('cash/teste/getCNAE'),
        'type':"POST",
        'dataType':'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        'success': function(data){
            console.log(data);
            if(data.dados.length>0){
                const anexo = document.querySelector('select[name=anexo]');
                //const aliquota = document.querySelector('input[name=aliquota]');
                
                //aliquota.innerHTML='<option>Escolha uma opção</option>';
                anexo.innerHTML='<option value="">Selecione uma opção</option>';
                
                /*for(let i=0;i<=(data.dados.length-1);i++){
                    aliquota.innerHTML+='<option value="+'+data.dados[i].aliquota+'+">'+data.dados[i].aliquota+'</option>';
                }*/
                
                for(let i=0;i<=(data.dados.length-1);i++){
                    anexo.innerHTML+='<option value="'+data.dados[i].anexo+'">'+data.dados[i].anexo+'</option>';
                }
            }
        },
        error:function(p1,p2,p3){
            console.log(p1+" "+p2+" "+p3);
        }
    });
}

function optanteNacional(){
    const arrayImposto = ['ISS','COFINS','CSLL','IRPJ','PIS','CPP','IPI','ICMS'];
    var simplesNacional = document.querySelector('select[name=simplesNacional]');
    if(simplesNacional.value=="1"){
        for(let i=0;i<=arrayImposto.length-1;i++){
            document.querySelector('input[name='+arrayImposto[i]+'Valor]').disabled=true;
            if(arrayImposto[i]!="ISS"){document.querySelector('input[name='+arrayImposto[i]+'Percentual]').disabled=true;}
            if(arrayImposto[i]=="ISS"){
                document.querySelector('input[name='+arrayImposto[i]+'Percentual]').value=5;
                percentualDecimal(
                    document.querySelector('input[name='+arrayImposto[i]+'Percentual]'),
                    document.querySelector('input[name='+arrayImposto[i]+'Decimal]')
                );
            }
        }
    }else{
        for(let i=0;i<=arrayImposto.length-1;i++){
            document.querySelector('input[name='+arrayImposto[i]+'Valor]').disabled=false;
            document.querySelector('input[name='+arrayImposto[i]+'Percentual]').disabled=false;
        }
    }
    
    if(simplesNacional.value=="1"){
        for(let i=0;i<=arrayImposto.length-1;i++){
            var checkboxRetido = document.querySelector('input[name='+arrayImposto[i].toLowerCase()+'Retido]');
            checkboxRetido.addEventListener('click',()=>{
                var inputValue = document.querySelector('input[name='+arrayImposto[i]+'Valor]');
                var inputPercentual = document.querySelector('input[name='+arrayImposto[i]+'Percentual]');
                if(inputValue.disabled || inputPercentual.disabled){
                    inputValue.disabled=false;
                    inputPercentual.disabled=false;
                }else{
                    inputValue.disabled=true;
                    if(arrayImposto[i]!="ISS"){inputPercentual.disabled=true;}
                }
            });
        }
    }else if(simplesNacional.value=="2"){
        
    }
}



function calcularSimples(){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    
    $.ajax({
        url:getRoot("cash/teste/calcularSimples"),
        type: "POST",
        dataType: 'json',
        data: formData,
        timeout: (1*60*1000),
        cache: false,
        processData: false,
        contentType: false,
        'success': function(data){
            console.log(data);
            if(data.erros.length>0){
                
            }else{
                const COFINSValor = document.querySelector("input[name=COFINSValor]");
                const COFINSPercentual = document.querySelector("input[name=COFINSPercentual]");
                const COFINSDecimal = document.querySelector("input[name=COFINSDecimal]");
                if(data.dadosAliquota.COFINS.COFINS_ValorImposto!=null){
                    COFINSValor.value = data.dadosAliquota.COFINS.COFINS_ValorImposto;
                    mascaraDinheiro(COFINSValor);
                }else{COFINSValor.value = "0,00";}
                
                if(data.dadosAliquota.COFINS.COFINS_Percentual!=null){
                    COFINSPercentual.value = data.dadosAliquota.COFINS.COFINS_Percentual;
                }else{COFINSPercentual.value = 0.00;}
                
                if(data.dadosAliquota.COFINS.COFINS_Decimal!=null){
                    COFINSDecimal.value = data.dadosAliquota.COFINS.COFINS_Decimal;
                }else{COFINSDecimal.value = 0.00;}
                
                const CSLLValor = document.querySelector("input[name=CSLLValor]");
                const CSLLPercentual = document.querySelector("input[name=CSLLPercentual]");
                const CSLLDecimal = document.querySelector("input[name=CSLLDecimal]");
                if(data.dadosAliquota.CSLL.CSLL_ValorImposto!=null){
                    CSLLValor.value=data.dadosAliquota.CSLL.CSLL_ValorImposto;
                    mascaraDinheiro(CSLLValor);
                }
                if(data.dadosAliquota.CSLL.CSLL_Percentual!=null){
                    CSLLPercentual.value = data.dadosAliquota.CSLL.CSLL_Percentual;
                }
                if(data.dadosAliquota.CSLL.CSLL_Decimal!=null){
                    CSLLDecimal.value = data.dadosAliquota.CSLL.CSLL_Decimal;
                }
                
                const ISSValor = document.querySelector("input[name=ISSValor]");
                const ISSPercentual = document.querySelector("input[name=ISSPercentual]");
                const ISSDecimal = document.querySelector("input[name=ISSDecimal]");
                if(data.dadosAliquota.ISS.ISS_ValorImposto!=null){
                    ISSValor.value=data.dadosAliquota.ISS.ISS_ValorImposto;
                    mascaraDinheiro(ISSValor);
                }else{ISSValor.value = "0,00";}
                
                if(data.dadosAliquota.ISS.ISS_Percentual!=null){
                    ISSPercentual.value = data.dadosAliquota.ISS.ISS_Percentual;
                }else{ISSPercentual.value = 0.00;}
                
                if(data.dadosAliquota.ISS.ISS_Decimal!=null){
                    ISSDecimal.value = data.dadosAliquota.ISS.ISS_Decimal;
                }else{ISSDecimal.value = 0.00;}
                
                const IRPJValor = document.querySelector("input[name=IRPJValor]");
                const IRPJPercentual = document.querySelector("input[name=IRPJPercentual]");
                const IRPJDecimal = document.querySelector("input[name=IRPJDecimal]");
                if(data.dadosAliquota.IRPJ.IRPJ_ValorImposto!=null){
                    IRPJValor.value=data.dadosAliquota.IRPJ.IRPJ_ValorImposto;
                    mascaraDinheiro(IRPJValor);
                }else{IRPJValor.value = "0,00";}
                
                if(data.dadosAliquota.IRPJ.IRPJ_Percentual!=null){
                    IRPJPercentual.value = data.dadosAliquota.IRPJ.IRPJ_Percentual;
                }else{IRPJPercentual.value = 0.00;}
                
                if(data.dadosAliquota.IRPJ.IRPJ_Decimal!=null){
                    IRPJDecimal.value = data.dadosAliquota.IRPJ.IRPJ_Decimal;
                }else{IRPJDecimal.value = 0.00;}
                
                const PISValor = document.querySelector("input[name=PISValor]");
                const PISPercentual = document.querySelector("input[name=PISPercentual]");
                const PISDecimal = document.querySelector("input[name=PISDecimal]");
                if(data.dadosAliquota.PIS.PIS_ValorImposto!=null){
                    PISValor.value=data.dadosAliquota.PIS.PIS_ValorImposto;
                    mascaraDinheiro(PISValor);
                }else{PISValor.value = "0,00";}
                
                if(data.dadosAliquota.PIS.PIS_Percentual!=null){
                    PISPercentual.value = data.dadosAliquota.PIS.PIS_Percentual;
                }else{ PISPercentual.value = 0.00;}
                
                if(data.dadosAliquota.PIS.PIS_Decimal!=null){
                    PISDecimal.value = data.dadosAliquota.PIS.PIS_Decimal;
                }else{PISDecimal.value = 0.00;}
                
                const CPPValor = document.querySelector("input[name=CPPValor]");
                const CPPPercentual = document.querySelector("input[name=CPPPercentual]");
                const CPPDecimal = document.querySelector("input[name=CPPDecimal]");
                if(data.dadosAliquota.CPP.CPP_ValorImposto!=null){
                    CPPValor.value=data.dadosAliquota.CPP.CPP_ValorImposto;
                    mascaraDinheiro(CPPValor);
                }else{CPPValor.value = "0,00";}
                
                if(data.dadosAliquota.CPP.CPP_Percentual!=null){
                    CPPPercentual.value = data.dadosAliquota.CPP.CPP_Percentual;
                }else{CPPPercentual.value = 0.00;}
                
                if(data.dadosAliquota.CPP.CPP!=null){
                    CPPDecimal.value = data.dadosAliquota.CPP.CPP_Decimal;
                }else{CPPDecimal.value = 0.00;}
                
                const IPIValor = document.querySelector("input[name=IPIValor]");
                const IPIPercentual = document.querySelector("input[name=IPIPercentual]");
                const IPIDecimal = document.querySelector("input[name=IPIDecimal]");
                if(data.dadosAliquota.IPI.IPI_ValorImposto!=null){
                    IPIValor.value = data.dadosAliquota.IPI.IPI_ValorImposto;
                    mascaraDinheiro(IPIValor);
                }else{IPIValor.value ="0,00";}
                
                if(data.dadosAliquota.IPI.IPI_Percentual!=null){
                    IPIPercentual.value = data.dadosAliquota.IPI.IPI_Percentual;
                }else{IPIPercentual.value = 0.00;}
                
                if(data.dadosAliquota.IPI.IPI!=null){
                    IPIDecimal.value = data.dadosAliquota.IPI.IPI_Decimal;
                }else{IPIDecimal.value = 0.00;}
                
                const ICMSValor = document.querySelector("input[name=ICMSValor]");
                const ICMSPercentual = document.querySelector("input[name=ICMSPercentual]");
                const ICMSDecimal = document.querySelector("input[name=ICMSDecimal]");
                if(data.dadosAliquota.ICMS.ICMS_ValorImposto!=null){
                    ICMSValor.value = data.dadosAliquota.ICMS.ICMS_ValorImposto;
                    mascaraDinheiro(ICMSValor);
                }else{ICMSValor.value = "0,00";}
                
                if(data.dadosAliquota.ICMS.ICMS_Percentual!=null){
                    ICMSPercentual.value = data.dadosAliquota.ICMS.ICMS_Percentual;
                }else{ICMSPercentual.value = 0.00;}
                
                if(data.dadosAliquota.ICMS.ICMS!=null){
                    ICMSDecimal.value = data.dadosAliquota.ICMS.ICMS_Decimal;
                }else{ICMSDecimal.value = 0.00;}
                
                const valorTributadoAliquota = document.querySelector("input[name=ValorRecolhidoAliquota]");
                if(data.valorTributadoAliquota!=null){
                    valorTributadoAliquota.value = data.valorTributadoAliquota;
                    mascaraDinheiro(valorTributadoAliquota);
                }
 
            }
        },
        error: function(p1,p2,p3){
            console.log(p1+" "+p2+" "+p3);
        }
    });
    
    /*for (const key of formData.keys()) {
      console.log(key);
    }*/
}

function verificaFiledSetRBT12(){
    var checks = document.querySelectorAll("input.checkboxRetido");
    var fieldsetRBT12 = document.querySelector("fieldset#fieldsetRBT12")
    var cond = false;
    
    for(let i=0;i<=checks.length-1;i++){if(checks[i].checked==true){cond=true;}}
   
    if(cond){
        fieldsetRBT12.disabled=false;
    }else{
        fieldsetRBT12.disabled=true;
    }
}

function percentualDecimal(element,elementDecimal){
    elementDecimal.value=(element.value.replace(",","."))/100;
    console.log(elementDecimal.value);
}

var checks = document.querySelectorAll("input.checkboxRetido");
for(let i=0;i<=checks.length-1;i++){checks[i].addEventListener("change",()=>{verificaFiledSetRBT12();});}

const radio1 = document.getElementById('parcelasim');
const radio2 = document.getElementById('parcelanao');
const fieldset = document.getElementById('parcelas');

radio1.addEventListener("click", ()=>{
    //fieldset.style.display="block";
    fieldset.disabled=false;
});
radio2.addEventListener("click", ()=>{
    //  fieldset.style.display="none";
    fieldset.disabled=true;
});

const radioser1 = document.getElementById('radioServico1');
const radioser2 = document.getElementById('radioServico2')
const fieldsetser = document.getElementById('fieldsetServicos');

const selectServicoFieldset = document.querySelector("fieldset#selectServicoFieldset");

radioser1.addEventListener("click", ()=>{
    //fieldset.style.display="block";
    selectServicoFieldset.disabled=true;
    fieldsetser.disabled=false;
});
radioser2.addEventListener("click", ()=>{
    //  fieldset.style.display="none";
    selectServicoFieldset.disabled=false;
    fieldsetser.disabled=true;
});

const radioTribMunicipal1 = document.querySelector("input#radioTribMunicipal1");
const radioTribMunicipal2 = document.querySelector("input#radioTribMunicipal2");
const fieldsetTribMunicipal = document.getElementById('fieldsetTribMunicipal');

const fieldsetTribMunicipalSelect = document.querySelector("fieldset#selectTributacaoMunicipalFieldset");

radioTribMunicipal1.addEventListener("click", ()=>{
    //fieldset.style.display="block";
    fieldsetTribMunicipalSelect.disabled=true;
    fieldsetTribMunicipal.disabled=false;
});
radioTribMunicipal2.addEventListener("click", ()=>{
    //  fieldset.style.display="none";
    fieldsetTribMunicipalSelect.disabled=false;
    fieldsetTribMunicipal.disabled=true;
});

/*const issRetido = document.querySelectorAll("input[name=issRetido]");
const fieldsetISSRetido = document.querySelector("fieldset#fieldsetIssRetido");

issRetido[0].addEventListener('click',()=>{
    fieldsetISSRetido.disabled=false;
});

issRetido[1].addEventListener('click',()=>{
    fieldsetISSRetido.disabled=true;
});*/