<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//gets sql to check if user is active below
$userID = $_SESSION['userID'];
$conn = mysqli_connect("localhost", "root", "", "classDatabase");
$sql = "SELECT userActive FROM users WHERE userID='$userID' ";
$resource = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($resource)) {
    $userActive = $row['userActive'];
}

//checks the credentials to make sure only Tutors/Administrators access their pages
if (!isset($_SESSION['userType']) or $_SESSION['userType'] == "student") {
    echo("<p style='color:red'>You are either not logged in or not authorized to view this page<br>
			If this is a mistake, contact network administrator</p>");
    die();
} elseif ($userActive == 0) {
    echo "<p style='color:red'> Access denied, confirmed as tutor but you have not been authorized by an administrator yet.</p>";
    die();
} else {
    echo("<p style='color:green'>Access granted, User confirmed as tutor or admin</p>");
}
mysqli_close($conn);
