<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!-- Muestra el formulario de registro o agrega al usuario a la base de datos -->
<div class="row">
	<div class="column middle">
	<?php
    include("../modelo/revisaEstudiante.php");
    if (isset($_POST['curso'])) {
        addEnrollmentToDatabase();
    } else {
        showForm();
    }
    ?>
	</div>
</div>

<?php
function showForm()
    {
        // selecciona cursos donde el usuario no se ha inscrito y los muestra
        $usuarioID = $_SESSION['usuarioID'];
        $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
        $sql = "SELECT cursoID, cursoNombre FROM curso
			WHERE cursoID NOT IN (SELECT cursoID FROM estudianteCurso WHERE usuarioID=$usuarioID)";
        $resource = mysqli_query($conn, $sql);
        if (mysqli_num_rows($resource)<1) {
            echo "No hay cursos para inscribirse";
        } else {
            // muestra todos los cursos potenciales para tomar
            echo "<form name='enroll' method='post' action='estudianteInscribirse.php'>";
            while ($currentCurso = mysqli_fetch_array($resource)) {
                echo "<input type='checkbox' name='curso[]' value='$currentCurso[cursoID]' />
			  $currentCurso[cursoNombre] <br>";
            }
            echo"<input type='submit' onclick='submit' />
			</form>";
        }
        mysqli_close($conn);
    }


function addEnrollmentToDatabase()
{
    // agrega información de inscripción
    $curso = $_POST['curso'];
    $usuarioID = $_SESSION['usuarioID'];
    $today = date("Ymd");

    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    foreach ($curso as $currentCurso) {
        $sql = "INSERT INTO estudianteCurso (cursoID, usuarioID, fechaRegistrado, autorizado)
				VALUES ('$currentCurso', '$usuarioID', '$today', 0)";
        // verifica si se agregó con éxito
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green'>Registrado exitosamente</p>";
        } else {
            echo"<p style='color:red'>Error al registrarse en el curso<br/> ";
            echo(mysqli_error($conn));
            echo "<br/>Póngase en contacto con el administrador de red</p>";
            mysqli_close($conn);
            die();
        }
    }
    echo "<a href='estudianteInscribirse.php'>Haga clic aquí para inscribirse en otro curso</a>
		   <br><a href='estudianteInicio.php'>Haga clic aquí para volver a la página de inicio del estudiante</a>";
    mysqli_close($conn);
}

include("../vista/include/piePagina.php");
?>
