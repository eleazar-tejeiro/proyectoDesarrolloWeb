<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS users (
			usuarioID INT NOT NULL AUTO_INCREMENT,
			nombreUsuario VARCHAR(30) NOT NULL,
			usuarioApellido  VARCHAR(30) NOT NULL,
			usuarioApodo     VARCHAR(50) NOT NULL,
			usuarioContra VARCHAR(50) NOT NULL,
			usuarioTipo 	 VARCHAR(13) NOT NULL,
			usuarioActivo   BOOLEAN NOT NULL,
			PRIMARY KEY (usuarioID)
			)";

    //check if table was created
    if (mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>SUCCESS</p>");
    } else {
        echo("<p style='color:red'>FAIL: <br/>");
        echo(mysqli_error($conn) . "</p>");
    }
    mysqli_close($conn);
    ?>
	</div>
</div>
<?php
include("vista/include/piePagina.php");
?>
