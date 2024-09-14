//cardGastosMensais
//console.log(sessionStorage.getItem('TipoCliente'));
var myChartReceita;
var myChartDespesa;

// window.addEventListener('load',()=>{
//   dados();
// });

window.addEventListener('load',()=>{
    if(sessionStorage.getItem('TipoCliente')=="PJ"){
        dados();
        setInterval(dados,3000);
    }else if(sessionStorage.getItem('TipoCliente')=='PF'){
        dados();
      /* setInterval(dadosPF,3000);*/
    }
});

function dados() {
    $.ajax({
        url: getRoot(getURL() + '/dados'),
        beforeSend: function() {
            $('.overlay-loading').fadeIn();
        },
        type: "GET",
        dataType: 'json',
        success: function(data, status, xhr) {
            console.log(data);
            $('.overlay-loading').fadeOut();
            sessionStorage.setItem("dadosHomePJ", 1);
            
            if (data.TipoCliente == "PF") {
                console.log(data.TipoCliente);
                // Código para PF (Pessoa Física)
                
            } else if (data.TipoCliente == "PJ") {
                // Atualiza as informações de pagamento e recebimento
                const cardPagamento = document.querySelector("#pagamento");
                const cardRecebimento = document.querySelector("#recebimento");

                cardPagamento.innerHTML = "Total de: R$ 0,00";
                if (data.despensasMensais != false) {
                    cardPagamento.innerHTML = "Total de: " + data.despensasMensais.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
                }

                cardRecebimento.innerHTML = "Total de: R$ 0,00";
                if (data.receitasMensais != false) {
                    cardRecebimento.innerHTML = "Total de: " + data.saldo.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
                }

                // Lógica para gráficos
                receitasMensais(data);
                despesasMensais(data);
                receitaAnual(data);
                despesaAnual(data);
                
                escreverDadosSidebar(data);
                
                if (data.receitaAnual && data.receitaAnual.length > 1) {
                    atualizarIndicatorsDiferenca(data.receitaAnual, '#analize-recebimento');
                } else {
                    console.log("Não há dados suficientes para calcular a diferença entre meses para receitas.");
                }

                if (data.despesaAnual && data.despesaAnual.length > 1) {
                    atualizarIndicatorsDiferenca(data.despesaAnual, '#analize-pagamento');
                } else {
                    console.log("Não há dados suficientes para calcular a diferença entre meses para despesas.");
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage) {
            console.log(jqXhr + ' ' + textStatus + ' ' + errorMessage);
        }
    });
}



function atualizarIndicatorsDiferenca(dadosAnuais, seletorAnalyze) {
    let mesAtual = new Date().getMonth() + 1;
    // console.log(mesAtual);
    
    let mesAnterior = mesAtual - 1;

    let ultimoMes = dadosAnuais.find(item => item.Mes === mesAtual);
    let mesAnteriorItem = dadosAnuais.find(item => item.Mes === mesAnterior);

    let indicator = document.querySelector(seletorAnalyze);

    if (ultimoMes && mesAnteriorItem) {
        let valorAtual = parseFloat(ultimoMes.Valor.replace(',', '.'));
        let valorAnterior = parseFloat(mesAnteriorItem.Valor.replace(',', '.'));
        
        let resultado = (valorAtual * 100) / valorAnterior;
        let diferenca = resultado - 100;

        indicator.className = diferenca >= 0 ? 'outcomei' : 'incomei';
        indicator.querySelector('.topi p').textContent = `${diferenca.toFixed(2)} %`;
        indicator.querySelector('.topi i').className = diferenca >= 0 ? 'bi bi-caret-up-fill' : 'bi bi-caret-down-fill';
        
        if(diferenca === 0){
            indicator.querySelector('.topi p').classList.add('text-matrix');
            indicator.querySelector('.topi i').classList.add('text-matrix');
        }else{
            indicator.querySelector('.topi p').classList.remove('text-matrix');
            indicator.querySelector('.topi i').classList.remove('text-matrix');
        }
        
        let icone = indicator.querySelector('.topi i');
        let paragraph = indicator.querySelector('.topi p');
        icone.style.display = 'block';
        icone.style.margin = '0 auto';
        icone.style.textAlign = 'center';
        
        paragraph.style.display = 'block';
        paragraph.style.margin = '0 auto';
        paragraph.style.textAlign = 'center';
    } else {

        indicator.className = 'text-matrix';
        indicator.querySelector('.topi p').textContent = '0.00 %';
        indicator.querySelector('.topi i').className = 'bi bi-dash';
        indicator.querySelector('.topi p').classList.add('text-matrix');
        indicator.querySelector('.topi i').classList.add('text-matrix');
        
        
        let icone = indicator.querySelector('.topi i');
        let paragraph = indicator.querySelector('.topi p');
        icone.style.display = 'block';
        icone.style.margin = '0 auto';
        icone.style.textAlign = 'center';
        
        paragraph.style.display = 'block';
        paragraph.style.margin = '0 auto';
        paragraph.style.textAlign = 'center';
        
    }
    
}

function escreverDadosSidebar(data){
    let receitaTotal = 0; 
    console.log(data.receitasMensais.length);
    for(let index=0; index <= (data.receitasMensais.length-1);index++){
        receitaTotal += parseFloat(data.receitasMensais[index].ValorTotal.replace(',','.'));  
    }
    let despesasTotal = 0; 
    for(let index=0; index <= (data.despensasMensais.length-1);index++){
        despesasTotal += parseFloat(data.despensasMensais[index].ValorTotal.replace(',','.'));  
    }
    let resultado = receitaTotal - despesasTotal;
    console.log(resultado);
   
    const formatado = resultado.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    console.log(formatado); 

    
    document.getElementById('lucro').innerText = formatado;
}
//selectPJ.innerHTML='';
//selectPJ.innerHTML+="<option value=''>Selecione uma PJ</option>";
// for(let i=0;i<=data.PJs.length-1;i++){
//     //console.log(data.PJs[i].Nome);
//     selectPJ.innerHTML+="<option value='"+data.PJs[i].CNPJ+"'>"+data.PJs[i].Nome+"</option>";
// }


// Chart Recebimento(com dados reais)
function receitaAnual(data) {
    console.log(data);
    const recebimento = document.getElementById('myChartRecebimento');
    let dataCharts = Array(12).fill(0); // Inicializa com 0

    if (data.receitaAnual.length > 0) {
        data.receitaAnual.forEach(item => {
            if (item.Mes >= 1 && item.Mes <= 12) {
                dataCharts[item.Mes - 1] = item.Valor;
            }
        });
    }

    if (myChartReceita) {
        myChartReceita.data.datasets[0].data = dataCharts;
        myChartReceita.update();
    } else {
        myChartReceita = new Chart(recebimento, {
            type: 'line',
            data: {
                labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                datasets: [{
                    label: 'Recebimento Mensal',
                    data: dataCharts,
                    backgroundColor: 'transparent',
                    borderColor: "#ffc15e",
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                }
            }
        });
    }
}

//Char Pagamento(com dados reais)
function despesaAnual(data) {
    const pagamento = document.getElementById('myChartPagamento');
    let dataCharts = Array(12).fill(0); // Inicializa com 0

    if (data.despesaAnual.length > 0) {
        data.despesaAnual.forEach(item => {
            if (item.Mes >= 1 && item.Mes <= 12) {
                dataCharts[item.Mes - 1] = item.Valor;
            }
        });
    }

    if (myChartDespesa) {
        myChartDespesa.data.datasets[0].data = dataCharts;
        myChartDespesa.update();
    } else {
        myChartDespesa = new Chart(pagamento, {
            type: 'line',
            data: {
                labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                datasets: [{
                    label: 'Despesa Mensal',
                    data: dataCharts,
                    backgroundColor: 'transparent',
                    borderColor: "#8158fc",
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                }
            }
        });
    }
}

function receitasMensais(data){
      if(data.receitasMensais.length<=0 || data.receitasMensais==false){
          const cardEntradasValor = document.querySelector("div.infoi #recebimento");
          cardEntradasValor.innerHTML='';
          let valorTotal = 0;
          cardEntradasValor.innerHTML="Total de: "+valorTotal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
      }else{
          const tabelaReceitaBody = document.querySelector("table #tabelaReceitaBody");
          tabelaReceitaBody.innerHTML='';
          let Total = 0;
          
          for(let i=0;i<=(data.receitasMensais.length-1);i++){
              let tr = document.createElement('tr');
              let td1 = document.createElement('td');
              let td2 = document.createElement('td');
              let valor = Number.parseFloat(data.receitasMensais[i].ValorTotal);
              valor = valor.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
              
              td1.innerHTML=data.receitasMensais[i].Historico;
              td2.innerHTML="<span class='text-success'>+"+valor+"</span>";
              tr.appendChild(td);
              tabelaReceitaBody.appendChild(tr);
              
              Total += Number.parseFloat(data.receitasMensais[i].ValorTotal);
          }
          let tr = document.createElement('tr');
          let td = document.createElement('td');
          let valorTotal = Total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
          td.innerHTML="Total: <span class='text-success'>+"+valorTotal+"</span>";
          td.setAttribute('colspan','2');
          tr.appendChild(td);
          tabelaReceitaBody.appendChild(tr);
          
          const cardEntradasValor = document.querySelector("div.infoi #recebimento");
          cardEntradasValor.innerHTML='';
          cardEntradasValor.innerHTML="Total de: +"+valorTotal;
      }
}

function despesasMensais(data){
        if(data.despensasMensais.length<=0 || data.despensasMensais==false){
            const cardDespensasValor = document.querySelector("div.infoi #pagamento");
            cardDespensasValor.innerHTML='';
            let valorTotal = 0;
            cardDespensasValor.innerHTML="Total de: "+valorTotal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
        }else{
            const tabelaDespesaBody = document.querySelector("table #tabelaDespesaBody");
            tabelaDespesaBody.innerHTML='';
            let Total = 0;
            //table
            //tabelaDespesaBody.setAttribute('class','table');
            for(let i=0;i<=(data.despensasMensais.length-1);i++){
                let tr = document.createElement('tr');
                let td1 = document.createElement('td');
                let td2 = document.createElement('td');
                let valor = Number.parseFloat(data.despensasMensais[i].ValorTotal);

                valor = valor.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

                td1.innerHTML=data.despensasMensais[i].Historico;
                td2.innerHTML="<span class='text-danger'>-"+valor+"</span>";
                
                tr.append(td1);
                tr.append(td2);

                tabelaDespesaBody.append(tr);
                
                Total += Number.parseFloat(data.despensasMensais[i].ValorTotal);
            }
            let tr = document.createElement('tr');
            let td = document.createElement('td');
            let valorTotal = Total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            td.setAttribute('colspan','2');
            td.innerHTML="Total: <span class='text-danger'>-"+valorTotal+"</span>";
            tr.append(td);
            tabelaDespesaBody.append(tr);
            
            const cardDespensasValor = document.querySelector("div.infoi #pagamento");
            cardDespensasValor.innerHTML='';
            cardDespensasValor.innerHTML="Total de: -"+valorTotal;
        }   
}

function buscarDadosPJ(){
    let form = $('#formEscolhePJ')[0];
    let formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/buscarDadosPJ'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
           // const cardSaldo = document.querySelector("div#cardSaldo .card-body");
            
            //cardSaldo.innerHTML="Total: "+data.saldo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            
            receitasMensais(data);
            
            despesasMensais(data);
            
            receitaAnual(data);
            
            despesaAnual(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}
