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
    <script src="<?php echo(DIRJS."config.js"); ?>"></script>
    <meta charset="UTF-8">
    <meta name='author' content='MG'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel='stylesheet' href="<?php echo DIRCSS."styleHome/StyleWAL.css";?>" />
    <meta name='description' content='<?php echo $this->getDescription();?>'/>
    <meta name='keywords' content='<?php echo $this->getKeywords();?>'/>
        <title><?php echo $this->getTitle();?></title>
</head>
<body>
    
    <!-- SIDE BAR -->
    <section id="sidebares">
        <div class="brand">
            <img src="img/ivici.png"  alt="Image" height="60" width="60">
            <!-- <span class="text">IVICI</span> -->
    </div>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class="bx fa-solid fa-house"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx fa-solid fa-cart-shopping" ></i>
                    <span class="text">Minha vendas</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx fa-solid fa-chart-simple" ></i>
                    <span class="text">Analize</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx fa-solid fa-message" ></i>
                    <span class="text">Messagem</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bx fa-solid fa-user-group"></i>
                    <span class="text">Equipe</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class="bx fa-solid fa-gear"></i>
                    <span class="text">Configuração</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <!-- <i class="bx fa-solid fa-right-from-bracket fa-rotate-180"></i> -->
                    <img src="" alt="">
                    <span class="text">Sair</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDE BAR -->


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class="bx fa-solid fa-bars"></i>
            <a href="" class="nav-link">Categorias</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class="bx fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <a href="#" class="notification">
                <i class="bx fa-solid fa-bell"></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="img/wallacy2.jpeg">
            </a>
        </nav>
        <!-- NAVBAR -->
        
        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrump">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class="fa-solid fa-right-long"></i></li>
                        <li>
                            <a href="#" class="active">Home</a>
                        </li>
                    </ul>
                </div>
                <a href="#" class="btn-download">
                    <i class="bx fa-solid fa-down-long"></i>
                    <span class="text">download PDF </span>
                </a>
            </div>

            <ul class="box-info">
                <li>
                    <i class="bx fa-solid fa-calendar-days"></i>
                    <span class="text">
                        <h3>1020</h3>
                        <p>Notas lançadas</p>
                    </span>
                </li>
                <li>
                    <i class="bx fa-solid fa-wallet"></i>
                    <span class="text">
                        <h3>R$28.234,95</h3>
                        <p>pagemento do mês</p>
                    </span>
                </li>
                <li>
                    <i class="bx fa-solid fa-coins"></i>
                    <span class="text">
                        <h3>2500</h3>
                        <p>Despesas</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
						<i class="bx fa-solid fa-magnifying-glass"></i>
						<i class="bx fa-solid fa-filter"></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>User</th>
								<th>Date Order</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="img/wallacy2.jpeg">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/wallacy2.jpeg">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/wallacy2.jpeg">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/wallacy2.jpeg">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/wallacy2.jpeg">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Todos</h3>
						<i class="bx fa-solid fa-plus"></i>
						<i class="bx fa-solid fa-filter"></i>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Todo List</p>
							<i class="bx fa-solid fa-ellipsis-vertical"></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class="bx fa-solid fa-ellipsis-vertical"></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class="bx fa-solid fa-ellipsis-vertical"></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class="bx fa-solid fa-ellipsis-vertical"></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class="bx fa-solid fa-ellipsis-vertical"></i>
						</li>
					</ul>
				</div>
			</div>
        </main>
        <!-- MAIN -->
    </section>
        <!-- CONTENT -->
        <script src="<?php echo DIRJS.'scriptWAL.js'; ?>"></script>
    <script src="https://kit.fontawesome.com/abbfc112fb.js" crossorigin="anonymous"></script>
</body>
</html>