<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
<div class="row">
	<div class="column middle">
	<?php
    include("modelo/revisaProfesor.php");

    if (!isset($_POST['cursoID']) and !isset($_POST['studentID'])) {
        if (!isset($_POST['forename'])) {
            showForm();
        } else {
            addUserToDatabase();
            $studentID = getStudentID();
            $resource = getCourses();
            showCourses($resource, $studentID);
        }
    } else {
        enrollStudent();
    }
    ?>
	</div>
</div>

<?php
function showForm()
    {
        //shows the form to create a student
        echo " <form name='register' method='post' action='profAdicionaEstudiante.php'>
		Forename		  <input type='text' name='forename'/> <br />
		Surname  		  <input type='text' name='surname'/> <br />
		usuarioApodo 		  <input type='text' name='usuarioApodo'/> <br />
		<input type='submit' onclick='submit' />
		</form>";
    }

function addUserToDatabase()
{
    //adds the information entered by the user to the table
    $forename = $_POST['forename'];
    $surname = $_POST['surname'];
    $usuarioApodo = $_POST['usuarioApodo'];

    $sql = "INSERT INTO users (nombreUsuario, usuarioApellido, usuarioApodo, usuarioContra, usuarioTipo, usuarioActivo)
			VALUES ('$forename', '$surname', '$usuarioApodo', '$usuarioApodo', 'student', 1)";
    doSQL($sql);
    $studentID = getStudentID();
}

function getStudentID()
{
    //retrieves studentId from database, returns for showCourses function
    $usuarioApodo = $_POST['usuarioApodo'];
    $sql = "SELECT usuarioID FROM users WHERE usuarioApodo='$usuarioApodo' ";
    $record = mysqli_fetch_array(doSQL($sql));
    $studentID = $record['usuarioID'];
    return $studentID;
}

function getCourses()
{
    //gets all courses that the current tutor teaches, returns them for showCourses function
    $tutorID = $_SESSION['usuarioID'];
    $sql = "SELECT * FROM course WHERE cursoPropietario = $tutorID";
    $resource = doSQL($sql);
    return $resource;
}

function showCourses($resource, $studentID)
{
    //shows the list of courses, and tutor can enroll the student onto course using this form
    echo "Which of your courses do you want to enroll the student on?<br>";
    echo "<form name='showCourses' method='post' action='profAdicionaEstudiante.php' >";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<input type='checkbox' name='cursoID[]' value='$currentLine[cursoID]' />";
        echo $currentLine['cursoNombre'] . '<br>';
    }
    echo "<br> <input type='hidden' name='studentID' value='$studentID' />
		   <input type='submit' onclick='submit' /> </form>";
}

function enrollStudent()
{
    //writes the enrollment info into the database
    $course = $_POST['cursoID'];
    $studentID = $_POST['studentID'];
    $today = date("Ymd");

    foreach ($course as $currentCourse) {
        $sql = "INSERT INTO studentTaking (cursoID, usuarioID, dateRegistered, authorized)
				VALUES ('$currentCourse', '$studentID', '$today', 1)";
        doSQL($sql);
    }
}

function doSQL($sql)
{
    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');

    //check if SQL was successful
    if ($resource = mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>Success</p>");
        return $resource;
    } else {
        echo("<p style='color:red'>Fail: <br/> ");
        echo(mysqli_error($conn));
        echo("<br/>Contact Network Admin</p>");
        return false;
    }
    mysqli_close($conn);
}

include("vista/include/piePagina.php");
?>
