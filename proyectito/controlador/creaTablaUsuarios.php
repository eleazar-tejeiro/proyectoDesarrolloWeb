<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS users (
			userID INT NOT NULL AUTO_INCREMENT,
			userForename VARCHAR(30) NOT NULL,
			userSurname  VARCHAR(30) NOT NULL,
			username     VARCHAR(50) NOT NULL,
			userPassword VARCHAR(50) NOT NULL,
			userType 	 VARCHAR(13) NOT NULL,
			userActive   BOOLEAN NOT NULL,
			PRIMARY KEY (userID)
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
