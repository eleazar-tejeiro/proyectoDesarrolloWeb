<?php
if (session_status() === PHP_SESSION_NONE)
{
	session_start();
}
?>
<!--Left Navigation Bar Information -->
<div class="row">
	<div class="column side">
		<ul class="menu">
			<?php logInOut();
			selectMenu();?>
		</ul>
	</div>

<?php

function logInOut() {
//function to show either 'log in' or 'Log out' on side bar
	if (!isset($_SESSION['usuarioTipo']))
	{
		echo "<li><a href='registrarse.php'>Register</a></li>";
		echo "<li><a href='login.php'>Login</a></li>";
	}
	else
	{
		echo "<li><a href='cerrarSesion.php'>cerrarSesion</a></li>";
	}
}

function selectMenu(){
//function to select what menu is displayed
	if (isset($_SESSION['usuarioTipo']))
	{
		if($_SESSION['usuarioTipo'] == "tutor")
		{
			tutorMenu();
		}
		else if ($_SESSION['usuarioTipo'] == "student")
		{
			studentMenu();
		}
		else if ($_SESSION['usuarioTipo'] == "administrator"){
			adminMenu();
		}
	}
}

function tutorMenu() {
//function for the tutor options
	echo "<li><a href='profInicio.php'>Home</a></li>
		<li><a href='profUsuarioCalif.php'>Student's Grades</a></li>
		<li><a href='profNuevoCurso.php'>Add New Course</a></li>
		<li><a href='profCarga.php'>Upload a Resource</a></li>
		<li><a href='profAutorizaEstudiante.php'>Authorize Student</a></li>
		<li><a href='profAdicionaEstudiante.php'>Add Student</a></li>";
}

function studentMenu() {
//function for student options
	echo "<li><a href='estudianteInicio.php'>Home</a></li>
		<li><a href='estudianteInscribirse.php'>Enroll on Course</a></li>
		<li><a href='estudianteCurso.php'>Courses</a></li>
		<li><a href='estudianteCalificaciones.php'>Grades</a></li>";
}

function adminMenu() {
//function for the admin options
	echo "<li style='color:black; font-size:24px; font-weight:bold'>Admin Links</li>
		<li><a href='adminInicio.php'>Home</a></li>
		<li><a href='adminAutoriza.php'>Authorize Users</a></li>
		<li><a href='adminMuestraTablas.php'>Display Database Tables</a></li>
		<li><a href='adminCreaTablas.php'>Create Database Tables</a></li>
		<li style='color:black; font-size:24px; font-weight:bold'>Tutor Links</li>
		<li><a href='tutorShowUsers.php'>Show Users</a></li>
		<li><a href='profAutorizaEstudiante.php'>Authorize Student</a></li>
		<li><a href='profAdicionaEstudiante.php'>Add Student</a></li>";
}
?>
