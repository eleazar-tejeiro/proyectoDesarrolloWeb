<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<!--Create the Database for Tables to Be Stored -->
<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "");
    $sql = "CREATE DATABASE IF NOT EXISTS BDClaseVirtual";

    //check if database was created
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
