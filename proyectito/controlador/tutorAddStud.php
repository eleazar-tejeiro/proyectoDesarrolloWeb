<?php
include("include/header.php");
include("include/leftNav.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
<div class="row">
	<div class="column middle">
	<?php
    include("tutorCheck.php");

    if (!isset($_POST['courseID']) and !isset($_POST['studentID'])) {
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
        echo " <form name='register' method='post' action='tutorAddStud.php'>
		Forename		  <input type='text' name='forename'/> <br />
		Surname  		  <input type='text' name='surname'/> <br />
		Username 		  <input type='text' name='username'/> <br />
		<input type='submit' onclick='submit' />
		</form>";
    }

function addUserToDatabase()
{
    //adds the information entered by the user to the table
    $forename = $_POST['forename'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];

    $sql = "INSERT INTO users (userForename, userSurname, username, userPassword, userType, userActive)
			VALUES ('$forename', '$surname', '$username', '$username', 'student', 1)";
    doSQL($sql);
    $studentID = getStudentID();
}

function getStudentID()
{
    //retrieves studentId from database, returns for showCourses function
    $username = $_POST['username'];
    $sql = "SELECT userID FROM users WHERE username='$username' ";
    $record = mysqli_fetch_array(doSQL($sql));
    $studentID = $record['userID'];
    return $studentID;
}

function getCourses()
{
    //gets all courses that the current tutor teaches, returns them for showCourses function
    $tutorID = $_SESSION['userID'];
    $sql = "SELECT * FROM course WHERE courseOwner = $tutorID";
    $resource = doSQL($sql);
    return $resource;
}

function showCourses($resource, $studentID)
{
    //shows the list of courses, and tutor can enroll the student onto course using this form
    echo "Which of your courses do you want to enroll the student on?<br>";
    echo "<form name='showCourses' method='post' action='tutorAddStud.php' >";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<input type='checkbox' name='courseID[]' value='$currentLine[courseID]' />";
        echo $currentLine['courseName'] . '<br>';
    }
    echo "<br> <input type='hidden' name='studentID' value='$studentID' />
		   <input type='submit' onclick='submit' /> </form>";
}

function enrollStudent()
{
    //writes the enrollment info into the database
    $course = $_POST['courseID'];
    $studentID = $_POST['studentID'];
    $today = date("Ymd");

    foreach ($course as $currentCourse) {
        $sql = "INSERT INTO studentTaking (courseID, userID, dateRegistered, authorized)
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

include("include/footer.php");
?>
