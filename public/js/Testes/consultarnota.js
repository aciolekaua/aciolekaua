window.addEventListener("load",()=>{
    
    obj = {
        tabela: $('#tabela_notafiscal'),
        startTabela:function(tabela){ 
            this.tabela.DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'csvHtml5'
                ]
            });
            const divDtButtons = document.querySelector("div.dt-buttons");
            divDtButtons.style.margin='0 0 3% 0';
            const btnExcel = document.querySelector("button.buttons-excel");
            btnExcel.setAttribute('class',"btn btn-success buttons-excel buttons-html5");
            btnExcel.innerHTML="<i class='bi bi-file-earmark-excel'></i> Excel";
            
            const btnCSV = document.querySelector("button.buttons-csv");
            btnCSV.setAttribute('class',"btn btn-secondary buttons-csv buttons-html5");
            btnCSV.innerHTML="<i class='bi bi-filetype-csv'></i> CSV";
        },
        escrevaTabela:function(data){
            console.log(data);
            const table = $(obj.tabela).DataTable();
            if(data.erros.length>0){
                
            }else{
                var retorno = data.retorno[0];
                console.log(retorno);
                if(retorno.Codigo!=100){
                    console.log("");
                }else{
                    table.clear().draw();
                    for(let i=0;i<=retorno.Documentos.length-1;i++){
                        var status = 0;
                        
                        var dateArray = retorno.Documentos[i].Resumo.DocDataEmissao.replace("T"," ").split(' ');
                        date = dateArray[0].split('-');
                        
                        switch(retorno.Documentos[i].DocStatus){
                            case 1:
                                status="<span class='text-dark fw-bold'>Pendente</span>";
                            break;
                            case 2:
                                status="<span class='text-success fw-bold'>Autorizado</span>";
                            break;
                            case 3:
                                status="<span class='text-danger fw-bold'>Rejeitado</span>";
                            break;
                            case 4:
                                status="<span class='text-dark fw-bold'>Necessita Interação</span>";
                            break;
                            case 5:
                                status="<span class='text-dark fw-bold'>Cancelado</span>";
                            break;
                            case 6:
                                status="<span class='text-dark fw-bold'>Inutilizado</span>";
                            break;
                            case 7:
                                status="<span class='text-dark fw-bold'>Aguardando Consulta</span>";
                            break;
                            case 8:
                                status="<span class='text-dark fw-bold'>Encerrado</span>";
                            break;
                            case 9:
                                status="<span class='text-dark fw-bold'>Em Conflito</span>";
                            break;
                            case 10:
                                status="<span class='text-dark fw-bold'>EPEC</span>";
                            break;
                            case 11:
                                status="<span class='text-dark fw-bold'>Contigência Offline</span>";
                            break;
                            case 12:
                                status="<span class='text-dark fw-bold'>Denegado</span>";
                            break;
                            case 13:
                                status="<span class='text-dark fw-bold'>Contigência FS-DA</span>";
                            break;
                            case 19:
                                status="<span class='text-dark fw-bold'>Aguardando Cancelamento</span>";
                            break;
                        }
                        
                        table.row.add([
                            status,
                            retorno.Documentos[i].DocModelo.toUpperCase(),
                            retorno.Documentos[i].DocNumero,
                            retorno.Documentos[i].NFSe.NFSeNumero,
                            retorno.Documentos[i].DocSerie,
                            date[2]+"/"+date[1]+"/"+date[0]+" "+dateArray[1],
                            retorno.Documentos[i].Resumo.DocNomeDestinatario,
                            retorno.Documentos[i].Resumo.DocVlrTotal,
                            ""
                        ]).draw();
                    }
                }
            }
            
        }
    }
    
    obj.startTabela();
    
    
});

function stratLodingBTN(){
    document.querySelector("button#btnConsultar").innerHTML="<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>";
}
function stopLodingBTN(){
    document.querySelector("button#btnConsultar").innerHTML="Consultar";
}

function consultarNota(){
    let form = $('#formConsultaNota')[0];
    let formData = new FormData(form);
    stratLodingBTN();
    $.ajax({
        url:getRoot("cash/teste/consultarNota"),
        type:"POST",
        datatype:"json",
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            //console.log(data);
            stopLodingBTN();
            obj.escrevaTabela(data);
        },
        error: function(texto1, texto2, texto3){
            stopLodingBTN();
            console.log(texto1+" "+texto2+" "+texto3 );
        }
    });
}