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



// comprueba las credenciales para asegurarse de que solo los estudiantes accedan a la página
if (!isset($_SESSION['usuarioTipo'])) {
    echo("<p style='color:red'>No estás conectado</p>
           <a href='login.php'>Por favor inicie sesión aquí</a>");
           include("../vista/include/piePagina.php");
    die();
} elseif ($_SESSION['usuarioTipo'] != "estudiante") {
    echo "<p style='color:red'>Acceso denegado, solo los estudiantes pueden ver esta página</p><br>
		  <p>Si esto es un error, contacte a un administrador de red</p>";
    die();
} elseif ($usuarioActivo==0) {
    echo "<p style='color:red'>Acceso denegado, está confirmado como estudiante, pero aún no ha sido autorizado por un administrador</p>";
    die();
} else {
    echo("<p style='color:green'>Acceso otorgado, Usuario confirmado como Estudiante</p>");
}
mysqli_close($conn);
