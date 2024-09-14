// alternar barra lateral
// const sidebar = document.getElementById('sidebar');
const element = document.getElementById("remove");
const fechar = document.querySelector(".bi-x-lg");
            console.log(element.className);          
fechar.addEventListener("click", () => {
    if (element.className == "sidebar") { 
        
        if(element.className != "sidebar"){
            element.style.left = "0px";
            console.log(element);          
        }else{
            if(element.className == "main-content"){
                
            }else{
            element.style.left = "-345px";
            console.log(element);
            }
        }
    }
});

