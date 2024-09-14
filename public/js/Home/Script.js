function exportExcel(id,filename,type,fn, dl){
    var elt = document.getElementById(id);
    var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
    return dl ?
     XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
     XLSX.writeFile(wb, fn || (filename+'.' + (type || 'xlsx')));
}

function exportPDF(id,fileName){
    
    var table = document.getElementById(id);
    
    var opt = {
        margin: 1,
        filename: fileName+'.pdf',
        image: {type:'jpeg', quality:0.95},
        html2canvas: {scale:2},
        jsPDF: {orientation: 'l',
            unit: 'cm',
            format: 'a4',
            putOnlyUsedFonts:true,
            floatPrecision: 16}
        }
    
    html2pdf(table,opt);
}

function download_table_as_csv(table_id="id1", separator = ",") {
    // Select rows from table_id
    var rows = document.querySelectorAll("table#" + table_id + " tr");
    // Construct csv
    var csv = [];
      //looping through the table
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
           //looping through the tr
        for (var j = 0; j < cols.length; j++) {
           // removing space from the data
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/(\s\s)/gm, " ")
             // removing double qoute from the data
            data = data.replace(/"/g, `""`);
            // Push escaped string
            row.push(`"` + data + `"`);
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join("\n");
    // Download it
    var filename = "export_" + table_id + "_" + new Date().toLocaleDateString() + ".csv";
    var link = document.createElement("a");
    link.style.display = "none";
    link.setAttribute("target", "_blank");
    link.setAttribute("href", "data:text/csv;charset=utf-8," + encodeURIComponent(csv_string));
    link.setAttribute("download", filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

window.addEventListener("load",()=>{
    var TipoClientePJ = document.querySelectorAll(".TipoClientePJ");
    var TipoClientePF = document.querySelectorAll(".TipoClientePF");
    if(sessionStorage.getItem('TipoCliente')=="PF"){
    
        for(let i=0;i<=(TipoClientePJ.length-1);i++){
            TipoClientePJ[i].style.display='none';
        }
        for(let i=0;i<=(TipoClientePF.length-1);i++){
            //TipoClientePF[i].style.display='flex';
        }
    }else if(sessionStorage.getItem('TipoCliente')=="PJ"){
        for(let i=0;i<=(TipoClientePJ.length-1);i++){
            //TipoClientePJ[i].style.display='flex';
        }
        for(let i=0;i<=(TipoClientePF.length-1);i++){
            TipoClientePF[i].style.display='none';
        }
        /*var CardPF = document.document.querySelectorAll(".TipoClientePF");
        CardPF.style.display='none';*/
    }
    
});
function pagamentoPix(){
    
    qrCodePix();
}
// function dadosPF(){
//     $.ajax({
//         url:getRoot('cash/home/dadosPF'),
//         type:"GET",
//         dataType:'json',
//         success: function(data,status,xhr){
//             console.log(data);
//             const cardSaldo = document.querySelector("div#cardSaldoPF .card-body");
//             const CpfUsuarios = document.getElementById("PF");
            
//             cardSaldo.innerHTML="Total: "+data.saldo.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
            
//             receitasMensais(data);
            
//             despesasMensais(data);
            
//             receitaAnual(data);
            
//             despesaAnual(data);
            
//             cpfUsuarios(data);
//             console.log(cpfUsuarios);
        
        
//             CpfUsuarios.innerHTML='';
//             for(let i=0;i<=data.cpfUsuarios.length-1;i++){
//                 CpfUsuarios.innerHTML+="<option value='"+data.cpfUsuarios[i]+"'>"+data.cpfUsuarios[i]+"</option>";
//             }
//         },
//         error: function(jqXhr, textStatus, errorMessage){
//             console.log(jqXhr+' '+textStatus+' '+errorMessage);
//         }
//     });
// }
