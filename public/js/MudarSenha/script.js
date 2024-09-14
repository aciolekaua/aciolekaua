window.addEventListener('load',()=>{
    const btnMudarSenha = document.querySelector("button#btnMudarSenha");
    
    btnMudarSenha.addEventListener('click',()=>{
        var form = $('#formMudaSenha')[0];
        var formData = new FormData(form);
        $.ajax({
            url:getRoot(getURL()+'/mudarSenha'),
            type:"POST",
            dataType:'json',
            data:formData,
            timeout:12000,
            cache:false,
            processData: false,
            contentType:false,
            success: function(data,status,xhr){
                console.log(data);
                const divMSG = document.querySelector("div#divMSG");
                divMSG.innerHTML='';
                
                if(data.erros.length>0){
                    for(var i = 0;i<(data.erros.length);i++){
                        divMSG.innerHTML+="<div class='d-block mb-1 alert alert-danger alert-dismissible fade show' role='alert'><i class='bi bi-x-circle-fill me-1'></i>"+data.erros[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                    }
                }
                
                if(data.sucessos.length>0){
                    for(var i = 0;i<(data.sucessos.length);i++){
                        divMSG.innerHTML+="<div class='d-block mb-1 alert alert-success alert-dismissible fade show' role='alert'><i class='bi bi-check-circle-fill me-1'></i>"+data.sucessos[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                    }
                }
            },
            error: function(jqXhr, textStatus, errorMessage){
                console.log(jqXhr+" "+textStatus+" "+errorMessage);
            }
        });
    });
    
});