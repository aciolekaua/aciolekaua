function cadastrarPJ(){
    var form = $('#formCadastraPJ')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/cadastrarPJ'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(status);
            console.log(xhr);
            console.log(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });    
}

function registrarCeretificadoDigital(){
    var form = $('#formCertificadoDigital')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/registrarCeretificadoDigital'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(status);
            console.log(xhr);
            console.log(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });    
}

function senhaCertificado(obj){
    var inputSenha = document.querySelector("input#SenhaCD");
    if(obj.value == '1'){
        inputSenha.disabled = false;
    }else if(obj.value == '3'){
        inputSenha.disabled = true;
    }
}

function registrarModuloNota(){
    var form = $('#formModulosNotas')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/registrarModuloNota'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(status);
            console.log(xhr);
            console.log(data);
            getEmpresaAPI();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });    
}

function acaoModuloNota(){
    var form = $('#formModulosNotas')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/acaoModuloNota'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(status);
            console.log(xhr);
            console.log(data);
            statusModulos();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });    
}

function cadastrarServico(){
    var form = $('#formCadastraServico')[0];
    var formData = new FormData(form);
    $.ajax({
        'url':getRoot(getURL()+'/cadastrarServico'),
        'type':"POST",
        'dataType':'json',
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData: false,
        contentType:false,
        'success': function(data){
            console.log(data);
            carregarSevicos();
        },
        error: function(p1,p2,p3){
            console.log(p1+" "+p2+" "+p3);
        }
    });
}

function carregarSevicos(){
    $.ajax({
        url:getRoot(getURL()+'/getServicos'),
        type:"GET",
        dataType:'json',
        timeout:(1*60*1000),
        success: function(data,status,xhr){
            console.log(data);
            const tBodyServicos = document.querySelector('#tBodyServicos');
            tBodyServicos.innerHTML='';
            if(data.erros.length>0){
                
            }else{
                if(data.dados!==false && data.dados.length>0){
                    
                    for(let i=0;i<=data.dados.length-1;i++){
                        //<input name='codigoServico' type="checkbox" class="btn-check" id="btn-check" autocomplete="off">
                        //<label class="btn btn-primary" for="btn-check"><i class='bi bi-trash'></i></label>
                        var linha = '';
                        linha+="<tr>";
                        linha+="<td>"+data.dados[i].Codigo+"</td>";
                        linha+="<td>"+data.dados[i].Descricao+"</td>";
                        linha+="<td>";
                        linha+="<form id='formExcluirServico"+i+"'>";
                        linha+="<input onclick='deleteServico(formExcluirServico"+i+")' name='codigoServico' type='checkbox' class='btn-check' id='btn-check"+i+"' autocomplete='off' value='"+data.dados[i].Codigo+"'>";
                        linha+="<label class='btn btn-danger' for='btn-check"+i+"'><i class='bi bi-trash'></i></label>";
                        linha+="</form>";
                        linha+="</td>";
                        linha+="</tr>";
                        tBodyServicos.innerHTML+=linha;
                    }
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });   
}

function deleteServico(form){

    var formData = new FormData(form);
    $.ajax({
        'url':getRoot(getURL()+'/deleteServico'),
        'type':"POST",
        'dataType':'json',
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData: false,
        contentType:false,
        'success': function(data){
            console.log(data);
            carregarSevicos();
        },
        error: function(p1,p2,p3){
            console.log(p1+" "+p2+" "+p3);
        }
    });
}

function getEmpresaAPI(){
    $.ajax({
        url:getRoot(getURL()+'/getEmpresaAPI'),
        type:"GET",
        dataType:'json',
        timeout:(1*60*1000),
        success: function(data,status,xhr){
            /*console.log(status);
            console.log(xhr);*/
            console.log(data);
            if(data.erros.length>0){
                
            }else{
                /*if(data.dados[0].Codigo!=100){
                    
                }else{
                    writeModulos(data);
                }*/
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });  
}

function statusModulos(){
    $.ajax({
        url:getRoot(getURL()+'/getStatusModulosNotas'),
        type:"GET",
        dataType:'json',
        timeout:(1*60*1000),
        success: function(data,status,xhr){
            /*console.log(status);
            console.log(xhr);*/
            console.log(data);
            if(data.dados.length<=0 || data.dados==false){
                
            }else{
                var cardNFSE = document.querySelector("#cardNFSE #status");
                if(data.dados.IdNFSE == 1){
                    cardNFSE.setAttribute('class','card-text text-success');
                }else{
                    cardNFSE.setAttribute('class','card-text text-danger');
                }
                cardNFSE.innerHTML=data.dados.DescricaoNFSE;
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });  
    
}

function validarMunicipio(){
    $.ajax({
        url:getRoot(getURL()+'/validarMunicipio'),
        type:"GET",
        dataType:'json',
        timeout:(1*60*1000),
        success: function(data,status,xhr){
            /*console.log(status);
            console.log(xhr);*/
            console.log(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });  
}
window.addEventListener("load",()=>{
    getEmpresaAPI();
    carregarSevicos();
    statusModulos();
});