const radioPfPj = document.querySelectorAll("input[name=tipoCliente]");
radioPfPj[0].addEventListener('click',()=>{
    sessionStorage.setItem('TipoCliente', radioPfPj[0].value);
});
radioPfPj[1].addEventListener('click',()=>{
    sessionStorage.setItem('TipoCliente', radioPfPj[1].value);
});
window.addEventListener('load',()=>{
    console.log(getRoot());
});
function logar(){
    
    const bntLogin = document.querySelector("button#login");
    bntLogin.innerHTML='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span class="visually-hidden">Loading...</span>';
    var form = $('#formLogin')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot('login/logar'),
        beforeSend:function(){
            $('.overlayk-loading').fadeIn();
        },
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:(2*60*1000),
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            $('.overlayk-loading').fadeOut();
            bntLogin.innerHTML='Entrar';
            if(data.login){
                window.location.href=getRoot('home');
                //window.location.href=getRoot('lancamentos');
            }else{
                if(data.erros.length>0){
                    const divMSG = document.querySelector('div#divMSG');
                    divMSG.innerHTML='';
                    divMSG.style.zIndex = '98';
                    divMSG.style.position = 'absolute';
                    divMSG.style.marginTop='5%';
                    for(let i=0;i<=(data.erros.length-1);i++){
                        let div = document.createElement('div');
                        div.style.zIndex = '99';
                        div.setAttribute('class','alert alert-danger');
                        div.setAttribute('role','alert');
                        div.innerHTML=data.erros[i];
                        
                        /*let button = document.createElement('button');
                        button.setAttribute('type','button');
                        button.setAttribute('class','btn-close');
                        button.setAttribute('aria-label','Close');
                        button.setAttribute('data-bs-dismiss','alert');
                        div.appendChild(button);*/
                        
                        divMSG.appendChild(div);
                    }
                   /* let cont = 1.0;
                    let interval = "";
                    divMSG.style.opacity=1.0;
                    setTimeout(()=>{
                        interval = setInterval(()=>{
                            if(cont<=0.0){clearInterval(interval);divMSG.innerHTML='';}
                            cont=cont-0.01;
                            divMSG.style.opacity=cont;
                        },10);
                        
                        //divMSG.innerHTML='';
                    },5000);*/
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            bntLogin.innerHTML='Entrar';
            $('.overlayk-loading').fadeOut();
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
            const divMSG = document.querySelector('div#divMSG');
            divMSG.innerHTML="";
            //alert(jqXhr);
            div.setAttribute('class','alert alert-danger');
            div.setAttribute('role','alert');
            div.innerHTML="Error na conexão";
            divMSG.appendChild(div);
        }
    });
}
document.addEventListener('keypress',(event)=>{if(event.keyCode===13){logar();}});
const bntLogin = document.querySelector("button#login");
bntLogin.addEventListener('click',()=>{
    logar();
    
});

const toggle_btn = document.querySelector(".toggle-btn");

let firstTheme = localStorage.getItem("dark");

changeTheme(+firstTheme);

function changeTheme(isDark) {
    if (isDark) {
        document.body.classList.add("dark");
        toggle_btn.classList.replace("uil-moon", "uil-sun")
        localStorage.setItem("dark", 1);
    }else{
        document.body.classList.remove("dark");
        toggle_btn.classList.replace("uil-sun", "uil-moon")
        localStorage.setItem("dark", 0);
    }
}

toggle_btn.addEventListener("click", () => {
    changeTheme(!document.body.classList.contains("dark"));
});
