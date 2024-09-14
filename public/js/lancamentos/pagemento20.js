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
            if(TipoDePagamento.value==="89153" || TipoDePagamento.value==="42088" || TipoDePagamento.value==="51000" || TipoDePagamento.value===""){FieldsetAgencia_Conta.disabled=true;}
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

//QRCODE
const QRCodeRadio=document.querySelectorAll('input[name=QRCodeRadio]');
const FieldsetQRCode=document.querySelector('fieldset[id=FieldsetQRCode]');
const QRCodeLink=document.querySelector('input[id=QRCodeLink]');
const QRCodeURL = document.querySelector('input[name=QRCodeURL]');
const FieldsetComum=document.querySelector('fieldset[id=FieldsetComum]');
const Beneficiario=document.querySelector('input[id=Beneficiario]');
const Nota=document.querySelector('input[id=Nota]');
const Valor=document.querySelector('input[id=Valor]');
const Data=document.querySelector('input[id=Data]');
const Comprovante=document.querySelector('input[id=Comprovante]');

QRCodeRadio[0].addEventListener("click",()=>{
    var value=QRCodeRadio[0].checked;
    if(value){
        FieldsetQRCode.disabled=true;
        //QRCodeLink.required=false;
        QRCodeLink.value='';
        QRCodeURL.value="";
        
        FieldsetComum.disabled=false;
        Beneficiario.required=true;
        Nota.required=true;
        Valor.required=true;
        Data.required=true;
        Comprovante.required=false;
    }
});

QRCodeRadio[1].addEventListener("click",()=>{
    var value=QRCodeRadio[1].checked;
    if(value){
        FieldsetQRCode.disabled=false;
        //QRCodeLink.required=true;
        
        FieldsetComum.disabled=true;
        Beneficiario.required=false;
        Nota.required=false;
        Valor.required=false;
        Data.required=false;
        Comprovante.required=false;
        
        Beneficiario.value="";
        Nota.value="";
        Valor.value="";
        Data.value="";
        Comprovante.value="";
    }
});
//Dados
function dados(){
    $.ajax({
        url:getRoot(getURL()+'/dados'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            if(data.error.length>0){
                const divMSG = document.querySelector("div[id=mensage]");
                divMSG.innerHTML="";
                for(let i=0;i<=(data.error.length-1);i++){
                    divMSG.innerHTML+="<div class='d-block mb-1 alert alert-warning alert-dismissible fade show' role='alert'><i class='bi bi-exclamation-circle-fill me-1'></i>"+data.error[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
                
            }
            const selectPJ = document.querySelector("select[name=PJ]");
            const selectGrupo = document.querySelector("select[name=Grupo]");
            const selectTipoDePagamento = document.querySelector("select[name=TipoDePagamento]");
            const selectFormaDePagamento = document.querySelector("select[name=FormaDePagamento]");
            //console.log(selectPJ.length>0)
            selectPJ.innerHTML='';
            
            if(sessionStorage.getItem('TipoCliente')=="PF"){
                selectPJ.innerHTML+='<option value="">Selecione uma opção</option>';
            }
            
            if(data.pj.length>0){
                for(var i = 0;i<=(data.pj[0].length-1);i++){selectPJ.innerHTML+="<option value='"+data.pj[0][i].CNPJ+"'>"+data.pj[0][i].Nome+"</option>";}
            }
            
            
            if(selectGrupo.length<=1){
                selectGrupo.innerHTML='';
                selectGrupo.innerHTML+='<option value="">Selecione uma opção</option>';
                if((data.grupo[0].length+1)>selectGrupo.length){
                    if(data.grupo[0].length>0){
                        for(var i = 0;i<=(data.grupo[0].length-1);i++){selectGrupo.innerHTML+="<option value='"+data.grupo[0][i].Id+"'>"+data.grupo[0][i].Descricao+"</option>";}
                    }
                    
                }
            }

            selectTipoDePagamento.innerHTML='';
            selectTipoDePagamento.innerHTML+='<option value="">Selecione uma opção</option>';
            if((selectTipoDePagamento.length-1)<data.pagamento[0].length){
                if(data.pagamento.length>0){
                    for(let i = 0;i<=(data.pagamento[0].length-1);i++){selectTipoDePagamento.innerHTML+="<option value='"+data.pagamento[0][i].ID+"'>"+data.pagamento[0][i].Nome+"</option>";}
                }
            }
            if(sessionStorage.getItem('TipoCliente')=="PJ"){
               
                
                if(selectFormaDePagamento.length<=1){
                    selectFormaDePagamento.innerHTML='';
                    selectFormaDePagamento.innerHTML+='<option value="">Selecione uma opção</option>';
                    console.log(data.contas[0].length);
                    if((data.contas[0].length+1)>selectFormaDePagamento.length){
                        for(var i = 0;i<=(data.contas[0].length-1);i++){
                            if(data.contas[0][i].Agencia=="" ||data.contas[0][i].Conta==""){
                                selectFormaDePagamento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"</option>";
                            }else{
                                selectFormaDePagamento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"/"+data.contas[0][i].Agencia+"/"+data.contas[0][i].Conta+"</option>";
                            }
                        }
                    }
                }
                
            }    
            
            /*const dSelect=document.querySelectorAll(".dselect");
            for(var i=0;i<=(dSelect.length-1);i++){dselect(dSelect[i],{search:true})}*/
        },
        error: function(jqXhr, textStatus, errorMessage){
            
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
            
            const divMSG = document.querySelector("div[id=mensage]");
            divMSG.innerHTML="<div class='d-block alert alert-danger alert-dismissible fade show' role='alert'>Falha na busca de dados<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            
            const dSelect=document.querySelectorAll(".dselect");
            for(var i=0;i<=(dSelect.length-1);i++){dselect(dSelect[i],{search:true})}
        }
    });
    
}

window.addEventListener('load',()=>{
    dados();
    /*if(sessionStorage.getItem('TipoCliente')=="PF"){
        document.querySelector("select[name=PJ]").addEventListener('change',dados());
    }else if(sessionStorage.getItem('TipoCliente')=="PJ"){
        
    }
    */
    dateNow(document.querySelector('input[name=Data]'));
});

function getSubGrupos(){
    var form = $('#formPagamento')[0];
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

function registro(){
    var form = $('#formPagamento')[0];
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
            const selectFormaDePagamento = document.querySelector("select[name=FormaDePagamento]");
            selectFormaDePagamento.innerHTML='';
            selectFormaDePagamento.innerHTML+='<option value="">Selecione uma opção</option>';
            if(selectFormaDePagamento.length<=1){
                if(data.contas.length>0){
                    for(var i = 0;i<=(data.contas[0].length-1);i++){
                        if(data.contas[0][i].Agencia=="" ||data.contas[0][i].Conta==""){
                            selectFormaDePagamento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"</option>";
                        }else{
                            selectFormaDePagamento.innerHTML+="<option value='"+data.contas[0][i].ID+"'>"+data.contas[0][i].Nome+"/"+data.contas[0][i].Agencia+"/"+data.contas[0][i].Conta+"</option>";
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