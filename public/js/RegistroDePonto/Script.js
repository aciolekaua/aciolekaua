window.addEventListener('load',()=>{
    document.querySelector("#btnLogin").click();
});

function insertRegistroPonto(){
    const form = $('#formRegistroPonto')[0];
    const formData = new FormData(form);
    $.ajax({
        type:'POST',
        url:getRoot(getURL()+"/insertRegistroPonto"),
        dataType:'json',
        data:formData,
        timeout:(1*60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            console.log(data);
        },
        error: function(texto1, texto2, texto3){
            console.log(texto1+" "+texto2+" "+texto3 );
        }
    });
}
function login(){
    const form = $('#formLogin')[0];
    const formData = new FormData(form);
    //console.log(getRoot(getURL()+"/login"));
    $.ajax({
        type:'POST',
        url:getRoot(getURL()+"/login"),
        dataType:'json',
        data:formData,
        timeout:(1*60*1000),
        cache:false,
        processData:false,
        contentType:false,
        success: function(data){
            console.log(data);
        },
        error: function(texto1, texto2, texto3){
            console.log(texto1+" "+texto2+" "+texto3 );
        }
    });
}