<?php
session_start();
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<!--Si usuarioApodo está configurado, inicie sesión como usuario, si no muestra login-->
<div class="row">
	<div class="column middle">
	<?php
    if (!isset($_POST['usuarioApodo'])) {
        showLogin();
    } else {
        doLogin();
    }
    ?>
	</div>
</div>

<?php
function showLogin()
    {
        
        //muestra el formulario para iniciar sesión
        echo("<div class='bold-line'></div>
        <div class='container'>
          <div class='window' style='height: 360px'>
            <div class='overlay' style='height: 360px'></div>
            <div class='content'>
              <form name='login' method='post' action='login.php' class='input-fields'>
                <input type='text' name='usuarioApodo' placeholder='Usuario' class='input-line full-width'></input>
                <input type='password' name='password' placeholder='Contraseña' class='input-line full-width'></input>
                <div><input type='submit' onclick='submit' class='ghost-round full-width'/></div>
              </form>      
            </div>
          </div>
        </div>
	");
    }

function doLogin()
{
    // obtiene las variables publicadas para iniciar sesión
    $usuarioApodo = $_POST['usuarioApodo'];
    $password = $_POST['password'];

    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT usuarioID, usuarioTipo, usuarioApodo FROM usuarios
			WHERE usuarioApodo ='$usuarioApodo' AND usuarioContra ='$password' ";
    if ($resource = mysqli_query($conn, $sql)) {
        checkLogin($resource);
    } else {
        echo("<p style='color:red'>ERROR: Usuario o Contraseña incorrectos ... intente nuevamente />");
        header("Location: login.php");
    }
    mysqli_close($conn);
}

function checkLogin($resource)
{
    // verifica las credenciales ingresadas
    if (mysqli_num_rows($resource) == 1) {
        $row = mysqli_fetch_array($resource);
        $_SESSION['usuarioTipo'] = $row['usuarioTipo'];
        $_SESSION['usuarioID'] = $row['usuarioID'];
        $_SESSION['usuarioApodo'] = $row['usuarioApodo'];
        echo("<p style='color:green'>LOGIN CORRECTO</p>");
        showLinkToUserPage();
    } else {
        echo("<p style='color:red'> ERROR DE INICIAR SESIÓN: Usuario o Contraseña incorrectos ... intente nuevamente </p>");
    }
}

function showLinkToUserPage()
{
    // dependiendo del usuario, muestra un enlace diferente a su página de inicio
    if ($_SESSION['usuarioTipo'] == "profesor") {
        echo("<a href='profInicio.php'>Haga clic aquí para acceder a la página de inicio del profesor</a>");
    } elseif ($_SESSION['usuarioTipo'] == "estudiante") {
        echo("<a href='estudianteInicio.php'>Haga clic aquí para la página de inicio de estudiante</a>");
    } elseif ($_SESSION['usuarioTipo'] == "administrador") {
        echo("<a href='adminInicio.php'>Haga clic aquí para la página de inicio de administrador</a>");
    } else {
        echo("<a href='login.php'>Algo salió mal ... vuelva a intentar iniciar sesión o póngase en contacto con el administrador de la red</a>");
    }
}
include("../vista/include/piePagina.php");
?>
