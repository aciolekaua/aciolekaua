window.addEventListener("load",()=>{
    //buscarDados();
    if(sessionStorage.getItem("TipoCliente")=="PJ"){
        buscarDadosGrupo();
        buscarDadosContas();
    }
});

const divs = document.querySelectorAll(".card");
    const acessar = document.querySelectorAll(".acessar");
    let divAberta = null;
    
    for (let i = 0; i < acessar.length; i++) {
        acessar[i].addEventListener("click", function () {
            const targetDivId = this.dataset.target; //Assumindo atributo de destino de dados
            const targetDiv = document.querySelector(`#${targetDivId}`);
            
            if (divAberta && divAberta !== targetDiv) {
                divAberta.style.display = "none";
            }
            
            if (targetDiv.style.display === "block") {
                targetDiv.style.display = "none";
                divAberta = null;
            } else {
                targetDiv.style.display = "block";
                divAberta = targetDiv;
            }
        });
    }

function insertPlanoDeContas(){
    var form = $('#formLayoutCSV')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/planoDeContas'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            buscarDadosGrupo();
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
        }
    });
}

function deleteGrupo(id){
    $.ajax({
        url:getRoot(getURL()+'/deleteGrupo/'+id),
        type:"POST",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            buscarDadosGrupo();
            buscarDadosContas();
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
            console.log(data);
            if(data.erros.length>0){
                //console.log("Sem dados");
            }else if(data.dados==false){
                var table = $('#tabelaGrupoContasContabil').DataTable();
                table.clear().draw();
            }else if(data.dados.length>0){
                /*var tabela = document.getElementById('tBodyGrupoContasContabil');
                tabela.innerHTML='';*/

                var table = $('#tabelaGrupoContasContabil').DataTable();
                table.clear().draw();

                for(let i=0;i<=data.dados.length-1;i++){
                    var json =`{
                        'CodigoConta':${data.dados[i].CodigoConta},
                        'Descricao':'${data.dados[i].Descricao}',
                        'Id':'${data.dados[i].Id}',
                        'TipoAcao':'${data.dados[i].TipoAcao}',
                        'Tomador':'${data.dados[i].Tomador}'
                    }`;
                    
                    buttons+=`</div>`;
                    var buttons = "<div class='row'>";
                    buttons+=`<div class='col'><i onclick='deleteGrupo("${data.dados[i].Id}")' class="btn text-danger bi bi-trash-fill"></i></div>`;
                    
                    buttons+=`
                        <div class='col-6'>
                                
                            <i class="btn bi bi-pencil-square text-primary" onclick="setDadosGrupoUpdate(${json.trim()});" 
                            data-bs-toggle="modal" data-bs-target="#modalEditarGrupo" ></i>
                        
                        </div>
                    `;
                    buttons+=`</div>`;

                    var linha =[];
                    var TipoAcao = "";
                    if(data.dados[i].TipoAcao==1){
                        TipoAcao="Pagamento"
                    }else if(data.dados[i].TipoAcao==2){
                        TipoAcao="Recebimento"
                    }
                    linha.push(
                        TipoAcao,
                        data.dados[i].Descricao,
                        buttons
                    );
                    
                    table.row.add(linha).draw();
                }

                var selectGrupo = document.querySelectorAll('.selectGrupoContas');
                selectGrupo.innerHTML="";
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
                console.log(data);
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

                            //json = btoa(json);
    
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
            console.log(data);
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            buscarDadosContas();
        }
    });
}

function updateGrupoContabil(){
    var form = $('#formUpdateGrupoContabil')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/updateGrupoContabil'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            buscarDadosGrupo();
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            buscarDadosGrupo();
            buscarDadosContas();
        }
    });
}

function deleteContaContabil(id){
    //id = id.replace('&quot;','');
    console.log(getURL()+'/deleteContaContabil/'+id)
    $.ajax({
        url:getRoot(getURL()+'/deleteContaContabil/'+id),
        type:"POST",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
            buscarDadosContas();
        }
    });
}

function setDadosContaUpdate(dados){
    //console.log(atob(dados).trim());
    
    $('#formUpdateContaContabil input[name=CodigoContabil]').val(dados.NumeroConta);
    $('#formUpdateContaContabil input[name=NomeContabil]').val(dados.NomeConta);
    $('#formUpdateContaContabil input[name=DescricaoConta]').val(dados.Descricao);
    $('#formUpdateContaContabil input[name=PalavraChave]').val(dados.PalavraChave);
    $('#formUpdateContaContabil input[name=IdConta]').val(dados.Id);
    $('#formUpdateContaContabil select[name=GrupoContas]').val(dados.IdGrupo);
}

function setDadosGrupoUpdate(dados){
    console.log(dados);
    
    $('#formUpdateGrupoContabil input[name=Nome]').val(dados.Descricao);
    $('#formUpdateGrupoContabil input[name=IdGrupo]').val(dados.Id);
    /*$('#formUpdateContaContabil input[name=NomeContabil]').val(dados.NomeConta);
    $('#formUpdateContaContabil input[name=DescricaoConta]').val(dados.Descricao);
    $('#formUpdateContaContabil input[name=PalavraChave]').val(dados.PalavraChave);
    $('#formUpdateContaContabil input[name=IdConta]').val(dados.Id);
    $('#formUpdateContaContabil select[name=GrupoContas]').val(dados.IdGrupo);*/
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
            console.log(data);
            buscarDadosGrupo();
            buscarDadosContas();
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
            console.log(data);
            buscarDadosContas();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+"/"+textStatus+"/"+errorMessage);
            buscarDadosContas();
        }
    });
    
}

