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
<html lang='pt-br'>
    <head>
        <script src="<?php echo(DIRJS."config.js"); ?>"></script>
        
        <meta charset='UTF-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1'/>
        <meta name='author' content='MG'/>
        <meta name='description' content='<?php echo $this->getDescription();?>'/>
        <meta name='keywords' content='<?php echo $this->getKeywords();?>'/>
        <title><?php echo $this->getTitle();?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <link rel='stylesheet' href="<?php echo DIRCSS."styleHome/Style.css";?>" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
        <?php $this->addHead();?>
        
    </head>
    <body>
        <!-- Menssage Error -->
        <div id='divMensage'></div>
        <!-- Menssage Error -->
        
        <!-- top navigation bar -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
          <div class="container-fluid">
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="offcanvas"
              data-bs-target="#sidebar"
              aria-controls="offcanvasExample"
            >
              <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a
              id ="teste" class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
              href="<?php echo(DIRPAGE."home");?>"
              >Cash</a
            >
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#topNavBar"
              aria-controls="topNavBar"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavBar">
              <form class="d-flex ms-auto my-3 my-lg-0">
                <div class="input-group">
                  <!--<input-->
                  <!--  class="form-control"-->
                  <!--  type="search"-->
                  <!--  placeholder="Search"-->
                  <!--  aria-label="Search"-->
                  <!--/>-->
                  <!--<button class="btn btn-primary" type="submit">-->
                  <!--  <i class="bi bi-search"></i>-->
                  <!--</button>-->
                </div>
              </form>
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle ms-2"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <i class="bi bi-person-fill"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?php echo(DIRPAGE."perfil"); ?>"><i class="bi bi-person-circle me-1"></i>Perfil</a></li>
                    <li><a class="dropdown-item" href="<?php echo(DIRPAGE."mudar-senha"); ?>"><i class="bi bi-key-fill me-1"></i>Mudar Senha</a></li>
                    <!--<li><a class="dropdown-item" href="#">Another action</a></li>-->
                    <!--<li>-->
                    <!--  <a class="dropdown-item" href="#">Something else here</a>-->
                    <!--</li>-->
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- top navigation bar -->
        
        <!-- offcanvas -->
        <div
          class="offcanvas offcanvas-start sidebar-nav"
          tabindex="-1"
          id="sidebar"
        >
          <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
              <ul class="navbar-nav">
                <!--<li>-->
                <!--  <div class="text-muted small fw-bold text-uppercase px-3">-->
                <!--    CORE-->
                <!--  </div>-->
                <!--</li>-->
                <!--<li>-->
                <!--  <a href="#" class="nav-link px-3 active">-->
                <!--    <span class="me-2"><i class="bi bi-speedometer2"></i></span>-->
                <!--    <span>Dashboard</span>-->
                <!--  </a>-->
                <!--</li>-->
                <!--<li class="my-4"><hr class="dropdown-divider bg-light" /></li>-->
                
                <li>
                  <div class="text small fw-bold text-uppercase px-3 mb-3">
                    Início
                  </div>
                </li>
                
                <li>
                  <a href="<?php echo(DIRPAGE."home");?>" class="nav-link px-3">
                    <span class="me-2"><i class="bi bi-house"></i></span>
                    <span>Início</span>
                  </a>
                </li>
                
                <!--<li>
                  <a href="<?php //echo(DIRPAGE."home");?>" class="nav-link px-3">
                    <span class="me-2"><i class="bi bi-receipt"></i></span>
                    <span>Emissão de Notas</span>
                  </a>
                </li>-->
                
                <li>
                    <a
                        class="nav-link px-3 sidebar-link"
                        data-bs-toggle="collapse"
                        href="#emissaonotas"
                    >
                        <span class="me-2"><i class="bi bi-receipt"></i></span>
                        <span>Emissão de Notas</span>
                        <span class="ms-auto">
                          <span class="right-icon">
                            <i class="bi bi-chevron-down"></i>
                          </span>
                        </span>
                    </a>
                    <div class="collapse" id="emissaonotas">
                        <ul class="navbar-nav ps-3">
                            <li>
                                <a href="<?php echo(DIRPAGE."emissao-nota-configuracao");?>" class="nav-link px-3">
                                  <span class="me-2"><i class="bi bi-gear-fill"></i></span>
                                  <span>Configurações</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php //echo(DIRPAGE."home");?>" class="nav-link px-3">
                                  <span class="me-2"><i class="bi bi-receipt"></i></span>
                                  <span>NFS-e</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
                <li>
                  <div class="text small fw-bold text-uppercase px-3 mb-3">
                      Gestão Geral
                  </div>
                </li>
                
                <?php if($_SESSION['TipoCliente']=="PJ"){$display="display:none;"; }?>
                <li style="<?php echo"{$display}"; ?>">
                    <a
                        class="nav-link px-3 sidebar-link"
                        data-bs-toggle="collapse"
                        href="#lancamentos"
                    >
                        <span class="me-2"><i class="bi bi-clipboard2-fill"></i></span>
                        <span>Lançamentos</span>
                        <span class="ms-auto">
                          <span class="right-icon">
                            <i class="bi bi-chevron-down"></i>
                          </span>
                        </span>
                    </a>
                    <div class="collapse" id="lancamentos">
                        <ul class="navbar-nav ps-3">
                            <li>
                                <a href="<?php echo(DIRPAGE."lancamentos-pagamento");?>" class="nav-link px-3">
                                  <span class="me-2"
                                    ><i class="bi bi-credit-card"></i
                                  ></span>
                                  <span>Pagamento</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo(DIRPAGE."lancamentos-recebimento");?>" class="nav-link px-3">
                                  <span class="me-2"
                                    ><i class="bi bi-cash-stack"></i
                                  ></span>
                                  <span>Recebimento</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li>
                  <a
                    class="nav-link px-3 sidebar-link"
                    data-bs-toggle="collapse"
                    href="#tabelas"
                  >
                    <span class="me-2"><i class="bi bi-table"></i></span>
                    <span>Tabelas</span>
                    <span class="ms-auto">
                      <span class="right-icon">
                        <i class="bi bi-chevron-down"></i>
                      </span>
                    </span>
                  </a>
                  <div class="collapse" id="tabelas">
                    <ul class="navbar-nav ps-3">
                      <li>
                        <a href="<?php echo(DIRPAGE."tabelas-pagamento");?>" class="nav-link px-3">
                          <span class="me-2"
                            ><i class="bi bi-credit-card"></i
                          ></span>
                          <span>Pagamento</span>
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo(DIRPAGE."tabelas-recebimento");?>" class="nav-link px-3">
                          <span class="me-2"
                            ><i class="bi bi-cash-stack"></i
                          ></span>
                          <span>Recebimento</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <?php
                    if($_SESSION['TipoCliente']=="PJ"){
                        echo"<li>";
                        echo"<a href='".DIRPAGE."gestao-de-usuarios' class='nav-link px-3'>";
                        echo"<span class='me-2'><i class='bi bi-person-lines-fill'></i></span>";
                        echo"<span>Gestão de Usuários</span>";
                        echo"</a>";
                        echo"</li>";
                    }
                ?>
                <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
                <li>
                  <a href="<?php echo(DIRPAGE."logout");?>" class="nav-link px-3">
                    <span class="me-2"><i class="bi bi-box-arrow-left"></i></span>
                    <span>Sair</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- offcanvas -->
            
        <?php $this->addMain();?>
            
        <script src="<?php echo DIRJS.'dselect.js';?>"></script>
        <!-- Footer -->
        <?php $this->addFooter();?>
        <!-- Footer -->
    <!--<script src="<?php //echo(DIRJS."jquery.dataTables.min.js");?>"></script>-->
    <!--<script src="<?php //echo(DIRJS."dataTables.bootstrap5.min.js");?>"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="<?php echo DIRJS.'ajaxMenssage.js'; ?>"></script>
    <!--<script src="<?php //echo(DIRJS."dataTable.js"); ?>"></script>-->
    <script src="<?php echo DIRJS.'Funcoes.js'; ?>"></script>
    <script>
    
        /*const select=document.querySelectorAll(".dselect");
        for(i=0;i<select.length;i++){dselect(select[i],{search:true})}*/
    
    </script>
   
    </body>
</html>