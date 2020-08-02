<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuarioID']))
{
		header('Location: login.php');
    die();
} else {
    // obtiene sql para verificar si el usuario está activo a continuación
    $usuarioID = $_SESSION['usuarioID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT usuarioActivo FROM usuarios WHERE usuarioID='$usuarioID' ";
    $resource = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($resource)) {
        $usuarioActivo = $row['usuarioActivo'];
    }
}


// comprueba las credenciales para asegurarse de que solo los profesores / administradores accedan a sus páginas
if (!isset($_SESSION['usuarioTipo']) or $_SESSION['usuarioTipo'] == "estudiante") {
    echo("<p style='color:red'>No has iniciado sesión o no estás autorizado para ver esta página <br>
                Si esto es un error, contacte al administrador de la red</p>");
            include("../vista/include/piePagina.php");
    die();
} elseif ($usuarioActivo == 0) {
    echo "<p style='color:red'> Acceso denegado, confirmado como profesor pero aún no ha sido autorizado por un administrador</p>";
    die();
} else {
    echo("<p style='color:green'>Acceso concedido, Usuario confirmado como profesor o administrador</p>");
}
mysqli_close($conn);
