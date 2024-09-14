window.addEventListener('load',()=>{
    getDados();
    
    const fieldsetData = document.querySelector("fieldset#fieldsetData");
    const dataRadio = document.querySelectorAll("input[name=dataRadio]");
    for(let i=0;i<=dataRadio.length-1;i++){
        dataRadio[i].addEventListener("change",()=>{
            if(parseInt(dataRadio[i].value)==0){
                fieldsetData.disabled=false;
            }else{
                fieldsetData.disabled=true;
            }
        });
    }
    
    startTabela();
    
});

function startTabela(){
    return $('#tabelaNotas').DataTable();
}

function getDados(){
    $.ajax({
        url:getRoot(getURL()+"/dados"),
        type:"GET",
        datatype:"json",
        timeout:(1*60*1000),
        success: function(data,status,xhr){
            console.log(data);
            writePJs(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    })
}

function writePJs(data){
    if(data.erros.length>0){
        
    }else{
        if(data.TipoCliente=="PF"){
            if(data.PJs!==false && data.PJs.length>0){
                const PJ = document.querySelector("select[name=PJ]");
                PJ.innerHTML='';
                // PJ.innerHTML+='<option value="">Selecione uma opção</option>';
                for(let i=0;i<=data.PJs.length-1;i++){
                    PJ.innerHTML+="<option value='"+data.PJs[i].CNPJ+"'>"+data.PJs[i].Nome+"</option>";
                }
            }
        }else if(data.TipoCliente=="PJ"){
            const PJ = document.querySelector("select[name=PJ]");
            PJ.innerHTML=`<option value='${data.dados.id}' selected>${data.dados.nomeFantasia}</option>`;
            PJ.style.pointerEvents='none';
            PJ.style.opacity='0.8';
            PJ.style.userSelect='none';
        }
    }
}

function modalCancelaNota(modelo,numero,muneroNFSE,serie){
    //console.log(modelo,numero,muneroNFSE,serie);
    document.querySelector("#modalCancelaNota input[name=modelo]").value=modelo;
    document.querySelector("#modalCancelaNota input[name=numero]").value=numero;
    document.querySelector("#modalCancelaNota input[name=numeroNFSE]").value=muneroNFSE;
    document.querySelector("#modalCancelaNota input[name=serie]").value=serie;
}

function cancelarNota(){
    
    var form = $('#formModalCancelaNota')[0];
    var formData = new FormData(form);
    
    var form2 = $('#consultarNotas')[0];
    var formData2 = new FormData(form2);
    
    var pj = formData2.get('PJ');
    formData.append('PJ',pj);
    
    $.ajax({
        url:getRoot(getURL()+'/cancelarNota'),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            consultarNotas();
          $('.overlayk-loading').fadeOut();
            if(data.erros.length>0){
                const divMenssage = document.querySelector("#menssage");
                
                for(let i=0;i<=data.erros.length-1;i++){
                    var divAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    divAlert += data.erros[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }

            }
            if(data.sucessos.length>0){
                const divMenssage = document.querySelector("#menssage");
                for(let i=0;i<=data.sucessos.length-1;i++){
                    var divAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    divAlert += data.sucessos[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            $('.overlayk-loading').fadeIn();
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}

function consultarNotas(btn){
    var form = $('#consultarNotas')[0];
    var formData = new FormData(form);
    console.log(btn);
    btn.innerHTML=`
        <div class="text-center">
          <div class="spinner-border spinner-border-sm" role="status">
            <span class="visually-hidden">Carregando...</span>
          </div>
        </div>
    `;
    $.ajax({
        url:getRoot(getURL()+'/consultarNotas'),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            $('.overlayk-loading').fadeOut();
            btn.innerHTML='Consultar';
            console.log(status);
            console.log(xhr);
            console.log(data);
            if(data.erros.length>0){
                table = startTabela();
                table.clear().draw();
            }else{
                if(data.dados==false){
                    table = startTabela();
                    table.clear().draw();
                }else{
                    
                    var dados = data.dados;
                    table = startTabela();
                    table.clear().draw();
                    
                    localStorage.setItem('notasEmitidas',JSON.stringify(dados));
                    
                    for(let i=0;i<=dados.length-1;i++){
                        //console.log(dados[i].DocPDF);
                        var status = 0;
                        
                        var dateArray = dados[i].Resumo.DocDataEmissao.replace("T"," ").split(' ');
                        date = dateArray[0].split('-');
                        
                        var dataEmissao = date[2]+"/"+date[1]+"/"+date[0]+" "+dateArray[1];
                        
                        var dataEmissaoPDF = date[2]+"/"+date[1]+"/"+date[0];
                        
                        switch(dados[i].DocStatus){
                            case 1:
                                status="<span class='text-dark fw-bold'style='display:flex; text-aligns:center;'>Pendente</span>";
                            break;
                            case 2:
                                // status="<span class='text-success fw-bold sucesso' style='display:flex; text-aligns:center;'>Autorizado</span>";
                                status="<span class='status aprovado'>Autorizado</span>";
                            break;
                            case 3:
                                status="<span class='text-danger fw-bold rejeitado' style='display:flex; text-aligns:center;'>Rejeitado</span>";
                            break;
                            case 4:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Necessita Interação</span>";
                            break;
                            case 5:
                                // status="<span class='text-dark fw-bold '>Cancelado</span>";
                                status="<span class='status cancelado'>Cancelado</span>";
                            break;
                            case 6:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Inutilizado</span>";
                            break;
                            case 7:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Aguardando Consulta</span>";
                            break;
                            case 8:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Encerrado</span>";
                            break;
                            case 9:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Em Conflito</span>";
                            break;
                            case 10:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>EPEC</span>";
                            break;
                            case 11:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Contigência Offline</span>";
                            break;
                            case 12:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Denegado</span>";
                            break;
                            case 13:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Contigência FS-DA</span>";
                            break;
                            case 19:
                                status="<span class='text-dark fw-bold' style='display:flex; text-aligns:center;'>Aguardando Cancelamento</span>";
                            break;
                        }
                        
                        var btnsAcoes = "";
                        
                        var funcao = "modalCancelaNota(";
                        funcao+='"'+dados[i].DocModelo.toUpperCase()+'",';
                        funcao+=dados[i].DocNumero+",";
                        funcao+=dados[i].NFSe.NFSeNumero+",";
                        funcao+=dados[i].DocSerie;
                        funcao+=");";
                        
                        if(dados[i].DocStatus==1 || dados[i].DocStatus==2){
                            btnsAcoes += "<span class='col p-3 fs-3' style='cursor: pointer;' data-bs-toggle='modal' data-bs-target='#modalCancelaNota' onclick='"+funcao+"' title='Cancelar Documento'><i class='bi bi-file-earmark-x text-danger'></i></span>";
                        }else{
                            btnsAcoes += "<span class='col p-3 fs-3' style='pointer-events: none;'><i class='bi bi-file-earmark-x text-secondary'></i></span>"
                        }
                        
                        if(dados[i].DocPDFLink!=''){
                            //btnsAcoes+=`<span><i class="bi bi-file-earmark-arrow-down" onclick="pdfNota('${dados[i].DocPDFLink}');"></i></span>`;
                            btnsAcoes+=`<span class='col p-3 fs-3'><a class="bi bi-file-earmark-arrow-down" href="data:application/octet-stream;base64,${dados[i].DocPDF}" download="${formData.get('PJ')}_${dataEmissaoPDF.replace(/[^0-9]/g,'')}.pdf"></a></span>`;
                        }
                        
                        btnsAcoes+=`<span class='col p-3 fs-3' style='cursor: pointer;' onclick='copiarNota(${dados[i].DocProtocolo})'><i class="bi bi-files text-primary"></i></span>`;
                        
                        var divBTNs = document.createElement('div');
                        divBTNs.setAttribute('class','row');
                        divBTNs.innerHTML=btnsAcoes;
                        
                        var valor = "R$ "+dados[i].Resumo.DocVlrTotal;
                        table.row.add([
                            status,
                            dados[i].DocModelo.toUpperCase(),
                            dados[i].DocNumero,
                            dados[i].NFSe.NFSeNumero,
                            dados[i].DocSerie,
                            dataEmissao,
                            dados[i].Resumo.DocNomeDestinatario,
                            valor.toString().bold(),
                            divBTNs.innerHTML
                        ]).draw();
                    }
                    
                    
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            $('.overlayk-loading').fadeOut();
            btn.innerHTML='Consultar';
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });    
}

function copiarNota(protocolo){
    console.log(protocolo);
    var notasEmitidas = JSON.parse(localStorage.getItem('notasEmitidas'));
    if(notasEmitidas!=null){
        for(let i=0;i<=(notasEmitidas.length-1);i++){
            if(parseInt(notasEmitidas[i].DocProtocolo)==protocolo){
                localStorage.setItem('copiarNota',JSON.stringify(notasEmitidas[i].DocXML));
                localStorage.removeItem("notasEmitidas");
                i = notasEmitidas.length+1;
            }
        }
        
        var formData = new FormData();
        formData.append('copiarNota',localStorage.getItem('copiarNota'));
        
        $.ajax({
            url:getRoot(getURL()+'/copiarNota'),
            type:"POST",
            dataType:'json',
            data: formData,
            timeout:(1*60*1000),
            cache:false,
            processData: false,
            contentType:false,
            success: function(data,status,xhr){
               /* var dados = JSON.stringify(data)
                console.log(JSON.parse(dados));*/
                console.log(data);
                localStorage.setItem('copiarNota',JSON.stringify(data));
                window.location=getRoot('area-nota-nfse?copy=true'); 
            },
            error: function(jqXhr, textStatus, errorMessage){
                console.log(jqXhr+" "+textStatus+" "+errorMessage);
            }
        });
    }
    
   
}

function pdfNota(arquivo){
    //var a = window.atob(arquivo);
    var j = window.open("data:application/octet-stream;charset=utf-16le;base64,"+arquivo,'_blank');
    //j.document.write(a);
}
