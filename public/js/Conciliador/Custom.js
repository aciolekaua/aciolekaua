$(document).ready(function () {
     $('[data-toggle="tooltip"]').tooltip({
         placement : 'top'
     });
     $('#listar-dados').DataTable({
         serverSide: true,
         ajax: getRoot(getURL()+'visualizandoTabela'),
         language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json',
         },
         'dom': 'lBfrtip',
         'buttons': [
             {
                 "extend":"excelHtml5",
                 "text":"<i class='fas fa-file-excel'></i> Excel",
                 "title":"Exportar o Excel",
                 "className": "btn btn-success",
             },{
                 "extend":"pdfHtml5",
                 "text":"<i class='fas fa-file-pdf'></i> PDF",
                 "title":"Exportar o PDF",
                 "className": "btn btn-danger",
             },{
                "extend":"csvHtml5",
                 "text":"<i class='fas fa-file-csv'></i> CSV",
                 "title":"Exportar o CSV",
                 "className": "btn btn-primary",
             }
        ],
    });
});
    
$(function(){
   $('#btnEnviar').on('click', function(){
      const formCSV = $("#formEnviarCSV")[0];
      const formData = new FormData(formCSV);
      //formData.append("file",arquivoCsv.files[0]);
      console.log(Array.from(formData));
      console.log(formData);
      $.ajax({
        url:getRoot(getURL()+'/enviarArquivos'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
            success: function(data,status,xhr){
                console.log(data);
            },
            error: function(jqXhr, textStatus, errorMessage){
                console.log(jqXhr+" "+textStatus+" "+errorMessage);
            } 
      })
       
    }); 
});