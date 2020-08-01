<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("../modelo/revisaAdmin.php");
    echo "<p>Esta es la pagina por defecto de administrador. Sus opciones estan al lado izqueirdo.
		<br> Se puede revisar distintos datos de tablas de profesores y estudiantes.</p>"

    ?>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
