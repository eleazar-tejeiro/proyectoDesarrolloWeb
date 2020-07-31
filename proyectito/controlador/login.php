<?php
session_start();
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>


<!--If usuarioApodo is set then login user, if not show login-->
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
        //shows form for logging in
        echo("<form name='login' method='post' action='login.php' >
            Usuario <input type='text' name='usuarioApodo' /> <br />
            Contraseña <input type='password' name='password' /> <br />
            <input type='submit' onclick='submit' />
            </form>
	");
    }

function doLogin()
{
    //gets the posted variables to login
    $usuarioApodo = $_POST['usuarioApodo'];
    $password = $_POST['password'];

    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT usuarioID, usuarioTipo FROM users
			WHERE usuarioApodo ='$usuarioApodo' AND usuarioContra ='$password' ";
    if ($resource = mysqli_query($conn, $sql)) {
        checkLogin($resource);
    } else {
        echo("<p style='color:red'>FAIL: Incorrect usuarioApodo or Password... please try again />");
        header("Location: login.php");
    }
    mysqli_close($conn);
}

function checkLogin($resource)
{
    //check credentials entered
    if (mysqli_num_rows($resource) == 1) {
        $row = mysqli_fetch_array($resource);
        $_SESSION['usuarioTipo'] = $row['usuarioTipo'];
        $_SESSION['usuarioID'] = $row['usuarioID'];
        echo("<p style='color:green'>LOGIN SUCCESS</p>");
        showLinkToUserPage();
    } else {
        echo("<p style='color:red'>LOGIN FAIL: Incorrect usuarioApodo or Password... please try again />");
    }
}

function showLinkToUserPage()
{
    //depending on user, show different link to their homepage
    if ($_SESSION['usuarioTipo'] == "tutor") {
        echo("<a href='profInicio.php'>Click here for the tutor home page</a>");
    } elseif ($_SESSION['usuarioTipo'] == "student") {
        echo("<a href='estudianteInicio.php'>Click here for student home page</a>");
    } elseif ($_SESSION['usuarioTipo'] == "administrator") {
        echo("<a href='adminInicio.php'>Click here for administrator home page</a>");
    } else {
        echo("<a href='login.php'>Something went wrong... retry login or contact network admin</a>");
    }
}
include("../vista/include/piePagina.php");
?>
