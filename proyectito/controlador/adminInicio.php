<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("modelo/revisaAdmin.php");
    echo "<p>This is the Administrator Home Page. See the sidebar for different functions.
		<br> You can also access some of the tutor pages on the side to perform adminstrative functions.</p>"

    ?>
	</div>
</div>
<?php
include("vista/include/piePagina.php");
?>
