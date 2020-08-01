<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Academy123" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--Import Google Icon Font-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" href="/proyectoDesarrolloWeb/proyectito/vista/css/estilos.css"/>
	<title>Academy123</title>
</head>
<body>
<div>
	<div id="heading">
		<img src="/proyectoDesarrolloWeb/proyectito/vista/images/logo.png" alt="logo.jpg" align="left" style="width:80px;height:80px;">
		<h1>Academy123</h1>
	</div>
  
	<div class="nav_menu" id="myTopnav">
		<ul>
    <li><a href="/proyectoDesarrolloWeb/proyectito/index.php" class="active">Inicio</a></li>
    <div class="dropdown">
    <button class="dropbtn">Tipo usuario
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="/proyectoDesarrolloWeb/proyectito/controlador/estudianteInicio.php">Estudiante</a>
      <a href="/proyectoDesarrolloWeb/proyectito/controlador/profInicio.php">Profesor</a>
      <a href="/proyectoDesarrolloWeb/proyectito/controlador/adminInicio.php">Administrador</a>
    </div>
    <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
		</ul>
  </div>
  
  <script>
    function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
        x.className += " responsive";
      } else {
        x.className = "topnav";
      }
    }
</script>
