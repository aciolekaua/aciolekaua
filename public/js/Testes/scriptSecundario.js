function mascaraNome(i){
                var v = i.value.replace(/\d/g,'').toUpperCase();
                	i.value = v.toUpperCase();
            }
            
    function mascaraTel(o, f) {
                  setTimeout(function() {
                    var v = tel(o.value);
                    if (v != o.value) {
                      o.value = v;
                    }
                  }, 1);
                }
                
    function tel(v){
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
    
    function checkInscricaoMunicipal(element,bairro){
        $.ajax({
            'url':'https://servicodados.ibge.gov.br/api/v1/localidades/municipios?orderBy=nome',
            'type':"GET",
            'dataType':'json',
            'success': function(data){
                if(data == undefined){
                    console.log(data)
                }else{
                    for(var i = 0; i<=data.length-1;i++){
                        if(data[i].nome.toLowerCase()==bairro.toLowerCase()){
                            element.value=data[i].id;
                        }
                    }
                }
            }
        })   
    }
    
    function checkInscricaoEstadual(element,bairro){
        $.ajax({
            'url':'https://servicodados.ibge.gov.br/api/v1/localidades/estados',
            'type':"GET",
            'dataType':'json',
            'success': function(data){
                if(data == undefined){
                    console.log(data)
                }else{
                    console.log(data)
                    /*for(var i = 0; i<=data.length-1;i++){
                        if(data[i].nome.toLowerCase()==bairro.toLowerCase()){
                            element.value=data[i].id;
                        }
                    }*/
                }
            }
        })   
    }
      
    function checkCNPJ(cnpj){
        $.ajax({
            'url':'https://receitaws.com.br/v1/cnpj/'+ cnpj.replace(/[^0-9]/g, ''),
            'type':"GET",
            'dataType':'jsonp',
            'success': function(data){
                if(data.nome == undefined){
                    alert(data.message);
                }else{
                                     
                    document.getElementById('nome').value = data.nome;
                    document.getElementById('Bairro').value = data.bairro;
                    document.getElementById('Endereco').value = data.logradouro;
                    document.getElementById('Numero').value = data.numero;
                    document.getElementById('Cidade').value = data.municipio;
                    document.getElementById('email').value = data.email;
                    document.getElementById('Uf').value = data.uf;
                    document.getElementById('Complemento').value = data.complemento;
                    document.getElementById('Cep').value = data.cep;
                    data.telefone=data.telefone.split("/");
                    document.getElementById('Tel').value = data.telefone[0];
                
                    if(data.tipo.toLowerCase()==="matriz"){
                        document.querySelector('select[name=filial]').value = 'n';
                    }else if(data.tipo.toLowerCase()==="filial"){
                        document.querySelector('select[name=filial]').value = 's';
                    }
                    document.querySelector('input[name=cnaeText]').value = data.atividade_principal[0].text;
                    document.querySelector('input[name=cnaeCode]').value = data.atividade_principal[0].code;
                    //console.log(data);
              }
          }
        })   
    }
    
    function checkCNPJMatriz(element){
        $.ajax({
            'url':'https://receitaws.com.br/v1/cnpj/'+ element.value.replace(/[^0-9]/g, ''),
            'type':"GET",
            'dataType':'jsonp',
            'success': function(data){
                if(data.nome == undefined){
                    alert(data.message);
                }else{
                    if(data.tipo.toLowerCase()!='matriz'){
                        alert("Esse CNPJ não é de uma matriz");
                        element.value='';
                    }
                }
            }
        })   
    }
    
    function cadastro(){
        //var formData = new FormData(evt.target);
        var form = $('#formCadastro')[0];
        var formData = new FormData(form);
        //console.log(formData);
        //var dados = $('#formCadastro').serialize();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: getRoot('cash')+'/teste/cadastroempresaapi',
            data: formData,
            timeout:12000,
            cache:false,
            processData: false,
            contentType:false,
            success: function (data,status,xhr) { 
                //console.log(data);
                const msgTeste = document.querySelector('#msgTeste');
                msgTeste.innerHTML='';
                if(data[0]['Codigo']!=100){
                    msgTeste.setAttribute('class','alert alert-danger');
                    msgTeste.innerHTML=data[0]['Descricao'];
                }else{
                    for(var i = 0;i<=(data[0]['RetornoCadastro'].length-1);i++){
                        if(data[0]['RetornoCadastro'][i]['Descricao'].indexOf("caixa para envio")!=-1){}else{
                            const newDiv = document.createElement("div");
                            const role = document.createAttribute("role");
                            role.value = "alert";
                            newDiv.setAttributeNode(role);
                            newDiv.innerHTML=data[0]['RetornoCadastro'][i]['Descricao']+" <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                            //const currentDiv = document.getElementById("msgTeste");
                            document.body.insertBefore(newDiv, msgTeste);
                            if(data[0]['RetornoCadastro'][i]['Codigo']!=100){
                                newDiv.setAttribute('class','alert alert-danger alert-dismissible fade show');
                            }else{
                                newDiv.setAttribute('class','alert alert-success alert-dismissible fade show');
                            }
                        }
                        
                    }
                }
                //console.log(status);
                //console.log(xhr);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(jqXhr+' '+textStatus+' '+errorMessage);
            }
        });
    }
    
    function spinnerStart(){
        const msgTeste = document.querySelector('#msgTeste');
        msgTeste.innerHTML='';
        msgTeste.setAttribute('class','text-center');
        msgTeste.innerHTML="<div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div>";
    }
            
    function mascaraCpf(o, f) {
                  setTimeout(function() {
                    var v = cpf(o.value);
                    if (v != o.value) {
                      o.value = v;
                    }
                  }, 1);
                }

    function cpf(v) {
                  var r = v.replace(/\D/g, "");
                  r = r.replace(/^-1/, "");
                  if (r.length>12) {
                     r = r.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{1,2}).*/, "$1.$2.$3/$4-$5");
                  }else if(r.length>11){
                    r = r.replace(/^(\d{2})(\d{3})(\d{3})(\d{4}).*/, "$1.$2.$3/$4");
                  }else if (r.length > 9) {
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

    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            // document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            // document.getElementById('ibge').value=(conteudo.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
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
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                // document.getElementById('ibge').value="...";

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
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    }
    
    function moeda(a, e, r, t) {
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

    function certificadoA3(){
        const divA1 = document.querySelector('div[id=divA1]');
        divA1.style.display='none';
    }

    function certificadoA1(){
        const divA1 = document.querySelector('div[id=divA1]');
        divA1.style.display='block';
    }