window.addEventListener('load',()=>{
    const selectPermissoes = document.querySelector("select#selectPermissoes");
    const nMaxConselheiros = document.querySelector("select[name=nMaxConselheiros]");
    const nMinVotos = document.querySelector("select[name=nMinVotos]");
    const nMaxVotos = document.querySelector("select[name=nMaxVotos]");
   
    for(let i=1;i<=10;i++){
        
        let option1 = document.createElement("option");
        option1.value=i;
        option1.innerHTML=i;
        let option2 = document.createElement("option");
        option2.value=i;
        option2.innerHTML=i;
        let option3 = document.createElement("option");
        option3.value=i;
        option3.innerHTML=i;
        
        nMaxConselheiros.appendChild(option1);
        nMinVotos.appendChild(option2);
        nMaxVotos.appendChild(option3);
    }
    
    $.ajax({
        url:getRoot(getURL()+'/dados'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            if(data.erros.length>0){
                
            }
            if(data.dados.length>0){
                selectPermissoes.innerHTML='';
                selectPermissoes.innerHTML='<option>Selecione uma opção</option>';
                for(let i=0;i<=(data.dados.length-1);i++){
                    let option = document.createElement('option');
                    option.value=data.dados[i].ID;
                    option.innerHTML=data.dados[i].Cargo;
                    selectPermissoes.appendChild(option);
                }
            }
            if(data.regras!==false){
                nMaxConselheiros.value=data.regras.NumMaxCon;
                nMinVotos.value=data.regras.NumMinVot;
                nMaxVotos.value=data.regras.NumMaxVot;
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
    
    tabelaUsuarios();
    
    const btnRegistrarFieldset = document.querySelector("button#btnRegistrarFieldset");
    const btnAtualizarFieldset = document.querySelector("button#btnAtualizarFieldset");
    
    const btnRegistrar_Atualizar_Usuario = document.querySelector("button#btnRegistrar_Atualizar_Usuario");
    
    const Fieldset = document.querySelectorAll("fieldset.registrarFieldset");
    const radioCPF_Email = document.querySelectorAll("input[name=Email_CPF]");
    const fieldsetCPF_Email = document.querySelectorAll("fieldset.fieldsetCPF_Email");
    
    radioCPF_Email[0].addEventListener("click",()=>{
        fieldsetCPF_Email[0].disabled=false;
        fieldsetCPF_Email[1].disabled=true;
    });
    
    radioCPF_Email[1].addEventListener("click",()=>{
        fieldsetCPF_Email[0].disabled=true;
        fieldsetCPF_Email[1].disabled=false;
    });
    
    btnRegistrarFieldset.addEventListener("click",()=>{
        /*Fieldset[0].style.display="none";
        Fieldset[1].style.display="block";
    
        Fieldset[0].disabled=true;
        Fieldset[1].disabled=false;
        */
        btnRegistrar_Atualizar_Usuario.innerHTML='Registar';
        btnRegistrar_Atualizar_Usuario.setAttribute('onclick','salvarUsuarios();');
        btnRegistrar_Atualizar_Usuario.setAttribute('class','btn btn-orange');
        
        /*fieldsetCPF_Email[0].disabled=false;
        fieldsetCPF_Email[1].disabled=false;*/
    });
    
    btnAtualizarFieldset.addEventListener("click",()=>{
       /* Fieldset[0].style.display="block";
        Fieldset[1].style.display="none";
    
        Fieldset[0].disabled=false;
        Fieldset[1].disabled=true;*/
        
        btnRegistrar_Atualizar_Usuario.innerHTML='Atualizar';
        btnRegistrar_Atualizar_Usuario.setAttribute('onclick','atualizarUsuarios();');
        btnRegistrar_Atualizar_Usuario.setAttribute('class','btn btn-primary');
        
        /*fieldsetCPF_Email[1].disabled=true;*/
    });
    
});

function tabelaUsuarios(){
    $.ajax({
        url:getRoot(getURL()+'/tabelaGestaoUsuarios'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            if(data.erros.length>0){
                
            }
            if(data.dados.length>0){
                const tbodyTabela = document.querySelector("tbody#tbodyTabela");
                var table = $('#tabelaUsuarios').DataTable();
                table.clear().draw();
                for(let i=0;i<=(data.dados.length-1);i++){
                    table.row.add([
                        "<input class='form-check-input' type='checkbox' name='idAssoc[]' value='"+ data.dados[i].ID+"' />",
                        data.dados[i].NomePF,
                        data.dados[i].Cargo
                    ]).draw();
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}

function salvarUsuarios(){
    var form = $('#formRegistra_Atualiza_Usuario')[0];
    var formData = new FormData(form);
    console.log(formData);
    $.ajax({
        url:getRoot(getURL()+'/salvarUsuarios'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            tabelaUsuarios();
            console.log(data);
            
            const mensage = document.querySelector("div#mensage");
            mensage.innerHTML='';
            if(data.erros.length>0){
                for(var i = 0;i<(data.erros.length);i++){
                    mensage.innerHTML+="<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+data.erros[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
            if(data.sucessos.length>0){
                for(let i=0;i<=(data.sucessos.length-1);i++){
                    mensage.innerHTML+="<div class='alert alert-success alert-dismissible fade show' role='alert'>"+data.sucessos[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function atualizarUsuarios(){
    var form = $('#formRegistra_Atualiza_Usuario')[0];
    var formData = new FormData(form);
    //console.log(formData);
    $.ajax({
        url:getRoot(getURL()+'/atualizarUsuarios'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            tabelaUsuarios();
            console.log(data);
            
            const mensage = document.querySelector("div#mensage");
            mensage.innerHTML='';
            if(data.erros.length>0){
                for(var i = 0;i<(data.erros.length);i++){
                    mensage.innerHTML+="<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+data.erros[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
            if(data.sucessos.length>0){
                for(let i=0;i<=(data.sucessos.length-1);i++){
                    mensage.innerHTML+="<div class='alert alert-success alert-dismissible fade show' role='alert'>"+data.sucessos[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function excluirUsuarios(){
    var form = $('#formusuarios')[0];
    var formData = new FormData(form);
    //console.log(formData);
    $.ajax({
        url:getRoot(getURL()+'/excluirUsuarios'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            const mensage = document.querySelector("div#mensage");
            mensage.innerHTML='';
            if(data.excluidos>0){
                let div = document.createElement('div');
                div.setAttribute('class','alert alert-success alert-dismissible fade show');
                div.setAttribute('role','alert');
                div.innerHTML=data.excluidos+" excluido(s)";
                
                let button = document.createElement('button');
                button.setAttribute('type','button');
                button.setAttribute('class','btn-close');
                button.setAttribute('aria-label','Close');
                button.setAttribute('data-bs-dismiss','alert');
                div.appendChild(button);
                mensage.appendChild(div);
            }
            if(data.nExcluidos>0){
                let div = document.createElement('div');
                div.setAttribute('class','alert alert-danger alert-dismissible fade show');
                div.setAttribute('role','alert');
                div.innerHTML=data.nExcluidos+" NÃO excluido(s)";
                
                let button = document.createElement('button');
                button.setAttribute('type','button');
                button.setAttribute('class','btn-close');
                button.setAttribute('aria-label','Close');
                button.setAttribute('data-bs-dismiss','alert');
                div.appendChild(button);
                mensage.appendChild(div);
            }
            tabelaUsuarios();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function salvarRegrasConselho(){
    var form = $('#formRegrasConselho')[0];
    var formData = new FormData(form);
    //console.log(formData);
    $.ajax({
        url:getRoot(getURL()+'/registroDeRegrasConselho'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            //tabelaUsuarios();
            //console.log(data);
            const mensage = document.querySelector("div#mensage");
            mensage.innerHTML='';
            if(data.erros.length>0){
                for(let i=0;i<=(data.erros.length-1);i++){
                    mensage.innerHTML+="<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+data.erros[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
            
            if(data.sucessos.length>0){
                for(let i=0;i<=(data.sucessos.length-1);i++){
                    mensage.innerHTML+="<div class='alert alert-success alert-dismissible fade show' role='alert'>"+data.sucessos[i]+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}