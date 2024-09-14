// Get unique values for the desired columns

// {2 : ["M", "F"], 3 : ["RnD", "Engineering", "Design"], 4 : [], 5 : []}

function getUniqueValuesFromColumn() {

    var unique_col_values_dict = {}

    allFilters = document.querySelectorAll(".table-filter")
    allFilters.forEach((filter_i) => {
        col_index = filter_i.parentElement.getAttribute("col-index");
        // alert(col_index)
        const rows = document.querySelectorAll("#emp-table > tbody > tr")

        rows.forEach((row) => {
            cell_value = row.querySelector("td:nth-child("+col_index+")").innerHTML;
            // if the col index is already present in the dict
            if (col_index in unique_col_values_dict) {

                // if the cell value is already present in the array
                if (unique_col_values_dict[col_index].includes(cell_value)) {
                    // alert(cell_value + " is already present in the array : " + unique_col_values_dict[col_index])

                } else {
                    unique_col_values_dict[col_index].push(cell_value)
                    // alert("Array after adding the cell value : " + unique_col_values_dict[col_index])

                }


            } else {
                unique_col_values_dict[col_index] = new Array(cell_value)
            }
        });

        
    });

    for(i in unique_col_values_dict) {
        // alert("Column index : " + i + " has Unique values : \n" + unique_col_values_dict[i]);
    }

    updateSelectOptions(unique_col_values_dict)

};

// Add <option> tags to the desired columns based on the unique values

function updateSelectOptions(unique_col_values_dict) {
    allFilters = document.querySelectorAll(".table-filter")

    allFilters.forEach((filter_i) => {
        col_index = filter_i.parentElement.getAttribute('col-index')

        unique_col_values_dict[col_index].forEach((i) => {
            filter_i.innerHTML = filter_i.innerHTML +"\n<option value=${i}>${i}</option>"
        });

    });
};


// Create filter_rows() function

// filter_value_dict {2 : Value selected, 4:value, 5: value}

function filter_rows() {
    allFilters = document.querySelectorAll(".table-filter")
    var filter_value_dict = {}

    allFilters.forEach((filter_i) => {
        col_index = filter_i.parentElement.getAttribute('col-index')

        value = filter_i.value
        if (value != "all") {
            filter_value_dict[col_index] = value;
        }
    });

    var col_cell_value_dict = {};

    const rows = document.querySelectorAll("#emp-table tbody tr");
    rows.forEach((row) => {
        var display_row = true;

        allFilters.forEach((filter_i) => {
            col_index = filter_i.parentElement.getAttribute('col-index')
            col_cell_value_dict[col_index] = row.querySelector("td:nth-child(" + col_index+ ")").innerHTML
        })

        for (var col_i in filter_value_dict) {
            filter_value = filter_value_dict[col_i]
            row_cell_value = col_cell_value_dict[col_i]
            
            if (row_cell_value.indexOf(filter_value) == -1 && filter_value != "all") {
                display_row = false;
                break;
            }


        }

        if (display_row == true) {
            row.style.display = "table-row"

        } else {
            row.style.display = "none"

        }





    })

}

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
        //let valorPercentualAplicado = dados.dadosAliquota.declaracao[nomeImpostosArray[i]][nomeImpostosArray[i]+'_PercentualAplicado'];
        let valorParticionaldo = dados.dadosAliquota.semRetencao[nomeImpostosArray[i]][nomeImpostosArray[i]+'_ValorImposto'];

        /*if(valorPercentualAplicado==undefined){
            trPercentualAplicado.innerHTML+=`<td>0%</td>`;
        }else{
            trPercentualAplicado.innerHTML+=`<td>${valorPercentualAplicado}%</td>`;
        }*/

        if(valorParticionaldo==undefined){
            trSemRetencao.innerHTML+=`<td>R$ 0</td>`;
        }else{
            trSemRetencao.innerHTML+=`<td>${parseFloat(valorParticionaldo)
            .toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</td>`;
        }
    }
    /*Fim do sem retenção*/

    /*Valores da DAS*/
    trDAS.innerHTML+=`<td>Valor da DAS:${0}</td>`;
    for(let i=0;i<nomeImpostosArray.length;i++){
        trDAS.innerHTML+=`<td></td>`;
    }
    /*Fim da DAS*/
    
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
            spanStatusCalculado.innerHTML='Calculado no Anexo 3: Sim';
            table_wrapper.append(spanStatusCalculado);
        }else if(dados.anexo=="5"){
            var spanStatusCalculado = document.createElement("span");
            spanStatusCalculado.id='spanAnexo5';
            spanStatusCalculado.innerHTML='Calculado no Anexo 3: Não';
            table_wrapper.append(spanStatusCalculado);
        }
        table_wrapper.append(table);
    }
    

}

/*Função de requisição do calculo do Simples*/
function calcSimples(formData) {
    /*var form = $('#formCalcSimples')[0];
    var formData = new FormData(form);*/
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
            //console.log(Object.keys(data.dadosAliquota));
            escreverTableSimples(data)

        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });    
}
/*Fim da função*/

/*inicio da escolha do tipo de view que vai ver*/
const radios = document.querySelectorAll('input[type="radio"]');

for (const radio of radios) {
    radio.addEventListener('change', (event) => {
      const divId = event.target.value;
      const divs = document.querySelectorAll('.table-wrapper');
  
      for (const div of divs) {
        div.style.display = 'none';
      }
  
      document.getElementById(divId).style.display = 'block';
    });
  }
/*fim do for*/

/*Evento de envio de dados do Simples*/
document.getElementById('enviar').addEventListener('click',()=>{
    var table_wrapper = document.querySelector('.table-wrapper');
    table_wrapper.innerHTML='';

    var form = $('#formCalcSimples')[0];
    var formData = new FormData(form);
    for(let anexo=1;anexo<=5;anexo++){
        if(formData.get('faturamento_anexo'+anexo+'_sem_retencao')!="" || formData.get('faturamento_anexo'+anexo+'_com_retencao')!=""){
            let faturamentoSemRetencao=formData.get('faturamento_anexo'+anexo+'_sem_retencao');
            let faturamentoComRetencao=formData.get('faturamento_anexo'+anexo+'_com_retencao');
            let faturamentoDoMes = parseFloat(faturamentoSemRetencao)+parseFloat(faturamentoComRetencao);
            //console.log(result);
            formData.append('faturamentoDoMes',faturamentoDoMes);
            formData.append('faturamentoSemRetencao',faturamentoSemRetencao);
            formData.append('faturamentoComRetencao',faturamentoComRetencao);
            formData.append('anexo',anexo);
            calcSimples(formData);
        }
    }
});
/*Fim do evento*/

/*Envento de checklist do formulário*/
const divs = document.querySelectorAll(".check");
const checkboxes = document.querySelectorAll(".checkbox");

console.log("helooooo")
for (let i = 0; i < checkboxes.length; i++) {
  checkboxes[i].addEventListener("change", function () {
    if (this.checked) {
      divs[i].style.display = "flex";
    } else {
      divs[i].style.display = "none";
    }
  });
}
/*Fim do evento*/