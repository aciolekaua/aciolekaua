const circles = document.querySelectorAll(".circle");
const circles1 = document.querySelectorAll(".circle1");
  progressBar = document.querySelector(".indicator");
  progressBar1 = document.querySelector(".indicator1");
  buttons = document.querySelectorAll(".button");
  buttons1 = document.querySelectorAll(".button1");
const formSteps = document.querySelectorAll(".form-step");
const formSteps1 = document.querySelectorAll(".form-step1");

let currentStep = 1;
let formStepsNum = 0;
// função que atualiza a etapa atual e atualiza o DOM
const updateSteps = (e) => {
  // atualize a etapa atual com base no botão clicado
  currentStep = e.target.id === "next" ? ++currentStep : --currentStep;
  formStepsNum = e.target.id === "next" ? ++formStepsNum : --formStepsNum;
  updateFormSteps();
  // percorrer todos os círculos e adicionar/remover classe "ativa" com base em seu índice e etapa atual
  circles.forEach((circle, index) => {
    circle.classList[`${index < currentStep ? "add" : "remove"}`]("active");
  });
  // atualize a largura da barra de progresso com base na etapa atual
  progressBar.style.width = `${((currentStep - 1) / (circles.length - 1)) * 100}%`;
  // verifique se a etapa atual é a última etapa ou a primeira etapa e desative os botões correspondentes

};

// adicionar ouvintes de evento de clique a todos os botões
buttons.forEach((button) => {
  button.addEventListener("click", updateSteps);
  
});

function updateFormSteps() {
  formSteps.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
      formStep.classList.remove("form-step-active");
  });

  formSteps[formStepsNum].classList.add("form-step-active");
}

let currentStep1 = 1;
let formStepsNum1 = 0;

// função que atualiza a etapa atual e atualiza o DOM
const updateSteps1 = (e) => {
  // atualize a etapa atual com base no botão clicado
  currentStep1 = e.target.id === "next1" ? ++currentStep1 : --currentStep1;
  formStepsNum1 = e.target.id === "next1" ? ++formStepsNum1 : --formStepsNum1;
  updateFormSteps1();
  // percorrer todos os círculos e adicionar/remover classe "ativa" com base em seu índice e etapa atual
  circles1.forEach((circle1, index) => {
    circle1.classList[`${index < currentStep1 ? "add" : "remove"}`]("active1");
  });
  // atualize a largura da barra de progresso com base na etapa atual
  progressBar1.style.width = `${((currentStep1 - 1) / (circles1.length - 1)) * 100}%`;
  // verifique se a etapa atual é a última etapa ou a primeira etapa e desative os botões correspondentes

};

// adicionar ouvintes de evento de clique a todos os botões
buttons1.forEach((button) => {
  button.addEventListener("click", updateSteps1);
  
});

function updateFormSteps1() {
    formSteps1.forEach((formStep1) => {
        formStep1.classList.contains("form-step-active1") &&
        formStep1.classList.remove("form-step-active1");
    });

  formSteps1[formStepsNum1].classList.add("form-step-active1");
}