// Verifica se o elemento existe antes de adicionar o evento
const exportFile = document.querySelector(".export__file-btn");
const exportOptions = document.querySelector(".export__file-options");

// // toggle abrir e fechar box
if (exportFile && exportOptions) {
    exportFile.addEventListener("click", () => {
        // console.log('entrei :)');
        exportOptions.classList.toggle("open");
    });
    
    // // hide style - exportFile on scroll
    window.addEventListener("scroll", () => {
        if (exportOptions.classList.contains("open")) {
            exportOptions.classList.remove("open");
            // console.log('entrei if :)');
        }
    });
} else {
    console.log('Elementos não encontrados.');
}

function start_tippys(){
    tippy('#view', {
        content: '<strong>Visualizar <span style="color: #c3aeff;">Informações</span></strong>',
        allowHTML: true,
        duration:50,
        maxWidth: 200,
        placement: 'top',
        animation: 'perspective',
        followCursor: 'horizontal',
      });
    tippy('#calcular', {
        content: '<strong>Calcular <span style="color: #c3aeff;">DAS</span></strong>',
        allowHTML: true,
        duration:50,
        maxWidth: 200,
        placement: 'bottom',
        animation: 'perspective',
        followCursor: 'horizontal',
      });
}

// setup 
const data = {
  // labels: ['Jan', 'Fev', 'Mar','Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
  labels: ['Bom', 'Ruim', 'Risco'],
  datasets: [{
    label: 'Weekly Sales',
    // data: [5550, 5633, 5800, 5988, 4811, 4399, 2121, 4177, 6700, 6733, 12000, 14000],
    data: [2160000, 1080000, 360000],
    backgroundColor: [
      '#2fa52d',
      '#ffc15e',
      '#f42d2d',
    ],
    needleValue: 0,
    borderColor:'#afb7bf',
    borderWidth: 2,
    cutout: '95%',
    circumference: 180,
    rotation: 270,
    borderRadius:5,
  }]
};

  // gaugeNeedle
const gaugeNeedle = {
id: 'gaugeNeedle',
afterDatasetDraw(chart, args, options) {
    const { ctx, config, data, chartArea: { top, bottom, left, right, 
    width, height } } = chart;

    ctx.save();
    // console.log(data);
    const needleValue = data.datasets[0].needleValue;
    const dataTotal = data.datasets[0].data.reduce((a, b) => a + b, 0)
    const angle = Math.PI + (1 / dataTotal * needleValue * Math.PI)
    // const angle = dataTotal / needleValue
    //const cx = width / 2;
    const cx = width / 2;
    const cy = chart._metasets[0].data[0].y;
    // console.log(chart._metasets[0].data[0].y);
    // console.log(ctx);
    
    // needle
    ctx.translate(cx, cy);
    ctx.rotate(angle);
    ctx.beginPath();
    ctx.moveTo(0, -2);
    ctx.lineTo((cy / 1.8)  + 20, 0);
    ctx.lineTo(0, 2);
    ctx.fillStyle ='#6c757d';
    ctx.fill();
    ctx.restore();

    // needle dot
    ctx.beginPath();
    ctx.arc(cx, cy, 5, 0, 10);
    ctx.fill();
    ctx.restore();
    
    const total = 3600000 - needleValue;

    ctx.font = '20px Helvetica';
    ctx.fillStyle = '#6c757d';
    ctx.fillText('Limite: ' + total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }), cx, cy + 30);
    ctx.textAlign = 'center';
    ctx.restore();


    /**ctx.font = '20px Helvetica';
    ctx.fillStyle = '#6c757d';
    ctx.fillText('RBA: ' +'R$ ' + needleValue, cx, cy + 30);
    ctx.textAlign = 'center';
    ctx.restore();**/
}
}
 // config 
 const config = {
  type: 'doughnut',
  data,
  options: {
    plugins:{
      legend: {
        display: false
      },
      tooltip: {
        yAlign: 'bottom',
        displayColors: false,
        callbacks: {
          label: function(tooltipItem, data, value) {
            const tracker = tooltipItem.dataset.needleValue;
            return `Limite Usado: ${tracker.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}`;
          }
        }
      }
    }
  },
  plugins: [gaugeNeedle]
};
// render init block
const limite = new Chart(
  document.getElementById('myChartLimite'),
  config
);

const search = document.querySelector('.input-group-search input'),
//table_rows = document.querySelectorAll('tbody tr'),
table_headings = document.querySelectorAll('thead th');

// 1. Procurando dados específicos da tabela HTML

function searchTable(table_rows) {
    //console.log(table_rows);
    table_rows.forEach((row, i) => {
        let table_data = row.textContent.toLowerCase(),
            search_data = search.value.toLowerCase();

        row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
        row.style.setProperty('--delay', i / 25 + 's');
    });

    document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
        visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
    });
}

// 2. Classificação | Ordenando dados da tabela HTML
function tableHeadings(table_rows){
    //console.log(table_rows);
    table_headings.forEach((head, i) => {
        let sort_asc = true;
        head.onclick = () => {
            table_headings.forEach(head => head.classList.remove('active'));
            head.classList.add('active');
    
            document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
            table_rows.forEach(row => {
                row.querySelectorAll('td')[i].classList.add('active');
            });
    
            head.classList.toggle('asc', sort_asc);
            sort_asc = head.classList.contains('asc') ? false : true;
    
            sortTable(i, sort_asc,table_rows);
        };
    });
}

function sortTable(column, sort_asc,table_rows) {
    [...table_rows].sort((a, b) => {
        let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
            second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

        return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
    })
        .map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
}

// 3. Convertendo tabela HTML em PDF

const pdf_btn = document.querySelector('#toPDF');
const customers_table = document.querySelector('.customers_table');


const toPDF = function (customers_table) {
    const html_code = `
    <!DOCTYPE html>
    <link rel="stylesheet" type="text/css" href="style.css">
    <main class="table" id="customers_table">${customers_table.innerHTML}</main>`;

    const new_window = window.open();
     new_window.document.write(html_code);

    setTimeout(() => {
        new_window.print();
        new_window.close();
    }, 400);
}

pdf_btn.onclick = () => {
    toPDF(customers_table);
}

// 4. Convertendo tabela HTML em JSON

const json_btn = document.querySelector('#toJSON');

const toJSON = function (table) {
    let table_data = [],
        t_head = [],

        t_headings = table.querySelectorAll('th'),
        t_rows = table.querySelectorAll('tbody tr');

    for (let t_heading of t_headings) {
        let actual_head = t_heading.textContent.trim().split(' ');

        t_head.push(actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase());
    }

    t_rows.forEach(row => {
        const row_object = {},
            t_cells = row.querySelectorAll('td');

        t_cells.forEach((t_cell, cell_index) => {
            const img = t_cell.querySelector('img');
            if (img) {
                row_object['customer image'] = decodeURIComponent(img.src);
            }
            row_object[t_head[cell_index]] = t_cell.textContent.trim();
        })
        table_data.push(row_object);
    })

    return JSON.stringify(table_data, null, 4);
}

json_btn.onclick = () => {
    const json = toJSON(customers_table);
    downloadFile(json, 'json')
}

// 5. Convertendo tabela HTML em arquivo CSV

const csv_btn = document.querySelector('#toCSV');

const toCSV = function (table) {
    // Code For SIMPLE TABLE
    // const t_rows = table.querySelectorAll('tr');
    // return [...t_rows].map(row => {
    //     const cells = row.querySelectorAll('th, td');
    //     return [...cells].map(cell => cell.textContent.trim()).join(',');
    // }).join('\n');

    const t_heads = table.querySelectorAll('th'),
        tbody_rows = table.querySelectorAll('tbody tr');

    const headings = [...t_heads].map(head => {
        let actual_head = head.textContent.trim().split(' ');
        return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
    }).join(',') + ',' + 'image name';

    const table_data = [...tbody_rows].map(row => {
        const cells = row.querySelectorAll('td'),
            img = decodeURIComponent(row.querySelector('img').src),
            data_without_img = [...cells].map(cell => cell.textContent.replace(/,/g, ".").trim()).join(',');

        return data_without_img + ',' + img;
    }).join('\n');

    return headings + '\n' + table_data;
}

csv_btn.onclick = () => {
    const csv = toCSV(customers_table);
    downloadFile(csv, 'csv', 'customer orders');
}

// 6. Convertendo tabela HTML em arquivo EXCEL

const excel_btn = document.querySelector('#toEXCEL');

const toExcel = function (table) {
    // Code For SIMPLE TABLE
    // const t_rows = table.querySelectorAll('tr');
    // return [...t_rows].map(row => {
    //     const cells = row.querySelectorAll('th, td');
    //     return [...cells].map(cell => cell.textContent.trim()).join('\t');
    // }).join('\n');

    const t_heads = table.querySelectorAll('th'),
        tbody_rows = table.querySelectorAll('tbody tr');

    const headings = [...t_heads].map(head => {
        let actual_head = head.textContent.trim().split(' ');
        return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
    }).join('\t') + '\t' + 'image name';

    const table_data = [...tbody_rows].map(row => {
        const cells = row.querySelectorAll('td'),
            img = decodeURIComponent(row.querySelector('img').src),
            data_without_img = [...cells].map(cell => cell.textContent.trim()).join('\t');

        return data_without_img + '\t' + img;
    }).join('\n');

    return headings + '\n' + table_data;
}

excel_btn.onclick = () => {
    const excel = toExcel(customers_table);
    downloadFile(excel, 'excel');
}

const downloadFile = function (data, fileType, fileName = '') {
    const a = document.createElement('a');
    a.download = fileName;
    const mime_types = {
        'json': 'application/json',
        'csv': 'text/csv',
        'excel': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    }
    a.href = `
        data:${mime_types[fileType]};charset=utf-8,${encodeURIComponent(data)}
    `;
    document.body.appendChild(a);
    a.click();
    a.remove();
}

//  7. 
// const divs = document.querySelectorAll(".tabela");
// const acessar = document.querySelectorAll(".acessar");

// for (let i = 0; i < acessar.length; i++) {
    //     acessar[i].addEventListener("click", function () {
        //     //   console.log("entrou no evento")
        //     if (this.click) {
            //         divs[i].style.display = "flex";
//         console.log("entrou no if")
//     } else {
    //         console.log("entrou no else")
    //       divs[i].style.display = "none";
    //     }
    //   });
    // }
    
    const divs = document.querySelectorAll(".tabela");
    const acessar = document.querySelectorAll(".acessar");
    let divAberta = null;
    
    for (let i = 0; i < acessar.length; i++) {
        acessar[i].addEventListener("click", function () {
            const targetDivId = this.dataset.target; //Assumindo atributo de destino de dados
            const targetDiv = document.querySelector(`#${targetDivId}`);
            
            if (divAberta && divAberta !== targetDiv) {
                divAberta.style.display = "none";
            }
            
            if (targetDiv.style.display === "block") {
                targetDiv.style.display = "none";
                divAberta = null;
            } else {
                targetDiv.style.display = "block";
                divAberta = targetDiv;
            }
        });
    }

function calcularRBT12(anexo=null){
    var input_rbt12 = document.querySelector("input[name=rbt12]");
    if(anexo==null){
        var valor_totalizada_DAS = 0;
        var valor_totalizada_folha = 0;

        for(let anexo=1;anexo<=5;anexo++){
            //console.log(anexo);
            var input_faturamento_sem_retencao = document.querySelector("input[name=faturamento_sem_retencao_anexo_"+anexo+"]");
            var input_faturamento_com_retencao = document.querySelector("input[name=faturamento_com_retencao_anexo_"+anexo+"]");
            //var input_folha = document.querySelector("input[name=folha_anexo_"+anexo+"]");

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
                //formData.append('folha',input_folha.value);

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
                        valor_totalizada_folha += 
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

                        document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado.replace('.',',')+"%";
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
        //var input_folha = document.querySelector("input[name=folha_anexo_"+anexo+"]");

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
            //formData.append('folha',input_folha.value);

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
                    document.querySelector('div[id=div_valor_totalizada_DAS]').innerText = "Total da DAS: " + valor_totalizada_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    document.querySelector('div[id=div_valor_totalizado_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + valor_total_DAS.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    document.querySelector('h3[id=div_aliquota_retencao_anexo_'+anexo+']').innerText = "Anexo "+anexo+": " + data.dadosAliquota.declaracao.ISS.ISS_PercentualAplicado.replace('.',',')+"%";
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
    var h2_rbt12_card = document.querySelector('h2[id=h2_rbt12_card]');
    var h2_folha_card = document.querySelector('h2[id=h2_fatorR_card]');

    h2_rbt12_card.innerText ="Total do RBT12: " +  dados.rbt12.toLocaleString('pt-BR', {
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

    var fatorR = dados.fatorR +"";

    h2_folha_card.innerText = "Fator R: " + fatorR.replace('.',',') + '%';

    for(let i=1;i<=5;i++){
        document.querySelector("input[name=faturamento_sem_retencao_anexo_"+i+"]").value="0,00";
        document.querySelector("input[name=faturamento_com_retencao_anexo_"+i+"]").value="0,00";
        //document.querySelector("input[name=folha_anexo_"+i+"]").value="0,00";
    }
    
    /*select_anexo.value = "";
    json = JSON.stringify(dados);
    select_anexo.setAttribute('onchange',`getFatulras(${json})`);*/
}

function escrever_tabela(data){
    var tbody = document.querySelector('table[id=tabela_RBT12] tbody');
    console.log(data);
    //tbody.innerHTML = '';
    
    for(let i=0;i<=(data.length - 1);i++){
        var row = document.createElement('tr');
        var c_status = document.createElement('td');
        var c_periodo = document.createElement('td');
        var c_rbt12 = document.createElement('td');
        var c_botoes_de_acao = document.createElement('td');
        var c_cnpj = document.createElement('td');
        var c_razao = document.createElement('td');
        var c_status_envio = document.createElement('td');
        var c_ultima_busca = document.createElement('td');
        var c_mais = document.createElement('td');
        var c_botaoModal = document.createElement('td');

        c_status.innerHTML='<p class="status delivered">Em dia</p>';
        row.append(c_status);

        c_periodo.setAttribute('class','td-periodo');
        c_periodo.innerHTML = '<p class="periodo pending">'+data[i].competencia.split('-')[1]+'</p>';
        row.append(c_periodo);

        data[i].rbt12 = parseFloat(data[i].rbt12);
        c_rbt12.setAttribute('class','text-matrix');
        c_rbt12.innerHTML = '<p class="rbt12">'+data[i].rbt12.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL',
            minimumFractionDigits: 2
        })+'</p>';
        row.append(c_rbt12);

        c_botoes_de_acao.setAttribute('class','text-matrix');
        c_botoes_de_acao.innerHTML = `
            <a href=""><i class="bi bi-file-earmark-arrow-down-fill"></i></a>
            <!--<a href=""><i class="bi bi-arrow-counterclockwise"></i></a>-->
            <a href=""><i class="bi bi-person-fill-down"></i></a>
        `;
        row.append(c_botoes_de_acao);

        c_cnpj.setAttribute('class','text-matrix');
        c_cnpj.innerHTML = data[i].cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
        row.append(c_cnpj);

        c_razao.setAttribute('class','text-matrix');
        c_razao.innerHTML = data[i].razao;
        row.append(c_razao);
        
        /*c_status_envio.setAttribute('class','baixado');
        c_status_envio.innerHTML = '<a href=""><i class="bi bi-check-circle-fill"></i></a>';
        row.append(c_status_envio);*/

        c_ultima_busca.innerHTML = '<p class="busca">09/08/2024</p>';
        row.append(c_ultima_busca);

        //botaoModal.setAttribute('type','button');
        //c_botaoModal.setAttribute('class','btn-visualizar');
        //c_botaoModal.innerText = "Calcular";
        //c_botaoModal.addEventListener('click',()=>{escrever_dados_modal(data[i]);});
        //c_botaoModal.setAttribute('data-bs-toggle','modal');
        //c_botaoModal.setAttribute('data-bs-target','#modal_calcular_simples');

        var calcularRBT12 = document.createElement('img');
        calcularRBT12.src = dirImg()+'CalcularSimples/DAS/calculations-calculate-svgrepo-com.svg';
        calcularRBT12.setAttribute('id','calcular');
        calcularRBT12.addEventListener('click',()=>{escrever_dados_modal(data[i]);});
        calcularRBT12.setAttribute('data-bs-toggle','modal');
        calcularRBT12.setAttribute('data-bs-target','#modal_calcular_simples');
        calcularRBT12.style.cursor="pointer";

        var visualizar = document.createElement('img');
        visualizar.src = dirImg()+'CalcularSimples/DAS/view-svgrepo-com.svg';
        visualizar.setAttribute('id','view');
        visualizar.style.cursor="pointer";

        c_botaoModal.append(visualizar);
        c_botaoModal.append(calcularRBT12);

        //c_mais.append(c_botaoModal);
        row.append(c_botaoModal);

        tbody.append(row);
    }

    search.addEventListener('input', ()=>{searchTable(document.querySelectorAll('tbody tr'));});
    //console.log(search);
    tableHeadings(document.querySelectorAll('tbody tr'));
    start_tippys();
}

function buscarSimples(dados_fatura){
    var tbody = document.querySelector('table[id=tabela_RBT12] tbody');
    tbody.innerHTML = '';

    dados_tabela = [];
    
    var formData = new FormData();
    /*for(let i=0;i<=(dados_fatura.length -1);i++){
        formData.append(`cnpj[${i}]`,dados_fatura[i].cnpj);
        formData.append(`razao[${i}]`,dados_fatura[i].nome);
    }*/
    
    formData.append('rogeri0','');
    $.ajax({
        url:getRoot(getURL()+'/getRBT12'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success :function(data,status,xhr){
            console.log(data);
            if(data.dados!=false){
                escrever_tabela(data.dados);
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
    
    
}
    
window.addEventListener("load",()=>{
    $.ajax({
        url:getRoot(getURL()+'/empresas_faturamentoDAS'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);

            if(data.erro.length>0){
                return false;
            }

            buscarSimples(data.empresas);
                        
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });

    for(let i=1;i<=5;i++){
        //console.log(i);
        document.querySelector("input[name=faturamento_sem_retencao_anexo_"+i+"]").addEventListener('blur',()=>{
            calcularRBT12(i);
        });
        document.querySelector("input[name=faturamento_com_retencao_anexo_"+i+"]").addEventListener('blur',()=>{
            calcularRBT12(i);
        });
        /*document.querySelector("input[name=folha_anexo_"+i+"]").addEventListener('blur',()=>{
            calcularRBT12(i);
        });*/
    }
   
    /*document.querySelector('button[id=btn_calcular_simples').addEventListener('click',()=>{
        calcularRBT12();
    }); */
})