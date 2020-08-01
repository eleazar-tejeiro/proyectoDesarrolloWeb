<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuarioID']))
{
		header('Location: login.php');
    die();
} else {
    //gets sql to check if user is active below
    $usuarioID = $_SESSION['usuarioID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT usuarioActivo FROM usuarios WHERE usuarioID='$usuarioID' ";
    $resource = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($resource)) {
        $usuarioActivo = $row['usuarioActivo'];
    }
}


//checks the credentials to make sure only Profesors/Administrators access their pages
if (!isset($_SESSION['usuarioTipo']) or $_SESSION['usuarioTipo'] == "estudiante") {
    echo("<p style='color:red'>You are either not logged in or not autorizado to view this page<br>
            If this is a mistake, contact network administrator</p>");
            include("../vista/include/piePagina.php");
    die();
} elseif ($usuarioActivo == 0) {
    echo "<p style='color:red'> Access denied, confirmed as profesor but you have not been autorizado by an administrator yet.</p>";
    die();
} else {
    echo("<p style='color:green'>Access granted, User confirmed as profesor or admin</p>");
}
mysqli_close($conn);
