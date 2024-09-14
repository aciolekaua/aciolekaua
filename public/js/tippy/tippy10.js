function executarTippy() {
    let larguraTela = window.innerWidth;
    const emissao = document.getElementById('emissao');
    const dashboard = document.getElementById('dashboard');
    
    if (larguraTela >= 700 && larguraTela <= 1200) {
        tippy(dashboard, {
            content: '<a href="#NFSe" style="color: #fff">NFSe</a><br><a href="#Consulta" style="color: #fff">Consulta</a></br><a href="#Configuracao" style="color: #fff">Configuração</a>',
            placement: 'right',
            allowHTML: true,
            sticky: true,
            theme: 'dashboard',
            interactive: true
        });

        if (emissao) {
            tippy(emissao, {
                content: '<a href="#NFSe" style="color: #fff">NFSe</a><br><a href="#Consulta" style="color: #fff">Consulta</a></br><a href="#Configuracao" style="color: #fff">Configuração</a>',
                placement: 'right',
                allowHTML: true,
                sticky: true,
                theme: 'emissao',
                interactive: true
            });
        }

        tippy('#lancamentos', {
            content: '<a href="#NFSe" style="color: #fff">Pagamento</a><br><a href="#lancamentos-pagamento" style="color: #fff">Recebimento</a></br><a href="#Configuracao" style="color: #fff">Configurações</a>',
            placement: 'right',
            allowHTML: true,
            sticky: true,
            theme: 'lancamentos',
            interactive: true
        });

        tippy('#tabelas', {
            content: '<a href="#NFSe" style="color: #fff">Pagamento</a><br><a href="#lancamentos-recebimento" style="color: #fff">Recebimento</a>',
            placement: 'right',
            allowHTML: true,
            sticky: true,
            theme: 'tabelas',
            interactive: true,
        });
    }
}

// Executar a função ao carregar a página
window.onload = executarTippy;

// Executar a função ao redimensionar a tela
window.addEventListener("resize", executarTippy);