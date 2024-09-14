<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

$session=new Src\Classes\ClassSessions;
$session->verifyInsideSession();

//$this->addSession();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <meta charset="UTF-8">
    <!--<meta name='author' content='MG'/>-->
    <!--<meta name="google-site-verification" content="h1Tts-hH_LVMQa4xCq4fenAfEecuUTTl20qEkyCvjic" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msapplication-TileColor" content="#f6efda">
    <meta name="theme-color" content="#f6efda">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo (DIRIMG.'./logo/apple-touch-icon.png');?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo (DIRIMG.'./logo/favicon-32x32.png');?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo (DIRIMG.'./logo/favicon-16x16.png');?>">
    <link rel="manifest" href="<?php echo (DIRIMG.'./logo/site.webmanifest');?>">
    <link rel="mask-icon" href="<?php echo (DIRIMG.'./logo/safari-pinned-tab.svg');?>" color="#d5695b">
    <!--<link rel="shortcut icon" href="<?php echo (DIRIMG.'./Home/ivici.ico');?>" type="image/x-icon" sizes="76x76">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="<?php echo(DIRJS."config.js"); ?>"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8EW3FB5RNG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        
        gtag('config', 'G-8EW3FB5RNG');
        </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    
    
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <!-- Link to the file hosted on your server, -->
    <link rel="stylesheet" href="path-to-the-file/splide.min.css">
    <!-- or link to the CDN -->
    <link rel="stylesheet" href="url-to-cdn/splide.min.css">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">-->
    <link rel="stylesheet" href="<?php echo (DIRCSS.'./tippy/tippy3.css');?>">
    <link rel='stylesheet' href="<?php echo DIRCSS."styleHome/styleGeral49.css";?>" />
    <link rel='stylesheet' href="<?php echo DIRCSS."styleHome/styleHomolog46.css";?>" />
    <meta name='description' content='<?php echo $this->getDescription();?>'/>
    <meta name='keywords' content='<?php echo $this->getKeywords();?>'/>
    <title><?php echo $this->getTitle();?></title>
    <?php $this->addHead();?>
    
</head>
<body>
    <div class="overlayk-loading">
                <!--<img src="" alt="gif" height="180" width="180">-->
            <div class="loader">Carregando
                <span></span>
            </div>
        </div>
    <div class="containeri">
            <aside id="remove-aside">
                <div class="top-list">
                    <div class="logo-boxi">
                        <img src="https://ivici.com.br/homolog/public/img/Home/logo.png" alt="">
                        <div class="wrapper">
                            <svg>
                                <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                                    P J
                                </text>
                            </svg>
                        </div>
                    </div>
                    <i class="bi bi-x" id="closeBtni"></i>
                </div>
                <ul class="navlist">
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."home");?>">
                            <span class="ml-2 mb-1"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/chart.svg"); ?>"></span>
                            <h3>Dashboard</h3>
                        </a>
                    </li>
                    <li class="list">
                        <div class="dropend">
                          <a type="button" class="dropdown-toggle sidebar-link ativo" data-bs-toggle="dropdown" aria-expanded="false" href="#Emissao">
                            <span class="ml-2 mb-1"><img width="32px" height="32px" src="https://ivici.com.br/homolog/public/img/./svg/file.svg"></span>
                                    <h3>Emissão</h3>
                          </a>
                          <ul class="dropdown-menu">
                            <div id="Emissao">
                                <div class="main-texti">
                                    <h4 class="text-h4">Emissão</h4>
                                    
                                    <hr>
                                </div>
                                <ul class="navbar-nav">
                                    <li>
                                        <a href="<?php echo(DIRPAGE."area-nota-nfse");?>" class=" px-4" style="display:flex">
                                            <span class="ml-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/fileMoney.svg"); ?>"></span>
                                            <h2 class="text-h2">NFS-e</h2>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo(DIRPAGE."area-nota-consulta");?>" class="px-4 ativo" style="display:flex">
                                            <span class="ml-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/eye.svg"); ?>"></span>
                                            <h2 class="text-h2">Consulta</h2>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo(DIRPAGE."area-nota-configuracao");?>" class="px-4 TipoClientePJ ativo" style="display:flex">
                                            <span class="ml-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/settingsNota.svg"); ?>"></span>
                                            <h2 class="text-h2">Configuração</h2>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                          </ul>
                        </div>
                    </li>
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."emdesenvolvimento");?>">
                            <span class="ml-2 mb-1"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/table.svg"); ?>"></span>
                            <h3>Gerenciador</h3>
                        </a>
                    </li>
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."emdesenvolvimento");?>">
                            <span class="ml-2 mb-1"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/buscaArquivo.svg"); ?>"></span>
                            <h3>Conciliador</h3>
                        </a>
                    </li>
                    <li class="list">
                        <div class="dropend">
                                <a type="button" class="dropdown-toggle sidebar-link ativo" data-bs-toggle="dropdown" aria-expanded="false" href="#lancamentos">
                                    <span class="ml-2 mb-1"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/file.svg"); ?>"></span>
                                    <h3>Lançamento</h3>
                                    <!--<span class="ms-auto">-->
                                    <!--        <span class="right-icon">-->
                                    <!--            <i class="bi bi-chevron-down"></i>-->
                                    <!--        </span>-->
                                    <!--    </span>-->
                                </a>
                            <ul class="dropdown-menu">
                                <div id="lancamentos">
                                    <div class="main-texti">
                                        <h4 class="text-h4">Lançamento</h4>
                                        
                                        <hr>
                                    </div>
                                    <ul class="navbar-nav">
                                        <li>
                                            <a href="<?php echo(DIRPAGE."lancamentos-pagamento");?>" class="px-4 ativo" style="display:flex">
                                                <span class="ml-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/pagamento.svg"); ?>"></span>
                                                <h2 class="text-h2">Pagamento</h2>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo(DIRPAGE."lancamentos-recebimento");?>" class="px-4 ativo" style="display:flex">
                                                <span class="ml-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/recebimento.svg"); ?>"></span>
                                                <h2 class="text-h2">Recebimento</h2>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                        </div>
                    </li>
                    <li class="list">
                        <div class="dropend">
                                <a type="button" class="dropdown-toggle sidebar-link ativo" data-bs-toggle="dropdown" aria-expanded="false" href="#lancamentos">
                                    <span class="ml-2 mb-1"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/table.svg"); ?>"></span>
                                    <h3>Tabelas</h3>
                                    <!--<span class="ms-auto">-->
                                    <!--        <span class="right-icon">-->
                                    <!--            <i class="bi bi-chevron-down"></i>-->
                                    <!--        </span>-->
                                    <!--    </span>-->
                                </a>
                            <ul class="dropdown-menu">
                                <div id="lancamentos">
                                    <div class="main-texti">
                                        <h4 class="text-h4">Tabelas</h4>
                                        
                                        <hr>
                                    </div>
                                    <ul class="navbar-nav">
                                        <li>
                                            <a href="<?php echo(DIRPAGE."tabelas-pagamento"); ?>" class="px-4 ativo" style="display:flex">
                                                <span class="ml-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/pagamento.svg"); ?>"></span>
                                                <h2 class="text-h2">Pagamento</h2>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo(DIRPAGE."tabelas-recebimento"); ?>" class="px-4 ativo" style="display:flex">
                                                <span class="ml-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/recebimento.svg"); ?>"></span>
                                                <h2 class="text-h2">Recebimento</h2>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                        </div>
                    </li>
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."emdesenvolvimento");?>">
                            <span class="ml-2 mb-1"><img width="28px" height="28px" src="https://ivici.com.br/homolog/public/img/./ui/icons/chat.png"></span>
                            <h3>Chat</h3>
                        </a>
                    </li>
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."simples-nacional"); ?>">
                            <span class="ml-2 mb-1"><img width="22px" height="22px" src="<?php echo(DIRIMG."./svg/file-box.svg"); ?>"></span>
                            <h3>Simples Nacional</h3>
                        </a>
                    </li>
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."emdesenvolvimento"); ?>">
                            <span class="ml-2 mb-1"><img width="28px" height="28px" src="<?php echo(DIRIMG."./svg/calendar.svg"); ?>"></span>
                            <h3>Agenda</h3>
                        </a>
                    </li>
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."emdesenvolvimento"); ?>">
                            <span class="ml-2 mb-1"><img width="28px" height="28px" src="<?php echo(DIRIMG."./svg/funcionario.svg"); ?>"></span>
                            <h3>Registro Ponto</h3>
                        </a>
                    </li>
                    <li class="list">
                        <a href="<?php echo(DIRPAGE."emdesenvolvimento"); ?>">
                            <span class="ml-2 mb-1"><img width="28px" height="28px" src="<?php echo(DIRIMG."./svg/adicionarfuncionario.svg"); ?>"></span>
                            <h3>Registro Funcionario</h3>
                        </a>
                    </li>
                    <li class="logouti">
                        <a href="<?php echo(DIRPAGE."logout");?>">
                            <span class="ml-2 mb-1"><i class="bi bi-box-arrow-in-left"></i></span>
                            <h3>Log out</h3>
                        </a>
                    </li>
                    
                </ul>
            </aside>
        <!--</div>-->
        <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
            <div class="user-info">
                <img src="https://ivici.com.br/homolog/public/img/Home/mypic.jpg" alt="">
                <!--<div id="dadosSideBar" class="namei"></div>-->
                <div id='dadosPerfil' class="avatar-text"></div>
                <!--<div id="dadosSideBar" class="namei"><p class="text-matrix">EMPRESA TEST</p><span class="text-matrix">83.374.792/0001-91</span></div>-->
            </div>
            
            <hr>
            <a class="sub-menu-link" href="<?php echo(DIRPAGE."perfil"); ?>">
                <img src="<?php echo(DIRIMG."./svg/userAdicionar.svg"); ?>"width="32px" height="32px">
                <p>Perfil</p>
                <i class="bi bi-person-fill-check"></i>
            </a>
        
            <a class="sub-menu-link" href="<?php echo(DIRPAGE."mudar-senha"); ?>">
                <img src="<?php echo(DIRIMG."./svg/userEdit.svg"); ?>"width="32px" height="32px">
                <p>Mudar Senha</p>
                <i class="bi bi-person-fill-lock"></i>
            </a>
        
            <a href="<?php echo(DIRPAGE."gestao-de-usuarios");?>" class='sub-menu-link TipoClientePJ'>
                <img src="<?php echo(DIRIMG."./svg/group.svg"); ?>"width="32px" height="32px">
                <!--<span class='me-3'><i class='bi bi-person-lines-fill'></i></span>-->
                <p>Gestão de Usuários</p>
                <i class="bi bi-person-fill-gear"></i>
            </a>
            <!--<a href="https://ivici.com.br/homolog/perfil" class="sub-menu-link">-->
            <!--    <img src="https://ivici.com.br/homolog/public/img/./svg/userAdicionar.svg" width="32px" height="32px">-->
            <!--    <p>Editar Perfil</p>-->
            <!--    <i class="bi bi-person-fill-check"></i>-->
            <!--</a>-->
            
            <!--<a href="https://ivici.com.br/homolog/mudar-senha" class="sub-menu-link">-->
            <!--    <img src="https://ivici.com.br/homolog/public/img/./svg/userEdit.svg" width="32px" height="32px">-->
            <!--    <p>Mudar Senha</p>-->
            <!--    <i class="bi bi-person-fill-lock"></i>-->
            <!--</a>-->
            
            <!--<a href="https://ivici.com.br/homolog/gestao-de-usuarios" class="sub-menu-link">-->
            <!--    <img src="https://ivici.com.br/homolog/public/img/./svg/group.svg" width="32px" height="32px">-->
            <!--    <p>Gestão de Usuários</p>-->
            <!--    <i class="bi bi-person-fill-gear"></i>-->
            <!--</a>-->
            
            <a href="https://ivici.com.br/logout" class="sub-menu-link">
                <img src="https://ivici.com.br/homolog/public/img/./svg/logout.svg" width="32px" height="32px">
                <p>Sair</p>
                <span>&gt;</span>
            </a>

        </div>
    </div>
        <!-- MAIN -->
        <?php $this->addMain(); ?>
        <div class="righti">
           <div class="header-righti">
               <div class="menuIconi">
                   <i class="bi bi-list"></i>
               </div>
                   <!--<div class="topIconsi">-->
                       <div class="iconi">
                           <i class="bi bi-chat-text-fill"></i>
                           <span>3</span>
                       </div>
                       <div class="iconi">
                           <i class="bi bi-bell-fill"></i>
                           <span>2</span>
                       </div>
                       <div class="iconi">
                           <i class="bi bi-shop-window"></i>
                           <span>+</span>
                       </div>
                       <!-- <div class="iconi">
                           <a href="<?php echo(DIRPAGE."perfil")?>">
                               <i class="bi bi-gear-fill"></i>
                           </a>
                       </div> -->
                   <!--</div>-->
                   <div class="profilei" onclick="abrirMenu()">
                       <!-- <div id="dadosSideBar" class="namei"></div> -->
                       <div class="pici">
                           <img src="https://ivici.com.br/homolog/public/img/Home/mypic.jpg" alt="">
                           <i class="bi bi-chevron-down"></i>
                       </div>
                   </div>
            </div>
           <div class="card-infoi" id="card-info">
               <div class="main-texti">
                   <h2 class="text-matrix">Analize o seu Limite</h2>
                       <div class="icon-boxi">
                            <!-- <div class="iconi">
                               <i class="bi bi-plus"></i>
                           </div> -->
                           <div class="iconi">
                               <i class="bi bi-clipboard2-data-fill"></i>
                           </div>
                       </div>
               </div>
               <div>
                   <!--<iframe width="280" height="280" src="https://lookerstudio.google.com/embed/reporting/3ebab438-d305-4a2b-8ebd-46a494927b7d/page/LTTuD" frameborder="0" style="border:0" allowfullscreen sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>-->
                   <canvas id="myChartLimite" height="100px"></canvas>
               </div>
               <div class="card-detailsi">
                   <h2>Dados Detalhados</h2>

                   <div class="all-info-card">
                       <div class="info-card-item">
                           <p>Lucro</p>
                           <span id="lucro" class="balance">R$ 6000,00</span>
                       </div>
                       <div class="info-card-item">
                           <p>Recebimento</p>
                           <span>R$ 4835,37</span>
                       </div>
                       <div class="info-card-item">
                           <p>Pagamento</p>
                           <span>R$ 3458,96</span>
                       </div>
                       <div class="info-card-item">
                           <p>Nota Fiscal Emitida</p>
                           <span>26</span>
                       </div>
                       <div class="info-card-item">
                           <p>Contratos Feitos</p>
                           <span>8</span>
                       </div>
                   </div>

                   <div class="manageBtni">
                       <a href="#">Emitir Nota</a>
                   </div>
                   <div class="transferBtni">
                       <a href="#">analizar</a>
                   </div>
               </div>
           </div>

           <!--<div class="friendsi">-->
           <!--    <div class="main-texti">-->
           <!--        <h2>Lista de Usuarios</h2>-->
           <!--        <div class="searchBox chat" style="background: #f8f8f8;">-->
           <!--            <i class="bi bi-search"></i>-->
           <!--            <input type="text" class="inputChat" placeholder="Pesquisar..."/>-->
           <!--        </div>-->
           <!--    </div>-->

           <!--    <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/avatar1.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>wallacy A</h4>-->
           <!--                <span>704.263.294-06</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--    </div>-->
           <!--    <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/avatar2.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>Kauã C</h4>-->
           <!--                <span>154.366.114-94</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--    </div>-->
           <!--    <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/avatar3.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>pereira S</h4>-->
           <!--                <span>704.263.294-06</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--    </div>-->
           <!--    <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/avatar3.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>pereira S</h4>-->
           <!--                <span>704.263.294-06</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--    </div>-->
           <!--    <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/avatar3.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>pereira S</h4>-->
           <!--                <span>704.263.294-06</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--    </div>-->
           <!--    <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/avatar4.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>Kauã A</h4>-->
           <!--                <span>154.366.114-94</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--    </div>-->
           <!--    <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/avatar2.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>mateus G</h4>-->
           <!--                <span>482.157.759-54</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--    </div>-->
           <!--     <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--            <img src="<?php echo DIRIMG?>Home/img/avatar1.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>veridiana M</h4>-->
           <!--                <span>949.755.314-53</span>-->
           <!--             </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--     </div>-->
           <!--     <div class="friendBoxi">-->
           <!--         <div class="servicei">-->
           <!--           <img src="<?php echo DIRIMG?>Homeimg/avatar2.jpg" alt="">-->
           <!--           <div class="friendNamei">-->
           <!--                <h4>roberto F</h4>-->
           <!--                <span>619.384.754-53</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--     </div>-->
           <!--     <div class="friendBoxi">-->
           <!--        <div class="servicei">-->
           <!--          <img src="<?php echo DIRIMG?>Homeimg/avatar1.jpg" alt="">-->
           <!--            <div class="friendNamei">-->
           <!--                <h4>wallacy A</h4>-->
           <!--                <span>704.263.294-06</span>-->
           <!--            </div>-->
           <!--        </div>-->
           <!--        <div class="mesaageIconi">-->
           <!--            <i class="bi bi-chat-text-fill"></i>-->
           <!--        </div>-->
           <!--     </div>-->
           <!--</div>-->
        </div>
    </div>
        <!-- MAIN -->

    <!--</div>-->
    </div>
    <!-- CONTENT -->
  <!--<div class="main-content">-->
        <!--<header class='scrolled'>-->
        <!--    <div class="header-title-wrapper">-->
        <!--        <label for="menu-toggle">-->
        <!--            <span class="las la-bars" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"></span>-->
        <!--        </label>-->
        <!--        <div class="header">-->
        <!--            <h1 class="text-matrix">ivici</h1>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <label class="theme-switch" id="theme-switch">-->
        <!--        <input type="checkbox" class="theme-switch__checkbox toggle-btn" id="btn-toggle" onclick="changeTheme()" >-->
        <!--        <div class="theme-switch__container">-->
        <!--        <div class="theme-switch__clouds"></div>-->
        <!--            <div class="theme-switch__stars-container">-->
        <!--              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144 55" fill="none">-->
        <!--                <path fill-rule="evenodd" clip-rule="evenodd" d="M135.831 3.00688C135.055 3.85027 134.111 4.29946 133 4.35447C134.111 4.40947 135.055 4.85867 135.831 5.71123C136.607 6.55462 136.996 7.56303 136.996 8.72727C136.996 7.95722 137.172 7.25134 137.525 6.59129C137.886 5.93124 138.372 5.39954 138.98 5.00535C139.598 4.60199 140.268 4.39114 141 4.35447C139.88 4.2903 138.936 3.85027 138.16 3.00688C137.384 2.16348 136.996 1.16425 136.996 0C136.996 1.16425 136.607 2.16348 135.831 3.00688ZM31 23.3545C32.1114 23.2995 33.0551 22.8503 33.8313 22.0069C34.6075 21.1635 34.9956 20.1642 34.9956 19C34.9956 20.1642 35.3837 21.1635 36.1599 22.0069C36.9361 22.8503 37.8798 23.2903 39 23.3545C38.2679 23.3911 37.5976 23.602 36.9802 24.0053C36.3716 24.3995 35.8864 24.9312 35.5248 25.5913C35.172 26.2513 34.9956 26.9572 34.9956 27.7273C34.9956 26.563 34.6075 25.5546 33.8313 24.7112C33.0551 23.8587 32.1114 23.4095 31 23.3545ZM0 36.3545C1.11136 36.2995 2.05513 35.8503 2.83131 35.0069C3.6075 34.1635 3.99559 33.1642 3.99559 32C3.99559 33.1642 4.38368 34.1635 5.15987 35.0069C5.93605 35.8503 6.87982 36.2903 8 36.3545C7.26792 36.3911 6.59757 36.602 5.98015 37.0053C5.37155 37.3995 4.88644 37.9312 4.52481 38.5913C4.172 39.2513 3.99559 39.9572 3.99559 40.7273C3.99559 39.563 3.6075 38.5546 2.83131 37.7112C2.05513 36.8587 1.11136 36.4095 0 36.3545ZM56.8313 24.0069C56.0551 24.8503 55.1114 25.2995 54 25.3545C55.1114 25.4095 56.0551 25.8587 56.8313 26.7112C57.6075 27.5546 57.9956 28.563 57.9956 29.7273C57.9956 28.9572 58.172 28.2513 58.5248 27.5913C58.8864 26.9312 59.3716 26.3995 59.9802 26.0053C60.5976 25.602 61.2679 25.3911 62 25.3545C60.8798 25.2903 59.9361 24.8503 59.1599 24.0069C58.3837 23.1635 57.9956 22.1642 57.9956 21C57.9956 22.1642 57.6075 23.1635 56.8313 24.0069ZM81 25.3545C82.1114 25.2995 83.0551 24.8503 83.8313 24.0069C84.6075 23.1635 84.9956 22.1642 84.9956 21C84.9956 22.1642 85.3837 23.1635 86.1599 24.0069C86.9361 24.8503 87.8798 25.2903 89 25.3545C88.2679 25.3911 87.5976 25.602 86.9802 26.0053C86.3716 26.3995 85.8864 26.9312 85.5248 27.5913C85.172 28.2513 84.9956 28.9572 84.9956 29.7273C84.9956 28.563 84.6075 27.5546 83.8313 26.7112C83.0551 25.8587 82.1114 25.4095 81 25.3545ZM136 36.3545C137.111 36.2995 138.055 35.8503 138.831 35.0069C139.607 34.1635 139.996 33.1642 139.996 32C139.996 33.1642 140.384 34.1635 141.16 35.0069C141.936 35.8503 142.88 36.2903 144 36.3545C143.268 36.3911 142.598 36.602 141.98 37.0053C141.372 37.3995 140.886 37.9312 140.525 38.5913C140.172 39.2513 139.996 39.9572 139.996 40.7273C139.996 39.563 139.607 38.5546 138.831 37.7112C138.055 36.8587 137.111 36.4095 136 36.3545ZM101.831 49.0069C101.055 49.8503 100.111 50.2995 99 50.3545C100.111 50.4095 101.055 50.8587 101.831 51.7112C102.607 52.5546 102.996 53.563 102.996 54.7273C102.996 53.9572 103.172 53.2513 103.525 52.5913C103.886 51.9312 104.372 51.3995 104.98 51.0053C105.598 50.602 106.268 50.3911 107 50.3545C105.88 50.2903 104.936 49.8503 104.16 49.0069C103.384 48.1635 102.996 47.1642 102.996 46C102.996 47.1642 102.607 48.1635 101.831 49.0069Z" fill="currentColor"></path>-->
        <!--              </svg>-->
        <!--            </div>-->
        <!--            <div class="theme-switch__circle-container">-->
        <!--              <div class="theme-switch__sun-moon-container">-->
        <!--                <div class="theme-switch__moon">-->
        <!--                  <div class="theme-switch__spot"></div>-->
        <!--                  <div class="theme-switch__spot"></div>-->
        <!--                  <div class="theme-switch__spot"></div>-->
        <!--                </div>-->
        <!--              </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </label>-->
        <!--</header>-->
        <!--</div>-->
    <script src="<?php echo DIRJS.'validate.js'; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <?php $this->addFooter(); ?>
        <!-- CONTENT --> 
    <script src="<?php echo DIRJS.'funcoes.js'; ?>"></script>
    <script src="<?php echo DIRJS.'scriptsidebar1.js'; ?>"></script>
    <!--<script src="php echo DIRJS.'./Home/scriptWAL.js';"></script>-->
    <!--<script src="<?php echo DIRJS.'./Home/teste.js'; ?>"></script>-->
    <!--<script src="https://kit.fontawesome.com/abbfc112fb.js" crossorigin="anonymous"></script>-->
    
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <!--<script src="<?php echo DIRJS.'./tippy/tippy10.js'; ?>"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js" integrity="sha256-A+2opyqhvbBV8tbd9mIM8w9zvvMYHOawY03BQRtq7Kw=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function abrirMenu(){
            subMenu.classList.toggle("open-menu");
        }

        const sideMenu = document.querySelector("aside");

        const closeBtn = document.querySelector("#closeBtni");
        const menuBtn = document.querySelector(".menuIconi");

        menuBtn.addEventListener("click", ()=>{
            sideMenu.style.display = "block";
        });

        closeBtn.addEventListener("click", ()=>{
            sideMenu.style.display = "none";
        });

        
        /*const splide = new Splide( '.splide', {
            updateOnMove: true,
            type        : 'loop',
            perPage     : 1,
            perMove     : 1,
            focus       : 'center',
            autoScroll: {
                speed: 1,
            },
        });
        
        splide.mount( window.splide.Extensions );*/
        
        // const toggle_btn = document.querySelector(".toggle-btn");
        // const btn = document.getElementById("btn-toggle");
        // const temaCheck =  document.querySelector(".theme-switch");
        
        var element = document.body;
        let themeSwitcherPage = document.querySelector(".switch-themei");
        themeSwitcherPage.addEventListener('click',()=>{
            var isDarkModeActive = element.classList.contains("darkThemeColors");
            //Salvando o tema escolhido no localStorage
            localStorage.setItem("theme", isDarkModeActive ? ":root" : "darkThemeColors");
            element.classList.toggle("darkThemeColors");
            //Ativando os botões de tema com animação
            themeSwitcherPage.querySelector("span:nth-child(1)").classList.toggle("active");
            themeSwitcherPage.querySelector("span:nth-child(2)").classList.toggle("active");
            //console.log("O tema selecionado foi: "+ themeSwitcher);
        });

        //Carregado no DOM, a lista e o tema
        window.addEventListener('DOMContentLoaded',function(){
        //console.log("Página carregada.");
        var savedTheme = localStorage.getItem("theme");
        //let activeIndex = parseInt(localStorage.getItem("activeItemIndex"));
        var element = document.body;

        //let cardInfo = document.getElementById("card-info");
        //console.log(window.location.href);
        let url = window.location.href;

        //Carregando o Ultimo tema salvo pelo usuario
        if(savedTheme == "darkThemeColors"){
            element.classList.add("darkThemeColors");
            let themeSwitcherDom = document.querySelector(".switch-themei");
            themeSwitcherDom.querySelector("span:nth-child(1)").classList.toggle("active");
            themeSwitcherDom.querySelector("span:nth-child(2)").classList.toggle("active");
            //console.log("O tema salvo é:"+ savedTheme);

        }
        
    });

    </script>
</body>
</html>