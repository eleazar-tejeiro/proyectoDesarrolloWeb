<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
		<?php include("modelo/revisaProfesor.php");
        echo "<h2>Authorize Students</h2>
		<p>This page allows you to authorize student(s) onto courses. See the table
		   for the list of students waiting to be authorized or add them yourself. <br></p>";

        if (!isset($_POST['studentID'])) {
            if (!isset($_POST['courseID'])) {
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
    $userID = $_SESSION['userID'];
    $sql = "SELECT courseID, courseName FROM course WHERE courseOwner = $userID";
    if ($resource = doSQL($sql)) {
        showCourses($resource);
    }
}

function getStudentTakingCourse()
{
    //grabs all the students waiting to be authorized
    $courseID = $_POST['courseID'];
    $sql = "SELECT userID FROM studentTaking WHERE courseID = $courseID AND authorized = 0";
    if ($resource = doSQL($sql)) {
        getStudentDetails($resource);
    }
}

function getStudentDetails($resource)
{
    //gets the student's information
    $sql = "SELECT userID, userForename, userSurname FROM users WHERE ";
    while ($currentLine = mysqli_fetch_array($resource)) {
        $sql .= "userID = '$currentLine[userID]' OR ";
    }
    $sql = rtrim($sql, " OR ");
    if ($resource = doSQL($sql)) {
        showStudents($resource);
    }
}

function showStudents($resource)
{
    //shows a form of students to the tutor
    $courseID = $_POST['courseID'];
    echo "<form name='showStudents' method='post' action='profAutorizaEstudiante.php'>";
    echo "<input type='hidden' name='courseID' value='$courseID' /> ";
    echo "<table border='2'>
			<tr><th>Check</th><th>User ID</th><th>Name</th>";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<tr><td><input type='checkbox' name='studentID[]' value='$currentLine[userID]' /></td>";
        echo "<td>". $currentLine['userID'] . "</td><td>" . $currentLine['userForename'] ." " . $currentLine['userSurname'] . "</td></tr>";
    }
    echo "</table>";
    echo "<br><input type='submit' value='Authorize' onclick='submit' /> </form>";
}

function enrollStudent()
{
    //authorizes student to take course
    $courseID = $_POST['courseID'];
    foreach ($_POST['studentID'] as $userID) {
        $sql = "UPDATE studentTaking SET authorized = 1
				WHERE userID=$userID AND courseID = $courseID";
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
        echo("No Students waiting to be authorized");
        return false;
    }
    mysqli_close($conn);
}

function showCourses($resource)
{
    //shows form of courses
    echo "<form name='showCourses' method='post' action='profAutorizaEstudiante.php'>
		  <select name='courseID' required autofocus > ";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<option value='$currentLine[courseID]'>$currentLine[courseName]</option>";
    }
    echo "</select>
		  <input type='submit' onclick='submit' />
		  </form>";
}
?>
