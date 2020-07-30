<?php
    include("../vista/include/encabezado.php");
    include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    session_destroy();
    echo("You have successfully logged out. Redirecting you back to the home page...");
    header("Refresh: 3; url=../index.php");
     ?>
	</div>
</div>
<?php
    include("../vista/include/piePagina.php");
?>
