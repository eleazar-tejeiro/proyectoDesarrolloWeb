<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
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
        //shows the form to create a estudiante
        echo " <form name='register' method='post' action='profAdicionaEstudiante.php'>
		Nombre		  <input type='text' name='nombre'/> <br />
		Apellido  		  <input type='text' name='apellido'/> <br />
		usuarioApodo 		  <input type='text' name='usuarioApodo'/> <br />
		<input type='submit' onclick='submit' />
		</form>";
    }

function addUserToDatabase()
{
    //adds the information entered by the user to the table
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
    //retrieves estudianteId from database, returns for showCursos function
    $usuarioApodo = $_POST['usuarioApodo'];
    $sql = "SELECT usuarioID FROM usuarios WHERE usuarioApodo='$usuarioApodo' ";
    $record = mysqli_fetch_array(doSQL($sql));
    $estudianteID = $record['usuarioID'];
    return $estudianteID;
}

function getCursos()
{
    //gets all cursos that the current profesor teaches, returns them for showCursos function
    $profesorID = $_SESSION['usuarioID'];
    $sql = "SELECT * FROM curso WHERE cursoPropietario = $profesorID";
    $resource = doSQL($sql);
    return $resource;
}

function showCursos($resource, $estudianteID)
{
    //shows the list of cursos, and profesor can enroll the estudiante onto curso using this form
    echo "Which of your cursos do you want to enroll the estudiante on?<br>";
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
    //writes the enrollment info into the database
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

    //check if SQL was successful
    if ($resource = mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>Correcto</p>");
        return $resource;
    } else {
        echo("<p style='color:red'>ERROR: <br/> ");
        echo(mysqli_error($conn));
        echo("<br/>Contact Network Admin</p>");
        return false;
    }
    mysqli_close($conn);
}

include("../vista/include/piePagina.php");
?>
