<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
<div class="row">
	<div class="column middle">
	<?php
    include("modelo/revisaEstudiante.php");
    if (isset($_POST['course'])) {
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
        //selects courses where user has not enrolled and displays them
        $usuarioID = $_SESSION['usuarioID'];
        $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
        $sql = "SELECT cursoID, cursoNombre FROM course
			WHERE cursoID NOT IN (SELECT cursoID FROM studentTaking WHERE usuarioID=$usuarioID)";
        $resource = mysqli_query($conn, $sql);
        if (mysqli_num_rows($resource)<1) {
            echo "There are no courses for you to enroll on";
        } else {
            //displays all the potential courses to take
            echo "<form name='enroll' method='post' action='estudianteInscribirse.php'>";
            while ($currentCourse = mysqli_fetch_array($resource)) {
                echo "<input type='checkbox' name='course[]' value='$currentCourse[cursoID]' />
			  $currentCourse[cursoNombre] <br>";
            }
            echo"<input type='submit' onclick='submit' />
			</form>";
        }
        mysqli_close($conn);
    }


function addEnrollmentToDatabase()
{
    //adds enrollment information
    $course = $_POST['course'];
    $usuarioID = $_SESSION['usuarioID'];
    $today = date("Ymd");

    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    foreach ($course as $currentCourse) {
        $sql = "INSERT INTO studentTaking (cursoID, usuarioID, dateRegistered, authorized)
				VALUES ('$currentCourse', '$usuarioID', '$today', 0)";
        //check if added successfully
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green'>Successfully Registered</p>";
        } else {
            echo"<p style='color:red'>Failed to register for course<br/> ";
            echo(mysqli_error($conn));
            echo "<br/>Contact Network Admin</p>";
            mysqli_close($conn);
            die();
        }
    }
    echo "<a href='estudianteInscribirse.php'>Click here to enroll on another course</a>
		   <br><a href='estudianteInicio.php'>Click here to return to the student home page</a>";
    mysqli_close($conn);
}

include("vista/include/piePagina.php");
?>
