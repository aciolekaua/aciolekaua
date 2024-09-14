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

function dados(){
      $.ajax({
          url:getRoot(getURL()+'/dados'),
          beforeSend: function(){
            $('.overlay-loading').fadeIn();
          },
          type:"GET",
          dataType:'json',
          success: function(data,status,xhr){
              console.log(data);
              $('.overlay-loading').fadeOut();
              sessionStorage.setItem("dadosHomePJ", 1);
              if(data.TipoCliente=="PF"){
                  console.log(data.TipoCliente);
                  //const selectPJ = document.querySelector('select[name=PJ]');
                  if(data.erros.length>0){
                      
                  }else{
                    if(data.PJs.length>0){
                        //selectPJ.innerHTML='';
                        //selectPJ.innerHTML+="<option value=''>Selecione uma PJ</option>";
                        // for(let i=0;i<=data.PJs.length-1;i++){
                        //     //console.log(data.PJs[i].Nome);
                        //     selectPJ.innerHTML+="<option value='"+data.PJs[i].CNPJ+"'>"+data.PJs[i].Nome+"</option>";
                        // }
                    }
                  }
              }else if(data.TipoCliente=="PJ"){
                
                //const cardSaldo = document.querySelector("div.info-card-item #saldo");
                
                const cardPagamento = document.querySelector("div.infoi #pagamento");
                
                const cardRecebimento = document.querySelector('div.infoi #recebimento');

                //console.log(cardRecebimento);
                cardPagamento.innerHTML="Total de: R$ 0,00";
                if(data.despensasMensais!=false){
                    cardPagamento.innerHTML="Total de: "+data.despensasMensais.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                }

                cardRecebimento.innerHTML="Total de: R$ 0,00";
                if(data.receitasMensais!=false){
                    cardRecebimento.innerHTML="Total de: "+data.saldo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                }

                //cardSaldo.innerHTML=""+data.saldo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});

                receitasMensais(data);
                
                despesasMensais(data);
                
                receitaAnual(data);
                
                despesaAnual(data);
                
              }
              
          },
          error: function(jqXhr, textStatus, errorMessage){
              console.log(jqXhr+' '+textStatus+' '+errorMessage);
          }
      });
}
// Chart Recebimento(Com Dados reais)
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
              let td = document.createElement('td');
              let valor = Number.parseFloat(data.receitasMensais[i].ValorTotal);
              valor = valor.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
              
              td.innerHTML=data.receitasMensais[i].Historico+": <span class='text-success'>+"+valor+"</span>";
              tr.appendChild(td);
              tabelaReceitaBody.appendChild(tr);
              
              Total += Number.parseFloat(data.receitasMensais[i].ValorTotal);
          }
          let tr = document.createElement('tr');
          let td = document.createElement('td');
          let valorTotal = Total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
          td.innerHTML="Total: <span class='text-success'>+"+valorTotal+"</span>";
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
            
            for(let i=0;i<=(data.despensasMensais.length-1);i++){
                let tr = document.createElement('tr');
                let td = document.createElement('td');
                let valor = Number.parseFloat(data.despensasMensais[i].ValorTotal);
                valor = valor.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                td.innerHTML=data.despensasMensais[i].Historico+": <span class='text-danger'>-"+valor+"</span>";
                tr.appendChild(td);
                tabelaDespesaBody.appendChild(tr);
                
                Total += Number.parseFloat(data.despensasMensais[i].ValorTotal);
            }
            let tr = document.createElement('tr');
            let td = document.createElement('td');
            let valorTotal = Total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            
            td.innerHTML="Total: <span class='text-danger'>-"+valorTotal+"</span>";
            tr.appendChild(td);
            tabelaDespesaBody.appendChild(tr);
            
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
