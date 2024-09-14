const optionMenu = document.querySelector(".select-menu"),
selectBtn = optionMenu.querySelector(".select-btn"),
options = optionMenu.querySelectorAll(".option"),
sBtn_text = optionMenu.querySelector(".sBtn-text");

selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));       
options.forEach(option =>{
    option.addEventListener("click", ()=>{
        let selectedOption = option.querySelector(".option-text").innerText;
        sBtn_text.innerText = selectedOption;
        optionMenu.classList.remove("active");
    });
});           
const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formStepsNum++;
    updateFormSteps();
    updateProgressbar();
  });
});

prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formStepsNum--;
    updateFormSteps();
    updateProgressbar();
  });
});

function updateFormSteps() {
  formSteps.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
    formStep.classList.remove("form-step-active");
  });

  formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressbar() {
  progressSteps.forEach((progressStep, idx) => {
    if (idx < formStepsNum + 1) {
      progressStep.classList.add("progress-step-active");
    } else {
      progressStep.classList.remove("progress-step-active");
    }
  });

  const progressActive = document.querySelectorAll(".progress-step-active");

  progress.style.width =
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}

const butaoBanco = document.querySelector("#Banco");
const butaoPix = document.querySelector("#pix");

const bancoDiv = document.querySelector("#Banco-div");
const pixDiv = document.querySelector("#pix-div");


butaoBanco.addEventListener('click',()=>{
    bancoDiv.style.display='flex';
    bancoDiv.disabled=false;
  
  pixDiv.style.display='none';
  pixDiv.disabled=true;
});

butaoPix.addEventListener('click',()=>{
    pixDiv.style.display='flex';
    pixDiv.disabled=false;
    
    bancoDiv.style.display='none';
    bancoDiv.disabled=true;
});

function mudaValorCep(data){
  document.querySelector("input[name=enderecoPF]").value = data.logradouro;
  document.querySelector("input[name=cidadePF]").value = data.localidade;
  document.querySelector("input[name=bairroPF]").value = data.bairro;
  document.querySelector("input[name=complementoPF]").value = data.complemento;
  document.querySelector("input[name=ufPF]").value = data.uf;
}

function buscaCep(cepInput){

  $.ajax({
      url:'https://viacep.com.br/ws/'+ cepInput.value.replace(/[^0-9]/g, '') + '/json/',
      type:"GET",
      dataType:'json',
      success: function(data){
          console.log(data);
          mudaValorCep(data)
          // if(tipoCliente=="PJ"){mudaValorCepPJ(data);}
      },
      error: function(jqXhr, textStatus, errorMessage){
          console.log(jqXhr+' '+textStatus+' '+errorMessage);
      }
  });
}

function maskNumber(event){
  const input = event.target;
  input.value = input.value.replace(/\D/g, '');
}

//Dependentes functions

var controleCampo = 1;
function adicionarCampo() {
    controleCampo++;
    console.log(controleCampo);

    document.getElementById('form-dependente').insertAdjacentHTML('beforeend', '<div id="campo' + controleCampo + '"><br><span class="title">Dependente' + controleCampo + '</span><fildset action="" class="fields"><div class="input-field"><label for="">N° do CPF</label><input type="text" name="cpfDepedentes1' + controleCampo + '"id="cpfDepedentes' + controleCampo +'" class="form-control" maxlength="14" minlength="14" onkeypress="mascaraCpf(this, cpf)" onblur="mascaraCpf(this, cpf)" /> </div><div class="input-field"><label for="">Nome</label><input type="text" name="nomeDepedentes' + controleCampo +'" id="nomeDepedentes' + controleCampo +'" class="form-control" minlength="20" maxlength="150" pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(th);" /></div><div class="input-field"><label for="">Data de Nascimento</label><input type="date" name="dataNascimentoDepedentes' + controleCampo +'" id="dataNascimentoDepedentes' + controleCampo +'" class="form-control"/></div><div class="radio-field"><span>Você possui alguma deficiencia</span><br><input type="radio" id="sim' + controleCampo +'" name="radio_depedente' + controleCampo +'" class="radio" value="sim"><label for="">Sim</label><br><input type="radio" id="nao' + controleCampo +'" name="radio_depedente' + controleCampo +'" class="radio" value="nao"><label for="">Não</label><br></div><div class="input-field"><label for="">Local do Nascimento</label><input type="text" name="localNascimentoDepedentes' + controleCampo +'" id="localNascimentoDepedentes' + controleCampo +'" class="form-control" minlength="10" maxlength="40" pattern="[a-z A-Z À-ú]{2,}" onkeyup="mascaraNome(this);" onkeydown="mascaraNome(this);" /></div><div class="input-field"><label for="">Tipo de Depedencia</label><input type="text" name="tipoDepedencia' + controleCampo +'" id="tipoDepedencia' + controleCampo +'" class="form-control" /></div><div class="input-field2"><label for="">Matricula Cartório</label><input type="text" name="matriculaCartorio' + controleCampo +'" id="matriculaCartorio' + controleCampo +'" class="form-control" onkeypress="return maskNumber(event);" /></div><div class="input-field2"><label for="">Número Registro Cartório</label><input type="text" name="registroCartorio' + controleCampo +'" id="registroCartorio' + controleCampo +'" class="form-control" onkeypress="return maskNumber(event);" /></div><div class="input-field"><label for="">Número Livro</label><input type="text" name="numeroLivro' + controleCampo +'" id="numeroLivro' + controleCampo +'" class="form-control" onkeypress="return maskNumber(event);" /></div><div class="input-field"><label for="">Número Folha</label><input type="text" name="numeroFolha' + controleCampo +'" id="numeroFolha' + controleCampo +'" class="form-control" onkeypress="return maskNumber(event);" /></div><div class="input-field"><label for="">Número da D.N.V</label><input type="text" name="numeroDNV' + controleCampo +'" id="numeroDNV' + controleCampo +'" class="form-control" onkeypress="return maskNumber(event);" /></div> <button type="button" class="btn btn-remove" id="' + controleCampo + '" onclick="removerCampo(' + controleCampo + ')"> <i class="fa-solid fa-trash-can" aria-hidden="true"></i> Excluir </button></fildset>');
}

function removerCampo(idCampo){
    console.log("Campo remover: " + idCampo);
    document.getElementById('campo' + idCampo).remove();
}