<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<!-- Crear la base de datos para las tablas que se almacenarán -->
<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS takenQuizzes (
				name VARCHAR(40) NOT NULL,
				nombreArchivo VARCHAR(40) NOT NULL,
				usuarioID INT NOT NULL,
				score INT NOT NULL,
				questions INT NOT NULL,
				finalScore FLOAT(10) NOT NULL,
				cursoID VARCHAR(255) NOT NULL,
				takenDate DATE)";

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
