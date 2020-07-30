<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Website for Website Development Class-2019" />
	<meta name="author" content="Hawkin Saeger" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="vista/css/materialize.min.css"  media="screen,projection"/>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="vista/css/estilos.css"/>
	<title>NUESTRO CLASSROOM</title>
</head>
<body>
<div>
	<div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper deep-purple darken-2">
                <!-- Logo -->
                <img src="vista/images/logo.png" alt="logo.jpg" align="left" style="width:65px;height:65px;">
								<a href="#" class="brand-logo center">NUESTRO PROPIO CLASSROOM</a>
                <!-- Ícone para abrir no Mobile -->
                <a href="index.php" data-target="mobile-navbar" class="sidenav-trigger">
                    <i class="material-icons">menu</i>
                </a>
                <ul id="navbar-items" class="right hide-on-med-and-down">
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <a class="dropdown-trigger" data-target="dropdown-menu" href="#">
                            Tipo de usuario <i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>
                </ul>
                <!-- Dropdown -->
                <ul id="dropdown-menu" class="dropdown-content">
										<li><a href="controlador/estudianteInicio.php">Estudiante</a></li>
										<li><a href="controlador/profInicio.php">Profesor</a></li>
										<li><a href="controlador/adminInicio.php">Administrador</a></li>
                </ul>
            </div>
						<!-- Menu Mobile -->
				    <ul id="mobile-navbar" class="sidenav">
								<li><a href="index.php">Inicio</a></li>
								<li><a href="controlador/estudianteInicio.php">Estudiante</a></li>
								<li><a href="controlador/profInicio.php">Profesor</a></li>
								<li><a href="controlador/adminInicio.php">Administrador</a></li>
				    </ul>
        </nav>
    </div>
	<!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="vista/js/materialize.min.js"></script>
	<script type="text/javascript" src="vista/js/principal.js"></script>
</body>
