<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!--Muestra el formulario de registro o agrega al usuario a la base de datos-->
<div class="row">
	<div class="column middle">
	<?php
    if (isset($_POST['nombre'])) {
        addUserToDatabase();
    } else {
        /* if adding an admin, comment out the showForm() function and remove '//' from addAdminToDatabase()
        To see admin credentials being added, go to function below. Change the 'Values' in SQL statement for a new admin*/
        // addAdminToDatabase();
        showForm();
    }
    ?>
	</div>
</div>

<?php
// muestra el formulario para registrarse al usuario
function showForm()
{
    echo " <form name='register' method='post' action='registrarse.php'>
		Nombre		  <input type='text' name='nombre'/> <br />
		Apellido  		  <input type='text' name='apellido'/> <br />
		Usuario 		  <input type='text' name='usuarioApodo'/> <br />
		Contraseña		  <input type='password' name='password'/> <br />
		Confirmar contraseña  <input type='password' name='cpassword'/> <br />
           <label>Profesor / Estudiante</label>
           <select name='tipo' />
							<option value='' disabled selected>Elige un tipo</option>
							<option value='profesor'>Profesor</option>
							<option value='estudiante'>Estudiante</option>
							</select>
		<input type='submit' onclick='submit' />
		</form>";
}

function addUserToDatabase()
{
    // agrega la información ingresada por el usuario a la tabla
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuarioApodo = $_POST['usuarioApodo'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $tipo = $_POST['tipo'];

    // verifica si usuarioApodo existe
    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $sql = "SELECT usuarioApodo FROM usuarios WHERE usuarioApodo='$usuarioApodo' ";
    $resource= mysqli_query($conn, $sql);

    if ($password!=$cpassword) {
        echo "<br>Las contraseñas no coinciden, ingrese la información nuevamente";
        echo "<br>Refrescante en 3 segundos ...";
        header("Refresh:3; url=registrarse.php");
    } elseif (mysqli_num_rows($resource)>0) {
        echo "<br>usuarioApodo ya se ha utilizado, seleccione otro";
        echo "<br>Refrescante en 3 segundos ...";
        header("Refresh:3; url=registrarse.php");
    } else {
        $sql = "INSERT INTO usuarios (nombreUsuario, usuarioApellido, usuarioApodo, usuarioContra, usuarioTipo, usuarioActivo)
				VALUES ('$nombre', '$apellido', '$usuarioApodo', '$password', '$tipo', 0)";

        // verifica si se ha registrado correctamente
        if (mysqli_query($conn, $sql)) {
            echo("<p style='color:green'>Registrado exitosamente</p>");
            echo("<a href='login.php'>Haga clic aquí para iniciar sesión ahora</a>");
        } else {
            echo("<p style='color:red'>Fallo el registro: <br/> ");
            echo(mysqli_error($conn));
            echo("<br/> Póngase en contacto con el administrador de red </p>");
        }
    }
    mysqli_close($conn);
}

function addAdminToDatabase()
{
// esto es para codificar a los administradores en el sistema; solo cambie los primeros valores de 4 sql para crear un nuevo administrador, luego llame a la línea de función 16    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $sql = "INSERT INTO usuarios (nombreUsuario, usuarioApellido, usuarioApodo, usuarioContra, usuarioTipo, usuarioActivo)
				VALUES ('Admini', 'Admini', 'admin', 'password', 'administrador', 1)";
    if (mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>Adminstrator creado con éxito</p>");
        echo("<a href='login.php'>Haga clic aquí para iniciar sesión ahora</a>");
    } else {
        echo("<p style='color:red'>Error al crear administrador: <br/> ");
        echo(mysqli_error($conn));
        echo("<br/>Póngase en contacto con el administrador de red para obtener ayuda</p>");
    }
    mysqli_close($conn);
}

include("../vista/include/piePagina.php");
?>
