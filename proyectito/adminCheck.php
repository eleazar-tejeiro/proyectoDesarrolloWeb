<?php
if (session_status() === PHP_SESSION_NONE)
	{
	session_start();
	}

//checks the credentials to make sure only admins access their pages
if (!isset($_SESSION['userType']) or $_SESSION['userType'] != "administrator"){
	echo ("<p style='color:red'>You are either not logged in or not authorized to view this page.<br>
			If this is a mistake, contact network administrator</p>");
	die();
	}
else {
	echo ("<p style='color:green'>Verified as Admin</p>");
}
?>
