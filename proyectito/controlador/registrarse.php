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
        /* descomentar para la primera ejecució y crear así el usuario de administrador*/
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
    echo ("<div class='bold-line'></div>
            <div class='container'>
              <div class='window'>
                <div class='overlay'></div>
                <div class='content'>
                  <form name='register' method='post' action='registrarse.php' class='input-fields'>
                    <input type='text' name='nombre' placeholder='Nombre' class='input-line full-width'></input>
                    <input type='text' name='apellido' placeholder='Apellido' class='input-line full-width'></input>
                    <input type='text' name='usuarioApodo' placeholder='Usuario' class='input-line full-width'></input>
                    <input type='password' name='password' placeholder='Contraseña' class='input-line full-width'></input>
                    <input type='password' name='cpassword' placeholder='Confirmar contraseña' class='input-line full-width'></input>
                    <label class='input-label'>Profesor / Estudiante</label>
                    <select name='tipo' class='input-line full-width' />
                                <option value='' disabled selected>Tipo de usuario</option>
                                <option value='profesor'>Profesor</option>
                                <option value='estudiante'>Estudiante</option>
                    </select>
                    <div><input type='submit' onclick='submit' class='ghost-round full-width'/></div>
                  </form>      
                </div>
              </div>
            </div>");
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
