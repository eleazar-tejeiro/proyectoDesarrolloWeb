<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!--Barra de navegacion izquierda-->
<div class="row">
	<div class="column side">
        <ul class="menu">
			<?php logInOut();
			selectMenu();?>
		</ul>
    </div>

<?php

function logInOut()
{
    //Funcion para mostrar ya sea el 'inicio de sesion' o el 'cerrar sesion' en la barra de navegacion lateral
    if (!isset($_SESSION['usuarioTipo'])) {
        echo "<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/registrarse.php'>Registrarse</a></li>";
        echo "<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/login.php'>Loguearse</a></li>";
    } else {
        echo "<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/cerrarSesion.php'>Cerrar sesion activa</a></li>";
    }
}

function selectMenu()
{
    //Funcion para selecionar lo que el menu muestra
    if (isset($_SESSION['usuarioTipo'])) {
        if ($_SESSION['usuarioTipo'] == "tutor") {
            tutorMenu();
        } elseif ($_SESSION['usuarioTipo'] == "student") {
            studentMenu();
        } elseif ($_SESSION['usuarioTipo'] == "administrator") {
            adminMenu();
        }
    }
}

function tutorMenu()
{
    //Funcion para las opciones de los profesores
    echo "<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profInicio.php'>Pagina Principal</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profUsuarioCalif.php'>Notas del estudiante</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profNuevoCurso.php'>Añadir un nuevo curso</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profCarga.php'>Subir un recurso</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profAutorizaEstudiante.php'>Autorizar un estudiante</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profAdicionaEstudiante.php'>Añadir estudiante</a></li>";
}

function studentMenu()
{
    //Funcion para las opciones del estudiante
    echo "<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/estudianteInicio.php'>Pagina Principal</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/estudianteInscribirse.php'>Enlistarze en un curso</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/estudianteCurso.php'>Cursos</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/estudianteCalificaciones.php'>Notas</a></li>";
}

function adminMenu()
{
    //Funcion para las opciones del administrador
    echo "<li style='color:black; font-size:24px; font-weight:bold'>Enlaces de Administrador</li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/adminInicio.php'>Pagina Principal</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/adminAutoriza.php'>Autorizar usuarios</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/adminMuestraTablas.php'>Mostrar tablas de la base de datos</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/adminCreaTablas.php'>Crea tablas de la base de datos</a></li>
		<li style='color:black; font-size:24px; font-weight:bold'>Enlaces del Profesor</li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/tutorShowUsers.php'>Mostrar Usuarios</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profAutorizaEstudiante.php'>Autorizar estudiantes</a></li>
		<li><a href='/proyectoDesarrolloWeb/proyectito/controlador/profAdicionaEstudiante.php'>Añadir estudiantes</a></li>";
}
?>
