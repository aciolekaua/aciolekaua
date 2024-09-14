function getDados(){
    $.ajax({
        url:getRoot(getURL()+"/dados"),
        type:"GET",
        datatype:"json",
        timeout:(1*60*1000),
        success: function(data,status,xhr){
            console.log(data);
            writePJs(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    })
}

function writePJs(data){
    if(data.erros.length>0){
        
    }else{
        if(data.TipoCliente=="PF"){
            if(data.PJs!==false && data.PJs.length>0){
                const PJ = document.querySelector("select[name=PJ]");
                PJ.innerHTML='';
                PJ.innerHTML+='<option value="">Selecione uma opção</option>';
                for(let i=0;i<=data.PJs.length-1;i++){
                    PJ.innerHTML+="<option value='"+data.PJs[i].CNPJ+"'>"+data.PJs[i].Nome+"</option>";
                }
            }
        }else if(data.TipoCliente=="PJ"){
            const PJ = document.querySelector("select[name=PJ]");
            PJ.innerHTML=`<option value='${data.dados.id}' selected>${data.dados.nomeFantasia}</option>`;
            PJ.style.pointerEvents='none';
            PJ.style.opacity='0.8';
            PJ.style.userSelect='none';
            //getNotasClonadas(PJ.value);
            getAtividade(PJ.value);
            getNaturezaOperacao(PJ.value);
            getServico(PJ.value);

            if(data.ultimaSerie!=false){
                document.querySelector('input[name=NdoRPS]').value = parseInt(data.ultimaSerie.DocNumero)+1;
                document.querySelector('input[name=SerieDoRPS]').value = data.ultimaSerie.DocSerie;
            }
            
        }
    }
}
function mudaValorCNPJ(data){
    document.querySelector('input[name=nomeTomador]').value = data.nome;
    document.querySelector('input[name=cepTomador]').value = data.cep;
}

function buscaCNPJ(inpuCNPJ){
    
    if(inpuCNPJ.value.replace(/[^0-9]/g, '').length > 11){
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
     
}

function copiarNota(){
    
    var dadosNota = JSON.parse(localStorage.getItem('copiarNota'));
    var urlAtual = window.location.href;
    var urlClass = new URL(urlAtual);
    var copy = urlClass.searchParams.get("copy");
    if(copy==null){
        localStorage.removeItem('copiarNota');
    }else{
        if(localStorage.getItem('copiarNota')==null){
            $('.overlayk-loading').fadeOut();
        }else{
            
            
            var setTime = setInterval(()=>{
                if(parseInt(localStorage.getItem('confirmaCarregamento'))>=3){
                    
                    document.querySelector('#atividade').value=dadosNota.CompNfse.Nfse.InfNfse.Servico.CodigoCnae;
                    document.querySelector('#naturezaOperacao').value=dadosNota.CompNfse.Nfse.InfNfse.NaturezaOperacao;
                    document.querySelector('#selectServico').value=dadosNota.CompNfse.Nfse.InfNfse.Servico.ItemListaServico;
                    document.querySelector('textarea[name=DescriminacaoDosServicos]').value=dadosNota.CompNfse.Nfse.InfNfse.Servico.Discriminacao;
                    if(dadosNota.CompNfse.Nfse.InfNfse.TomadorServico.IdentificacaoTomador.CpfCnpj.Cnpj!=null){
                        document.querySelector('#CpfCnpjTomador').value=dadosNota.CompNfse.Nfse.InfNfse.TomadorServico.IdentificacaoTomador.CpfCnpj.Cnpj;
                        mask(document.querySelector('#CpfCnpjTomador'),cpfCnpjMask);
                        //buscaCNPJ(document.querySelector('#CpfCnpjTomador'));
                    }else if(dadosNota.CompNfse.Nfse.InfNfse.TomadorServico.IdentificacaoTomador.CpfCnpj.Cpf!=null){
                        document.querySelector('#CpfCnpjTomador').value=dadosNota.CompNfse.Nfse.InfNfse.TomadorServico.IdentificacaoTomador.CpfCnpj.Cpf;
                        mask(document.querySelector('#CpfCnpjTomador'),cpfCnpjMask);
                    }
                    
                    document.querySelector('#nomeTomador').value=dadosNota.CompNfse.Nfse.InfNfse.TomadorServico.RazaoSocial;
                    if(dadosNota.CompNfse.Nfse.InfNfse.TomadorServico.Endereco.Cep!=null){
                        document.querySelector('#cepTomador').value=dadosNota.CompNfse.Nfse.InfNfse.TomadorServico.Endereco.Cep;
                    }else{
                        buscaCNPJ(document.querySelector('#CpfCnpjTomador'));
                    }
  
                    mask(document.querySelector('#cepTomador'),cepMask);
                    document.querySelector('input[name=ValorTotalDosServicos]').value=dadosNota.CompNfse.Nfse.InfNfse.Servico.Valores.ValorServicos;
                    mascaraDinheiro(document.querySelector('input[name=ValorTotalDosServicos]'));
                    document.querySelector('input[name=NdoRPS]').value=parseInt(dadosNota.CompNfse.Nfse.InfNfse.IdentificacaoRps.Numero);
                    document.querySelector('input[name=SerieDoRPS]').value=parseInt(dadosNota.CompNfse.Nfse.InfNfse.IdentificacaoRps.Serie);
                    
                    $('.overlayk-loading').fadeOut();
                    clearInterval(setTime);
                    
                }else if(parseInt(localStorage.getItem('negaCarregamento'))>0){
                    $('.overlayk-loading').fadeOut();
                    clearInterval(setTime);
                    
                }
            },1000);
           
            console.log(dadosNota.CompNfse.Nfse);
        }
        
    }
}

window.addEventListener('load',()=>{
    
    if(sessionStorage.getItem('TipoCliente')=='PJ'){
        copiarNota();
        var urlAtual = window.location.href;
        var urlClass = new URL(urlAtual);
        var copy = urlClass.searchParams.get("copy");
        if(copy!=null){
            localStorage.setItem('confirmaCarregamento',0);
            localStorage.setItem('negaCarregamento',0)
            $('.overlayk-loading').fadeIn();
        }
    }else if(sessionStorage.getItem('TipoCliente')=='PF'){
        /*document.querySelector('select[name=PJ]').addEventListener('change',()=>{
            copiarNota();
            var urlAtual = window.location.href;
            var urlClass = new URL(urlAtual);
            var copy = urlClass.searchParams.get("copy");
            if(copy!=null){
                localStorage.setItem('confirmaCarregamento',0);
                localStorage.setItem('negaCarregamento',0)
                $('.overlayk-loading').fadeIn();
            }
        });*/
    }
    
    getDados();
    dateNow(document.querySelector('input[name=dataCompetencia]'));
});