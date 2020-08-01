<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
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
//shows the form to register to the user
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
    //adds the information entered by the user to the table
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuarioApodo = $_POST['usuarioApodo'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $tipo = $_POST['tipo'];

    //check if usuarioApodo exists
    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $sql = "SELECT usuarioApodo FROM usuarios WHERE usuarioApodo='$usuarioApodo' ";
    $resource= mysqli_query($conn, $sql);

    if ($password!=$cpassword) {
        echo "<br>Passwords do not match, please enter info again";
        echo "<br>Refreshing in 3 seconds...";
        header("Refresh:3; url=registrarse.php");
    } elseif (mysqli_num_rows($resource)>0) {
        echo "<br>usuarioApodo already has been used, please select another.";
        echo "<br>Refreshing in 3 seconds...";
        header("Refresh:3; url=registrarse.php");
    } else {
        $sql = "INSERT INTO usuarios (nombreUsuario, usuarioApellido, usuarioApodo, usuarioContra, usuarioTipo, usuarioActivo)
				VALUES ('$nombre', '$apellido', '$usuarioApodo', '$password', '$tipo', 0)";

        //check if registered successfully
        if (mysqli_query($conn, $sql)) {
            echo("<p style='color:green'>Successfully Registered</p>");
            echo("<a href='login.php'>Click here to log in now</a>");
        } else {
            echo("<p style='color:red'>Failed to Register: <br/> ");
            echo(mysqli_error($conn));
            echo("<br/>Contact Network Admin</p>");
        }
    }
    mysqli_close($conn);
}

function addAdminToDatabase()
{
    //this is to hardcode administrators into the system; only change first 4 sql values to create a new admin, then call function line 16
    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $sql = "INSERT INTO usuarios (nombreUsuario, usuarioApellido, usuarioApodo, usuarioContra, usuarioTipo, usuarioActivo)
				VALUES ('Admini', 'Admini', 'admin', 'password', 'administrator', 1)";
    if (mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>Successfully Created Adminstrator</p>");
        echo("<a href='login.php'>Click here to log in now</a>");
    } else {
        echo("<p style='color:red'>Failed to Create Admin: <br/> ");
        echo(mysqli_error($conn));
        echo("<br/>Contact Network Admin for assistance</p>");
    }
    mysqli_close($conn);
}

include("../vista/include/piePagina.php");
?>
