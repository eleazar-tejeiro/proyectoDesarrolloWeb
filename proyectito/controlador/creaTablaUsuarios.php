<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<!-- Crear la base de datos para las tablas que se almacenarán -->
<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS usuarios (
			usuarioID INT NOT NULL AUTO_INCREMENT,
			nombreUsuario VARCHAR(30) NOT NULL,
			usuarioApellido  VARCHAR(30) NOT NULL,
			usuarioApodo     VARCHAR(50) NOT NULL,
			usuarioContra VARCHAR(50) NOT NULL,
			usuarioTipo 	 VARCHAR(13) NOT NULL,
			usuarioActivo   BOOLEAN NOT NULL,
			PRIMARY KEY (usuarioID)
			)";

	// verifica si se creó la tabla
    if (mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>CORRECTO</p>");
    } else {
        echo("<p style='color:red'>ERROR: <br/>");
        echo(mysqli_error($conn) . "</p>");
    }
    mysqli_close($conn);
    ?>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
