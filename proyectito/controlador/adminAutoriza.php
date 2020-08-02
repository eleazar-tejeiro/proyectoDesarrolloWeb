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
        // obtener usuarios esperando ser autorizados de la base de datos
        $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
        $sql = "SELECT * FROM usuarios WHERE usuarioTipo!='administrador' AND usuarioActivo='0' ";
        $resource = mysqli_query($conn, $sql);
        if (mysqli_num_rows($resource)<1) {  // si no hay ninguno, muestra esto
            echo "No hay usuarios esperando ser autorizados";
        } else {
            echo "<h2>Usuarios esperando ser autorizados<br><table cellpadding='10px' border='2'>";
            echo "<tr><th>ID Usuario</th><th>Nombre</th><th>Apellido</th><th>Tipo de Usuario</th><th>¿Autoriza?</th></tr>";
            while ($row=mysqli_fetch_array($resource)) {
                $usuarioID = $row['usuarioID'];
                $nombreUsuario = $row['nombreUsuario'];
                $usuarioApellido = $row['usuarioApellido'];
                $usuarioTipo = $row['usuarioTipo'];

                echo "<tr><td>$usuarioID</td><td>$nombreUsuario</td><td>$usuarioApellido</td><td>$usuarioTipo</td>";
                echo "<td><form name='authorize' method='post' action='adminAutoriza.php'>";
                echo "<input type='hidden' name='usuarioID' value='$usuarioID'/>";
                echo "<input type='submit' value='AUTORIZAR'/>";
                echo "</form></td></tr>";
            }
            echo "</table>";
        }
        mysqli_close($conn);
    }
function authorizeUser()
{
    // autorizar al usuario
    $usuarioID = $_POST['usuarioID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "UPDATE usuarios SET usuarioActivo = 1 WHERE usuarioID=$usuarioID";
    if ($resource = mysqli_query($conn, $sql)) {
        echo "<p style='color:green'>Usuario autorizado con éxito</p>";
        header("Refresh:2;url='adminAutoriza.php' ");
    } else {
        echo "<p style='color:red'>Error al usuario autorizado. Póngase en contacto con el administrador de red</p>";
    }
    mysqli_close($conn);
}
?>
<?php
include("../vista/include/piePagina.php");
?>
