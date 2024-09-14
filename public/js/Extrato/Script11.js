function uploadExtrato(){
    let form = $('#formExtrato')[0];
    let formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/enviarExtrato'),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        datatype:"json",
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            console.log(data);
            $('.overlayk-loading').fadeOut();
            const divMenssage = document.querySelector("#menssage");
            if(data.erros.length>0){
                for(let i=0;i<=data.erros.length-1;i++){
                    var divAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    divAlert += data.erros[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }
            }
            if(data.sucessos.length>0){
                for(let i=0;i<=data.sucessos.length-1;i++){
                    var divAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    divAlert += data.sucessos[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }
            }
            buscarExtrato();

        },
        error: function(texto1, texto2, texto3){
            console.log(texto1+" "+texto2+" "+texto3 );
            $('.overlayk-loading').fadeOut();     
        }
    });

}

function buscarExtrato(){
    $.ajax({
        url:getRoot(getURL()+'/getExtrato'),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        datatype:"json",
        data: {},
        timeout:(60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            $('.overlayk-loading').fadeOut();
            console.log(data);
             if(data.erros.length>0){
                var table = $('#tabelaExtrato').DataTable();
                table.clear().draw();
            }else{

                var table = $('#tabelaExtrato').DataTable();
                table.clear().draw();
                if(data.dados.length<=0){
                    
                }else{
                    for(let i=0;i<=data.dados.length-1;i++){

                        var buttons = "<div class='row flex-row flex-nowrap'>";
                        buttons+=`
                            <div class='col'>
                                
                                <i class="btn bi bi-pencil-square text-primary" data-bs-toggle="modal" data-bs-target="#" onclick=""></i>
                                
                            </div>
                        `;
                        buttons+=`<div class='col'><i onclick="deleteExtrato('${data.dados[i].id}');" class="btn bi bi-trash-fill text-danger"></i></div>`;
                        buttons+=`</div>`;

                        var linha =[];
                        linha.push(
                            data.dados[i].dataEmissao,
                            data.dados[i].dataCompetencia,
                            `<a href="${data.dados[i].url}" target="_blank">Arquivo</a>`,
                            buttons
                        );
                        
                        table.row.add(linha).draw();
                    }
                }
            }
        },
        error: function(texto1, texto2, texto3){
            $('.overlayk-loading').fadeOut();     
            console.log(texto1+" "+texto2+" "+texto3 );
        }
    });
}

function deleteExtrato(id){
    let formData = new FormData();
    formData.append('id',id);
    $.ajax({
        url:getRoot(getURL()+'/deleteExtrato'),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        datatype:"json",
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            console.log(data);
            $('.overlayk-loading').fadeOut();
            buscarExtrato();
            const divMenssage = document.querySelector("#menssage");
            if(data.erro.length>0){
                for(let i=0;i<=data.erro.length-1;i++){
                    var divAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    divAlert += data.erros[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }
            }
            if(data.sucesso.length>0){
                for(let i=0;i<=data.sucesso.length-1;i++){
                    var divAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    divAlert += data.sucessos[i];
                    divAlert += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    divAlert += '</div>';
                    divMenssage.innerHTML+=divAlert;
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+' '+textStatus+' '+errorMessage);
            $('.overlayk-loading').fadeOut();
        }
    });
}

window.addEventListener('load',()=>{
    //$('input[name=mes]').mask('99');
    //$('input[name=ano]').mask('9999');
    var ano = new Date().getFullYear();
    for(let i=0;i<=6;i++){
        document.querySelector('select[name=ano]').innerHTML+=`<option value="${(ano-i)}">${(ano-i)}</option>`;
    }
    buscarExtrato();
});
    