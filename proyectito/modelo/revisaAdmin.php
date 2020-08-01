<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuarioID']))
{
		header('Location: login.php');
    die();
} else {
    //checks the credentials to make sure only admins access their pages
    if (!isset($_SESSION['usuarioTipo']) or $_SESSION['usuarioTipo'] != "administrator") {
        echo("<p style='color:red'>You are either not logged in or not autorizado to view this page.<br>
                If this is a mistake, contact network administrator</p>");
                include("../vista/include/piePagina.php");
        die();
    } else {
        echo("<p style='color:green'>Verified as Admin</p>");
        
    }
}

