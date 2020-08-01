<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
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
        //selects cursos where user has not enrolled and displays them
        $usuarioID = $_SESSION['usuarioID'];
        $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
        $sql = "SELECT cursoID, cursoNombre FROM curso
			WHERE cursoID NOT IN (SELECT cursoID FROM estudianteCurso WHERE usuarioID=$usuarioID)";
        $resource = mysqli_query($conn, $sql);
        if (mysqli_num_rows($resource)<1) {
            echo "There are no cursos for you to enroll on";
        } else {
            //displays all the potential cursos to take
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
    //adds enrollment information
    $curso = $_POST['curso'];
    $usuarioID = $_SESSION['usuarioID'];
    $today = date("Ymd");

    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    foreach ($curso as $currentCurso) {
        $sql = "INSERT INTO estudianteCurso (cursoID, usuarioID, fechaRegistrado, autorizado)
				VALUES ('$currentCurso', '$usuarioID', '$today', 0)";
        //check if added successfully
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green'>Successfully Registered</p>";
        } else {
            echo"<p style='color:red'>Failed to register for curso<br/> ";
            echo(mysqli_error($conn));
            echo "<br/>Contact Network Admin</p>";
            mysqli_close($conn);
            die();
        }
    }
    echo "<a href='estudianteInscribirse.php'>Click here to enroll on another curso</a>
		   <br><a href='estudianteInicio.php'>Click here to return to the estudiante home page</a>";
    mysqli_close($conn);
}

include("../vista/include/piePagina.php");
?>
