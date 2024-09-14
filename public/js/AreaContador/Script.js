window.addEventListener("load",()=>{
    document.querySelector('button#btnSalvar').addEventListener('click',()=>{
        inserirCodigoHistoricoContador();
    });
});

function getHistoricos(){
    var form = $('#formCodigosContabeis')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/getHistoricos'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            if(data.erros.length<=0){
                
            }
            if(data.dados.historicos.length>0){
                var cardCodigoContabel = document.querySelector("div#cardCodigoContabel");
                cardCodigoContabel.innerHTML="";
                let card = "";
                
                for(let i=0;i<=data.dados.historicos.length-1;i++){
                    card+="<div class='col-md-6 mb-3'>";
                    card+="<div class='card shadow-sm'>";
                    
                    if(data.dados.historicos[i].IdDecricao==0){
                        card+="<div class='card-header text-center text-white'style='background: linear-gradient(0deg, rgba(255,55,55,0.896796218487395) 0%, rgba(255,38,38,0.8) 53%, rgba(255,31,31,0.8) 99%);'>"
                        +data.dados.historicos[i].Historico+"</div>";
                    }else if(data.dados.historicos[i].IdDecricao==1){
                        card+="<div class='card-header text-center'style='background: linear-gradient(0deg, rgba(126,244,99,1) 0%, rgba(86,210,63,1) 55%, rgba(88,207,5,1) 97%);'>"
                        +data.dados.historicos[i].Historico+"</div>";
                    }else if(data.dados.historicos[i].IdDecricao==2){
                        card+="<div class='card-header text-center'style='background: linear-gradient(0deg, rgba(134,134,134,1) 0%, rgba(113,113,113,1) 50%, rgba(69,69,69,0.9808298319327731) 100%);'>"
                        +data.dados.historicos[i].Historico+"</div>";
                    }
                    
                    card+="<div class='card-body'>";
                    card+="<div class='row'>";
                    card+="<div class='col-sm-6 mb-2'>";
                    card+="<label class='form-label'>Pagar</label>";
                    card+="<input class='form-control' id='"+data.dados.historicos[i].ID+"_pagar' name='"+data.dados.historicos[i].ID+"_pagar' type='text'/>";
                    card+="</div>";
                    card+="<div class='col-sm-6 mb-2'>";
                    card+="<label class='form-label'>Há de pagar</label>";
                    card+="<input class='form-control' id='"+data.dados.historicos[i].ID+"_pagara' name='"+data.dados.historicos[i].ID+"_pagara' type='text'/>";
                    card+="</div>";
                    card+="</div>";
                    card+="</div>";
                    card+="</div>";
                    card+="</div>";
                    card+="</div>";
                    cardCodigoContabel.innerHTML+=card;
                    card="";
                }
                
            }
            
            if(data.dados.codigos.length>0){
                for(let i=0;i<=data.dados.codigos.length-1;i++){
                    let id = data.dados.codigos[i].ID;
                    document.getElementById(id+'_pagar').value=data.dados.codigos[i].P;
                    document.getElementById(id+'_pagara').value=data.dados.codigos[i].HP;
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function inserirCodigoHistoricoContador(){
    //console.log("OI");
    var form = $('#formCodigosContabeis')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/inserirCodigoHistoricoContador'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            const msgDiv = document.getElementById("msgDiv");
            msgDiv.style.zIndex='998';
            if(data.erros.length>0){
                
            }
            if(data.retorno.inseridas>0){
                let div = document.createElement('div');
                div.setAttribute('class','alert alert-success alert-dismissible fade show');
                div.setAttribute('role','alert');
                div.innerHTML="Foram adicionada(s) "+data.retorno.inseridas;
                div.innerHTML+='<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                msgDiv.appendChild(div);
            }
            if(data.retorno.atualizadas>0){
                let div = document.createElement('div');
                div.setAttribute('class','alert alert-success alert-dismissible fade show');
                div.setAttribute('role','alert');
                div.innerHTML="Foram atualizada(s) "+data.retorno.atualizadas;
                div.innerHTML+='<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                msgDiv.appendChild(div);
            }
            if(data.retorno.NaoInseridas>0){
                let div = document.createElement('div');
                div.setAttribute('class','alert alert-danger alert-dismissible fade show');
                div.setAttribute('role','alert');
                div.innerHTML="Não foram inserida(s) "+data.retorno.NaoInseridas;
                div.innerHTML+='<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                msgDiv.appendChild(div);
            }
            if(data.retorno.NaoAtualizadas>0){
                let div = document.createElement('div');
                div.setAttribute('class','alert alert-danger alert-dismissible fade show');
                div.setAttribute('role','alert');
                div.innerHTML="Não foram atualizada(s) "+data.retorno.NaoAtualizadas;
                div.innerHTML+='<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                msgDiv.appendChild(div);
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
    
}