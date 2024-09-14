//AJAX
function EmitirNotas() {
    let form = $('#formEmitirNota')[0];
    let formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+"/emitirNFSE"),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        datatype:"json",
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            console.log(data);
            $('.overlayk-loading').fadeOut();
            const divMenssage = document.querySelector("#menssage");
            if(data.erros.length>0){
                for(let i=0;i<=data.erros.length-1;i++){
                    var divAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    divAlert += data.erros[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }
            }
            if(data.sucessos.length>0){
                for(let i=0;i<=data.sucessos.length-1;i++){
                    var divAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    divAlert += data.sucessos[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }
            }
        },
        error: function(texto1, texto2, texto3){
            $('.overlayk-loading').fadeOut();
            console.log(texto1+" "+texto2+" "+texto3 );
        }
    });
}

function PagarNota(){
    // $('.overlayk-loading').fadeIn("slow",function(){
    //     console.log('Funcionou');
    // });
    window.location.href = 'checkout-pagamento';
    // $('.overlayk-loading').fadeOut("slow",function(){
    //     console.log('acabou');
    // });
}

function printNota(element){
  
    janela = window.open('Nota Fiscal','_blank','name=NotaFiscal,width=800,height=800');
    html = '<html>';
    html += '<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"></head>'
    html += '<body class="p-4">';
    html += element.innerHTML;
    html += '</body>';
    html += '</html>';
    janela.document.write(html);
    janela.document.close();
    janela.addEventListener('load',()=>{
        janela.print();
        janela.document.body.innerHTML='';
        janela.close();
    });
    
}

function escreverNota(){
    
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    
    var optionsPJ = document.querySelectorAll("select[name=PJ] option");
    for(let i=0;i<=optionsPJ.length-1;i++){
        if(optionsPJ[i].value==formData.get('PJ') && optionsPJ[i].value!=''){
            document.querySelector("span#nomePrestadorSpan").innerHTML=optionsPJ[i].innerText.toUpperCase();
        }
    }
    
    var optionsAtividade = document.querySelectorAll("select[name=atividade] option");
    for(let i=0;i<=optionsAtividade.length-1;i++){
        if(optionsAtividade[i].value==formData.get('atividade') && optionsAtividade[i].value!=''){
            document.querySelector("span#atividadeSpan").innerHTML=formData.get('atividade')+' - '+optionsAtividade[i].innerText.toUpperCase();
        }
    }
    
    var optionsCodServico = document.querySelectorAll("select[name=codServico] option");
    for(let i=0;i<=optionsCodServico.length-1;i++){
        if(optionsCodServico[i].value==formData.get('codServico') && optionsCodServico[i].value!=''){
            document.querySelector("span#cnaeSpan").innerHTML=optionsCodServico[i].innerText.toUpperCase();
        }
    }
    
    document.querySelector("span#cpfCnpjPrestadorSpan").innerHTML=' '+formData.get('PJ');
    document.querySelector("span#cpfCnpjTomadorSpan").innerHTML=' '+formData.get('CpfCnpjTomador');
    document.querySelector("span#nomeTomadorSpan").innerHTML=' '+formData.get('nomeTomador').toUpperCase();
    document.querySelector("span#valorSpan").innerHTML=' R$ '+formData.get('ValorTotalDosServicos');
}

function getInformacoesAnexo(){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    if(formData.get("RBT12")=="" || formData.get("anexo")==""){
        
    }else{
        $.ajax({
            'url':getRoot('teste/getInformacoesAnexo'),
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
    if(cnpj===""){
        
    }else{
        
        if(cnpjValidation(cnpj)===false){
            
        }else{
            var a = $.ajax({
                'url':'https://receitaws.com.br/v1/cnpj/'+ cnpj.replace(/[^0-9]/g, ''),
                'type':"GET",
                'dataType':'jsonp',
                'success': function(data){
                    //console.log(data);
                    const servico = document.querySelector("select#atividade");
                    servico.innerHTML='';
                    //servico.innerHTML='<option value="">Selecione uma opção</option>';
                    //console.log(servico);
                    if(data.atividade_principal.length>0){
                        servico.innerHTML='';
                        for(let i=0;i<=(data.atividade_principal.length-1);i++){
                            option = document.createElement("option");
                            option.value=data.atividade_principal[i].code.replace(/[^0-9]/g, '');
                            option.innerHTML=data.atividade_principal[i].text;
                            servico.appendChild(option);
                        }
                    }
                    if(data.atividades_secundarias.length>0){
                        //servico.innerHTML='';
                        for(let i=0;i<=(data.atividades_secundarias.length-1);i++){
                            option = document.createElement("option");
                            option.value=data.atividades_secundarias[i].code.replace(/[^0-9]/g, '');
                            option.innerHTML=data.atividades_secundarias[i].text;
                            servico.appendChild(option);
                        }
                    }
                    localStorage.setItem('confirmaCarregamento',parseInt(localStorage.getItem('confirmaCarregamento'))+1);
                },
                'error': (jqXhr, textStatus, errorMessage)=>{
                    console.log(jqXhr+" "+textStatus+" "+errorMessage);
                    localStorage.setItem('negaCarregamento',parseInt(localStorage.getItem('negaCarregamento'))+1);
                }
            });
            //console.log(a.then());
        }
        
    }
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

function getNaturezaOperacao(cnpj){
    if(cnpj===""){
        
    }else{
        if(cnpjValidation(cnpj)===false){
            
        }else{
            var form = $('#formEmitirNota')[0];
            var formData = new FormData(form);
            $.ajax({
                'url':getRoot(getURL()+"/getNaturezaOperacao"),
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
                    //naturezaOperacao.innerHTML="<option value=''>Selecione uma opção</option>";
                    if(data.NaturezaOperacao.length>0){
                        naturezaOperacao.innerHTML='';
                        for(let i=0;i<=(data.NaturezaOperacao.length-1);i++){
                            naturezaOperacao.innerHTML+="<option value='"+data.NaturezaOperacao[i].CodigoNaPrefeitura+"'>"+data.NaturezaOperacao[i].DescricaoNatureza+"</option>";
                        }
                        localStorage.setItem('confirmaCarregamento',parseInt(localStorage.getItem('confirmaCarregamento'))+1);
                    }
                },
                 error:function(p1,p2,p3){
                    console.log(p1+" "+p2+" "+p3);
                    localStorage.setItem('negaCarregamento',parseInt(localStorage.getItem('negaCarregamento'))+1);
                }
            });
            
        }
    }
    
}

function getServico(cnpj){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    $.ajax({
        'url':getRoot(getURL()+"/getServicos"),
        'type':"POST",
        'dataType':'json',
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData: false,
        contentType:false,
        'success': function(data){
            console.log(data);
            const selectServico = document.querySelector("select[name=codServico]");
            //selectServico.innerHTML='';
            //selectServico.innerHTML+="<option value=''>Selecione uma opção</option>";
            if(data.erros.length>0){
                
            }else{
                if(data.dados!=false){
                    selectServico.innerHTML='';
                    //selectServico.innerHTML+="<option value=''>Selecione uma opção</option>";
                    for(let i=0;i<=(data.dados.length-1);i++){
                        selectServico.innerHTML+="<option value='"+data.dados[i].Codigo+"'>"+data.dados[i].Codigo+" - "+data.dados[i].Descricao+"</option>";
                    }
                    
                    localStorage.setItem('confirmaCarregamento',parseInt(localStorage.getItem('confirmaCarregamento'))+1);
                }
            }
            
        },
        error:function(p1,p2,p3){
            console.log(p1+" "+p2+" "+p3);
            localStorage.setItem('negaCarregamento',parseInt(localStorage.getItem('negaCarregamento'))+1);
        }
    });
}

function getTributosMunicipais(value){
    var form = $('#formEmitirNota')[0];
    var formData = new FormData(form);
    $.ajax({
        'url':getRoot('teste/getTributosMunicipais'),
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
                //selectTribMunicipal.innerHTML+="<option value=''>Selecione uma opção</option>";
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

function getUltimaSerie(cnpj){
    if(cnpj!=""){
        var form = $('#formEmitirNota')[0];
        var formData = new FormData(form);
        $.ajax({
            'url':getRoot(getURL()+'/consultarUltimoRPS'),
            'type':"POST",
            'dataType':'json',
            data: formData,
            timeout:(60*1000),
            cache:false,
            processData: false,
            contentType:false,
            'success': function(data){
               console.log(data); 
            },
            error:function(p1,p2,p3){
                console.log(p1+" "+p2+" "+p3);
            }
        });
    }
}

const radio1 = document.getElementById('parcelasim');
const radio2 = document.getElementById('parcelanao');
const fieldset = document.getElementById('parcelas');

radio1.addEventListener("click", ()=>{fieldset.disabled=false;});

radio2.addEventListener("click", ()=>{fieldset.disabled=true;});