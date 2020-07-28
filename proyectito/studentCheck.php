<?php
if (session_status() === PHP_SESSION_NONE)
	{
	session_start();
	}

//gets sql for checking if user is active below
$userID = $_SESSION['userID'];
$conn = mysqli_connect("localhost","root","root","classDatabase");
$sql = "SELECT userActive FROM users WHERE userID='$userID' ";
$resource = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($resource)){
	$userActive = $row['userActive'];
}

//checks the credentials to make sure only students access the page
if (!isset($_SESSION['userType'])){
	echo ("<p style='color:red'>You are either not logged in</p>
		   <a href='login.php'>Please login here</a>");
	die();
	}
else if($_SESSION['userType'] != "student"){
	echo "<p style='color:red'>Access denied, only students can view this page</p><br>
		  <p>If this is a mistake, contact a network administrator</p>";
	die();
}
else if($userActive==0){
	echo "<p style='color:red'>Access denied, you are confirmed as a student, but you have not been authorized by an administrator yet.</p>";
	die();
}
else {
	echo ("<p style='color:green'>Access granted, User Confirmed as Student</p>");
}
mysqli_close($conn);
?>
