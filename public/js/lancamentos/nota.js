//Dados
function dados(){
    $.ajax({
        url:getRoot('cash/lancamentos-nota/dados'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            if(data.error.length>0){
                const divMSG = document.querySelector("div[id=mensage]");
                divMSG.innerHTML="<div class='alert alert-danger alert-dismissible fade show' role='alert'>Falha na busca de dados<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }else{
                const selectPJ = document.querySelector("select[name=PJ]");
                if(selectPJ.length>1){
                }else{
                    for(var i = 0;i<=(data.pj[0].length-1);i++){selectPJ.innerHTML+="<option value='"+data.pj[0][i].CNPJ+"'>"+data.pj[0][i].Nome+"</option>";}
                    const dSelect=document.querySelectorAll(".dselect");
                    for(var i=0;i<=(dSelect.length-1);i++){dselect(dSelect[i],{search:true})}
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
            
            const divMSG = document.querySelector("div[id=mensage]");
            divMSG.innerHTML="<div class='alert alert-danger alert-dismissible fade show' role='alert'>Falha na busca de dados<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            
            const dSelect=document.querySelectorAll(".dselect");
            for(var i=0;i<=(dSelect.length-1);i++){dselect(dSelect[i],{search:true})}
        }
    });
    
}
window.addEventListener('load',()=>{
    dados();
});

function registro(){
    var form = $('#formNota')[0];
    //console.log(form);
    var formData = new FormData(form);
    $.ajax({
        url:getRoot('cash/lancamentos-nota/registro'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            
            const divMSG = document.querySelector("div[id=mensage]");
            
            if(data.erros.length>0){
                for(var i = 0;i<(data.erros.length);i++){
                    divMSG.innerHTML+="<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+data.erros[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
            
            if(data.sucessos.length>0){
                for(var i = 0;i<(data.sucessos.length);i++){
                    divMSG.innerHTML+="<div class='alert alert-success alert-dismissible fade show' role='alert'>"+data.sucessos[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
            
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
            const divMSG = document.querySelector("div[id=mensage]");
            divMSG.innerHTML="<div class='alert alert-danger alert-dismissible fade show' role='alert'>Falha no envio de dados<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    });
}