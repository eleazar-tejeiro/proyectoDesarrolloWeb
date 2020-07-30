<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("modelo/revisaEstudiante.php");
        if (!isset($_POST['course'])) {
            showForm();
        } else {
            displayGrades();
            showProgress();
        }
        ?>
	</div>
</div>

<?php
function showForm()
        {
            //select the course to see progress/grades
            $usuarioID = $_SESSION['usuarioID'];
            $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
            $sql = "SELECT c.cursoID, c.cursoNombre FROM course c, studentTaking s WHERE c.cursoID=s.cursoID AND usuarioID='$usuarioID' ";
            $resource = mysqli_query($conn, $sql);
            //check to make sure they are enrolled in classes
            if (mysqli_num_rows($resource)<1) {
                echo "<p>You are not enrolled in any classes yet.<p><a href='estudianteInicio.php'>Please return to the student home.</a>";
            } else {
                //displays all the potential courses to take
                echo "Please select a class to see grades and progress.<br>";
                echo "<form name='select' method='post' action='estudianteCalificaciones.php'>";
                while ($currentCourse = mysqli_fetch_array($resource)) {
                    echo "<input type='radio' name='course[]' value='$currentCourse[cursoID]' />
			  $currentCourse[cursoNombre] <br>";
                }
                echo("<input type='submit' onclick='submit' />
			</form>");
            }
            mysqli_close($conn);
        }
function displayGrades()
{
    //display grades to user based on course selection
    $course = $_POST['course'];
    foreach ($course as $currentCourse) {
        $cursoID=$currentCourse;
    }

    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT * FROM takenQuizzes t, course c WHERE c.cursoID=t.cursoID AND t.cursoID='$cursoID' ";
    $resource = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM resources r, course c
			 WHERE r.cursoID=c.cursoID AND r.cursoID='$cursoID' AND r.nombreArchivo LIKE '%.txt' AND r.name NOT IN
			(SELECT name FROM takenQuizzes t WHERE t.cursoID='$cursoID')";
    $resource2 = mysqli_query($conn, $sql2);
    //heading display code
    if (mysqli_num_rows($resource)<1 && mysqli_num_rows($resource2)<1) { //assingments uploaded?
        echo "There are no assignments uploaded on this course yet.<br>";
        echo "<a href='estudianteInicio.php'>Click here to return to student home.</a><br>";
        echo "<a href='estudianteCalificaciones.php'>Click here to select another course.</a>";
        die();
    }
    echo "<h2>Grades</h2>
		  <table border='2'>
		  <tr><th>Name</th><th>Course</th><th>Taken Date</th><th>Score</th><th>Grade</th></tr>";
    if (mysqli_num_rows($resource)>0) { //check if there are any taken quizzes
        //display grades for each assignment completed
        while ($row = mysqli_fetch_array($resource)) {
            $name = $row['name'];
            $score = $row['score'];
            $questions = $row['questions'];
            $grade = $row['finalScore'];
            $course = $row['cursoNombre'];
            $takenDate = $row['takenDate'];

            echo"<tr><td>$name</td>
				 <td>$course</td>
				 <td>$takenDate</td>
				 <td>$score / $questions</td>
				 <td>$grade%</td>
				 </tr>";
        }
    }
    //display quizzes not completed
    if (mysqli_num_rows($resource2)>0) { //check if there are any quizzes not completed
        while ($row = mysqli_fetch_array($resource2)) {
            $name = $row['name'];
            $course = $row['cursoNombre'];
            echo"<tr><td>$name</td>
				 <td>$course</td>
				 <td style='text-align:center'>-</td>
				 <td style='text-align:center'>-</td>
				 <td style='text-align:center'>-</td>
				 </tr>";
        }
    }
    //display total grade in the class
    $sql3 = "SELECT SUM(questions) AS questions, SUM(score) AS score FROM takenQuizzes WHERE cursoID='$cursoID' ";
    $resource3 = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($resource3)>0) {
        echo "<tr><th>Total</th><td></td><td></td>";
        $row = mysqli_fetch_array($resource3);
        $totalQuestions = $row['questions'];
        $totalScore = $row['score'];
        $totalGrade = ($totalScore/$totalQuestions)*100;
        $totalGrade = round($totalGrade, 2);
        echo"<th>$totalScore / $totalQuestions</th><th>$totalGrade%</th>";
    } else {  //if no taken quizzes display below
        echo "<th>-</th><th>-</th>";
    }
    echo "</tr></table><br>";
    echo "<a href='estudianteCalificaciones.php'>Click here to select another course.</a><br>";
    echo "<a href='estudianteInicio.php'>Click here to return to the student home.</a>";
    mysqli_close($conn);
}
function showProgress()
{
    $course = $_POST['course'];
    foreach ($course as $currentCourse) {
        $cursoID=$currentCourse;
    }
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT * FROM resources WHERE cursoID='$cursoID' AND nombreArchivo LIKE '%.txt' ";
    $resource = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($resource);

    $sql = "SELECT * FROM takenQuizzes WHERE cursoID='$cursoID' ";
    $resource = mysqli_query($conn, $sql);
    $current = mysqli_num_rows($resource);
    $percent = ($current/$total) *100;
    $percent = round($percent, 2);

    echo "<br><br><h2>Progress</h2><p>You are done with $percent% of the class<p>";
    echo "<div class='outter'>
		  <div class='inner'></div></div>"; ?>
	<!--Styling for Progress Bar (Couldn't figure out how to get this in external file) -->
	<style type="text/CSS">
	.outter{
		height:25px;
		width:500px;
		border:solid 1px #000;
	}
	.inner{
		height:25px;
		width:<?php echo "$percent"; ?>%;
		border-right:solid 1px #000;
		background-color: green;
	}
	</style>
<?php
    mysqli_close($conn);
}
include("vista/include/piePagina.php");
?>
