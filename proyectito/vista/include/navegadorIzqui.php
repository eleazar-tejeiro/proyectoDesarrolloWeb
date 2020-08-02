<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!--Barra de navegacion izquierda-->
<div class="row">
	<div class="column side">
			<?php logInOut();
			selectMenu();?>
    </div>

<?php

function logInOut()
{
    //Funcion para mostrar ya sea el 'inicio de sesion' o el 'cerrar sesion' en la barra de navegacion lateral
    if (!isset($_SESSION['usuarioTipo'])) {
        echo "<a href='/proyectoDesarrolloWeb/proyectito/controlador/registrarse.php'>Registrarse</a>";
        echo "<a href='/proyectoDesarrolloWeb/proyectito/controlador/login.php'>Loguearse</a>";
    } else {
        echo "<a href='/proyectoDesarrolloWeb/proyectito/controlador/cerrarSesion.php'>Cerrar sesion activa</a>";
    }
}

function selectMenu()
{
    //Funcion para selecionar lo que el menu muestra
    if (isset($_SESSION['usuarioTipo'])) {
        if ($_SESSION['usuarioTipo'] == "profesor") {
            profesorMenu();
        } elseif ($_SESSION['usuarioTipo'] == "estudiante") {
            estudianteMenu();
        } elseif ($_SESSION['usuarioTipo'] == "administrador") {
            adminMenu();
        }
    }
}

function profesorMenu()
{
    //Funcion para las opciones de los profesores
    echo "<a href='/proyectoDesarrolloWeb/proyectito/controlador/profInicio.php'>Pagina Principal</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/profNuevoCurso.php'>Añadir un nuevo curso</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/profCarga.php'>Subir un recurso</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/profAutorizaEstudiante.php'>Autorizar un estudiante</a>
        <a href='/proyectoDesarrolloWeb/proyectito/controlador/profAdicionaEstudiante.php'>Añadir estudiante</a>
        <a href='/proyectoDesarrolloWeb/proyectito/controlador/profCurso.php'>Recursos subidos</a>";
}

function estudianteMenu()
{
    //Funcion para las opciones del estudiante
    echo "<a href='/proyectoDesarrolloWeb/proyectito/controlador/estudianteInicio.php'>Pagina Principal</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/estudianteInscribirse.php'>Enlistarze en un curso</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/estudianteCurso.php'>Recursos</a>";
}

function adminMenu()
{
    //Funcion para las opciones del administrador
    echo "
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/adminInicio.php'>Pagina Principal</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/adminAutoriza.php'>Autorizar usuarios</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/adminMuestraTablas.php'>Mostrar tablas de la base de datos</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/adminCreaTablas.php'>Crea tablas de la base de datos</a>
		
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/profAutorizaEstudiante.php'>Autorizar estudiantes</a>
		<a href='/proyectoDesarrolloWeb/proyectito/controlador/profAdicionaEstudiante.php'>Añadir estudiantes</a>";
}
?>
