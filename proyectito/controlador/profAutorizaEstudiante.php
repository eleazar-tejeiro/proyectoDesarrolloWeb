<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
		<?php include("modelo/revisaProfesor.php");
        echo "<h2>Authorize Students</h2>
		<p>This page allows you to authorize student(s) onto courses. See the table
		   for the list of students waiting to be autorizado or add them yourself. <br></p>";

        if (!isset($_POST['studentID'])) {
            if (!isset($_POST['cursoID'])) {
                getCourses();
            } else {
                getStudentTakingCourse();
            }
        } else {
            enrollStudent();
        }
        ?>
	</div>
</div>
<?php
include("vista/include/piePagina.php");

function getCourses()
{
    //gets the courses the tutors teach
    $usuarioID = $_SESSION['usuarioID'];
    $sql = "SELECT cursoID, cursoNombre FROM course WHERE cursoPropietario = $usuarioID";
    if ($resource = doSQL($sql)) {
        showCourses($resource);
    }
}

function getStudentTakingCourse()
{
    //grabs all the students waiting to be autorizado
    $cursoID = $_POST['cursoID'];
    $sql = "SELECT usuarioID FROM studentTaking WHERE cursoID = $cursoID AND autorizado = 0";
    if ($resource = doSQL($sql)) {
        getStudentDetails($resource);
    }
}

function getStudentDetails($resource)
{
    //gets the student's information
    $sql = "SELECT usuarioID, nombreUsuario, usuarioApellido FROM users WHERE ";
    while ($currentLine = mysqli_fetch_array($resource)) {
        $sql .= "usuarioID = '$currentLine[usuarioID]' OR ";
    }
    $sql = rtrim($sql, " OR ");
    if ($resource = doSQL($sql)) {
        showStudents($resource);
    }
}

function showStudents($resource)
{
    //shows a form of students to the tutor
    $cursoID = $_POST['cursoID'];
    echo "<form name='showStudents' method='post' action='profAutorizaEstudiante.php'>";
    echo "<input type='hidden' name='cursoID' value='$cursoID' /> ";
    echo "<table border='2'>
			<tr><th>Check</th><th>User ID</th><th>Name</th>";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<tr><td><input type='checkbox' name='studentID[]' value='$currentLine[usuarioID]' /></td>";
        echo "<td>". $currentLine['usuarioID'] . "</td><td>" . $currentLine['nombreUsuario'] ." " . $currentLine['usuarioApellido'] . "</td></tr>";
    }
    echo "</table>";
    echo "<br><input type='submit' value='Authorize' onclick='submit' /> </form>";
}

function enrollStudent()
{
    //authorizes student to take course
    $cursoID = $_POST['cursoID'];
    foreach ($_POST['studentID'] as $usuarioID) {
        $sql = "UPDATE studentTaking SET autorizado = 1
				WHERE usuarioID=$usuarioID AND cursoID = $cursoID";
        doSQL($sql);
        echo "Successfully Enrolled Student<br>";
    }
}

function doSQL($sql)
{
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    if ($resource = mysqli_query($conn, $sql)) {
        return $resource;
    } else {
        echo("No Students waiting to be autorizado");
        return false;
    }
    mysqli_close($conn);
}

function showCourses($resource)
{
    //shows form of courses
    echo "<form name='showCourses' method='post' action='profAutorizaEstudiante.php'>
		  <select name='cursoID' required autofocus > ";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<option value='$currentLine[cursoID]'>$currentLine[cursoNombre]</option>";
    }
    echo "</select>
		  <input type='submit' onclick='submit' />
		  </form>";
}
?>
