<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuarioID']))
{
		header('Location: login.php');
    die();
} else {
    // comprueba las credenciales para asegurarse de que solo los administradores accedan a sus páginas
    if (!isset($_SESSION['usuarioTipo']) or $_SESSION['usuarioTipo'] != "administrador") {
        echo("<p style='color:red'>No has iniciado sesión o no estás autorizado para ver esta página. <br>
                        Si esto es un error, comuníquese con el administrador de la red </p> ");
                include("../vista/include/piePagina.php");
        die();
    } else {
        echo("<p style='color:green'>Verificado como administrador</p>");
        
    }
}

