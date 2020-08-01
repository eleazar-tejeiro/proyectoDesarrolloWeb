<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("../modelo/revisaEstudiante.php"); ?>
	<p> This is the Estudiante Home Page. See the sidebar for different actions available to you as a Estudiante<br>
		Please enroll on cursos, complete uploaded quizzes, and check your grades regularly.</p>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
