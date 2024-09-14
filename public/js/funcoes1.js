// Função de pegar o root
window.addEventListener('load',()=>{
    sessionStorage.getItem('TipoCliente');
    var elementsPF = document.querySelectorAll('.TipoClientePF');
    for(let i=0; i<=(elementsPF.length-1);i++){
        if(sessionStorage.getItem('TipoCliente')=="PJ"){elementsPF[i].style.display='none';}
    }
});

function getRoot(PastaInterna=null){
    if(PastaInterna!==null){
        if(PastaInterna.indexOf("/")==0){
            return "https://"+document.location.hostname+PastaInterna;
        }else{
            return "https://"+document.location.hostname+"/"+PastaInterna;
        }
    }else{
        return "https://"+document.location.hostname+"/";
    }
}

function dirImg(){
    var pastaInterna = "public/img/";
    return getRoot(pastaInterna);
}

function dateNow(obj){
    
    if(obj.getAttribute('type')=='date'){
        var objDate = new Date();
    
        var ano = objDate.getFullYear();
        
        var mes = '';
        if((objDate.getMonth()+1)<=9){mes='0'+(objDate.getMonth()+1);}else{mes=objDate.getMonth()+1;}
        
        var dia = '';
        if(objDate.getDate()<=9){dia='0'+objDate.getDate();}else{dia=objDate.getDate();}
        
        obj.value=ano+'-'+mes+'-'+dia;
    }
    
}

function getURL(){
    return window.location.pathname;
}
//Formulário de cadastro
// $("#FormularioCad").on('submit',function(event){
//     event.preventDefault();
//     var dados=$(this).serialize();
//     var url=getRoot("cash/")+"cadastro/cadastrar";
//     $.ajax({
//         url: url,
//         type: 'post',
//         dataType: 'json',
//         data: dados,
//         success: function(response){
//             console.log(response);
//         }
//     });
// });
    
function mask(o, f) {
    setTimeout(function() {
        var v = f(o.value);
        if (v != o.value) {o.value = v;}
    }, 1);
    
}
function nomeMask(v) {
    var r = v.replace(/[^a-z A-Z À-ú]/g, "");
    return r;
}
function numeroMask(v){
    var r = v.replace(/\D/g, "");
    return r;
}
function cpfCnpjMask(v){
    var r = v.replace(/\D/g, "");
    if (r.length > 12) {
        r = r.replace(/^(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2}).*/, "$1.$2.$3/$4-$5");
    }else if (r.length > 11) {
        r = r.replace(/^(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4}).*/, "$1.$2.$3/$4");
    }else if (r.length > 9) {
        r = r.replace(/^(\d{0,3})(\d{0,3})(\d{0,3})(\d{0,2}).*/, "$1.$2.$3-$4");
    } else if (r.length > 6) {
        r = r.replace(/^(\d{0,3})(\d{0,3})(\d{0,3}).*/, "$1.$2.$3");
    } else if (r.length > 3) {
        r = r.replace(/^(\d{0,3})(\d{0,5})/, "$1.$2");
    } else {
        r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}  
function cepMask(v){
    var r = v.replace(/\D/g, "");
    if (r.length > 5) {
        r = r.replace(/^(\d{5})(\d{0,3})/, "$1-$2");
    } else {
        r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}
function inscricaoMunicipalMask(v){
    var r = v.replace(/\D/g, "");
    if (r.length > 6) {
        r = r.replace(/^(\d{3})(\d{3})(\d{0,1}).*/, "$1.$2-$3");
    } else if (r.length > 3) {
        r = r.replace(/^(\d{3})(\d{0,3})/, "$1.$2");
    } else {
        r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}

function listaServicoMask(v){
    var r = v.replace(/\D/g, "");
    if (r.length > 2) {
        r = r.replace(/^(\d{2})(\d{0,2})/, "$1.$2");
    } else {
        r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}

function aliquotaMask(v){
    var r = v.replace(/\D/g, "");
    if (r.length > 2) {
        r = r.replace(/^(\d{2})(\d{0,2})/, "$1,$2");
    } else {
        r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}
//Mascara de nome
function maskName(o, f) {
    setTimeout(function() {
        var v = nome(o.value);
        if (v != o.value) {o.value = v;}
    }, 1);
    
}

function nome(v) {
    var r = v.replace(/[^a-z A-Z À-ú]/g, "");
    return r;
}

//Mascra de dinheiro (Real Brasileiro)
function mascaraMoeda(a, e, r, t) {
    let n = ""
      , h = j = 0
      , u = tamanho2 = 0
      , l = ajd2 = ""
      , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
    -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
    h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2) {
        for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
            j = 0),
            ajd2 += l.charAt(h),
            j++;
        for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}

//Mascara de moeda
function mascaraDinheiro(i) {
    var v = i.value.replace(/\D/g,'');
    v = (v/100).toFixed(2) + '';
    v = v.replace(".", ",");
    v = v.replace(/(\d)(\d{3})(\d{3})(\d{3}),/g, "$1.$2.$3.$4,");
    v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
    v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
    if(i.value == "0,00"){i.value = "";}
    i.value = v;
}


//Mascara de telefone
function mascaraTel(o, f) {
    
    setTimeout(function() {
        var v = tel(o.value);
        if (v != o.value) {o.value = v;}
    }, 1);
    
}
    
function tel(v) {
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
    r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (r.length > 5) {
    r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (r.length > 2) {
    r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
    } else {
    r = r.replace(/^(\d*)/, "($1");
    }
    return r;
}

//Mascara de CPF
function mascaraCpf(o, f) {
    setTimeout(function() {
        var v = cpf(o.value);
        if (v != o.value) {o.value = v;}
    }, 1);
}

function cpf(v) {
    var r = v.replace(/\D/g, "");
    if (r.length > 9) {
        r = r.replace(/^(\d{3})(\d{3})(\d{3})(\d{1,2}).*/, "$1.$2.$3-$4");
    } else if (r.length > 5) {
        r = r.replace(/^(\d{3})(\d{3})(\d{0,3}).*/, "$1.$2.$3");
    } else if (r.length > 2) {
        r = r.replace(/^(\d{3})(\d{0,5})/, "$1.$2");
    } else {
        r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}

//Mascara de CNPJ
function mascaraCnpj(o, f) {
    setTimeout(function() {
        var v = cnpj(o.value);
        if (v != o.value) {o.value = v;}
    }, 1);
}

function cnpj(v) {
    var r = v.replace(/\D/g, "");
    //r = r.replace(/^0/, "");
    if (r.length>12) {
    r = r.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{1,2}).*/, "$1.$2.$3/$4-$5");
    }else if(r.length>8){
    r = r.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,4}).*/, "$1.$2.$3/$4");
    }else if (r.length > 5) {
    r = r.replace(/^(\d{2})(\d{3})(\d{0,3}).*/, "$1.$2.$3");
    } else if (r.length > 2) {
    r = r.replace(/^(\d{2})(\d{0,5})/, "$1.$2");
    } else {
    r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}

//Mascara de CEP
function mascaraCep(o, f) {
    setTimeout(function() {
        var v =  cep(o.value);
        if (v != o.value) {o.value = v;}
    }, 1);
}

function cep(v) {
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    
    if (r.length > 5) {
    r = r.replace(/^(\d{2})(\d{3})(\d{0,3}).*/, "$1$2-$3");
    } else if (r.length > 2) {
    r = r.replace(/^(\d{2})(\d{0,3})/, "$1$2");
    } else {
    r = r.replace(/^(\d*)/, "$1");
    }
    return r;
}

function limpa_formulário_cep() {
//Limpa valores do formulário de cep.
document.getElementById('enderecoPF').value=("");
document.getElementById('bairroPF').value=("");
document.getElementById('cidadePF').value=("");
document.getElementById('ufPF').value=("");
};
function meu_callback(conteudo) {
if (!("erro" in conteudo)) {
    console.log(conteudo);
//Atualiza os campos com os valores.
document.getElementById('enderecoPF').value=(conteudo.logradouro);
document.getElementById('bairroPF').value=(conteudo.bairro);
document.getElementById('cidadePF').value=(conteudo.localidade);
document.getElementById('ufPF').value=(conteudo.uf);
} //end if.
else {
//CEP não Encontrado.
limpa_formulário_cep();
// alert("CEP não encontrado.");
}
};

function pesquisacep(valor) {

//Nova variável "cep" somente com dígitos.
var cep = valor.replace(/\D/g, '');



//Verifica se campo cep possui valor informado.
if (cep != "") {

//Expressão regular para validar o CEP.
var validacep = /^[0-9]{8}$/;

//Valida o formato do CEP.
if(validacep.test(cep)) {

//Preenche os campos com "..." enquanto consulta webservice.
document.getElementById('enderecoPF').value="...";
document.getElementById('bairroPF').value="...";
document.getElementById('cidadePF').value="...";
document.getElementById('ufPF').value="...";

//Cria um elemento javascript.
var script = document.createElement('script');

//Sincroniza com o callback.
script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

//Insere script no documento e carrega o conteúdo.
document.body.appendChild(script);

} //end if.
else {
//cep é inválido.
limpa_formulário_cep();
// alert("Formato de CEP inválido.");
}
} //end if.
else {
//cep sem valor, limpa formulário.
limpa_formulário_cep();
}
};
function checkCnpj(cnpj){
$.ajax({
   'url':'https://receitaws.com.br/v1/cnpj/'+ cnpj.replace(/[^0-9]/g, ''),
   'type':"GET",
   'dataType':'jsonp',
   'success': function(data){
       if(data.nome == undefined){
           alert(data.status + '' + data.message)
       }else{
            document.getElementById('nomeEmpresaPJ').value = data.fantasia;
            document.getElementById('bairro').value = data.bairro;
            document.getElementById('endereco').value = data.logradouro;
            document.getElementById('numero').value = data.numero;
            document.getElementById('cidade').value = data.municipio;
            document.getElementById('uf').value = data.uf;
            document.getElementById('complemento').value = data.complemento;
            document.getElementById('cep').value = data.cep;
            document.getElementById('email').value = data.email;
            data.telefone=data.telefone.split("/");
            document.getElementById('tel').value = data.telefone[0];
       }
      //console.log(data);
   }
});   
}
//Mascara de senha
function OBJ(id,func,param){
    id.toString();
    var objInput=document.querySelector(id);
    var tam=param.length
    if(tam==0){
        func(objInput);
    }else if(tam==1){
        func(objInput,param[0]);
    }
    
}
function lockPass(valor){
    var atributo=valor.getAttribute("type");
    if(atributo=='password'){valor.setAttribute("type","text");}
    else if(atributo=='text'){valor.setAttribute("type","password");}
}
function display(obj,display){obj.style.display=display;}
function disable(obj,value){obj.disabled=value;}


function qrCodePix(formData){
    $.ajax({
        url:getRoot('cash/checkout-pagamento/gerarQrcode'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
            success: function(data,status,xhr){
                console.log(data);
            },
            error: function(jqXhr, textStatus, errorMessage){
                console.log(jqXhr+" "+textStatus+" "+errorMessage);
            } 
      })
}