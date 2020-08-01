<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("../modelo/revisaAdmin.php");

    if (!isset($_POST['usuarioID'])) {
        showTable();
    } else {
        authorizeUser();
    }
    ?>
	</div>
</div>
<?php
function showTable()
    {
        //get usuarios waiting to be autorizado from database
        $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
        $sql = "SELECT * FROM usuarios WHERE usuarioTipo!='administrador' AND usuarioActivo='0' ";
        $resource = mysqli_query($conn, $sql);
        if (mysqli_num_rows($resource)<1) {  //if none, display this
            echo "There are no usuarios waiting to be autorizado";
        } else {
            echo "<h2>Usuarios Waiting To Be autorizado<br><table cellpadding='10px' border='2'>";
            echo "<tr><th>ID Usuario</th><th>Nombre</th><th>Apellido</th><th>Tipo de Usuario</th><th>Authorize?</th></tr>";
            while ($row=mysqli_fetch_array($resource)) {
                $usuarioID = $row['usuarioID'];
                $nombreUsuario = $row['nombreUsuario'];
                $usuarioApellido = $row['usuarioApellido'];
                $usuarioTipo = $row['usuarioTipo'];

                echo "<tr><td>$usuarioID</td><td>$nombreUsuario</td><td>$usuarioApellido</td><td>$usuarioTipo</td>";
                echo "<td><form name='authorize' method='post' action='adminAutoriza.php'>";
                echo "<input type='hidden' name='usuarioID' value='$usuarioID'/>";
                echo "<input type='submit' value='AUTHORIZE'/>";
                echo "</form></td></tr>";
            }
            echo "</table>";
        }
        mysqli_close($conn);
    }
function authorizeUser()
{
    //authorize the user
    $usuarioID = $_POST['usuarioID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "UPDATE usuarios SET usuarioActivo = 1 WHERE usuarioID=$usuarioID";
    if ($resource = mysqli_query($conn, $sql)) {
        echo "<p style='color:green'>Successfully autorizado user</p>";
        header("Refresh:2;url='adminAutoriza.php' ");
    } else {
        echo "<p style='color:red'>Failed to autorizado user. Contact Network Admin</p>";
    }
    mysqli_close($conn);
}
?>
<?php
include("../vista/include/piePagina.php");
?>
