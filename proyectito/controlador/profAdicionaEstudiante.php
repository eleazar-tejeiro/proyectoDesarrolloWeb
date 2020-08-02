<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!--Muestra el formulario de registro o agrega al usuario a la base de datos-->
<div class="row">
	<div class="column middle">
	<?php
    include("../modelo/revisaProfesor.php");

    if (!isset($_POST['cursoID']) and !isset($_POST['estudianteID'])) {
        if (!isset($_POST['nombre'])) {
            showForm();
        } else {
            addUserToDatabase();
            $estudianteID = getEstudianteID();
            $resource = getCursos();
            showCursos($resource, $estudianteID);
        }
    } else {
        enrollEstudiante();
    }
    ?>
	</div>
</div>

<?php
function showForm()
    {
        // muestra el formulario para crear un estudiante
        echo " <form name='register' method='post' action='profAdicionaEstudiante.php'>
		Nombre		  <input type='text' name='nombre'/> <br />
		Apellido  		  <input type='text' name='apellido'/> <br />
		usuarioApodo 		  <input type='text' name='usuarioApodo'/> <br />
		<input type='submit' onclick='submit' />
		</form>";
    }

function addUserToDatabase()
{
    // agrega la información ingresada por el usuario a la tabla
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuarioApodo = $_POST['usuarioApodo'];

    $sql = "INSERT INTO usuarios (nombreUsuario, usuarioApellido, usuarioApodo, usuarioContra, usuarioTipo, usuarioActivo)
			VALUES ('$nombre', '$apellido', '$usuarioApodo', '$usuarioApodo', 'estudiante', 1)";
    doSQL($sql);
    $estudianteID = getEstudianteID();
}

function getEstudianteID()
{
    // recupera estudianteId de la base de datos, regresa para la función showCursos
    $usuarioApodo = $_POST['usuarioApodo'];
    $sql = "SELECT usuarioID FROM usuarios WHERE usuarioApodo='$usuarioApodo' ";
    $record = mysqli_fetch_array(doSQL($sql));
    $estudianteID = $record['usuarioID'];
    return $estudianteID;
}

function getCursos()
{
    // obtiene todos los cursos que enseña el profesor actual, los devuelve para la función showCursos
    $profesorID = $_SESSION['usuarioID'];
    $sql = "SELECT * FROM curso WHERE cursoPropietario = $profesorID";
    $resource = doSQL($sql);
    return $resource;
}

function showCursos($resource, $estudianteID)
{
    // muestra la lista de cursos, y el profesor puede inscribir al estudiante en el curso usando este formulario
    echo "¿En cuál de tus cursos quieres inscribir al estudiante?<br>";
    echo "<form name='showCursos' method='post' action='profAdicionaEstudiante.php' >";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<input type='checkbox' name='cursoID[]' value='$currentLine[cursoID]' />";
        echo $currentLine['cursoNombre'] . '<br>';
    }
    echo "<br> <input type='hidden' name='estudianteID' value='$estudianteID' />
		   <input type='submit' onclick='submit' /> </form>";
}

function enrollEstudiante()
{
    // escribe la información de inscripción en la base de datos
    $curso = $_POST['cursoID'];
    $estudianteID = $_POST['estudianteID'];
    $today = date("Ymd");

    foreach ($curso as $currentCurso) {
        $sql = "INSERT INTO estudianteCurso (cursoID, usuarioID, fechaRegistrado, autorizado)
				VALUES ('$currentCurso', '$estudianteID', '$today', 1)";
        doSQL($sql);
    }
}

function doSQL($sql)
{
    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');

    // Comprobar si SQL fue exitoso
    if ($resource = mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>Correcto</p>");
        return $resource;
    } else {
        echo("<p style='color:red'>ERROR: <br/> ");
        echo(mysqli_error($conn));
        echo("<br/>Póngase en contacto con el administrador de red</p>");
        return false;
    }
    mysqli_close($conn);
}

include("../vista/include/piePagina.php");
?>
