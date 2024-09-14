window.addEventListener('load',()=>{
    $.ajax({
        url:getRoot(getURL()+'/dados'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            const selectPJ = document.querySelector('select#selectPJ');
            selectPJ.innerHTML='';
            selectPJ.innerHTML='<option>Selecione uma opção</option>';
            if(data.erros.length>0){
            }else if(data.dados.length>0){
                for(let i=0;i<=(data.dados.length-1);i++){
                    selectPJ.innerHTML+='<option value='+data.dados[i].ID+'>'+data.dados[i].Tipo+'</option>';
                }
            }
            const dSelect=document.querySelectorAll(".dselect");
            for(var i=0;i<=(dSelect.length-1);i++){dselect(dSelect[i],{search:true})}
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
    
});
function cadastrarPF(btn){
    btn.innerHTML='<span class="spinner-border spinner-border-sm ms-1" role="status" aria-hidden="true"></span>';
    var form = $('#FormularioCad')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/cadastrarPF'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            btn.innerHTML='Cadastrar';
            console.log(data);
            alerta(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            btn.innerHTML='Cadastrar';
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}

function cadastrarPJ(btn){
    btn.innerHTML='<span class="spinner-border spinner-border-sm ms-1" role="status" aria-hidden="true"></span>';
    var form = $('#FormularioCad')[0];
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
            btn.innerHTML='Cadastrar';
            console.log(data);
            alerta(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            btn.innerHTML='Cadastrar';
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}

function alerta(data){
    const divMensage = document.querySelector("div#divMensage");
    divMensage.innerHTML='';
    if(data.erros.length>0){
        for(let i=0;i<=(data.erros.length-1);i++){
            let divAlert = document.createElement("div");
            divAlert.setAttribute("class",'alert alert-danger alert-dismissible fade show');
            divAlert.setAttribute("role",'alert');
            divAlert.innerHTML=data.erros[i]+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            divMensage.appendChild(divAlert);
        }
    }else{
        if(data.sucessos.length>0){
            for(let i=0;i<=(data.sucessos.length-1);i++){
                let divAlert = document.createElement("div");
                divAlert.setAttribute("class",'alert alert-success alert-dismissible fade show');
                divAlert.setAttribute("role",'alert');
                divAlert.innerHTML=data.sucesso[i]+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                divMensage.appendChild(divAlert);
            }
        }
    }
    
}

const btnPFForm = document.querySelector("button#btnPFForm");
const btnPJForm = document.querySelector("button#btnPJForm");
const fielsetPF = document.querySelector("fieldset#PF");
const fielsetPJ = document.querySelector("fieldset#PJ");
const btnMostrarSenha = document.querySelector("button#bntMostrarSenha");
btnMostrarSenha.addEventListener('click',()=>{
    const inputSenha = document.querySelector("input[name=senha]");
    const icone = document.querySelector("button#bntMostrarSenha i");
    let tipo = inputSenha.getAttribute('type');
    if(tipo=="password"){
        inputSenha.setAttribute('type','text');
        icone.setAttribute('class','bi bi-eye-slash');
    }else if(tipo=="text"){
        inputSenha.setAttribute('type','password');
        icone.setAttribute('class','bi bi-eye');
    }
    
});
function mudaValorCepPF(data){
    document.querySelector("input[name=enderecoPF]").value = data.logradouro;
    document.querySelector("input[name=cidadePF]").value = data.localidade;
    document.querySelector("input[name=bairroPF]").value = data.bairro;
    document.querySelector("input[name=complementoPF]").value = data.complemento;
    document.querySelector("input[name=ufPF]").value = data.uf;
}
function mudaValorCepPJ(data){
    document.querySelector("input[name=enderecoPJ]").value = data.logradouro;
    document.querySelector("input[name=cidadePJ]").value = data.localidade;
    document.querySelector("input[name=bairroPJ]").value = data.bairro;
    document.querySelector("input[name=complementoPJ]").value = data.complemento;
    document.querySelector("input[name=ufPJ]").value = data.uf;
}

function buscaCep(cepInput, tipoCliente){

    $.ajax({
        url:'https://viacep.com.br/ws/'+ cepInput.value.replace(/[^0-9]/g, '') + '/json/',
        type:"GET",
        dataType:'json',
        success: function(data){
            console.log(data);
            if(tipoCliente=="PF"){ mudaValorCepPF(data);}
            if(tipoCliente=="PJ"){mudaValorCepPJ(data);}
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}
function mudaValorCNPJ(data){
    document.querySelector('input[name=nomeFantazia]').value = data.fantasia;
    document.querySelector('input[name=razaoSocial]').value = data.nome;
    document.querySelector('input[name=bairroPJ]').value = data.bairro;
    document.querySelector('input[name=enderecoPJ]').value = data.logradouro;
    document.querySelector('input[name=numeroPJ]').value = data.numero;
    document.querySelector('input[name=cidadePJ]').value = data.municipio;
    document.querySelector('input[name=ufPJ]').value = data.uf;
    document.querySelector('input[name=complementoPJ]').value = data.complemento;
    document.querySelector('input[name=cepPJ]').value = data.cep;
    document.querySelector('input[name=emailPJ]').value = data.email;
    data.telefone=data.telefone.split("/");
    document.querySelector('input[name=telPJ]').value = data.telefone[0];
}

function buscaCNPJ(inpuCNPJ){
    $.ajax({
      url:'https://receitaws.com.br/v1/cnpj/'+ inpuCNPJ.value.replace(/[^0-9]/g, ''),
      type:"GET",
      dataType:'jsonp',
      success: function(data){
          console.log(data);
          if(data.nome == undefined){
              alert(data.status + '' + data.message)
          }else{
                mudaValorCNPJ(data);
          }
      },
      error:function(jqXhr, textStatus, errorMessage){
          console.log(jqXhr+' '+textStatus+' '+errorMessage);
      }
    });   
}

btnPFForm.addEventListener('click',()=>{
    fielsetPF.style.display='flex';
    fielsetPF.disabled=false;
    
    fielsetPJ.style.display='none';
    fielsetPJ.disabled=true;
});
btnPJForm.addEventListener('click',()=>{
    fielsetPF.style.display='none';
    fielsetPF.disabled=true;
    
    fielsetPJ.style.display='flex';
    fielsetPJ.disabled=false;
});


