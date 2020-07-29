<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//gets sql to check if user is active below
$usuarioID = $_SESSION['usuarioID'];
$conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
$sql = "SELECT usuarioActivo FROM users WHERE usuarioID='$usuarioID' ";
$resource = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($resource)) {
    $usuarioActivo = $row['usuarioActivo'];
}

//checks the credentials to make sure only Tutors/Administrators access their pages
if (!isset($_SESSION['usuarioTipo']) or $_SESSION['usuarioTipo'] == "student") {
    echo("<p style='color:red'>You are either not logged in or not authorized to view this page<br>
			If this is a mistake, contact network administrator</p>");
    die();
} elseif ($usuarioActivo == 0) {
    echo "<p style='color:red'> Access denied, confirmed as tutor but you have not been authorized by an administrator yet.</p>";
    die();
} else {
    echo("<p style='color:green'>Access granted, User confirmed as tutor or admin</p>");
}
mysqli_close($conn);
