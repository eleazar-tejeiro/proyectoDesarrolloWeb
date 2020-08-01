<?php
    include("../vista/include/encabezado.php");
    include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("../modelo/revisaProfesor.php"); ?>
	<p> This is the Profesor Home Page. See the sidebar for different actions available to a profesor.
		Authorize estudiantes, create cursos, upload recursos to those curso, check your estudiantes grades</p>
	</div>
</div>
<?php
    include("../vista/include/piePagina.php");
?>
