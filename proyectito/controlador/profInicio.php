<?php
    include("../vista/include/encabezado.php");
    include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("../modelo/revisaProfesor.php"); ?>
	<p> Esta es la página de inicio de Profesor. Consulte la barra lateral para conocer las diferentes acciones disponibles para un profesor.
		Autoriza a los estudiantes, crea cursos, sube recursos a esos cursos, revisa las calificaciones de tus estudiantes </p>
	</div>
</div>
<?php
    include("../vista/include/piePagina.php");
?>
