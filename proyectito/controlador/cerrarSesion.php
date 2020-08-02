<?php
    include("../vista/include/encabezado.php");
    include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    session_destroy();
    echo("Has terminado tu sesion satisfactoriamente. Redirigiéndote a la página de inicio ...");
    header("Refresh: 3; url=../index.php");
     ?>
	</div>
</div>
<?php
    include("../vista/include/piePagina.php");
?>
