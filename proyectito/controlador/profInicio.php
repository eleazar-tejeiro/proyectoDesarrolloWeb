<?php
    include("vista/include/encabezado.php");
    include("vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("modelo/revisaProfesor.php"); ?>
	<p> This is the Tutor Home Page. See the sidebar for different actions available to a tutor.
		Authorize students, create courses, upload resources to those course, check your students grades</p>
	</div>
</div>
<?php
    include("vista/include/piePagina.php");
?>
