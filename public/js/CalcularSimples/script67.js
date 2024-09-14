function escreverTableSimples(dados){

    var container_table = document.querySelector('.container_table');
    container_table.style.display='block';

    var container = document.querySelector('.container');
    container.style.display='none';

    var table_wrapper = document.querySelector('.table-wrapper');
    //table_wrapper.innerHTML='';

    var btnVoltar = document.getElementById('btnVoltar');
    btnVoltar.addEventListener('click',()=>{
        container_table.style.display='none';
        container.style.display='block';

        table_wrapper.innerHTML='';
    });

    var table = document.createElement('table');
    var thead = document.createElement('thead');
    var tbody = document.createElement('tbody');

    var nomeImpostosArray = Object.keys(dados.dadosAliquota.declaracao);
    /*Escrita do thead*/
    var trTitulo = document.createElement('tr');
    if(dados.anexoOriginal!=undefined){
        trTitulo.innerHTML+=`<th class="anexo">Anexo ${dados.anexoOriginal}</th>`;
        table.id=`anexo${dados.anexoOriginal}`;
    }else{
        trTitulo.innerHTML+=`<th class="anexo">Anexo ${dados.anexo}</th>`;
        table.id=`anexo${dados.anexo}`;
    }
    
    for(let i=0;i<nomeImpostosArray.length;i++){
        trTitulo.innerHTML+=`<th>${nomeImpostosArray[i]}</th>`;
    }
    thead.appendChild(trTitulo);
    /*Fim escrita thead*/

    /*Escrita tbody*/
    var trDeclaracao = document.createElement('tr');
    var trSemRetencao = document.createElement('tr');
    var trComRetencao = document.createElement('tr');
    var trPercentualAplicado = document.createElement('tr');
    var trValorParticionado = document.createElement('tr');
    var trDAS = document.createElement('tr');

    trPercentualAplicado.innerHTML+=`<td>Aliquota Efetiva: ${dados.aliquotaEfetiva}</td>`;
    trDeclaracao.innerHTML+=`<td>Valor de Declaração: ${parseFloat(dados.valorDaDeclaracao)
    .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;

    console.log(dados.dadosAliquota);
    /*Valores da declaração e percentual aplicado*/
    for(let i=0;i<nomeImpostosArray.length;i++){
        let valorPercentualAplicado = dados.dadosAliquota.declaracao[nomeImpostosArray[i]][nomeImpostosArray[i]+'_PercentualAplicado'];
        let valorParticionaldo = dados.dadosAliquota.declaracao[nomeImpostosArray[i]][nomeImpostosArray[i]+'_ValorImposto'];

        if(valorPercentualAplicado==undefined){
            trPercentualAplicado.innerHTML+=`<td>0%</td>`;
        }else{
            trPercentualAplicado.innerHTML+=`<td>${valorPercentualAplicado}%</td>`;
        }

        if(valorParticionaldo==undefined){
            trDeclaracao.innerHTML+=`<td>R$ 0</td>`;
        }else{
            trDeclaracao.innerHTML+=`<td>${parseFloat(valorParticionaldo)
            .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
        }
    }
    /*Fim*/

    /*Valores sem retenção*/
    trSemRetencao.innerHTML+=`<td>Valor sem retenção: ${parseFloat(dados.valorSemRetencao)
    .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
    for(let i=0;i<nomeImpostosArray.length;i++){
        let valorParticionaldo = dados.dadosAliquota.semRetencao[nomeImpostosArray[i]][nomeImpostosArray[i]+'_ValorImposto'];

        if(valorParticionaldo==undefined){
            trSemRetencao.innerHTML+=`<td>R$ 0</td>`;
        }else{
            trSemRetencao.innerHTML+=`<td>${parseFloat(valorParticionaldo)
            .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
        }
    }
    /*Fim do sem retenção*/

    /*Valores com retenção*/
    trComRetencao.innerHTML+=`<td>Valor com retenção: ${parseFloat(dados.valorComRetencao)
    .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
    for(let i=0;i<nomeImpostosArray.length;i++){
        let valorParticionaldo = dados.dadosAliquota.comRetencao[nomeImpostosArray[i]][nomeImpostosArray[i]+'_ValorImposto'];

        if(valorParticionaldo==undefined){
            trComRetencao.innerHTML+=`<td>R$ 0</td>`;
        }else{
            trComRetencao.innerHTML+=`<td>${parseFloat(valorParticionaldo)
            .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
        }
    }
    /*Fim do com retenção*/

    /*Valores da DAS*/
    trDAS.innerHTML+=`<td>Valor da DAS: ${parseFloat(dados.valorDAS)
    .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
    for(let i=0;i<nomeImpostosArray.length;i++){
        let valorParticionaldo = dados.dadosAliquota.DAS[nomeImpostosArray[i]][nomeImpostosArray[i]+'_ValorImposto'];
        if(valorParticionaldo==undefined){
            trDAS.innerHTML+=`<td>R$ 0</td>`;
        }else{
            trDAS.innerHTML+=`<td>${parseFloat(valorParticionaldo)
            .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
        }
    }
    /*Fim da DAS*/
    tbody.appendChild(trComRetencao);
    tbody.appendChild(trSemRetencao);
    tbody.appendChild(trPercentualAplicado);
    tbody.appendChild(trDeclaracao);
    tbody.appendChild(trDAS);
    
    /*Fim escrita tbody*/

    table.appendChild(thead);
    table.appendChild(tbody);

    if(table_wrapper.getElementsByTagName('table').length<=5){
        if(table_wrapper.getElementsByTagName('table').length<4){
            table.style.marginBottom="10%";
        }
        if(dados.anexoOriginal!=undefined && dados.anexoOriginal==5){
            var spanStatusCalculado = document.createElement("span");
            spanStatusCalculado.id='spanAnexo5';
            spanStatusCalculado.innerHTML='Anexo V COM FATOR "r" ACIMA DE 28%: Sim';
            table_wrapper.append(spanStatusCalculado);
        }else if(dados.anexo=="5"){
            var spanStatusCalculado = document.createElement("span");
            spanStatusCalculado.id='spanAnexo5';
            spanStatusCalculado.innerHTML='Anexo V COM FATOR "r" ACIMA DE 28%: Não';
            table_wrapper.append(spanStatusCalculado);
        }
        table_wrapper.append(table);
    }
    
    document.getElementById('valorTotalDAS').innerText=parseFloat(window.sessionStorage.getItem('totalDAS'))
    .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
}

/*Função de requisição do calculo do Simples*/
function calcSimples(formData) {
    /*var form = $('#formCalcSimples')[0];
    var formData = new FormData(form);*/
    //window.sessionStorage.setItem('totalDAS',);
    $.ajax({
        url:getRoot(getURL()+'/calcularSimples'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(status);
            console.log(xhr);
            console.log(data);
            if(window.sessionStorage.getItem('totalDAS')==''){
                window.sessionStorage.setItem('totalDAS',data.valorDAS);
            }else{
                let  totalDAS = parseFloat(window.sessionStorage.getItem('totalDAS'));
                totalDAS +=parseFloat(data.valorDAS);
                window.sessionStorage.setItem('totalDAS',totalDAS.toFixed(2));
            }
            //console.log(Object.keys(data.dadosAliquota));
            escreverTableSimples(data)

        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });    
}
/*Fim da função*/

/*Evento de envio de dados do Simples*/
document.getElementById('enviar').addEventListener('click',()=>{
    if(window.sessionStorage.getItem('totalDAS')!=null){
        window.sessionStorage.setItem('totalDAS','');
    }else{
        window.sessionStorage.setItem('totalDAS','');
    }
    var table_wrapper = document.querySelector('.table-wrapper');
    table_wrapper.innerHTML='';

    var form = $('#formCalcSimples')[0];
    var formData = new FormData(form);
    for(let anexo=1;anexo<=5;anexo++){
        if(formData.get('faturamento_anexo'+anexo+'_sem_retencao')!="" || formData.get('faturamento_anexo'+anexo+'_com_retencao')!=""){
            let faturamentoSemRetencao=formData.get('faturamento_anexo'+anexo+'_sem_retencao');
            let faturamentoComRetencao=formData.get('faturamento_anexo'+anexo+'_com_retencao');
            if(faturamentoComRetencao==""){faturamentoComRetencao=0;}
            if(faturamentoSemRetencao==""){faturamentoSemRetencao=0;}

            let faturamentoSemRetencao_temp = faturamentoSemRetencao.replaceAll('.','');
            faturamentoSemRetencao_temp = faturamentoSemRetencao_temp.replaceAll(',','.');

            let faturamentoComRetencao_temp = faturamentoComRetencao.replaceAll('.','');
            faturamentoComRetencao_temp = faturamentoComRetencao_temp.replaceAll(',','.');

            let faturamentoDoMes = parseFloat(faturamentoSemRetencao_temp)+parseFloat(faturamentoComRetencao_temp);
            //console.log(faturamentoDoMes);
            faturamentoDoMes = faturamentoDoMes.replace(".", ",");
            faturamentoDoMes = faturamentoDoMes.replace(/(\d)(\d{3})(\d{3})(\d{3}),/g, "$1.$2.$3.$4,");

            formData.append('faturamentoDoMes',faturamentoDoMes);
            formData.append('faturamentoSemRetencao',faturamentoSemRetencao);
            formData.append('faturamentoComRetencao',faturamentoComRetencao);
            formData.append('anexo',anexo);
            calcSimples(formData);
        }
    }
    console.log(window.sessionStorage.getItem('totalDAS'));
   
});
/*Fim do evento*/

/*Envento de checklist do formulário*/
const divs = document.querySelectorAll(".check");
const checkboxes = document.querySelectorAll(".checkbox");

for (let i = 0; i < checkboxes.length; i++) {
  checkboxes[i].addEventListener("change", function () {
    if (this.checked) {
      divs[i].style.display = "flex";
    } else {
      divs[i].style.display = "none";
      document.querySelector(`input[name="faturamento_anexo${(i+1)}_sem_retencao"]`).value="";
      document.querySelector(`input[name="faturamento_anexo${(i+1)}_com_retencao"]`).value="";
    }
  });
}
/*Fim do evento*/

/*Evento de print da tabela do Simples*/
document.getElementById('btnPrint').onclick = function(e) {
    //console.log(document.getElementById('arquivoCSS').href);
    var urlCSS = document.getElementById('arquivoCSS').href;

    $.ajax({
        url:urlCSS,
        type:"POST",
        dataType:'text',
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(status);
            console.log(xhr);
            console.log(data);
            data = data.replace("body::before","");
            data = data.replace("overflow-y: scroll;","");
            data = data.replace("overflow-x: scroll;","");
            data = data.replace("background: #cdceff;","");
            console.log(data);
            //escreverTableSimples(data)

            var conteudo = document.querySelector('.content_table').innerHTML;
            conteudo = conteudo.replace("margin-bottom: 10%;","margin-bottom: 5%;");
            var css = `<style>${data}</style>`;
            tela_impressao = window.open('about:blank');

            tela_impressao.document.write(css);
            tela_impressao.document.write(conteudo);

            tela_impressao.window.print();
            tela_impressao.window.close();

        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
    
}
/*Fim do evento*/

//Buscar RBT12 DAS Pagamento

function getRBT12_DAS_Pagamento(){
    var form = $('#formCalcSimples')[0];
    var formData = new FormData(form);
    //console.log(formData.get('cnpj'));
    //console.log(getRoot(getURL()+"/getRBT12_DAS_Pagamento"));
    $.ajax({
        url:getRoot(getURL()+"/getRBT12_DAS_Pagamento"),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            if(data.erro.length>0){

            }else{
                if(data.dados!=false){
                    var rbt12 = document.querySelector('input[name=rbt12]');
                    rbt12.value=data.dados.rbt12;
                    mascaraDinheiro(rbt12);
                }
            }
            
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

window.addEventListener('load', ()=>{
    document.querySelector("input[name=cnpj]").addEventListener('focusout', ()=>{
        getRBT12_DAS_Pagamento();
    });
});