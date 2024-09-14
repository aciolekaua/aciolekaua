function enviarEmail(){
    var form = $('#formRecuperaSenha1')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/enviarEmail'),
        type:"POST",
        dataType:'json',
        data: formData,
        timeout:12000,
        cache:false,
        processData: false,
        contentType:false,
        success: function(data,status,xhr){
            console.log(data);
            segundaParte(data);
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}

function segundaParte(data){
    if(data.erros.length>0){
        const divMSG = document.querySelector("div#divMSG");
        divMSG.innerHTML='';
        for(let i=0;i<=(data.erros.length-1);i++){
            let div = document.createElement('div');
            div.setAttribute('class','alert alert-danger alert-dismissible fade show');
            div.setAttribute('role','alert');
            div.innerHTML=data.erros[i];
            
            let button = document.createElement('button');
            button.setAttribute('type','button');
            button.setAttribute('class','btn-close');
            button.setAttribute('aria-label','Close');
            button.setAttribute('data-bs-dismiss','alert');
            div.appendChild(button);
            
            divMSG.appendChild(div);
        }
    }else if(data.email && data.token){
        const formPT1 = document.querySelector("form#formRecuperaSenha1");
        const fromPT2 = document.querySelector("form#formRecuperaSenha2");
        formPT1.style.display='none';
        fromPT2.style.display='block';
    }
}

function mudarSenha(){
    var form = $('#formRecuperaSenha2')[0];
    var formData = new FormData(form);
    $.ajax({
        url:getRoot(getURL()+'/mudarSenha'),
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
                const divMSG = document.querySelector('div#divMSG');
                divMSG.innerHTML='';
                for(let i=0;i<=(data.erros.length-1);i++){
                    let div = document.createElement("div");
                    div.setAttribute('class','alert alert-danger alert-dismissible fade show');
                    div.setAttribute('role','alert');
                    div.innerHTML+=data.erros[i];
                    div.innerHTML+='<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    
                    divMSG.appendChild(div);
                }
            }else if(data.sucessos.length>0){
                const divMSG = document.querySelector('div#divMSG');
                divMSG.innerHTML='';
                for(let i=0;i<=(data.sucessos.length-1);i++){
                    let div = document.createElement("div");
                    div.setAttribute('class','alert alert-success alert-dismissible fade show');
                    div.setAttribute('role','alert');
                    div.innerHTML+=data.sucessos[i];
                    div.innerHTML+='<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    
                    divMSG.appendChild(div);
                }
            }
        },
        error: function(jqXhr, textStatus, errorMessage){
            console.log(jqXhr+" "+textStatus+" "+errorMessage);
        }
    });
}

window.addEventListener('load',()=>{
    const btnEnviarEmail = document.querySelector("#btnEnviarEmail");
    btnEnviarEmail.addEventListener('click',()=>{enviarEmail();});
    
    const btnMudarSenha = document.querySelector("#btnMudarSenha");
    btnMudarSenha.addEventListener('click',()=>{mudarSenha();});
    
    const radioPFPJ = document.querySelectorAll("input[name=PFPJ]");
    const PFPJTemp = document.querySelector("input[name=PFPJTemp]");
    
    radioPFPJ[0].addEventListener('click',()=>{
        PFPJTemp.value=radioPFPJ[0].value;
    });
    
    radioPFPJ[1].addEventListener('click',()=>{
        PFPJTemp.value=radioPFPJ[1].value;
    });

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
