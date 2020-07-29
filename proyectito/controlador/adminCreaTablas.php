<?php
    include("vista/include/encabezado.php");
    include("vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("modelo/revisaAdmin.php");	?>
	<ul>
		<li><a href='creaTablaCurso.php'>Crear tabla de materias</a></li>
		<li><a href='creaTablaUsuarios.php'>Crear tabla de usuarios</a></li>
		<li><a href='creaTablaRecursos.php'>Crear tabla de recursos</a></li>
		<li><a href='creaMateriaEstudianteTabla.php'>Crear tabla de materias activas por alumnos</a></li>
		<li><a href='creaTablaCuestTomados.php'>Crear tabla de los quizzes tomados</a></li>
	</div>
</div>
<?php
    include("vista/include/piePagina.php");
?>
