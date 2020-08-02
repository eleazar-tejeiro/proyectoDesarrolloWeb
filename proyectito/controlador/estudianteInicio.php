<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("../modelo/revisaEstudiante.php"); ?>
	<p> Esta es la página de inicio de Estudiante. Consulte la barra lateral para ver las diferentes acciones disponibles para usted como Estudiante <br>
		Inscríbase en cursos, complete cuestionarios cargados y verifique sus calificaciones regularmente</p>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
