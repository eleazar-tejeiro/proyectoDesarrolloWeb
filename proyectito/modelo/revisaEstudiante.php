<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuarioID']))
{
		header('Location: login.php');
    die();
} else {
    //gets sql for checking if user is active below
    $usuarioID = $_SESSION['usuarioID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT usuarioActivo FROM usuarios WHERE usuarioID='$usuarioID' ";
    $resource = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($resource)) {
        $usuarioActivo = $row['usuarioActivo'];
    }
}



//checks the credentials to make sure only estudiantes access the page
if (!isset($_SESSION['usuarioTipo'])) {
    echo("<p style='color:red'>You are either not logged in</p>
           <a href='login.php'>Please login here</a>");
           include("../vista/include/piePagina.php");
    die();
} elseif ($_SESSION['usuarioTipo'] != "estudiante") {
    echo "<p style='color:red'>Access denied, only estudiantes can view this page</p><br>
		  <p>If this is a mistake, contact a network administrador</p>";
    die();
} elseif ($usuarioActivo==0) {
    echo "<p style='color:red'>Access denied, you are confirmed as a estudiante, but you have not been autorizado by an administrador yet.</p>";
    die();
} else {
    echo("<p style='color:green'>Access granted, User Confirmed as Estudiante</p>");
}
mysqli_close($conn);
