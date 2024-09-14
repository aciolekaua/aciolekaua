function excluirArquivo(dados){
    var formData = new FormData();

    formData.append('idComprovante',dados.idComprovante);
    formData.append('idLancamento',dados.idLancamento);
    formData.append('idGrupoComprovante',dados.grupo);

    console.log(dados);

    $.ajax({
        url:getRoot(getURL()+'/removerArquivo'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            tabelaPJ();
            document.querySelector(`button[id="${dados.idLancamento}"]`).click();
            setTimeout(()=>{
                document.querySelector(`button[id="${dados.idLancamento}"]`).click();
            }, 500);
            
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}

function adicionarImagem(dados){
    console.log(dados);
    var form = $('#formAdiconarImagem')[0];
    var formData = new FormData(form);

    formData.append('IdRecebimento',dados.id);
    if(dados.hasOwnProperty("grupo")){formData.append('GrupoComprovante',dados.grupo);}

    $.ajax({
        url:getRoot(getURL()+'/adicionarImagem'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            tabelaPJ();
            document.querySelector(`button[id="${dados.id}"]`).click();
            setTimeout(()=>{
                document.querySelector(`button[id="${dados.id}"]`).click();
            }, 500);
            
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
            /*const divMSG = document.querySelector("div[id=mensage]");
            divMSG.innerHTML="<div class='d-inline-block alert alert-danger alert-dismissible fade show' role='alert'>Falha no envio de dados !!!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            */
        }
    });
}

function escreverListaArquivos(data){
    console.log(data);
    var modalBody = document.querySelector("div[id=lista-comprovante]");
    modalBody.innerHTML=`
    <form id="formAdiconarImagem" action="" class='mb-3'>
        <div class="input-group">
            <input type="file" class="form-control" name="Comprovante[]" multiple accept=".pdf, .jpeg, .jpg, .png" >
            <button class="btn btn-outline-primary" type="button" id="btnAdicionaImagem">
                <i class="bi bi-file-earmark-plus"></i>
            </button>
        </div>
    </form>
    `;

    var btnAdicionaImagem = document.querySelector("button[id=btnAdicionaImagem]");
    
    //console.log(data.hasOwnProperty("arquivos"));
    if(!data.hasOwnProperty("arquivos")){
        btnAdicionaImagem.addEventListener('click',()=>{
            adicionarImagem({
                id:data.id
            });

        });
        return false;
    }else{
        btnAdicionaImagem.addEventListener('click',()=>{
            adicionarImagem({
                id:data.id,
                grupo:data.arquivos[0].grupo
            });

        });
    }

    for(let i=0;i<=data.arquivos.length-1;i++){
        //listaArquivos.innerHTML+="";
        var listaArquivos = document.createElement("div");
        listaArquivos.setAttribute('class','list-group list-group-horizontal mt-1');

        var item = document.createElement("a");
        item.setAttribute('class','list-group-item list-group-item-action');
        item.setAttribute('href',data.arquivos[i].url);
        item.setAttribute('download',data.arquivos[i].nome);
        if(data.arquivos[i].extensao=="pdf"){
            item.innerHTML= "<i class='bi bi-file-pdf h4 text-danger me-2'></i>"+data.arquivos[i].nome;
        }else if(
            data.arquivos[i].extensao=="png"
            || data.arquivos[i].extensao=="jpeg"
            || data.arquivos[i].extensao=="jpg"
        ){
            item.innerHTML= "<i class='bi bi-file-image h4 text-primary me-2'></i>"+data.arquivos[i].nome;
        }else{
            item.innerHTML= "<i class='bi bi-question-square h4 text-secondary me-2'></i>"+data.arquivos[i].nome;
        }

        listaArquivos.append(item);

        var btnGroup = document.createElement("div");
        btnGroup.setAttribute('class','dropdown list-group-item');

        var btnDrop = document.createElement("button");
        btnDrop.setAttribute('type','button');
        btnDrop.setAttribute('class','btn dropdown-toggle');
        btnDrop.setAttribute('data-bs-toggle','dropdown');
        btnDrop.setAttribute('aria-expanded','false');
        btnDrop.setAttribute('id','dropdownMenuEdicao');

        var ul = document.createElement('ul');
        ul.setAttribute('class','dropdown-menu');
        ul.setAttribute('aria-labelledby','dropdownMenuEdicao');

        //var liEdicao = document.createElement('li');
        var liExclusao = document.createElement('li');

        //var aEdicao = document.createElement('a');
        var aExclusao = document.createElement('a');

        //aEdicao.setAttribute('class','dropdown-item');
        /*aEdicao.addEventListener('click',()=>{
            console.log('Edição');
        });*/
        //aEdicao.innerHTML="<i class='bi bi-pencil-square me-1' ></i>Substituir";
        //liEdicao.append(aEdicao);

        aExclusao.setAttribute('class','dropdown-item');
        
        aExclusao.addEventListener('click',()=>{
            excluirArquivo({
                idComprovante:data.arquivos[i].id,
                grupo:data.arquivos[i].grupo,
                idLancamento:data.id
            });
        });
        aExclusao.innerHTML="<i class='bi bi-trash-fill me-1' ></i>Excluir";
;       liExclusao.append(aExclusao);

        //ul.append(liEdicao);
        ul.append(liExclusao);

        btnGroup.append(btnDrop);
        btnGroup.append(ul);
        
        listaArquivos.append(btnGroup);
        modalBody.append(listaArquivos);
    }
    
}

function escreverTabelaPJ(data, associados=null){
    var colunas = [
        { title: "Ações"},
        { title: "Data de Envio" },
        { title: "Lançador" },
        { title: "Histórico" },
        { title: "Pagamento" },
        { title: "Descrição" },
        { title: "Pagador" },
        { title: "Valor" },
        { title: "Data de Competência" },
        { title: "Arquivo"}
    ];

    if(associados!=null){
        for(let i=0;i<=(associados.length-1);i++){
            colunas.push({ title: associados[i].NomePF });
        }
    }
    
    var table = $('#tabela_recebimento').DataTable();
    table.destroy();

    var table = $('#tabela_recebimento').DataTable({
        buttons: [
            'excel',
            'csv'
        ],
        dom: 'Bfrtip',
        columns: colunas
    });
    table.clear().draw();

    //const divDtButtons = document.querySelector("div.dt-buttons");
    //divDtButtons.style.margin='0 0 3% 0';
    const btnExcel = document.querySelector("button.buttons-excel");
    btnExcel.setAttribute('class',"btn btn-success buttons-excel buttons-html5");
    btnExcel.innerHTML="<i class='bi bi-file-earmark-excel'></i> Excel";
    
    const btnCSV = document.querySelector("button.buttons-csv");
    btnCSV.setAttribute('class',"btn btn-secondary buttons-csv buttons-html5");
    btnCSV.innerHTML="<i class='bi bi-filetype-csv'></i> CSV";

    console.log(data);
    
    for(let i=0;i<=(data.tabela.length-1);i++){
        var tabelaPJ = [];
        if(data.tabela[i].Arquivo==null){data.tabela[i].Arquivo='';}
        data.tabela[i].Valor="R$ "+data.tabela[i].Valor;
        
        if(data.tabela[i].Agencia!="" && data.tabela[i].Conta!=""){
            data.tabela[i].TipoDePagamento = data.tabela[i].TipoDePagamento+"/"+data.tabela[i].Agencia+"/"+data.tabela[i].Conta
        }
        
        var Arquivo = "";
        if(data.tabela[i].Arquivo!=""){
            Arquivo = `<a target='_blank' href='${data.tabela[i].Arquivo}'>${data.tabela[i].Arquivo}</a>`;
        }

        var arquivos = "";
        if(data.tabela[i].arquivos.length>0){
            let array = JSON.stringify({
                "id":data.tabela[i].ID,
                "arquivos":data.tabela[i].arquivos
            });
            //array.push(data.tabela[i].ID);
            //console.log(array);
            arquivos = `<button 
                type='button' 
                class='btn btn-primary' 
                data-bs-toggle='modal' 
                data-bs-target='#modalArquivos'
                id = '${data.tabela[i].ID}'
                onclick='escreverListaArquivos(${array})'
            >
            Arquivos
            </button>`;
        }else{
            let array = JSON.stringify({
                "id":data.tabela[i].ID
            });
            arquivos = `<button type='button' 
                class='btn btn-primary' 
                data-bs-toggle='modal' 
                data-bs-target='#modalArquivos'
                id = '${data.tabela[i].ID}'
                onclick='escreverListaArquivos(${array})'
            >Arquivos</button>`;
        }
        
        //var ID = `<input class='form-check-input' type='checkbox' name='sel[]' value='${data.tabela[i].ID}' />`;

        var json = `{
            'Id': '${data.tabela[i].ID}',
            'DataEnvio': '${data.tabela[i].DataEnvio}',
            'Historico': '${data.tabela[i].Historico}',
            'TipoDePagamento': '${data.tabela[i].TipoDePagamento}',
            'Descricao': '${data.tabela[i].Descricao}',
            'Ofertante': '${data.tabela[i].Ofertante}',
            'Nota': '${data.tabela[i].Nota}',
            'Valor': '${data.tabela[i].Valor}',
            'Data': '${data.tabela[i].Data}'
        }`;

        var buttons = "<div class='row'>";
        buttons+=`<div class='col-6'><i data-bs-toggle="modal" data-bs-target="#modalConfirmaExclusaoRecebimento" onclick='setModalConfirmaExclusaoRecebimento("${data.tabela[i].ID}")' class="btn text-danger bi bi-trash-fill"></i></div>`;
        buttons+=`
            <div class='col-6'>
                <i class="btn bi bi-pencil-square text-primary" onclick="setModalRecebimento(${json});"
                data-bs-toggle="modal" data-bs-target="#modalEditarRecebimento" ></i>
            </div>
        `;
        buttons+="</div>";
        
        tabelaPJ.push(
            buttons,
            data.tabela[i].DataDeEnvio,
            data.tabela[i].PF,
            data.tabela[i].Historico,
            data.tabela[i].TipoDePagamento,
            data.tabela[i].Descricao,
            data.tabela[i].Ofertante,
            data.tabela[i].Valor,
            data.tabela[i].Data,
            arquivos
        );
        
        if(data.conselheiros.length>0){
            for(let w=0;w<=(data.conselheiros.length-1);w++){
                if(data.tabela[i][w]===undefined || data.tabela[i][w]===null){
                        tabelaPJ.push("<span class='status pendente'>Não revisado</span>");
                }else{
                    if(data.tabela[i][w].IdStatus==0){
                        tabelaPJ.push("<span class='status pendente'>"+data.tabela[i][w].Status+"</span>");
                    }else if(data.tabela[i][w].IdStatus==1){
                        tabelaPJ.push("<span class='status cancelado'>"+data.tabela[i][w].Status+"</span>");
                    }else if(data.tabela[i][w].IdStatus==2){
                        tabelaPJ.push("<span class='status aprovado'>"+data.tabela[i][w].Status+"</span>");
                    }
                }
            }
        }
        tabelaPJ.push("");
        table.row.add(tabelaPJ).draw();
    }
    //table.column( 1 ).visible( false );
}

function dadosPJ(){
    $.ajax({
        url:getRoot(getURL()+'/dadosPJ'),
        type:"POST",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            const Grupo = document.querySelector("select[name=Grupo]");
            const PJ = document.querySelector('select[name=PJUpdate]');
            const selectFormaDeRecebimento = document.querySelector("select[name=FormaDeRecebimento]");
            if(data.erros.length>0 && data.grupo==false){

            }else{
                if(data.grupo.length>(Grupo.length-1)){
                    for(let i=0;i<=(data.grupo.length-1);i++){
                        Grupo.innerHTML+=`<option value="${data.grupo[i].Id}">${data.grupo[i].Descricao}</option>`;
                    }
                    Grupo.addEventListener('change',()=>{getSubGrupos();});
                    PJ.innerHTML=`<option value="${data.cnpj}">${data.nome}</option>`;
                    PJ.style.pointerEvents="none";
                    PJ.style.background = "#ccc";
                }
            }

            if(data.contas.length>0){
                selectFormaDeRecebimento.innerHTML='';
                selectFormaDeRecebimento.innerHTML+='<option value="">Selecione uma opção</option>';
                if(data.contas.length > selectFormaDeRecebimento.length){
                    for(let i = 0;i<=(data.contas.length-1);i++){
                        if(data.contas[i].Agencia=="" ||data.contas[i].Conta==""){
                            selectFormaDeRecebimento.innerHTML+="<option value='"+data.contas[i].ID+"'>"+data.contas[i].Nome+"</option>";
                        }else{
                            selectFormaDeRecebimento.innerHTML+="<option value='"+data.contas[i].ID+"'>"+data.contas[i].Nome+"/"+data.contas[i].Agencia+"/"+data.contas[i].Conta+"</option>";
                        }
                    }
                } 
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function getSubGrupos(){
    var form = $('#formUpdateRecebimento')[0];
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

function tabelaPJ(associados=null){
    $.ajax({
        url:getRoot(getURL()+'/tabelaPJ'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            if(data.erros.length>0 || data.tabela==false){
                const mensage  = document.querySelector("div[id=mensage]");
                mensage.innerHTML='';
                for(let i=0;i<=(data.erros.length-1);i++){
                    mensage.innerHTML+='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.erros[i]+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';   
                }
                var table = $('#tabela_recebimento').DataTable();
                table.clear().draw();
                table.column( 1 ).visible( false );
            }else if(data.tabela.length>0){

                if(associados!=null){
                    escreverTabelaPJ(data,associados);
                }else{
                    escreverTabelaPJ(data);
                }
                
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function tabelaPF(){
    var form = $('#formPJ')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/tabelaPF'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            //Butões
            var permissao = data.permissao[0].Permissao;
            const divbutton = document.querySelector("div[id=divbutton]");
            divbutton.innerHTML="";
            if(permissao==948880538 || permissao==147031419){
                aprovar = document.createElement("button");
                aprovar.setAttribute("id","aprovar");
                aprovar.setAttribute("class","btn btn-primary");
                aprovar.setAttribute("type","button");
                aprovar.setAttribute("onclick","aprovarRecebimento();");
                aprovar.innerHTML='<i class="bi bi-check-circle"></i> Aprovar';
                
                negar = document.createElement("button");
                negar.setAttribute("id","negar");
                negar.setAttribute("class","btn btn-danger");
                negar.setAttribute("type","button");
                negar.setAttribute("onclick","negarRecebimento();");
                negar.innerHTML='<i class="bi bi-x-circle"></i> Negar';
                
                divbutton.appendChild(aprovar);
                divbutton.appendChild(negar);
            }
            if(permissao==687028677 || permissao==948880538){
                /*excluir = document.createElement("button");
                excluir.setAttribute("id","excluir");
                excluir.setAttribute("class","btn btn-danger");
                excluir.setAttribute("type","button");
                excluir.setAttribute("onclick","excluirRecebimento();");
                excluir.innerHTML='<i class="bi bi-x-circle"></i> Excluir';
                divbutton.appendChild(excluir);*/
            }
            if(permissao==687028677 || permissao==948880538 || permissao==147031419){}else{
                divbutton.innerHTML="";
            }
            //Tabela
            const table = $('#tabela_recebimento').DataTable();
            
            if(data.erros[0].length>0 || data.tabela[0]==false){
                //No caso de erros na busca de dados da tabela
                const mensage  = document.querySelector("div[id=mensage]");
                for(let i=0;i<=(data.erros[0].length-1);i++){
                    mensage.innerHTML+='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.erros[0][i]+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';   
                }
                table.clear().draw();
            }else if(data.tabela[0].length>0){

                table.clear().draw();
        
                if(permissao==687028677 || permissao==948880538 || permissao==147031419){
                    //Tabela COM seleção de linhas
                    tabelaComLinhasDeSelecao(table,data,permissao);
                    
                }else{
                    //Tabela SEM seleção de linhas
                    tabelaSemLinhasDeSelecao(data,table);
                }
                
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function tabelaSemLinhasDeSelecao(data,table){
    for(let i=0;i<=(data.tabela[0].length-1);i++){
        
        const theadTabela = document.querySelector('#theadTabela tr');
        
        theadTabela.innerHTML=`
            <th>Data de Envio</th>
            <th>PJ</th>
            <th>PF</th>
            <th>Histórico</th>
            <th>Recebimento</th>
            <th>Descrição</th>
            <th>Beneficiário</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Arquivo</th>
            <th></th><th></th><th></th>
        `;
           
        if(data.tabela[0][i].Agencia!="" && data.tabela[0][i].Conta!=""){
            data.tabela[0][i].TipoDePagamento = data.tabela[0][i].TipoDePagamento+"/"+data.tabela[0][i].Agencia+"/"+data.tabela[0][i].Conta
        }   
        
        /*var Arquivo = "";
        if(data.tabela[0][i].Arquivo!=""){
           Arquivo = `<a target='_blank' href='${data.tabela[0][i].Arquivo}'>${data.tabela[0][i].Arquivo}</a>`; 
        }*/

        var Arquivo = "";
        if(data.tabela[i].Arquivo!=""){
            Arquivo = `<a target='_blank' href='${data.tabela[i].Arquivo}'>${data.tabela[i].Arquivo}</a>`;
        }

        var arquivos = "";
        if(data.tabela[i].arquivos.length>0){
            let array = JSON.stringify({
                "id":data.tabela[i].ID,
                "arquivos":data.tabela[i].arquivos
            });
            //array.push(data.tabela[i].ID);
            //console.log(array);
            arquivos = `<button 
                type='button' 
                class='btn btn-primary' 
                data-bs-toggle='modal' 
                data-bs-target='#modalArquivos'
                id = '${data.tabela[i].ID}'
                onclick='escreverListaArquivos(${array})'
            >
            Arquivos
            </button>`;
        }else{
            let array = JSON.stringify({
                "id":data.tabela[i].ID
            });
            arquivos = `<button type='button' 
                class='btn btn-primary' 
                data-bs-toggle='modal' 
                data-bs-target='#modalArquivos'
                id = '${data.tabela[i].ID}'
                onclick='escreverListaArquivos(${array})'
            >Arquivos</button>`;
        }

        if(sessionStorage.getItem('TipoCliente')=="PF"){
            data.tabela[0][i].PF="Você";
        }
        table.row.add([
            data.tabela[0][i].DataDeEnvio,
            data.tabela[0][i].PJ,
            data.tabela[0][i].PF,
            data.tabela[0][i].Historico,
            data.tabela[0][i].TipoDePagamento,
            data.tabela[0][i].Descricao,
            data.tabela[0][i].Ofertante,
            data.tabela[0][i].Valor,
            data.tabela[0][i].Data,
            arquivos,
            "",
            ""
        ]).draw();
        
    }
    /*table.column( 0 ).visible( false );
    table.column( 1 ).visible( false );*/
}

function tabelaComLinhasDeSelecao(table,data,permissao){
    for(let i=0;i<=(data.tabela[0].length-1);i++){
        
        if(data.tabela[0][i].Agencia!="" && data.tabela[0][i].Conta!=""){
            data.tabela[0][i].TipoDePagamento = data.tabela[0][i].TipoDePagamento+"/"+data.tabela[0][i].Agencia+"/"+data.tabela[0][i].Conta
        }
                        
        /*var Arquivo = "";
        if(data.tabela[0][i].Arquivo!=""){
           Arquivo = `<a target='_blank' href='${data.tabela[0][i].Arquivo}'>${data.tabela[0][i].Arquivo}</a>`; 
        }*/

        var Arquivo = "";
        if(data.tabela[0][i].Arquivo!=""){
            Arquivo = `<a target='_blank' href='${data.tabela[0][i].Arquivo}'>${data.tabela[0][i].Arquivo}</a>`;
        }

        var arquivos = "";
        if(data.tabela[0][i].arquivos.length>0){
            let array = JSON.stringify({
                "id":data.tabela[0][i].ID,
                "arquivos":data.tabela[0][i].arquivos
            });
            //array.push(data.tabela[0][i].ID);
            //console.log(array);
            arquivos = `<button 
                type='button' 
                class='btn btn-primary' 
                data-bs-toggle='modal' 
                data-bs-target='#modalArquivos'
                id = '${data.tabela[0][i].ID}'
                onclick='escreverListaArquivos(${array})'
            >
            Arquivos
            </button>`;
        }else{
            let array = JSON.stringify({
                "id":data.tabela[0][i].ID
            });
            arquivos = `<button type='button' 
                class='btn btn-primary' 
                data-bs-toggle='modal' 
                data-bs-target='#modalArquivos'
                id = '${data.tabela[0][i].ID}'
                onclick='escreverListaArquivos(${array})'
            >Arquivos</button>`;
        }
        
        var ID = `<input class='form-check-input me-3' type='checkbox' name='sel[]' value='${data.tabela[0][i].ID}'/>`;
        
        data.tabela[0][i].Valor="R$ "+data.tabela[0][i].Valor;
        if(sessionStorage.getItem('TipoCliente')=="PF"){
            data.tabela[0][i].PF="Você";
        }
        if(permissao==948880538 || permissao==147031419){
            //Tabela COM status de aprovação do conselho
            const theadTabela = document.querySelector('#theadTabela tr');
        
            theadTabela.innerHTML=`
                <th></th>
                <th>Status</th>
                <th>Data de Envio</th>
                <th>PJ</th>
                <th>PF</th>
                <th>Histórico</th>
                <th>Recebimento</th>
                <th>Descrição</th>
                <th>Beneficiário</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Arquivo</th>
            `;
            
            let arrayTabelaConselho=[];
            
            if(data.tabela[0][i].IDStatus==0 || data.tabela[0][i].IDStatus==null){
                arrayTabelaConselho.push("<input class='form-check-input me-3' type='checkbox' name='sel[]' value='"+ data.tabela[0][i].ID+"' />","<span class='status pendente'>Não revisado</span>");
            }else if(data.tabela[0][i].IDStatus==1){
                arrayTabelaConselho.push("<input class='form-check-input me-3' type='checkbox' name='sel[]' value='"+ data.tabela[0][i].ID+"' />","<span class='status cancelado'>Negado</span>");
            }else if(data.tabela[0][i].IDStatus==2){
                arrayTabelaConselho.push("<input class='form-check-input me-3' type='checkbox' name='sel[]' value='"+ data.tabela[0][i].ID+"' />","<span class='status aprovado'>Aprovado</span>");
            }
            
            arrayTabelaConselho.push(
                data.tabela[0][i].DataDeEnvio,
                data.tabela[0][i].PJ,
                data.tabela[0][i].PF,
                data.tabela[0][i].Historico,
                data.tabela[0][i].TipoDePagamento,
                data.tabela[0][i].Descricao,
                data.tabela[0][i].Ofertante,
                data.tabela[0][i].Valor,
                data.tabela[0][i].Data,
                arquivos,
                ""
            );
            
            table.row.add(arrayTabelaConselho).draw();
        }else{
            
            const theadTabela = document.querySelector('#theadTabela tr');
        
            theadTabela.innerHTML=`
                <th></th>
                <th>Data de Envio</th>
                <th>PJ</th>
                <th>PF</th>
                <th>Histórico</th>
                <th>Recebimento</th>
                <th>Descrição</th>
                <th>Beneficiário</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Arquivo</th>
                <th></th><th></th>
            `;
            
            table.row.add([
                ID,
                data.tabela[0][i].DataDeEnvio,
                data.tabela[0][i].PJ,
                data.tabela[0][i].PF,
                data.tabela[0][i].Historico,
                data.tabela[0][i].TipoDePagamento,
                data.tabela[0][i].Descricao,
                data.tabela[0][i].Ofertante,
                data.tabela[0][i].Valor,
                data.tabela[0][i].Data,
                arquivos,
                ""
            ]).draw();
        }
    }
    
    /*if(permissao==948880538 || permissao==147031419){
        table.column( 0 ).visible( true );
        table.column( 1 ).visible( true );
    }else{
        table.column( 0 ).visible( true );
        table.column( 1 ).visible( false );
    }*/
}

function associadosPF(){
    $.ajax({
        url:getRoot(getURL()+'/associadosPF'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            if(data.erros.length>0){
                
            }else if(data.pj[0].length>0){
                const selectPJ = document.querySelector("select[name=pj]");
                //console.log(selectPJ);
                for(var i = 0;i<=(data.pj[0].length-1);i++){
                    selectPJ.innerHTML+="<option value='"+data.pj[0][i].CNPJ+"'>"+data.pj[0][i].Nome+"</option>";
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function associadosPJ(){
    $.ajax({
        url:getRoot(getURL()+'/associadosPJ'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            console.log(data);
            if(data.erros.length>0){
                
            }else if(data.conselheiros.length>0){
                //const theadTabela = document.querySelector('#theadTabela tr');
                //const tfootTabela = document.querySelector('#tfootTabela tr');
                
                //console.log(theadTabela);
                //console.log(tfootTabela);
                
                /*for(let i=0;i<=(data.conselheiros.length-1);i++){
                    theadTabela.innerHTML+="<th>"+data.conselheiros[i].NomePF+"</th>";
                    //tfootTabela.innerHTML+="<th>"+data.conselheiros[i].NomePF+"</th>";
                }*/
                
                tabelaPJ(data.conselheiros);
            }else{
                tabelaPJ();
            }
            
            /*$('#tabela_recebimento').DataTable({
                buttons: [
                    'excel',
                    'csv'
                ],
                dom: 'Bfrtip',
                searching: false
            } );*/
            
            
        },
        error: function(jqXhr, textStatus, errorMessage){
            tabelaPJ();
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function aprovarRecebimento(){
    var form = $('#formTabela')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/aprovarRecebimento'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            console.log(data.retorno);
            if(data.erros.length>0){
                console.log(data.erros);
            }else{
                if(data.retorno.aprovados>0){
                    const mensage  = document.querySelector("div[id=mensage]");
                    mensage.innerHTML='';
                    mensage.innerHTML='<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.retorno.aprovados+' aprovado(s)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }else if(data.retorno.nAprovados>0){
                    const mensage  = document.querySelector("div[id=mensage]");
                    mensage.innerHTML='';
                    mensege.innerHTML='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.retorno.nAprovados+' NÃO aprovado(s)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            tabelaPF();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function negarRecebimento(){
    var form = $('#formTabela')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/negarRecebimento'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            //console.log(data);
            //console.log(data.retorno);
            if(data.erros.length>0){
                //console.log(data.erros);
                const mensage  = document.querySelector("div[id=mensage]");
                mensage.innerHTML='';
                for(let i=0;i<=(data.erros.length-1);i++){
                    mensege.innerHTML+='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.erros[i]+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }else{
                if(data.retorno.aprovados>0){
                    const mensage  = document.querySelector("div[id=mensage]");
                    mensage.innerHTML='';
                    mensage.innerHTML='<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.retorno.aprovados+' negado(s)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }else if(data.retorno.nAprovados>0){
                    const mensage  = document.querySelector("div[id=mensage]");
                    mensage.innerHTML='';
                    mensege.innerHTML='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.retorno.nAprovados+' NÃO negado(s)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            tabelaPF();
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function excluirRecebimento(id){
    //var form = $('#formTabela')[0];
    var formData = new FormData();
    formData.append('id',id);
    $.ajax({
        url:getRoot(getURL()+'/excluirRecebimento'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            if(data.erros.length>0){
                const mensage  = document.querySelector("div[id=mensage]");
                mensage.innerHTML='';
                for(let i=0;i<=(data.erros.length-1);i++){
                    mensage.innerHTML+='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.erros[i]+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }else{
                if(sessionStorage.getItem('TipoCliente')=="PF"){
                    tabelaPF();
                }else if(sessionStorage.getItem('TipoCliente')=="PJ"){
                    console.log("PJ");
                    tabelaPJ();
                }
                
                if(data.retornos.apagados>0){
                    const mensage  = document.querySelector("div[id=mensage]");
                    mensage.innerHTML='';
                    mensage.innerHTML='<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.retornos.apagados+' foram apagado(s)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }else if(data.retornos.nApagados>0){
                    const mensage  = document.querySelector("div[id=mensage]");
                    mensage.innerHTML='';
                    mensage.innerHTML='<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.retornos.nApagados+' NÃO foram apagado(s)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
            sessionStorage.getItem('TipoCliente');
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function atualizarRecebimento(){
    //formUpdatePagamento
    var formData = new FormData($('#formUpdateRecebimento')[0]);
    $.ajax({
        url:getRoot(getURL()+'/atualizarRecebimento'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            if(data.erro.length>0){
                const mensage  = document.querySelector("div[id=mensage]");
                mensage.innerHTML='';
                mensage.innerHTML='<div class="alert alert-danger alert-dismissible fade show" role="alert">'+data.erro+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }else{
                if(sessionStorage.getItem('TipoCliente')=="PF"){
                    tabelaPF();
                }else if(sessionStorage.getItem('TipoCliente')=="PJ"){
                    tabelaPJ();
                }
                 
                const mensage  = document.querySelector("div[id=mensage]");
                mensage.innerHTML='';
                mensage.innerHTML='<div class="alert alert-success alert-dismissible fade show" role="alert">'+data.sucesso+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
              
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
}

function setModalRecebimento(json=null){
    console.log(json);
    const IdRecebimento= document.querySelector('input[name=IdRecebimento]');
    const Descricao = document.querySelector('textarea[name=Descricao]');
    const Ofertante = document.querySelector('input[name=Ofertante]');
    const Data = document.querySelector('input[name=Data]');
    const Valor = document.querySelector('input[name=Valor]');

    IdRecebimento.value=json.Id;
    Descricao.value = json.Descricao;
    Ofertante.value = json.Ofertante;
    Data.value = `${json.Data.split("/")[2]}-${json.Data.split("/")[1]}-${json.Data.split("/")[0]}`;
    Valor.value = json.Valor.replace("R$", "");
}

function setModalConfirmaExclusaoRecebimento(id=null){
    if(id!=null){
        document.querySelector("button[id=btnConfirmaExclusaoRecebimento]").addEventListener("click",()=>{
            excluirRecebimento(id);
        });
    }
}

window.addEventListener("load",()=>{
    //associadosPJ
    
    $.ajax({
        url:getRoot(getURL()+'/tipocliente'),
        type:"GET",
        dataType:'json',
        success: function(data,status,xhr){
            //console.log(data);
            if(data.TipoCliente=="PF"){
                $('#tabela_recebimento').DataTable({
                    buttons: [
                        'excel',
                        'csv'
                    ],
                    dom: 'Bfrtip',
                    searching: false
                } );
                
                //const divDtButtons = document.querySelector("div.dt-buttons");
                //divDtButtons.style.margin='0 0 3% 0';
                const btnExcel = document.querySelector("button.buttons-excel");
                btnExcel.setAttribute('class',"btn btn-success buttons-excel buttons-html5");
                btnExcel.innerHTML="<i class='bi bi-file-earmark-excel'></i> Excel";
                
                const btnCSV = document.querySelector("button.buttons-csv");
                btnCSV.setAttribute('class',"btn btn-secondary buttons-csv buttons-html5");
                btnCSV.innerHTML="<i class='bi bi-filetype-csv'></i> CSV";
    
                associadosPF();
                const cadrFormPJ = document.querySelector("div#cardFormPJ");
                cadrFormPJ.style.display="flex";
            }else if(data.TipoCliente=="PJ"){
                associadosPJ();
                dadosPJ();
                /*const divbutton = document.querySelector("div[id=divbutton]");
                divbutton.innerHTML="";
                excluir = document.createElement("button");
                excluir.setAttribute("id","excluir");
                excluir.setAttribute("class","btn btn-danger");
                excluir.setAttribute("type","button");
                excluir.setAttribute("onclick","excluirRecebimento();");
                excluir.innerHTML='<i class="bi bi-x-circle"></i> Excluir';
                divbutton.appendChild(excluir);*/
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
        }
    });
    
});
const selectPJ = document.querySelector("select[name=pj]");
selectPJ.addEventListener("change",()=>{
    tabelaPF();
});