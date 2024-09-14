const calendar = document.querySelector(".calendar"),
    date = document.querySelector(".date"),
    daysContainer = document.querySelector(".days"),
    prev = document.querySelector(".prev"),
    next = document.querySelector(".next"),
    todayBtn = document.querySelector(".today-btn"),
    gotoBtn = document.querySelector(".goto-btn"),
    dateInput = document.querySelector(".date-input"),
    eventDay = document.querySelector(".event-day"),
    eventDate = document.querySelector(".event-date");
    eventsContainer = document.querySelector(".events");
    addEventSubmit = document.querySelector(".add-event-btn");
    
let today = new Date();
let activeDay;
let month = today.getMonth();
let year = today.getFullYear();

const months = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro",
];

// const semana = [
//     "Seg",
//     "Ter",
//     "Qua",
//     "Qui",
//     "Sex",
//     "Sab",
//     "Dom"
// ];
// matriz de eventos padrão
// const eventsArr = [
//     {
//         day:4,
//         month:7,
//         year: 2023,
//         events:[
//             {
//                 title: "Evento 1 lorem ipsun dolar sit genfa tersd dsad",
//                 time:"10:00",
//             },
//             {
//                 title: "Evento 2",
//                 time:"11:00",
//             },
//         ],
//     },
//     {
//         day:12,
//         month:7,
//         year: 2023,
//         events:[
//             {
//                 title: "Evento 1 lorem ipsun dolar sit genfa tersd dsad",
//                 time:"10:00",
//             },
//             {
//                 title: "Evento 2",
//                 time:"11:00",
//             },
//         ],
//     },
// ];

// definir um array vazio
let eventsArr = [];

// chamando o get
getEvents();
// function adicionar os dias

function initCalendar(){
    // para obter os dias do mês anterior e o mês 
    // atual todos os dias e os dias do próximo mês 
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevLastDay = new Date(year, month, 0);
    const prevDays = prevLastDay.getDate();
    const lastDate = lastDay.getDate();
    const day = firstDay.getDay();
    const nextDays = 7 - lastDay.getDay() - 1;
    
    // data de atualização no topo do calendário
    date.innerHTML = months[month] + " " + year;
    
    // adicionando dias no calendario
    
    let days = "";
    
    // dias do mês anterior
    
    for (let x = day; x > 0; x--) {
        days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
    }
    // dias do mês atual
    
    for(let i = 1; i<=lastDate; i++){
        
        //verifique se o evento está presente no dia atual 
        
        let event = false;
        eventsArr.forEach((eventObj) =>{
            if(
                eventObj.day === i &&
                eventObj.month === month + 1 &&
                eventObj.year === year
            )
            {
                // if evento encontrado
                event = true
            }
        });
        
        // se o dia for hoje adiciona class today
        if(
            i === new Date().getDate() && 
            year === new Date().getFullYear() &&
            month === new Date().getMonth()
        ){
            activeDay = i;
            getActiveDay(i);
            updateEvents(i);
            // se o evento for encontrado, 
            // adicione também a classe do evento
            // adicionar ativo hoje na inicialização
            if(event){
                days += `<div class="day today active event" >${i}</div>`;
            }else{
                days += `<div class="day today active" >${i}</div>`;
            }
            
        }
        // adicione o restante como está
        else{
            if(event){
                days += `<div class="day event" >${i}</div>`;
            }else{
                days += `<div class="day" >${i}</div>`;
            }
        }
    }
    
    // dias do próximo mês
    
    for(let j = 1; j <= nextDays; j++){
        days += `<div class="day next-date" >${j}</div>`;
    }
    daysContainer.innerHTML = days;
    // adicionar Listener após a inicialização do calendário
    addListner();
}
window.addEventListener('load',()=>{
    initCalendar();
});


// mês anterior

function prevMonth(){
    month--;
    if(month < 0){
        month = 11;
        year--;
    }
    initCalendar();
}

// proximo mês
function nextMonth(){
    month++;
    if(month > 11){
        month = 0;
        year++;
    }
    initCalendar();
}

// add eventListener em anterior e próximo

prev.addEventListener("click", prevMonth);
next.addEventListener("click", nextMonth);

// nosso calendário está pronto
// vamos adicionar a funcionalidade goto date today

todayBtn.addEventListener("click", ()=>{
    today = new Date();
    month = today.getMonth();
    year = today.getFullYear();
    initCalendar();
});

dateInput.addEventListener("keyup", (e)=>{
    // permitir apenas números, remover qualquer outra coisa
    dateInput.value = dateInput.value.replace(/[^0-9/]/g, "");
    
    if(dateInput.value.length === 2){
        // adicione uma barra se dois números inseridos
        dateInput.value += "/";
    }
    if(dateInput.value.length > 7){
        // não permita mais de 7 caracteres
        dateInput.value = dateInput.value.slice(0, 7);
    }
    
    // se backspace pressionado
    if(e.inputType === "deleteContentBackward"){
        if(dateInput.value.length === 3){
            dateInput.value = dateInput.value.slice(0, 2);
        }
        
    }
});

gotoBtn.addEventListener("click", gotoDate);

// função ir data inserida
function gotoDate(){
    const dateArr = dateInput.value.split("/");
    console.log(dateArr);
    // alguma validação de data
    if(dateArr.length === 2){
        if(dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4){
            month = dateArr[0] - 1;
            year = dateArr[1];
            initCalendar();
            return;
        }
    }
    // se data inválida
    alert("invalid date");
}

const addEventBtn = document.querySelector(".add-event"),
addEventWrapper = document.querySelector(".add-event-wrapper"),
addEventCloseBtn = document.querySelector(".close"),
addEventTitle = document.querySelector(".event-name"),
addEventFrom = document.querySelector(".event-time-from"),
addEventTo = document.querySelector(".event-time-to");
 
$('.event-time-from').mask('99:99');
$('.event-time-to').mask('99:99');
 
addEventBtn.addEventListener("click", () => {
   addEventWrapper.classList.toggle("active");
});

addEventCloseBtn.addEventListener("click", () => {
   addEventWrapper.classList.remove("active");
});

document.addEventListener("click", (e)=>{
    // if click fora
    if(e.target != addEventBtn && !addEventWrapper.contains(e.target)){
        addEventWrapper.classList.remove("active");
    }
});
// permitir apenas 50 caracteres no título

addEventTitle.addEventListener("input",(e) =>{
    addEventTitle.value = addEventTitle.value.slice(0, 50);
});

// formato de hora em de e para hora
addEventFrom.addEventListener("input",(e) =>{
    var inicio = addEventFrom.value.split(':');
    if(parseInt(inicio[0])>23 || parseInt(inicio[0])<-1){addEventFrom.value='';}
    if(parseInt(inicio[1])>59 || parseInt(inicio[1])<-1){addEventFrom.value='';}
    // remover qualquer outra coisa números
    //addEventFrom.value = addEventFrom.value.replace(/[^0-9:]/g, "");
    // se dois números inseridos adicionarem automaticamente
   /* if(addEventFrom.value.length >1){
        addEventFrom.value += ":"
    }
    // não deixe o usuário inserir mais de 5 caracteres
    if(addEventFrom.value.length > 5){
        addEventFrom.value = addEventFrom.value.slice(0, 5);
    }*/
});

// mesmo tempo do addEventFrom
addEventTo.addEventListener("input",() =>{
    var fim = addEventTo.value.split(':');
    if(parseInt(fim[0])>23 || parseInt(fim[0])<-1){addEventTo.value='';}
    if(parseInt(fim[1])>59 || parseInt(fim[1])<-1){addEventTo.value='';}
    // remover qualquer outra coisa números
    /*addEventTo.value = addEventTo.value.replace(/[^0-9:]/g, "");
    // se dois números inseridos adicionarem automaticamente
    if(addEventTo.value.length === 2){
        addEventTo.value += ":"
    }
    // não deixe o usuário inserir mais de 5 caracteres
    if(addEventTo.value.length > 5){
        addEventTo.value = addEventTo.value.slice(0, 5);
    }*/
});

// vamos criar function para adicionar 
// listener nos dias após a renderização

function addListner(){
    const days = document.querySelectorAll(".day");
    days.forEach((day) => {
        day.addEventListener("click",(e) => {
            //definir dia atual como dia ativo
            activeDay = Number(e.target.innerHTML);
            
            // chamada ativa dia após clique
            getActiveDay(e.target.innerHTML);
            updateEvents(Number(e.target.innerHTML));
            
            // remover ativo do dia já ativo
            days.forEach((day) => {
                day.classList.remove("active");  
            });   
            // se o dia do mês anterior for clicado, 
            // vá para o mês anterior e adicione o ativo
            if (e.target.classList.contains("prev-date")) {
                prevMonth();
                //adicionar ativo a clicado dia após mês é alteração
                setTimeout(() => {
                  //adicionar ativo onde não há data anterior ou próxima data
                  const days = document.querySelectorAll(".day");
                  days.forEach((day) => {
                    if (
                      !day.classList.contains("prev-date") &&
                      day.innerHTML === e.target.innerHTML
                    ) {
                      day.classList.add("active");
                    }
                  });
                }, 100);
            }else if (e.target.classList.contains("next-date")) {
                nextMonth();
                //adicionar ativo para clicado dia após mês é alterado
                setTimeout(() => {
                  const days = document.querySelectorAll(".day");
                  days.forEach((day) => {
                    if (
                      !day.classList.contains("next-date") &&
                      day.innerHTML === e.target.innerHTML
                    ) {
                      day.classList.add("active");
                    }
                  });
                }, 100);
            }else {
                e.target.classList.add("active");
            }
        });
    });
}

// permite mostrar os eventos 
// do dia ativo e a data no topo
  
function getActiveDay(date){
    const day = new Date(year, month, date);
    var dayName = day.toString().split(" ")[0];
    
    switch(dayName.toLowerCase()){
        case 'mon':
            dayName='Seg';
        break;
        case 'tue':
            dayName='Ter';
        break;
        case 'wed':
            dayName='Qua';
        break;
        case 'thu':
            dayName='Qui';
        break;
        case 'fri':
            dayName='Sex';
        break;
        case 'sat':
            dayName='Sab';
        break;
        case 'sun':
            dayName='Dom';
        break;
    }
    
    eventDay.innerHTML = dayName;
    eventDate.innerHTML = date + " " + months[month] + " " + year;
}

// function para mostrar eventos daquele

function updateEvents(date){
    var dia = '';
    if(date<=9){dia = '0'+date;}else{dia=date;}
    var formData = new FormData();
    formData.append('dia',dia);
    $.ajax({
        url:getRoot(getURL()+"/getEventosAgenda"),
        type:"POST",
        datatype:"json",
        data: formData,
        timeout:(60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: (data)=>{
            console.log(data);
            if(data.erros.length>0){
                
            }else{
                let events = '';
                if(data.dados.length>0 && data.dados!=false){
                    for(let i=0;i<=data.dados.length-1;i++){
                        events+=` 
                            <div class="event">
                                <div class="title">
                                    <i class="fas fa-circle"></i>
                                    <h3 class="event-title">${data.dados[i].descricao}</h3>
                                </div>
                                <div class="event-time">
                                    <span class="event-time">${data.dados[i].inicio} - ${data.dados[i].fim}</span>
                                </div>
                            </div>
                        `;
                    }
                }else{
                    events = `
                        <div class="no-event">
                            <h3>Não a eventos</h3>
                        </div>
                    `;
                }
                eventsContainer.innerHTML = events;
            }
        },
        error: (jqXhr, textStatus, errorMessage)=>{
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
    
   /* let events = "";
    eventsArr.forEach((event) =>{
        // tem eventos apenas do dia ativo
        if(
          date === event.day &&
          month + 1 === event.month &&
          year === event.year
        ){
            // em seguida, mostre o evento no documento
            event.events.forEach((event) =>{
                events += `
                <div class="event">
                    <div class="title">
                        <i class="fas fa-circle"></i>
                        <h3 class="event-title">${event.title}</h3>
                    </div>
                    <div class="event-time">
                        <span class="event-time">${event.time}</span>
                    </div>
                </div>
                `;
            });
        }
    });
    
    // if nada encontrado
    if(events === ""){
        events = `
        <div class="no-event">
            <h3>Não a eventos</h3>
        </div>
        `;
    }
    
    eventsContainer.innerHTML = events;*/
    // salvar eventos quando o evento de atualização for chamado
    //saveEvents();
}

function insertEventosAgenda(dados){
     
    $.ajax({
        url:getRoot(getURL()+"/insertEventosAgenda"),
        type:"POST",
        datatype:"json",
        data: dados,
        timeout:(60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: (data)=>{
            console.log(data);
            updateEvents(activeDay);
        },
        error: (jqXhr, textStatus, errorMessage)=>{
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
            updateEvents(activeDay);
        }
    });
    
    
    
}
// permite criar função para adicionar eventos
addEventSubmit.addEventListener("click", () => {
    //return "";
    const eventTitle = addEventTitle.value;
    const eventTimeFrom = addEventFrom.value;
    const eventTimeTo = addEventTo.value;
    
    // algumas validações
    
    if(
      eventTitle === "" || 
      eventTimeFrom === "" || 
      eventTimeTo === ""
    ){
        alert("por favor preencha todos os campos");
        return;
    }
    
    const timeFromArr = eventTimeFrom.split(":");
    const timeToArr = eventTimeTo.split(":");
    
    if (
        timeFromArr.length !== 2 ||
        timeToArr.length !== 2 ||
        timeFromArr[0] > 23 ||
        timeFromArr[1] > 59 ||
        timeToArr[0] > 23 ||
        timeToArr[1] > 59
    ) {
        alert("invalido o formato do horario");
        return;
    }
  
    /*const timeFrom = convertTime(eventTimeFrom);
    const timeTo = convertTime(eventTimeTo);*/
    var mes = '';
    if((month+1)<=9){mes='0'+(month+1)}else{mes=(month+1)}
    
    var dia = '';
    if(activeDay<=9){dia='0'+activeDay;}else{dia=activeDay;}
    var formData = new FormData();
    formData.append('titulo',eventTitle);
    formData.append('inicio',eventTimeFrom+":00");
    formData.append('fim',eventTimeTo+":00");
    formData.append('data',year+'-'+mes+'-'+dia);
    
    insertEventosAgenda(formData);
    
    
    const timeFrom = eventTimeFrom;
    const timeTo = eventTimeTo;
    
    const newEvent = {
        title: eventTitle,
        time: timeFrom + " - " + timeTo,
        timeFrom: timeFrom,
        timeTo: timeTo
    };
      
    let eventAdded = false;
      
    //verifique se eventSarr não está vazio
    if(eventsArr.length > 0){
        //verifique se o dia atual já tem um evento e adicione a isso
        eventsArr.forEach((item) => {
            if(
              item.day === activeDay &&
              item.month === month + 1 &&
              item.year === year
            ){
                item.events.push(newEvent);
                eventAdded = true;
            }
        });
    }
    
    // matriz de eventos vazia ou o dia atual 
    // não tem evento criar novo
    
    if(!eventAdded){
        eventsArr.push({
           day:activeDay,
           month:month + 1,
           year: year,
           events: [newEvent],
        });
    }
    
    // remover action de adicionar formulário de evento
    addEventWrapper.classList.remove("active");
    // limpar os campos
    addEventTitle.value = "";
    addEventFrom.value = "";
    addEventTo.value = "";
    
    // mostrar evento adicionado atual
    //updateEvents(activeDay);
    
    // também adicione a classe de evento ao dia 
    // recém-adicionado, se ainda não estiver
    const activeDayEl = document.querySelector(".day.active");
    if (!activeDayEl.classList.contains("event")) {
        activeDayEl.classList.add("event");
    }
    
});


function convertTime(time){
    let timeArr = time.split(":");
    let timeHour = timeArr[0];
    console.log(timeHour);
    let timeMin = timeArr[1];
    let timeFormat = timeHour >= 18 ? " PM" : " AM";
    timeHour = timeHour % 12 || 12;
    time = timeHour + ":" + timeMin + "" + timeFormat;
    return time; 
}

// vamos criar uma função para remover eventos ao clicar

eventsContainer.addEventListener("click", (e) =>{
    /*if(e.target.classList.contains("event")){
        const eventTitle = e.target.children[0].children[1].innerHTML;
        // obtenha o título do evento, 
        // pesquise na matriz por título e exclua
        eventsArr.forEach((event) =>{
            if(
              event.day === activeDay &&
              event.month === month + 1 &&
              event.year === year
            ){
                event.events.forEach((item, index) =>{
                   if(item.title === eventTitle){
                       event.events.splice(index, 1);
                   } 
                });
                
                // nenhum evento restante naquele dia remover dia completo
                if(event.events.length === 0){
                    eventsArr.splice(eventsArr.indexOf(event), 1);
                    // depois de remover o dia completo, 
                    // remova também a class active desse dia
                    
                    const activeDayElem = document.querySelector(".day.active");
                    if(activeDayElem.classList.contains("event")){
                        activeDayElem.classList.remove("event");    
                    }
                }
            }
       });
       // depois de remover o evento de atualização da matriz de formulário
       updateEvents(activeDay);
    } */
});

// permite armazenar eventos no armazenamento local a partir daí

function saveEvents() {
    localStorage.setItem("events", JSON.stringify(eventsArr));
    
}

//função para obter eventos do armazenamento local
function getEvents() {
  //verifique se os eventos já estão salvos
  //no armazenamento local e retorne o evento senão nada
  if (localStorage.getItem("events") === null) {
    return;
  }else{
    return eventsArr.push(...JSON.parse(localStorage.getItem("events")));
  }
  
}