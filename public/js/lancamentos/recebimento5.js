//Conta nova 
const FieldsetFormaDeRecebimento=document.querySelector('fieldset[id=FieldsetFormaDeRecebimento]');
const FormaDeRecebimento=document.querySelector('select[id=FormaDeRecebimento]');
const NovaFormaDeRecebimento=document.querySelectorAll('input[name=NovaFormaDeRecebimento]');
const FieldsetNovaFormaDeRecebimento=document.querySelector('fieldset[id=FieldsetNovaFormaDeRecebimento]');
const FieldsetAgencia_Conta=document.querySelector('fieldset[id=FieldsetAgencia_Conta]');
const TipoDeRecebimento=document.querySelector('select[id=TipoDeRecebimento]');
const Agencia=document.querySelector('input[id=Agencia]');
const Conta=document.querySelector('input[id=Conta]');
NovaFormaDeRecebimento[0].addEventListener('click',()=>{
    var value=NovaFormaDeRecebimento[0].checked
    if(value){
        FieldsetFormaDeRecebimento.disabled=false;
        FieldsetNovaFormaDeRecebimento.disabled=true;
        TipoDeRecebimento.required=false;
        FormaDeRecebimento.required=true;
        Agencia.required=false;
        Conta.required=false;
        TipoDeRecebimento.value="";
        Agencia.value="";
        Conta.value="";
        FormaDeRecebimento.value="";
    }
});
NovaFormaDeRecebimento[1].addEventListener('click',()=>{
    var value=NovaFormaDeRecebimento[1].checked
    if(value){
        FieldsetFormaDeRecebimento.disabled=true;
        FieldsetNovaFormaDeRecebimento.disabled=false;
        FormaDeRecebimento.required=false;
        TipoDeRecebimento.required=true;
        Agencia.required=true;
        Conta.required=true;
        TipoDeRecebimento.value="";
        Agencia.value="";
        Conta.value="";
        FormaDeRecebimento.value="";
        
        TipoDeRecebimento.addEventListener('change',()=>{
            if(TipoDeRecebimento.value==="89153" || TipoDeRecebimento.value==="42088" || TipoDeRecebimento.value==="51000" || TipoDeRecebimento.value===""){FieldsetAgencia_Conta.disabled=true;}
            else{FieldsetAgencia_Conta.disabled=false;}
        });
    }
});

//Historico
const Grupo = document.querySelector('select[id=Grupo]');
const FieldsetDescricao=document.querySelector('fieldset[id=FieldsetDescricao]');
const Descricao=document.querySelector('input[id=Descricao]');
Grupo.addEventListener("change",()=>{
    getSubGrupos();
    /*var value=Grupo.value;
    if(value!=13707130){
        FieldsetDescricao.disabled=true;
        Descricao.required=false;
        Descricao.value="";
    }else{
        FieldsetDescricao.disabled=false;
        Descricao.required=true;
        Descricao.value="";
    }*/
});

//Dados
function dados(){
    $.ajax({
        url:getRoot(getURL()+'/dados'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            
            const selectPJ = document.querySelector("select[name=PJ]");
            const selectGrupo = document.querySelector("select[name=Grupo]");
            const selectTipoDeRecebimento = document.querySelector("select[name=TipoDeRecebimento]");
            const selectFormaDeRecebimento = document.querySelector("select[name=FormaDeRecebimento]");
            
            selectPJ.innerHTML="";
            if(selectPJ.length<=1){
                if(data.pj.length!=0){
                    for(var i = 0;i<=(data.pj[0].length-1);i++){selectPJ.innerHTML+="<option value='"+data.pj[0][i].CNPJ+"'>"+data.pj[0][i].Nome+"</option>";}
                }
            }
            
            if((selectGrupo.length-1)<data.grupo[0].length){
                for(var i = 0;i<=(data.grupo[0].length-1);i++){selectGrupo.innerHTML+="<option value='"+data.grupo[0][i].Id+"'>"+data.grupo[0][i].Descricao+"</option>";}
            }
            
            if(selectTipoDeRecebimento.length<=1){
                for(var i = 0;i<=(data.pagamento[0].length-1);i++){selectTipoDeRecebimento.innerHTML+="<option value='"+data.pagamento[0][i].ID+"'>"+data.pagamento[0][i].Nome+"</option>";}
            }

            if(sessionStorage.getItem('TipoCliente')=="PJ"){
                if(selectFormaDeRecebimento.length<=1){
                    //console.log(data.contas);
                    if(data.contas.length!=0){
                        for(var i = 0;i<=(data.contas[0].length-1);i++){
                            if(data.contas[0][i].Agencia=="" ||data.contas[0][i].Conta==""){
                                selectFormaDeRecebimento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"</option>";
                            }else{
                                selectFormaDeRecebimento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"/"+data.contas[0][i].Agencia+"/"+data.contas[0][i].Conta+"</option>";
                            }
                        }
                    }
                    
                }
            }
            /*if(data.error.length>0){
                const divMSG = document.querySelector("div[id=mensage]");
                divMSG.innerHTML="";
                for(let i=0;i<=(data.error.length-1);i++){
                    divMSG.innerHTML+="<div class='d-block mb-1 alert alert-warning alert-dismissible fade show' role='alert'><i class='bi bi-exclamation-circle-fill me-1'></i>"+data.error[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }else{
                
            }*/
            
            /*const dSelect=document.querySelectorAll(".dselect");
            for(var i=0;i<=(dSelect.length-1);i++){dselect(dSelect[i],{search:true})}*/
        },
        error: function(jqXhr, textStatus, errorMessage){
            
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
            
            const divMSG = document.querySelector("div[id=mensage]");
            divMSG.innerHTML="<div class='d-block alert alert-danger alert-dismissible fade show' role='alert'>Falha na busca de dados<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            
           /* const dSelect=document.querySelectorAll(".dselect");
            for(var i=0;i<=(dSelect.length-1);i++){dselect(dSelect[i],{search:true})}*/
        }
    });
    
}
window.addEventListener('load',()=>{
    dados();
    dateNow(document.querySelector('input[name=Data]'));
});

function registro(){
    var form = $('#formRecebimento')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/registro'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            const divMSG = document.querySelector("div[id=mensage]");
            
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
            const divMSG = document.querySelector("div[id=mensage]");
            divMSG.innerHTML="<div class='d-block alert alert-danger alert-dismissible fade show' role='alert'>Falha no envio de dados<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    });
}

function getSubGrupos(){
    var form = $('#formRecebimento')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/getSubGrupo'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            const subGrupo = document.querySelector('select[id=SubGrupo]');
            subGrupo.innerHTML="";
            
            if(data.erros.length<=0){
                for(let i= 0;i<=data.dados.length-1;i++){
                    subGrupo.innerHTML+=`<option value="${data.dados[i].Id}">${data.dados[i].NomeConta}</option>`;
                }
            }
            
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
            const divMSG = document.querySelector("div[id=mensage]");
            divMSG.innerHTML="<div class='d-inline-block alert alert-danger alert-dismissible fade show' role='alert'>Falha no envio de dados !!!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    });
}

document.querySelector('select[name=PJ]').addEventListener('change',(e)=>{
    //console.log(e.target.value);
    var formData = new FormData();
    formData.append('cnpj',e.target.value);
    $.ajax({
        url:getRoot(getURL()+'/getContasPF'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            const selectFormaDeRecebimento = document.querySelector("select[name=FormaDeRecebimento]");
            if(selectFormaDeRecebimento.length<=1){
                //console.log(data.contas);
                if(data.contas.length!=0){
                    for(var i = 0;i<=(data.contas[0].length-1);i++){
                        if(data.contas[0][i].Agencia=="" ||data.contas[0][i].Conta==""){
                            selectFormaDeRecebimento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"</option>";
                        }else{
                            selectFormaDeRecebimento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"/"+data.contas[0][i].Agencia+"/"+data.contas[0][i].Conta+"</option>";
                        }
                    }
                }
                
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(`${jqXhr} ${textStatus} ${errorMessage}`);
        }
    });
});