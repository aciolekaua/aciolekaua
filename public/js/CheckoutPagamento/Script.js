$('#expire-date-mes').mask('99');
$('#expire-date-ano').mask('99');
$('#cartao-cvv').mask('999');
$("#numero-cartao").mask('9999 9999 9999 9999');

const butaoCartao = document.querySelector("#cartao");
const butaoBoleto = document.querySelector("#boleto");
const butaoPix = document.querySelector("#pix");
const cartaoSvg = document.querySelector(".flip-card");

const cardFildset = document.querySelector(".card-fildset");
const boletoFildset = document.querySelector("#boleto-fildset");
const pixFildset = document.querySelector("#pix-fieldset");

const cartaoBtn = document.querySelector(".cartao-btn");
const boletoBtn = document.querySelector(".boleto-btn");
const pixBtn = document.querySelector(".pix-btn");


butaoCartao.addEventListener('click',()=>{
    cardFildset.style.display='flex';
    cardFildset.disabled=false;
    cartaoSvg.style.display = 'flex';
  
  boletoFildset.style.display='none';
  boletoFildset.disabled=true;
  
  pixFildset.style.display='none';
  pixFildset.disabled=true;
  
  cartaoBtn.classList.replace("bi-check-circle", "bi-check-circle-fill");
  pixBtn.classList.replace("bi-check-circle-fill", "bi-check-circle");
  boletoBtn.classList.replace("bi-check-circle-fill", "bi-check-circle");
});

butaoBoleto.addEventListener('click',()=>{
    boletoFildset.style.display='flex';
    boletoFildset.disabled=false;
    
    cardFildset.style.display='none';
    cardFildset.disabled=true;
    
    cartaoSvg.style.display = 'none';
    
    pixFildset.style.display='none';
    pixFildset.disabled=true;
    
    boletoBtn.classList.replace("bi-check-circle", "bi-check-circle-fill");
    cartaoBtn.classList.replace("bi-check-circle-fill", "bi-check-circle");
    pixBtn.classList.replace("bi-check-circle-fill", "bi-check-circle");
    
});

butaoPix.addEventListener('click',()=>{
    pixFildset.style.display='flex';
    pixFildset.disabled=false;
    
    boletoFildset.style.display='none';
    boletoFildset.disabled=true;
    
    cardFildset.style.display='none';
    cardFildset.disabled=true;
    
    cartaoSvg.style.display = 'none';
    
    pixBtn.classList.replace("bi-check-circle", "bi-check-circle-fill");
    cartaoBtn.classList.replace("bi-check-circle-fill", "bi-check-circle");
    boletoBtn.classList.replace("bi-check-circle-fill", "bi-check-circle");
});

function mascaraNome(i){
    var v = i.value.replace(/\d/g,'').toUpperCase();
        i.value = v.toUpperCase();
}


function recebernomecartao() {
    let nomeCartao = document.getElementById("nome-cartao").value;
    document.getElementById("valor_nomeCartao").innerHTML = nomeCartao;
}
function recebernumerocartao() {
    let numeroCartao = document.getElementById("numero-cartao").value;
    document.getElementById("valor_numeroCartao").innerHTML = numeroCartao;
}
function recebernumeromes() {
    let numeroMes = document.getElementById("expire-date-mes").value;
    document.getElementById("valor_dataMes").innerHTML = numeroMes;
}
function recebernumeroano() {
    let numeroAno = document.getElementById("expire-date-ano").value;
    document.getElementById("valor_dataAno").innerHTML = numeroAno;
}
function recebernumerocvv() {
    let numeroCvv = document.getElementById("cartao-cvv").value;
    document.getElementById("valor_cvv").innerHTML = numeroCvv;
}

$(function(){
    let form = $('#formGerarPix')[0];
    let formData = new FormData(form);
   $('#btnPix').on('click',function(){
       $.ajax({
        url:getRoot(getURL()+'/gerarQrcode'),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(1*60*1000),
        cache:false,
        processData: false,
        contentType:false,
            success: function(data,status,xhr){
                console.log(data);
                $('.overlayk-loading').fadeOut();
                
            },
            error: function(jqXhr, textStatus, errorMessage){
                console.log(jqXhr+" "+textStatus+" "+errorMessage);
                $('.overlayk-loading').fadeOut();
            } 
       });
   });
});
