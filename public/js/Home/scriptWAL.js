//barra laterial mudança ao clicar
const allSideMenu = document.querySelectorAll('#sidebares .side-menu.top li a');

allSideMenu.forEach(item=> {
    const li = item.parentElement;
    
    item.addEventListener('click', function () {
        allSideMenu.forEach(i=> {
            i.parentElement.classList.remove('active');
            
        });
        li.classList.add('active');
    });
});


// alternar barra lateral
const menuBar = document.querySelector('#sidebares .bx.fa-bars');
const sidebar = document.getElementById('sidebares');
const fechar = document.querySelectorAll(".bi-x-lg");

menuBar.addEventListener('click', function () {
    // alert('ola mundo');
	sidebar.classList.toggle('hide');
});

links.forEach((fechar) => 
fechar.addEventListener("click", () => {
    sidebar.classList.remove("hide");
})
);


const searchButton = document.querySelector('#content nav form .form-input button')
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchform = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if(window.innerWidth < 576) {
        e.preventDefault();
        searchform.classList.toggle('show');
        if(searchform.classList.contains('show')) {
            searchButtonIcon.classList.replace('fa-magnifying-glass', 'fa-x');
        } else {
            searchButtonIcon.classList.replace('fa-x', 'fa-magnifying-glass');
        }
    }
});

if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
    searchButtonIcon.classList.replace('fa-x', 'fa-magnifying-glass');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
        searchButtonIcon.classList.replace('fa-x', 'fa-magnifying-glass');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})
