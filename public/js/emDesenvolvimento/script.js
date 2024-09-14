let dias = document.getElementById("dias");
let horas = document.getElementById("horas");
let minutos = document.getElementById("minutos");
let segundos = document.getElementById("segundos");

let dd = document.getElementById("dd");
let hh = document.getElementById("hh");
let mm = document.getElementById("mm");
let ss = document.getElementById("ss");

let day_dot = document.querySelector(".dd_dot");
let hr_dot = document.querySelector(".hr_dot");
let min_dot = document.querySelector(".min_dot");
let sec_dot = document.querySelector(".sec_dot");

let endDate = '09/19/2023 00:00:00';
// date format mm/dd/yyyy

let x = setInterval( function(){
    let now = new Date(endDate).getTime();
    let countDown = new Date().getTime();
    let distance = now - countDown;

    // time calculation for days, horas, minutos e segundos
    let d = Math.floor(distance / (1000 * 60 * 60 * 24));
    let h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let m = Math.floor(distance % ((1000 * 60 * 60)) / (1000 * 60 ));
    let s = Math.floor((distance % (1000 * 60)) / 1000);
    
    // dias.classList.add("text-matrix");
    // horas.classList.add("text-matrix");
    // minutos.classList.add("text-matrix");
    // segundos.classList.add("text-matrix");

    // output the result in element with id
    dias.innerHTML = d + "<br><span>Dias<span>";
    horas.innerHTML = h + "<br><span>horas<span>";
    minutos.innerHTML = m + "<br><span>minutos<span>";
    segundos.innerHTML = s + "<br><span>segundos<span>";
    

    // animate stroke
    dd.style.strokeDashoffset = 440 - (440 * d) / 365;
    // 365 dias in an year
    hh.style.strokeDashoffset = 440 - (440 * h) / 24;
    // 24 horas in a day
    mm.style.strokeDashoffset = 440 - (440 * m) / 60;
    // 60 minutos in an horas
    ss.style.strokeDashoffset = 440 - (440 * s) / 60;
    // 60 segundos in an segundos   

    // animate circle dots
    day_dot.style.transform = `rotateZ(${d * 0.986}deg)`;
    // 360deg / 365dias = 0.986
    hr_dot.style.transform = `rotateZ(${h * 15}deg)`;
    // 360deg / 24horas = 15
    min_dot.style.transform = `rotateZ(${m * 6}deg)`;
    // 360deg / 60minutos = 6
    sec_dot.style.transform = `rotateZ(${s * 6}deg)`;
    // 360deg / 60segundos = 6

    // if the countdown is over, write some text
    if(distance < 0){
        clearInterval(x);
        document.getElementById("time").style.display = 'none';
        document.querySelector(".newYear").style.display = 'block';
    }

});