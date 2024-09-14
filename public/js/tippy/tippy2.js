
function executarTippy() {
    let larguraTela = window.innerWidth;
    if (larguraTela >= 700 && larguraTela <= 1200) {
        tippy('#tabelas','#tabelas', '#lancamentos', {
            content: '<a href="#NFSe" style="color: #fff">NFSe</a><br><a href="#Consulta">Consulta</a></br><a href="#Configuracao">Configuração</a>',
            placement: 'right',
            allowHTML: 'true',
            sticky: 'true',
            theme: 'tabelas',
            interactive: 'true'
        });

    }
}

// Executar a função ao carregar a página
window.onload = executarTippy;

// Executar a função ao redimensionar a tela
window.addEventListener("resize", executarTippy);