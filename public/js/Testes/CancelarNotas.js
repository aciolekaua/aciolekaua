function cancelarNota(){
    let form = $('#formCancelementoNota')[0];
    let formData = new FormData(form);
    $.ajax({
        url:getRoot("cash/teste/cancelarNota"),
        type:"POST",
        datatype:"json",
        data: formData,
        timeout:18000,
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            console.log(data)
        },
        error: function(texto1, texto2, texto3){
            console.log(texto1+" "+texto2+" "+texto3 );
        }
    });
}