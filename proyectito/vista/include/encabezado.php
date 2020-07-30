<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Academy123" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="/proyectoDesarrolloWeb/proyectito/vista/css/materialize.min.css"  media="screen,projection"/>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="/proyectoDesarrolloWeb/proyectito/vista/css/estilos.css"/>
	<title>Academy123</title>
</head>
<body>
<div>
	<div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper deep-purple darken-2">
                <!-- Logo -->
                <img src="/proyectoDesarrolloWeb/proyectito/vista/images/logo.png" alt="logo.jpg" align="left" style="width:65px;height:65px;">
								<a href="/proyectoDesarrolloWeb/proyectito/index.php" class="brand-logo center">Academy123</a>
                <!-- Ícone para abrir no Mobile -->
								<a href="/proyectoDesarrolloWeb/proyectito/index.php" data-target="mobile-navbar" class="sidenav-trigger">
                    <i class="material-icons">view_week</i>
                </a>
                <ul id="navbar-items" class="right hide-on-med-and-down" style="height: 100%">
                    <li style="align-items: center; height: 100%; display: flex; justify-content: center;"><a href="/proyectoDesarrolloWeb/proyectito/index.php">Inicio</a></li>
                    <li>
                        <a class="dropdown-trigger" style="align-items: center; height: 100%; display: flex; justify-content: center;" data-target="dropdown-menu" href="#">
                            Tipo de usuario <i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>
                </ul>
                <!-- Dropdown -->
                <ul id="dropdown-menu" class="dropdown-content">
										<li><a href="/proyectoDesarrolloWeb/proyectito/controlador/estudianteInicio.php">Estudiante</a></li>
										<li><a href="/proyectoDesarrolloWeb/proyectito/controlador/profInicio.php">Profesor</a></li>
										<li><a href="/proyectoDesarrolloWeb/proyectito/controlador/adminInicio.php">Administrador</a></li>
                </ul>
            </div>
						<!-- Menu Mobile -->
				    <ul id="mobile-navbar" class="sidenav">
								<li><a href="/proyectoDesarrolloWeb/proyectito/index.php">Inicio</a></li>
								<li><a href="/proyectoDesarrolloWeb/proyectito/controlador/estudianteInicio.php">Estudiante</a></li>
								<li><a href="/proyectoDesarrolloWeb/proyectito/controlador/profInicio.php">Profesor</a></li>
								<li><a href="/proyectoDesarrolloWeb/proyectito/controlador/adminInicio.php">Administrador</a></li>
				    </ul>
        </nav>
    </div>

	<!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="/proyectoDesarrolloWeb/proyectito/vista/js/materialize.min.js"></script>
	<script type="text/javascript" src="/proyectoDesarrolloWeb/proyectito/vista/js/principal.js"></script>
