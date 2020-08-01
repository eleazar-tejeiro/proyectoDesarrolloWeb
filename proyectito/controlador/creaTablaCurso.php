<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS curso (
			cursoID 	 INT NOT NULL AUTO_INCREMENT,
			cursoNombre   VARCHAR(50) NOT NULL,
			cursoPropietario  INT NOT NULL,
			PRIMARY KEY (cursoID),
			FOREIGN KEY (cursoPropietario) REFERENCES users(usuarioID)
			)";

    //check if table was created
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
