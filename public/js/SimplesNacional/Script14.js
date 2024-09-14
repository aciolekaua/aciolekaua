window.addEventListener('load',()=>{
    buscaDados();

    if(sessionStorage.getItem('TipoCliente')=="PJ"){
        document.querySelector('select[name=PJ]').style.pointEvents="none";
        document.querySelector('select[name=PJ]').style.opacity="0.5";
    }
    
    var inputs = document.querySelectorAll('input[name=Anexo]');
   
    for(let i=0;i<=inputs.length-1;i++){
        inputs[i].addEventListener('click',()=>{
            console.log(inputs[i].value);
        });
    }
    
});

function buscaDados(){
    $.ajax({
        url:getRoot(getURL()+'/dados'),
        type:"POST",
        dataType:'json',
        timeout:1*60*1000,
        success: function(data, status,xxr){
            console.log(data);
            if(data.length<=0){

            }else{

                /*const select = document.querySelector('select[name=PJ]');
                select.innerHTML="";
                for(let i=0;i<=data.length-1;i++){
                    if(i===0){
                        select.innerHTML+=`
                        <option value='${data[i].CNPJ}' selected>${data[i].Nome}</option>
                        `;
                    }else{
                        select.innerHTML+=`
                        <option value='${data[i].CNPJ}'>${data[i].Nome}</option>
                        `;
                    }
                }*/

                // Cria um objeto Date para armazenar a data atual
                /*const dataAtual = new Date();

                // Formata a data no formato YY-mm-dd
                const ano = parseInt(dataAtual.getFullYear().toString().slice(-2)); // Pega os últimos 2 dígitos do ano
                if((dataAtual.getMonth() + 1) > 1){
                    const mes = (dataAtual.getMonth() - 1).toString().padStart(2, '0');
                }else{
                    const mes = (dataAtual.getMonth() + 1).toString().padStart(2, '0');
                }
                //const dia = dataAtual.getDate().toString().padStart(2, '0');
                const dia = "01";
                // Exibe a data atual no console
                console.log(`${ano}-${mes}-${dia}`);*/

                getRBT12({
                    "cnpj":data[0].CNPJ,
                    "nome":data[0].Nome,
                    //"competencia":`${ano}-${mes}-${dia}`
                });
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            //buscarSimples();
        }
    });
}

function registroSimples(){

    var form = $('#formSimples')[0];
    var formData = new FormData(form);
    formData.append('PJ',$("#PJFormFiltro").val());
    formData.append('Anexo',$("#AnexoFormFiltro").val());

    $.ajax({
        url:getRoot(getURL()+'/registroSimples'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:1*60*1000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data, status,xxr){
            console.log(data);
            buscarSimples();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            //buscarSimples();
        }
    });
    
}

function buscarSimples(){
    $.ajax({
        url:getRoot(getURL()+'/getSimples'),
        type:"POST",
        dataType:'json',
        data: new FormData($("#formFiltro")[0]),
        timeout:1*60*1000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data, status,xxr){
            console.log(data);
            if(data.erros.length>0){
                var table = $('#tabelaSimplesNacional').DataTable();
                table.clear().draw();
            }else{
                
                var table = $('#tabelaSimplesNacional').DataTable();
                table.clear().draw();
                if(data.dados.length<=0){
                    
                }else{
                    for(let i=0;i<=data.dados.length-1;i++){
                        var json = `{
                            'mesCompetencia':${data.dados[i].MesCompetencia},
                            'anoCompetencia':${data.dados[i].AnoCompetencia},
                            'valor':'${data.dados[i].Valor}',
                            'anexo':${data.dados[i].Anexo},
                            'id':'${data.dados[i].Id}'
                        }`;

                        let meses = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];

                        var buttons = "<div class='row flex-row flex-nowrap'>";
                        buttons+=`<div class='col'><i onclick="" class="btn bi bi-calculator-fill text-secondary"></i></div>`;
                        buttons+=`<div class='col'><i onclick="deleteSimples('${data.dados[i].Id}');buscarSimples();" class="btn bi bi-trash-fill text-danger"></i></div>`;
                        buttons+=`
                            <div class='col'>
                                
                                <i class="btn bi bi-pencil-square text-primary" data-bs-toggle="modal" data-bs-target="#modalUpdateSimples" onclick="setModalUpdateSimples(${json.trim()});buscarSimples();"></i>
                                
                            </div>
                        `;
                        buttons+=`</div>`;
                        let status = "";
                        if(data.dados[i].StatusSimples){
                            status = `<i class="text-success bi bi-check-circle"></i>`;
                        }else{
                            status = `<i class="text-danger bi bi-x-circle"></i>`;
                        }

                        var linha =[];
                        linha.push(
                            status,
                            data.dados[i].AnoCompetencia,
                            meses[(parseInt(data.dados[i].MesCompetencia)-1)],
                            data.dados[i].AliquotaEfetiva,
                            data.dados[i].Valor,
                            buttons
                        );
                        
                        table.row.add(linha).draw();
                    }
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
        }
    });
  
}

function deleteSimples(id){
    $.ajax({
        url:getRoot(getURL()+'/deleteSimples/'+id),
        type:"POST",
        dataType:'json',
        success: function(data, status,xxr){
            console.log(data);
            buscarSimples();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            //buscarSimples();
        }
    });
}

function setModalUpdateSimples(dados){
    console.log(dados);
    $('select[name=MesCompetencia]').val(dados.mesCompetencia);
    $('select[name=AnoCompetencia]').val(dados.anoCompetencia);
    $('select[name=Anexo]').val(dados.anexo);
    $('input[name=ValorCompetencia]').val(dados.valor);
    $('input[name=IdSimples]').val(dados.id);
}

function updateSimples(){
    var form = $('#formUpdateSimples')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/updateSimples'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:1*60*1000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data, status,xxr){
            console.log(data);
            buscarSimples(document.querySelector('select[id=AnexoFormFiltro]').value);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            //buscarSimples();
        }
    });
}

function calcularRBT12(anexo=null){
    var input_rbt12 = document.querySelector("input[name=rbt12]");
    var h2_folha_card = document.querySelector('h2[id=h2_fatorR_card]');
    if(anexo==null){
        var valor_totalizada_DAS = 0;
        //var valor_totalizada_folha = 0;      

        for(let anexo=1;anexo<=5;anexo++){
            //console.log(anexo);
            var input_faturamento_sem_retencao = document.querySelector("input[name=faturamento_sem_retencao_anexo_"+anexo+"]");
            var input_faturamento_com_retencao = document.querySelector("input[name=faturamento_com_retencao_anexo_"+anexo+"]");
            var input_folha = document.querySelector("input[name=folha");

            var valor1 = input_faturamento_com_retencao.value.replace(',','.');
            var valor2 = input_faturamento_sem_retencao.value.replace(',','.');

            valor1 = parseFloat(valor1); 
            valor2 = parseFloat(valor2);

            if(!valor1 == 0 || !valor2 == 0){
                var formData = new FormData();
                formData.append('anexo',anexo);
                formData.append('rbt12',input_rbt12.value);
                formData.append('faturamentoSemRetencao',input_faturamento_sem_retencao.value);
                formData.append('faturamentoComRetencao',input_faturamento_com_retencao.value);
                formData.append('folha',input_folha.value);

                $.ajax({
                    url:getRoot(getURL()+'/calcularSimples'),
                    type:"POST",
                    dataType:'json',
                    data: formData,
                    timeout:12000,
                    cache:false,
                    processData: false,
                    contentType:false,
                    success :function(data,status,xhr){
                        console.log(data);

                        if(anexo==5){
                            h2_folha_card.innerText = "Fator R: " + data.fatorR.replace('.',',') + '%';
                        }

                        if(parseInt(data.anexo)!=parseInt(data.anexoOriginal)){
                            document.querySelector("h2[id=painel_titulo_anexo_5] button").innerHTML = "Anexo 5(Serviços) calculado com anexo " + data.anexo;
                        }else{
                            document.querySelector("h2[id=painel_titulo_anexo_5] button").innerHTML = "Anexo 5(Serviços)";
                        }
                        
                        //document.querySelector("div[id=div_anexo_anexo_"+i+"]").innerText = "Anexo: "+data.anexo;
                        document.querySelector("div[id=div_aliquota_anexo_"+anexo+"]").innerText = "Aliquota: "+data.aliquotaEfetiva.replace('.', ',')+"%";

                        var valor_total_sem_retencao = parseFloat(data.valorSemRetencao);
                        document.querySelector("div[id=col_sem_retencao_Total_anexo_"+anexo+"]").innerText = valor_total_sem_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                        var valor_total_com_retencao = parseFloat(data.valorComRetencao);
                        document.querySelector("div[id=col_com_retencao_Total_anexo_"+anexo+"]").innerText = valor_total_com_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                        var valor_total_DAS = parseFloat(data.valorDAS);
                        document.querySelector("div[id=col_DAS_Total_anexo_"+anexo+"]").innerText = valor_total_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                        valor_totalizada_DAS += valor_total_DAS;

                        var impostos = Object.getOwnPropertyNames(data.dadosAliquota.DAS);
                        //console.log(impostos);

                        for(let i=0;i<=(impostos.length - 1);i++){
                            var valor_sem_retencao = data.dadosAliquota.semRetencao[impostos[i]][impostos[i]+"_ValorImposto"];
                            var valor_com_retencao = data.dadosAliquota.comRetencao[impostos[i]][impostos[i]+"_ValorImposto"];
                            var valor_DAS = data.dadosAliquota.DAS[impostos[i]][impostos[i]+"_ValorImposto"];
                            
                            if(valor_sem_retencao==undefined){valor_sem_retencao = 0.00;} 
                            if(valor_com_retencao==undefined){valor_com_retencao = 0.00;} 
                            if(valor_DAS==undefined){valor_DAS = 0.00;}
                            
                            valor_DAS = parseFloat(valor_DAS);
                            valor_com_retencao = parseFloat(valor_com_retencao);
                            valor_sem_retencao = parseFloat(valor_sem_retencao);

                            document.getElementById("col_sem_retencao_"+impostos[i]+"_anexo_"+anexo).innerText = valor_sem_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                            document.getElementById("col_com_retencao_"+impostos[i]+"_anexo_"+anexo).innerText = valor_com_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                            document.getElementById("col_DAS_"+impostos[i]+"_anexo_"+anexo).innerText = valor_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                        }

                        if(data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado!=undefined){
                            document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado.replace('.',',')+"%";
                        }else{
                            document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": 0%";
                        }
                        document.querySelector('h3[id=div_aliquota_efetiva_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + data.aliquotaEfetiva.replace('.',',')+"%";
                        document.querySelector('div[id=div_valor_totalizada_DAS]').innerText = "Total da DAS: " + valor_totalizada_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                        document.querySelector('div[id=div_valor_totalizado_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + valor_total_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                        /*for(let i=0;i<=5;i++){
                            document.querySelector('h3[id=div_aliquota_retencao_anexo_'+i+']').innerText = 
                        }*/

                    },
                    error: function(jqXhr, textStatus, errorMessage){
                        console.log(jqXhr+" "+textStatus+" "+errorMessage);
                    }
                });

            }else{
                document.querySelector('div[id=div_valor_totalizado_anexo_'+anexo+']').innerText = "Anexo "+anexo+": R$ 0,00";
                document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": 0%";
                document.querySelector('h3[id=div_aliquota_efetiva_anexo_'+anexo+']').innerText = "Anexo "+anexo+": 0%";
            }
            
        }

    }else{
        var valor_totalizada_DAS = 0;

        var input_faturamento_sem_retencao = document.querySelector("input[name=faturamento_sem_retencao_anexo_"+anexo+"]");
        var input_faturamento_com_retencao = document.querySelector("input[name=faturamento_com_retencao_anexo_"+anexo+"]");
        var input_folha = document.querySelector("input[name=folha]");

        var valor1 = input_faturamento_com_retencao.value.replace(',','.');
        var valor2 = input_faturamento_sem_retencao.value.replace(',','.');

        valor1 = parseFloat(valor1); 
        valor2 = parseFloat(valor2);

        if(!valor1 == 0 || !valor2 == 0){
            var formData = new FormData();
            formData.append('anexo',anexo);
            formData.append('rbt12',input_rbt12.value);
            formData.append('faturamentoSemRetencao',input_faturamento_sem_retencao.value);
            formData.append('faturamentoComRetencao',input_faturamento_com_retencao.value);
            formData.append('folha',input_folha.value);

            $.ajax({
                url:getRoot(getURL()+'/calcularSimples'),
                type:"POST",
                dataType:'json',
                data: formData,
                timeout:12000,
                cache:false,
                processData: false,
                contentType:false,
                success :function(data,status,xhr){
                    console.log(data);
                    if(anexo==5){
                        h2_folha_card.innerText = "Fator R: " + data.fatorR.replace('.',',') + '%';
                    }
                    
                    if(parseInt(data.anexo)!=parseInt(data.anexoOriginal)){
                        document.querySelector("h2[id=painel_titulo_anexo_5] button").innerHTML = "Anexo 5(Serviços) calculado com anexo " + data.anexo;
                    }else{
                        document.querySelector("h2[id=painel_titulo_anexo_5] button").innerHTML = "Anexo 5(Serviços)";
                    }
                    //document.querySelector("div[id=div_anexo_anexo_"+i+"]").innerText = "Anexo: "+data.anexo;
                    document.querySelector("div[id=div_aliquota_anexo_"+anexo+"]").innerText = "Aliquota: "+data.aliquotaEfetiva.replace('.', ',')+"%";

                    var valor_total_sem_retencao = parseFloat(data.valorSemRetencao);
                    document.querySelector("div[id=col_sem_retencao_Total_anexo_"+anexo+"]").innerText = valor_total_sem_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                    var valor_total_com_retencao = parseFloat(data.valorComRetencao);
                    document.querySelector("div[id=col_com_retencao_Total_anexo_"+anexo+"]").innerText = valor_total_com_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                    var valor_total_DAS = parseFloat(data.valorDAS);
                    document.querySelector("div[id=col_DAS_Total_anexo_"+anexo+"]").innerText = valor_total_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                    var impostos = Object.getOwnPropertyNames(data.dadosAliquota.DAS);
                    console.log(impostos);

                    for(let i=0;i<=(impostos.length - 1);i++){
                        var valor_sem_retencao = data.dadosAliquota.semRetencao[impostos[i]][impostos[i]+"_ValorImposto"];
                        var valor_com_retencao = data.dadosAliquota.comRetencao[impostos[i]][impostos[i]+"_ValorImposto"];
                        var valor_DAS = data.dadosAliquota.DAS[impostos[i]][impostos[i]+"_ValorImposto"];
                        
                        if(valor_sem_retencao==undefined){valor_sem_retencao = 0.00;} 
                        if(valor_com_retencao==undefined){valor_com_retencao = 0.00;} 
                        if(valor_DAS==undefined){valor_DAS = 0.00;}
                        
                        valor_DAS = parseFloat(valor_DAS);
                        valor_com_retencao = parseFloat(valor_com_retencao);
                        valor_sem_retencao = parseFloat(valor_sem_retencao);

                        document.getElementById("col_sem_retencao_"+impostos[i]+"_anexo_"+anexo).innerText = valor_sem_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                        document.getElementById("col_com_retencao_"+impostos[i]+"_anexo_"+anexo).innerText = valor_com_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                        document.getElementById("col_DAS_"+impostos[i]+"_anexo_"+anexo).innerText = valor_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    }

                    for(let a=1;a<=5;a++){
                        var valor_das_temp = document.querySelector("div[id=col_DAS_Total_anexo_"+a+"]").innerText;
                        valor_das_temp = valor_das_temp.replace("R$","");
                        valor_das_temp = valor_das_temp.replace(".","");
                        valor_das_temp = valor_das_temp.replace(",",".");
                        console.log(valor_das_temp);
                        valor_das_temp = parseFloat(valor_das_temp);

                        valor_totalizada_DAS += valor_das_temp;
                    }

                    //document.querySelector('div[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Aliquota de retenção: " + data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado.replace('.',',')+"%";
                    if(data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado!=undefined){
                        document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado.replace('.',',')+"%";
                    }else{
                        document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": 0%";
                    }
                    document.querySelector('div[id=div_valor_totalizada_DAS]').innerText = "Total da DAS: " + valor_totalizada_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    document.querySelector('div[id=div_valor_totalizado_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + valor_total_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    //document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado.replace('.',',')+"%";
                    document.querySelector('h3[id=div_aliquota_efetiva_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + data.aliquotaEfetiva.replace('.',',')+"%";

                },
                error: function(jqXhr, textStatus, errorMessage){
                    console.log(jqXhr+" "+textStatus+" "+errorMessage);
                }
            });

        }else{
            document.querySelector('div[id=div_valor_totalizado_anexo_'+anexo+']').innerText = "Anexo "+anexo+": R$ 0,00";
            document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": 0%";
            document.querySelector('h3[id=div_aliquota_efetiva_anexo_'+anexo+']').innerText = "Anexo "+anexo+": 0%";
        }
    }   
    
}    

function getFatulras(dados){
    //var obj = document.querySelector("select[name=anexo]");
    //console.log(obj);
    var formData = new FormData();
    formData.append('cnpj',dados.cnpj);
    $.ajax({
        url:getRoot(getURL()+'/getFaturas'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            var faturamento_com_retencao = {
                "1":0,
                "2":0,
                "3":0,
                "4":0,
                "5":0
            };
            var faturamento_sem_retencao = {
                "1":0,
                "2":0,
                "3":0,
                "4":0,
                "5":0
            };

            for(let i=0;i<=(data.dados.length - 1);i++){
                for(let anexo_temp=1;anexo_temp<=5;anexo_temp++){
                    anexo_temp = anexo_temp+"";
                    if(data.dados[i].anexo == anexo_temp){
                        faturamento_com_retencao[anexo_temp] += parseFloat(data.dados[i].faturamento_retido);
                        faturamento_sem_retencao[anexo_temp] += parseFloat(data.dados[i].faturamento_nao_retido);
                    }
                }
            }

            for(let i=1;i<=5;i++){
                let anexo = i+"";
                let div_anexo = document.querySelector('div[id=painel_anexo_'+anexo+']');
                let btn_anexo = document.querySelector('button[aria-controls=painel_anexo_'+anexo+']');
                if(faturamento_com_retencao[anexo] != 0 || faturamento_sem_retencao[anexo] != 0){
                    div_anexo.setAttribute('class','accordion-collapse collapse show');
                    btn_anexo.setAttribute('aria-expanded','true');
                    btn_anexo.setAttribute('class','accordion-button fs3');
                }else{
                    div_anexo.setAttribute('class','accordion-collapse collapse');
                    btn_anexo.setAttribute('aria-expanded','false');
                    btn_anexo.setAttribute('class','accordion-button collapsed fs3');
                }
            }

            var valor_faturamento_sem_rentencao_total = 0;
            var valor_faturamento_com_rentencao_total = 0;

            for(let i=1;i<=5;i++){
                var input_faturamento_sem_retencao_temp = document.querySelector("input[name=faturamento_sem_retencao_anexo_"+i+"]");
                var input_faturamento_com_retencao_temp = document.querySelector("input[name=faturamento_com_retencao_anexo_"+i+"]");
                input_faturamento_sem_retencao_temp.value = faturamento_sem_retencao[i].toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                input_faturamento_com_retencao_temp.value = faturamento_com_retencao[i].toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

                mascaraDinheiro(input_faturamento_sem_retencao_temp);
                mascaraDinheiro(input_faturamento_com_retencao_temp);

                //var valor_total_faturamento_temp = (faturamento_sem_retencao[i] + faturamento_com_retencao[i]);

                valor_faturamento_sem_rentencao_total += faturamento_sem_retencao[i];
                valor_faturamento_com_rentencao_total += faturamento_com_retencao[i];

                document.querySelector('h2[id=div_valor_faturamento_sem_rentencao_anexo_'+i+']').innerText = "Anexo "+i+":"+faturamento_sem_retencao[i].toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                document.querySelector('h2[id=div_valor_faturamento_com_rentencao_anexo_'+i+']').innerText = "Anexo "+i+":"+faturamento_com_retencao[i].toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            }

            document.querySelector('h2[id=div_valor_faturamento_sem_rentencao_total]').innerText = "Total do Faturamento Sem Retenção: "+valor_faturamento_sem_rentencao_total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            document.querySelector('h2[id=div_valor_faturamento_com_rentencao_total]').innerText = "Total do Faturamento Com Retenção: "+valor_faturamento_com_rentencao_total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            calcularRBT12();

            console.log([faturamento_sem_retencao,faturamento_com_retencao]);

            /*var input_faturamento_sem_retencao = document.querySelector('input[name=faturamento_sem_retencao]');
            var input_faturamento_com_retencao = document.querySelector('input[name=faturamento_com_retencao]');
            input_faturamento_sem_retencao.value = faturamento_sem_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            input_faturamento_com_retencao.value = faturamento_com_retencao.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            mascaraDinheiro(input_faturamento_sem_retencao);
            mascaraDinheiro(input_faturamento_com_retencao);*/
                        
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });


}    

function escrever_dados_modal(dados){
    console.log(dados);
    getFatulras(dados);
    ///var select_anexo = document.querySelector("select[name=anexo]");
    var div_nome_empresa = document.querySelector("h1[id=div_nome_empresa]");
    var input_rbt12 = document.querySelector("input[name=rbt12]");
    var input_folha = document.querySelector("input[name=folha]");
    var h2_rba_card = document.querySelector('h2[id=h2_rba_card]');
    dados.rba = parseFloat(dados.rba);
    dados.rpa = parseFloat(dados.rpa);

    h2_rba_card.innerText ="Total do RBA: " +  dados.rba.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
    });

    if(dados.rba > 0){
        /*let part1 = (dados.rba * 60) / 100;
        let part2 = (dados.rba * 30) / 100;
        let part3 = (dados.rba * 10) / 100;*/
        limite.data.datasets[0].needleValue = dados.rba;
        limite.update();
        console.log(limite);
    }

    div_nome_empresa.innerText = dados.razao;

    input_rbt12.value = 0;
    input_rbt12.value = dados.rbt12.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    mascaraDinheiro(input_rbt12);

    input_folha.value = 0;
    //input_folha.value = dados.rbt12.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    mascaraDinheiro(input_folha);

    
    for(let i=1;i<=5;i++){
        document.querySelector("input[name=faturamento_sem_retencao_anexo_"+i+"]").value="0,00";
        document.querySelector("input[name=faturamento_com_retencao_anexo_"+i+"]").value="0,00";
        //document.querySelector("input[name=folha_anexo_"+i+"]").value="0,00";
    }
    
    /*select_anexo.value = "";
    json = JSON.stringify(dados);
    select_anexo.setAttribute('onchange',`getFatulras(${json})`);*/
}

function getRBT12(dados){
    var formData = new FormData();
    /*for(let i=0;i<=(dados_fatura.length -1);i++){
        formData.append(`cnpj[${i}]`,dados_fatura[i].cnpj);
        formData.append(`razao[${i}]`,dados_fatura[i].nome);
    }*/
    
    formData.append('cnpj',dados.cnpj);
    console.log(getRoot()+"calcular-simples/getRBT12_DAS_Pagamento");
    $.ajax({
        url:getRoot("calcular-simples/getRBT12_DAS_Pagamento"),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success :function(data,status,xhr){
            console.log(data);
            /*if(data.dados!=false){
                escrever_tabela(data.dados);
            }*/
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}