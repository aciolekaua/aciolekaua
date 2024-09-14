<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}
$this->addSession(); 
?>
<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <script src="<?php echo(DIRJS."config.js"); ?>"></script>
        <meta charset='UTF-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1'/>
        <meta name='author' content='MG'/>
        <meta name='description' content='<?php echo $this->getDescription();?>'/>
        <meta name='keywords' content='<?php echo $this->getKeywords();?>'/>
        <title><?php echo $this->getTitle();?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <!--<script src="<?php //echo DIRJS.'zepto.min.js';?>"></script>-->
        <?php $this->addHead();?>
    </head>
    <body>
        <!--<span class="las la-cancel"></span>-->
        <!--<div class="sidebar">-->
            <!--<div class="sidebar-container">-->
            <!--    <div class="logo-boxi">-->
            <!--        <img src="<?php echo (DIRIMG.'./Home/ivici.png');?>" alt="">-->
            <!--        <div class="wrapper">-->
            <!--            <svg>-->
            <!--                <text x="50%" y="50%" dy=".35em" text-anchor="middle">-->
            <!--                    P J-->
            <!--                </text>-->
            <!--            </svg>-->
            <!--        </div>-->
            <!--    </div>-->
                <!--<div class="brand"><h3><img src="<?php echo (DIRIMG.'./Home/ivici.png');?>"  alt="Image" height="62" width="62"></h3> -->
                <!--<span class="bi bi-x"></span>-->
                    <!--<div class="fechar-container">-->
                    <!--<input type="checkbox" name="" id="menu-fechar">-->
                    <!--    <label for="menu-fechar">-->
                    <!--        <span class="bi bi-x"></span>-->
                    <!--    </label>-->
                    <!--</div>-->
                <!--</div>-->
        
                <!--<div class="sidebar-avatar">-->
                <!--    <div id='fotoPerfil' class="avatar-perfil">-->
                        <!--<i class="bi bi-person-fill-check"></i>-->
                <!--        <img src="<?php echo(DIRIMG."./svg/userPerfil.svg"); ?>">-->
                        <!--<img src=""  alt="" id="img">-->
                <!--    </div>-->
                <!--    <div class="avatar-info">-->
                        <!--<div id='dadosPerfil' class="avatar-text"></div>-->
                        <!--<span class="las la-angle-double-down"></span>-->
                <!--    </div>-->
                <!--</div>-->
        
            <!--    <div class="sidebar-menu">-->
            <!--        <ul>-->
            <!--            <li id="dashboard">-->
            <!--                <a href="<?php echo(DIRPAGE."home");?>" class="nav-link ativo">-->
            <!--                    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/chart.svg"); ?>"></span>-->
                                <!--<span class="bi bi-house-door"></span>-->
            <!--                    <span>Dashboard</span>-->
            <!--                </a>-->
            <!--            </li>-->
                        
            <!--            <li>-->
            <!--                <a-->
            <!--                    class="nav-link sidebar-link ativo"-->
            <!--                    data-bs-toggle="collapse"-->
            <!--                    href="#emissao"-->
            <!--                >-->
            <!--                    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/search.svg"); ?>"></span>-->
            <!--                    <span>Emissão</span>-->
            <!--                    <span class="ms-auto">-->
            <!--                        <span class="right-icon">-->
            <!--                            <i class="bi bi-chevron-down"></i>-->
            <!--                        </span>-->
            <!--                    </span>-->
            <!--                </a>-->
                            
            <!--                <div class="collapse" id="emissao">-->
            <!--                    <ul  class="navbar-nav">-->
            <!--                        <li>-->
            <!--                            <a href="<?php echo(DIRPAGE."area-nota-nfse");?>" class="nav-link px-3">-->
            <!--                                <span class="me-2"><img src="<?php echo(DIRIMG."./svg/fileMoney.svg"); ?>"></span>-->
            <!--                                <span>NFS-e</span>-->
            <!--                            </a>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <a href="<?php echo(DIRPAGE."area-nota-consulta");?>" class="nav-link px-3 ativo">-->
            <!--                                <span class="me-2"><img src="<?php echo(DIRIMG."./svg/eye.svg"); ?>"></span>-->
            <!--                                <span>Consulta</span>-->
            <!--                            </a>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <a href="<?php echo(DIRPAGE."area-nota-configuracao");?>" class="nav-link px-3 TipoClientePJ ativo">-->
            <!--                                <span class="me-2"><img src="<?php echo(DIRIMG."./svg/settingsNota.svg"); ?>"></span>-->
            <!--                                <span>Configuração</span>-->
            <!--                            </a>-->
            <!--                        </li>-->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--            </li>-->
                        
            <!--            <li class='-TipoClientePF'>-->
            <!--                <a-->
            <!--                    class="nav-link sidebar-link ativo"-->
            <!--                    data-bs-toggle="collapse"-->
            <!--                    href="#lancamentos"-->
            <!--                >-->
            <!--                    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/file.svg"); ?>"></span>-->
            <!--                    <span>Lançamentos</span>-->
            <!--                    <span class="ms-auto">-->
            <!--                        <span class="right-icon">-->
            <!--                            <i class="bi bi-chevron-down"></i>-->
            <!--                        </span>-->
            <!--                    </span>-->
            <!--                </a>-->
                        
            <!--                <div class="collapse" id="lancamentos">-->
                            <!--class="navbar-nav tippy-box"--> 
            <!--                    <ul class="navbar-nav">-->
            <!--                        <li>-->
            <!--                            <a id="lancamentos-pagamento" href="<?php echo(DIRPAGE."lancamentos-pagamento");?>" class="nav-link px-3 ativo">-->
            <!--                                <span class="me-2"><img src="<?php echo(DIRIMG."./svg/pagamento.svg"); ?>"></span>-->
            <!--                                <span>Pagamento</span>-->
            <!--                            </a>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <a id="lancamentos-recebimento" href="<?php echo(DIRPAGE."lancamentos-recebimento");?>" class="nav-link px-3 ativo">-->
            <!--                                <span class="me-2"><img src="<?php echo(DIRIMG."./svg/recebimento.svg"); ?>"></span>-->
            <!--                                <span>Recebimento</span>-->
            <!--                            </a>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            <a href="<?php echo(DIRPAGE."configuracao-lancamento");?>" class="nav-link px-3 ativo">-->
            <!--                                <span class='me-2'><i class="bi bi-gear-fill"></i></span>-->
            <!--                                <span>Configurações</span>-->
            <!--                            </a>-->
            <!--                        </li>-->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--            </li>-->
        
                        <!--<li>-->
                        <!--    <a href="<?php echo(DIRPAGE."gerenciador");?>" class="nav-link  sidebar-link ativo">-->
                        <!--        <span class="me-2"><img src="<?php echo(DIRIMG."./svg/table.svg"); ?>"></span>-->
                        <!--        <span>Gerenciador</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <!-- <li>
                            <a class="nav-link ativo" href="<?php //echo(DIRPAGE."agenda"); ?>">
                                <span class="me-2"><img src="<?php //echo(DIRIMG."./svg/calendar.svg"); ?>"></span>
            <!--                    <span>Extrato</span>-->
            <!--                </a>-->
            <!--            </li> -->
                        
            <!--           <li>-->
            <!--               <a-->
            <!--                   class="nav-link  sidebar-link ativo"-->
            <!--                   data-bs-toggle="collapse"-->
            <!--                   href="#tabelas"-->
            <!--               >-->
            <!--                   <span class="me-2"><img src="<?php echo(DIRIMG."./svg/table.svg"); ?>"></span>-->
            <!--                   <span>Tabelas</span>-->
            <!--                   <span class="ms-auto">-->
            <!--                     <span class="right-icon">-->
            <!--                       <i class="bi bi-chevron-down"></i>-->
            <!--                     </span>-->
            <!--                   </span>-->
            <!--               </a>-->
        
            <!--               <div class="collapse" id="tabelas">-->
            <!--                   <ul class="navbar-nav">-->
            <!--                       <li>-->
            <!--                           <a href="<?php echo(DIRPAGE."tabelas-pagamento"); ?>" class="nav-link px-3 ativo">-->
            <!--                               <span class="me-2"><img src="<?php echo(DIRIMG."./svg/pagamento.svg"); ?>"></span>-->
            <!--                               <span>Pagamento</span>-->
            <!--                           </a>-->
            <!--                       </li>-->
            <!--                       <li>-->
            <!--                           <a href="<?php echo(DIRPAGE."tabelas-recebimento");?>" class="nav-link px-3 ativo">-->
            <!--                               <span class="me-2"><img src="<?php echo(DIRIMG."./svg/recebimento.svg"); ?>"></span>-->
            <!--                               <span>Recebimento</span>-->
            <!--                           </a>-->
            <!--                       </li>-->
            <!--                   </ul>-->
            <!--               </div>-->
                           
            <!--           </li>-->
                       <!--<li>-->
                       <!--    <a-->
                       <!--        class="nav-link  sidebar-link ativo"-->
                       <!--        data-bs-toggle="collapse"-->
                       <!--        href="#registro"-->
                       <!--    >-->
                       <!--        <span class="me-2"><img src="<?php echo(DIRIMG."./svg/table.svg"); ?>"></span>-->
                       <!--        <span>Registro</span>-->
                       <!--        <span class="ms-auto">-->
                       <!--          <span class="right-icon">-->
                       <!--            <i class="bi bi-chevron-down"></i>-->
                       <!--          </span>-->
                       <!--        </span>-->
                       <!--    </a>-->
        
                       <!--    <div class="collapse" id="registro">-->
                       <!--        <ul class="navbar-nav">-->
                       <!--            <li>-->
                       <!--                <a href="<?php echo(DIRPAGE."registro-funcionario"); ?>" class="nav-link px-3 ativo">-->
                       <!--                    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/pagamento.svg"); ?>"></span>-->
                       <!--                    <span>Funcionario</span>-->
                       <!--                </a>-->
                       <!--            </li>-->
                       <!--            <li>-->
                       <!--                <a href="<?php echo(DIRPAGE."registro-empresa");?>" class="nav-link px-3 ativo">-->
                       <!--                    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/recebimento.svg"); ?>"></span>-->
                       <!--                    <span>Empresa</span>-->
                       <!--                </a>-->
                       <!--            </li>-->
                       <!--        </ul>-->
                       <!--    </div>-->
                           
                       <!--</li>-->
                        
                        <!-- <<li>
                            <a class="nav-link ativo" href="<?php //echo(DIRPAGE."conciliador"); ?>">
                                <span class="me-2"><img src="<?php //echo(DIRIMG."./svg/buscaArquivo.svg"); ?>"></span>
            <!--                    <span>Conciliador</span>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
                            <!--<a class="nav-link" href="<?php echo(DIRPAGE."extrato"); ?>">-->
                                <!--<span class="me-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/extrato.svg"); ?>"></span>-->
            <!--                    <span>Extrato</span>-->
            <!--                </a>-->
            <!--            </li> -->
            <!--           <li>-->
            <!--                <a class="nav-link" href="<?php echo(DIRPAGE."simples-nacional"); ?>">-->
            <!--                    <span class="me-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/file-box.svg"); ?>"></span>-->
            <!--                    <span>Simples Nacional</span>-->
            <!--                </a>-->
            <!--            </li>-->
                        <!-- <li>
                            <a class="nav-link ativo" href="<?php //echo(DIRPAGE."emdesenvolvimento"); ?>">
            <!--                    <button class="continue-application">-->
            <!--                        <div>-->
            <!--                            <div class="pencil"></div>-->
            <!--                            <div class="folder">-->
            <!--                                <div class="top">-->
            <!--                                    <svg viewBox="0 0 24 27">-->
            <!--                                    <svg width="32px" height="32px" viewBox="0 0 66 66">-->
                                                    
            <!--                                        <defs id="defs2"/>-->
            <!--                                        color do 2 path :fill:#acbec2;-->-->
                                                    <!-- <g id="layer1" transform="translate(-384)">
            <!--                                        <path d="m 394.01532,9 h 49 v 6 h -49 z" id="path12574" style="fill:#3e4f59;fill-opacity:1;fill-rule:evenodd;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1"/>-->

            <!--                                        <path d="m 394.01532,15 h 49 v 40 h -49 z" id="path12576" style="fill:#e8edee;fill-opacity:1;fill-rule:evenodd;stroke-width:2.00001;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1"/>-->
                                                    
            <!--                                        <path d="m 394.01532,15 v 40 h 29.76953 a 28.484051,41.392605 35.599482 0 0 18.625,-40 z" id="path12578" style="fill:#e8edee;fill-opacity:1;fill-rule:evenodd;stroke:none;stroke-width:2.00002;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1"/>-->
                                                    
            <!--                                        <path d="m 396.01532,8 c -1.64501,0 -3,1.3549933 -3,3 v 40 c 0,0.552285 0.44772,1 1,1 0.55228,0 1,-0.447715 1,-1 V 11 c 0,-0.564128 0.43587,-1 1,-1 h 45 c 0.56413,0 1,0.435872 1,1 v 3 h -42 c -0.55228,0 -1,0.447715 -1,1 0,0.552285 0.44772,1 1,1 h 42 v 37 c 0,0.564127 -0.43587,1 -1,1 h -49 c -0.55228,0 -1,0.447715 -1,1 0,0.552285 0.44772,1 1,1 h 49 c 1.64501,0 3,-1.354994 3,-3 0,-14 0,-28 0,-42 0,-1.6450067 -1.35499,-3 -3,-3 z" id="path12580" style="color:#000000;fill:#000000;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1"/>-->
                                                    
            <!--                                        <path d="m 439.01532,11 c -0.55228,0 -1,0.447715 -1,1 0,0.552285 0.44772,1 1,1 0.55228,0 1,-0.447715 1,-1 0,-0.552285 -0.44772,-1 -1,-1 z" id="path12582" style="color:#000000;fill:#ed7161;fill-opacity:1;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"/>-->
                                                    
            <!--                                        <path d="m 435.01532,11 c -0.55228,0 -1,0.447715 -1,1 0,0.552285 0.44772,1 1,1 0.55228,0 1,-0.447715 1,-1 0,-0.552285 -0.44772,-1 -1,-1 z" id="path12584" style="color:#000000;fill:#ecba16;fill-opacity:1;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"/>-->
                                                    
            <!--                                        <path d="m 431.01532,11 c -0.55228,0 -1,0.447715 -1,1 0,0.552285 0.44772,1 1,1 0.55228,0 1,-0.447715 1,-1 0,-0.552285 -0.44772,-1 -1,-1 z" id="path12586" style="color:#000000;fill:#42b05c;fill-opacity:1;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"/>-->
                                                    
            <!--                                        <path d="m 389.01532,54 a 1,1 0 0 0 -1,1 1,1 0 0 0 1,1 1,1 0 0 0 1,-1 1,1 0 0 0 -1,-1 z" id="path12588" style="color:#000000;fill:#000000;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"/>-->
                                                    
            <!--                                        <path d="m 397.01532,14 c -0.55228,0 -1,0.447715 -1,1 0,0.552285 0.44772,1 1,1 0.55228,0 1,-0.447715 1,-1 0,-0.552285 -0.44772,-1 -1,-1 z" id="path12590" style="color:#000000;fill:#000000;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"/>-->
        
            <!--                                        <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>-->
            <!--                                    </g>-->
            <!--                                    </svg>-->
            <!--                                </div>-->
            <!--                                <div class="paper"></div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <span class="textoGerador">-->
            <!--                            Gerador de contrato-->
            <!--                        </span>-->
            <!--                    </button>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
                            <!--<a class="nav-link ativo" href="<?php echo(DIRPAGE."agenda"); ?>">-->
                            <!--    <span class="me-2"><img src="<?php echo(DIRIMG."./svg/calendar.svg"); ?>"></span>-->
            <!--                    <span>Agenda</span>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
                            <!--<a class="nav-link" href="<?php echo(DIRPAGE."emdesenvolvimento"); ?>">-->
                            <!--    <span class="me-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/funcionario.svg"); ?>"></span>-->
            <!--                    <span>Registro Ponto</span>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
                            <!--<a class="nav-link" href="<?php echo(DIRPAGE."emdesenvolvimento"); ?>">-->
                            <!--    <span class="me-2"><img width="32px" height="32px" src="<?php echo(DIRIMG."./svg/adicionarfuncionario.svg"); ?>"></span>-->
            <!--                    <span>Registro Funcionario</span>-->
            <!--                </a>-->
            <!--            </li> -->
                        
                        <!--<li>-->
                        <!--    <a class="nav-link ativo" href="<?php echo(DIRPAGE."perfil"); ?>">-->
                        <!--        <span class="me-2"><img src="<?php echo(DIRIMG."./svg/userAdicionar.svg"); ?>"width="32px" height="32px"></span>-->
                        <!--        <span>Perfil</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        
                        <!--<li>-->
                        <!--    <a class="nav-link ativo" href="<?php echo(DIRPAGE."mudar-senha"); ?>">-->
                        <!--        <span class="me-2"><img src="<?php echo(DIRIMG."./svg/userEdit.svg"); ?>"width="32px" height="32px"></span>-->
                        <!--        <span>Mudar Senha</span>-->
                        <!--    </a>-->
                        <!--</li>-->
                        
                        <!--<li class='TipoClientePJ'>-->
                        <!--    <a href="<?php echo(DIRPAGE."gestao-de-usuarios");?>" class='nav-link ativo'>-->
                        <!--        <span class="me-2"><img src="<?php echo(DIRIMG."./svg/group.svg"); ?>"width="32px" height="32px"></span>-->
                                <!--<span class='me-3'><i class='bi bi-person-lines-fill'></i></span>-->
                        <!--        <span>Gestão de Usuários</span>-->
                        <!--    </a>-->
                        <!--</li>-->
            <!--            <li>-->
                            <!--<a href="<?php echo(DIRPAGE."logout");?>" class="nav-link logout">-->
                            <!--    <span class="bi bi-box-arrow-left"></span> -->
                            <!--    <span class="text">Sair</span>-->
                            <!--</a>-->
            <!--                <a href="<?php echo(DIRPAGE."logout");?>" class="nav-link logout ativo">-->
            <!--                    <button class="Btn">-->
          
            <!--                        <div class="sign">-->
            <!--                            <svg viewBox="0 0 512 512">-->
            <!--                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>-->
            <!--                            </svg>-->
            <!--                        </div>-->
            <!--                        <div class="text">Logout</div>-->
            <!--                    </button>-->
            <!--                </a>-->
            <!--            </li>-->
                        
                    
            <!--        </ul>-->
            <!--    </div>-->
        
                <!--<div class="sidebar-card">
            <!--        <div class="side-card-icon">-->
                         <!--<span class="las la-bars"></span> 
                        <!--<img src="<?php echo (DIRIMG.'./Home/homem.png');?>" alt="" id="img" width="40px">
            <!--        </div>-->
            <!--            <div class="splide" aria-labelledby="carousel-heading">-->
            <!--                <h2 id="carousel-heading" class="text-matrix">empresas associadas</h2>-->
            <!--                <div class="splide__track">-->
            <!--            		<ul class="splide__list">-->
            <!--            			<li class="splide__slide"><img src="https://picsum.photos/140/100" alt="" id="img"></li>-->
            <!--            			<li class="splide__slide"><img src="https://picsum.photos/140/100" alt="" id="img"></li>-->
            <!--            			<li class="splide__slide"><img src="https://picsum.photos/140/100" alt="" id="img"></li>-->
            <!--            			<li class="splide__slide"><img src="https://picsum.photos/140/100" alt="" id="img"></li>-->
            <!--            			<li class="splide__slide"><img src="https://picsum.photos/140/100" alt="" id="img"></li>-->
            <!--            		</ul>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        <div>-->
            <!--            <br>-->
            <!--            <h4 class="text-matrix">Equipe ivici</h4>-->
            <!--            <p class="text-matrix">Somos uma Empresa inovadora no mercado de sites e produtos para a web, -->
            <!--                prontos para impulsionar sua presença online. Estamos aqui para ajudar -->
            <!--                você a alcançar o sucesso digital e contabil de forma criativa e eficiente. -->
            <!--            </p>-->
            <!--            <br>-->
            <!--            </div>-->
                        <!--<button class="btn btn-main btn-block"> contate-nos</button>
            <!--    </div>-->
                
            <!--</div>-->
            <?php $this->addHeader();?>
            
            <?php $this->addMain();?>
            
            <script src="<?php echo DIRJS.'funcoes1.js'; ?>"></script>
            
            <?php $this->addFooter();?>
        
    </body>
    <script src="<?php echo DIRJS.'dselect.js';?>"></script>
    <script src="<?php echo DIRJS.'ajaxMenssage.js'; ?>"></script>
    <script>
    // const select=document.querySelectorAll(".dselect");
    // for(i=0;i<select.length;i++){dselect(select[i],{search:true})}
        
</script>
</html>