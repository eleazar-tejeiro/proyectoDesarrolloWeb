<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS studentTaking (
			cursoID 		INT NOT NULL,
			usuarioID   		INT NOT NULL,
			fechaRegistrado  DATE NOT NULL,
			autorizado 		BOOLEAN,
			FOREIGN KEY (cursoID) REFERENCES course(cursoID)
			ON UPDATE CASCADE ON DELETE RESTRICT,
			FOREIGN KEY (usuarioID) REFERENCES users(usuarioID)
			ON UPDATE CASCADE ON DELETE RESTRICT
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
