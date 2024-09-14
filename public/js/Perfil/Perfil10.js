window.addEventListener("load",()=>{
    buscarDados();
    if(sessionStorage.getItem("TipoCliente")=="PJ"){
        buscarDadosGrupo();
        buscarDadosContas();
    }
});

function buscarDados(){
    $.ajax({
        url:getRoot(getURL()+'/dados'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            if(data.length<=0){
                //console.log("Sem dados");
            }else{
                //console.log("Há dados");
                if(data.TipoCliente=="PF"){
                    $('#nome').val(data.Nome);
                }else if(data.TipoCliente=="PJ"){
                    $('#nome').val(data.NomeFantasia);
                }
                $('#email').val(data.Email);
                $('#cidade').val(data.Cidade);      
                $('#telefone').val(data.Telefone);
                $('#cep').val(data.CEP);
                $('#endereco').val(data.Endereco);
                $('#numero').val(data.Numero);
                $('#complemento').val(data.Complemento);
                $('#bairro').val(data.Bairro);;
                $('#uf').val(data.UF);
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function deleteGrupo(id){
    $.ajax({
        url:getRoot(getURL()+'/deleteGrupo/'+id),
        type:"POST",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            buscarDadosGrupo();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function buscarDadosGrupo(){
    $.ajax({
        url:getRoot(getURL()+'/dadosGrupo'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            if(data.erros.length>0){
                //console.log("Sem dados");
            }else if(data.dados.length>0){
                /*var tabela = document.getElementById('tBodyGrupoContasContabil');
                tabela.innerHTML='';*/

                var table = $('#tabelaGrupoContasContabil').DataTable();
                table.clear().draw();

                for(let i=0;i<=data.dados.length-1;i++){
                    var buttons = "<div class='row'>";
                    buttons+=`<div class='col'><i onclick='deleteGrupo("${data.dados[i].Id}")' class="btn text-danger bi bi-trash-fill"></i></div>`;
                    //buttons+=`<div class='col'><button class='btn btn-primary'><i class="bi bi-pencil-square"></i></button></div>`;
                    buttons+=`</div>`;

                    var linha =[];
                    linha.push(
                        data.dados[i].Descricao,
                        buttons
                    );
                    
                    table.row.add(linha).draw();
                }

                var selectGrupo = document.querySelectorAll('.selectGrupoContas');
                for(let j=0;j<=selectGrupo.length-1;j++){
                    selectGrupo[j].innerHTML=' ';
                    for(let i=0;i<=data.dados.length-1;i++){
                        selectGrupo[j].innerHTML+=`<option value='${data.dados[i].Id}'>${data.dados[i].Descricao}</option>`;
                    }
                }
                
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function buscarDadosContas(){
    if(sessionStorage.getItem("TipoCliente")=="PJ"){
        $.ajax({
            url:getRoot(getURL()+'/getContaContabil'),
            type:"GET",
            dataType:'json',
            success: function(data,status,xhr){
                //console.log(data);
                //tabelaCadastraContasContabil
                if(data.erros.length>0){
                    //console.log("Sem dados");
                }else{
                    /*var tabela = document.getElementById('tBodyContasContabil');
                    tabela.innerHTML='';*/
                    var table = $('#tabelaContasContabil').DataTable();
                    table.clear().draw();

                    if(data.dados.length>0){
                        for(let i=0;i<=data.dados.length-1;i++){
                        
                            var json =`{
                                'NumeroConta':${data.dados[i].NumeroConta},
                                'NomeConta':'${data.dados[i].NomeConta}',
                                'PalavraChave':'${data.dados[i].PalavraChave}',
                                'Descricao':'${data.dados[i].Descricao}',
                                'IdGrupo':'${data.dados[i].IdGrupo}',
                                'Id':'${data.dados[i].Id}'
                            }`;
    
                            var buttons = "<div class='row'>";
                            buttons+=`<div class='col-6'><i onclick='deleteContaContabil("${data.dados[i].Id}")' class="btn text-danger bi bi-trash-fill"></i></div>`;
                            buttons+=`
                                <div class='col-6'>
                                    
                                    <i class="btn bi bi-pencil-square text-primary" onclick="setDadosContaUpdate(${json.trim()});" 
                                    data-bs-toggle="modal" data-bs-target="#modalEditarContas" ></i>
                                   
                                </div>
                            `;
                            buttons+=`</div>`;
                            
                            var linha =[];
                            linha.push(
                                data.dados[i].NumeroConta,
                                data.dados[i].NomeConta,
                                data.dados[i].PalavraChave,
                                data.dados[i].Descricao,
                                data.dados[i].Grupo,
                                buttons
                            );
                            
                            table.row.add(linha).draw();
                        }
    
                    }
                    
                }

            },
            error: function(jqXhr, textStatus, errorMessage){
                console.log(jqXhr+' '+textStatus+' '+errorMessage);
            }
        });
    }
}

function updateContaContabil(){
    var form = $('#formUpdateContaContabil')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/updateContaContabil'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            //console.log(data);
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            buscarDadosContas();
        }
    });
}

function deleteContaContabil(id){
    //id = id.replace('&quot;','');
    //console.log(getURL()+'/deleteContaContabil/'+id)
    $.ajax({
        url:getRoot(getURL()+'/deleteContaContabil/'+id),
        type:"POST",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
            buscarDadosContas();
        }
    });
}

function setDadosContaUpdate(dados){
    //console.log(dados);
    $('#formUpdateContaContabil input[name=CodigoContabil]').val(dados.NumeroConta);
    $('#formUpdateContaContabil input[name=NomeContabil]').val(dados.NomeConta);
    $('#formUpdateContaContabil input[name=DescricaoConta]').val(dados.Descricao);
    $('#formUpdateContaContabil input[name=PalavraChave]').val(dados.PalavraChave);
    $('#formUpdateContaContabil input[name=IdConta]').val(dados.Id);
    $('#formUpdateContaContabil select[name=GrupoContas]').val(dados.IdGrupo);
}

function registroGrupo(){
    var form = $('#formCadastraGrupoContas')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/registroGrupo'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            //console.log(data);
            buscarDadosGrupo();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
        }
    });
}

function registroContasContabil() {
    var form = $('#formCadastraContasContabil')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/registroContasContabil'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            //console.log(data);
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            buscarDadosContas();
        }
    });
    
}

function atuaizar(){
    var form = $('#formPerfil')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/atualizar'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            //console.log(data);
            buscarDados();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            buscarDados();
        }
    });
}