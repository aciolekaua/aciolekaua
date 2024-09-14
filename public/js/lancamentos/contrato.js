//Conta nova 
const FieldsetFormaDePagamento=document.querySelector('fieldset[id=FieldsetFormaDePagamento]');
const FormaDePagamento=document.querySelector('select[id=FormaDePagamento]');
const NovaFormaDePagamento=document.querySelectorAll('input[name=NovaFormaDePagamento]');
const FieldsetNovaFormaDePagamento=document.querySelector('fieldset[id=FieldsetNovaFormaDePagamento]');
const FieldsetAgencia_Conta=document.querySelector('fieldset[id=FieldsetAgencia_Conta]');
const TipoDePagamento=document.querySelector('select[id=TipoDePagamento]');
const Agencia=document.querySelector('input[id=Agencia]');
const Conta=document.querySelector('input[id=Conta]');
NovaFormaDePagamento[0].addEventListener('click',()=>{
    var value=NovaFormaDePagamento[0].checked
    if(value){
        FieldsetFormaDePagamento.disabled=false;
        FieldsetNovaFormaDePagamento.disabled=true;
        TipoDePagamento.required=false;
        FormaDePagamento.required=true;
        Agencia.required=false;
        Conta.required=false;
        TipoDePagamento.value="";
        Agencia.value="";
        Conta.value="";
        FormaDePagamento.value="";
    }
});
NovaFormaDePagamento[1].addEventListener('click',()=>{
    var value=NovaFormaDePagamento[1].checked
    if(value){
        FieldsetFormaDePagamento.disabled=true;
        FieldsetNovaFormaDePagamento.disabled=false;
        FormaDePagamento.required=false;
        TipoDePagamento.required=true;
        Agencia.required=true;
        Conta.required=true;
        TipoDePagamento.value="";
        Agencia.value="";
        Conta.value="";
        FormaDePagamento.value="";
        
        TipoDePagamento.addEventListener('change',()=>{
            if(TipoDePagamento.value==="89153" || TipoDePagamento.value==="42088" || TipoDePagamento.value===""){FieldsetAgencia_Conta.disabled=true;}
            else{FieldsetAgencia_Conta.disabled=false;}
        });
    }
});

//Historico
const Historico=document.querySelector('select[id=Historico]');
const FieldsetDescricao=document.querySelector('fieldset[id=FieldsetDescricao]');
const Descricao=document.querySelector('input[id=Descricao]');
Historico.addEventListener("change",()=>{
    var value=Historico.value;
    if(value!=13707130){
        FieldsetDescricao.disabled=true;
        Descricao.required=false;
        Descricao.value="";
    }else{
        FieldsetDescricao.disabled=false;
        Descricao.required=true;
        Descricao.value="";
    }
});

//Dados
function dados(){
    $.ajax({
        url:getRoot('cash/lancamentos-contrato/dados'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            if(data.error.length>0){
                const divMSG = document.querySelector("div[id=mensage]");
                divMSG.innerHTML="<div class='alert alert-danger alert-dismissible fade show' role='alert'>Falha na busca de dados<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }else{
                const selectPJ = document.querySelector("select[name=PJ]");
                const selectHistorico = document.querySelector("select[id=Historico]");
                const selectTipoDePagamento = document.querySelector("select[name=TipoDePagamento]");
                const selectFormaDePagamento = document.querySelector("select[name=FormaDePagamento]");
                
                if(selectPJ.length>1 && selectHistorico.length>1 && selectTipoDePagamento.length>1 && selectFormaDePagamento.length>1){
                }else{
                    for(var i = 0;i<=(data.pj[0].length-1);i++){selectPJ.innerHTML+="<option value='"+data.pj[0][i].CNPJ+"'>"+data.pj[0][i].Nome+"</option>";}
                
                    for(var i = 0;i<=(data.historico[0].length-1);i++){selectHistorico.innerHTML+="<option value='"+data.historico[0][i].ID+"'>"+data.historico[0][i].Historico+"</option>";}
                    
                    for(var i = 0;i<=(data.pagamento[0].length-1);i++){selectTipoDePagamento.innerHTML+="<option value='"+data.pagamento[0][i].ID+"'>"+data.pagamento[0][i].Nome+"</option>";}
                    
                    for(var i = 0;i<=(data.contas[0].length-1);i++){
                        if(data.contas[0][i].Agencia=="" ||data.contas[0][i].Conta==""){
                            selectFormaDePagamento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"</option>";
                        }else{
                            selectFormaDePagamento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"/"+data.contas[0][i].Agencia+"/"+data.contas[0][i].Conta+"</option>";
                        }
                    }
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
    var form = $('#formContrado')[0];
    //console.log(form);
    var formData = new FormData(form);
    $.ajax({
        url:getRoot('cash/lancamentos-contrato/registro'),
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

