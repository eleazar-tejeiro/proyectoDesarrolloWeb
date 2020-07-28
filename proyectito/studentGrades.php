<?php
include("include/header.php");
include("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("studentCheck.php");
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
            $userID = $_SESSION['userID'];
            $conn = mysqli_connect('localhost', 'root', '', 'classDatabase');
            $sql = "SELECT c.courseID, c.courseName FROM course c, studentTaking s WHERE c.courseID=s.courseID AND userID='$userID' ";
            $resource = mysqli_query($conn, $sql);
            //check to make sure they are enrolled in classes
            if (mysqli_num_rows($resource)<1) {
                echo "<p>You are not enrolled in any classes yet.<p><a href='studentHome.php'>Please return to the student home.</a>";
            } else {
                //displays all the potential courses to take
                echo "Please select a class to see grades and progress.<br>";
                echo "<form name='select' method='post' action='studentGrades.php'>";
                while ($currentCourse = mysqli_fetch_array($resource)) {
                    echo "<input type='radio' name='course[]' value='$currentCourse[courseID]' />
			  $currentCourse[courseName] <br>";
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
        $courseID=$currentCourse;
    }

    $conn = mysqli_connect("localhost", "root", "", "classDatabase");
    $sql = "SELECT * FROM takenQuizzes t, course c WHERE c.courseID=t.courseID AND t.courseID='$courseID' ";
    $resource = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM resources r, course c
			 WHERE r.courseID=c.courseID AND r.courseID='$courseID' AND r.filename LIKE '%.txt' AND r.name NOT IN
			(SELECT name FROM takenQuizzes t WHERE t.courseID='$courseID')";
    $resource2 = mysqli_query($conn, $sql2);
    //heading display code
    if (mysqli_num_rows($resource)<1 && mysqli_num_rows($resource2)<1) { //assingments uploaded?
        echo "There are no assignments uploaded on this course yet.<br>";
        echo "<a href='studentHome.php'>Click here to return to student home.</a><br>";
        echo "<a href='studentGrades.php'>Click here to select another course.</a>";
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
            $course = $row['courseName'];
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
            $course = $row['courseName'];
            echo"<tr><td>$name</td>
				 <td>$course</td>
				 <td style='text-align:center'>-</td>
				 <td style='text-align:center'>-</td>
				 <td style='text-align:center'>-</td>
				 </tr>";
        }
    }
    //display total grade in the class
    $sql3 = "SELECT SUM(questions) AS questions, SUM(score) AS score FROM takenQuizzes WHERE courseID='$courseID' ";
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
    echo "<a href='studentGrades.php'>Click here to select another course.</a><br>";
    echo "<a href='studentHome.php'>Click here to return to the student home.</a>";
    mysqli_close($conn);
}
function showProgress()
{
    $course = $_POST['course'];
    foreach ($course as $currentCourse) {
        $courseID=$currentCourse;
    }
    $conn = mysqli_connect("localhost", "root", "", "classDatabase");
    $sql = "SELECT * FROM resources WHERE courseID='$courseID' AND filename LIKE '%.txt' ";
    $resource = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($resource);

    $sql = "SELECT * FROM takenQuizzes WHERE courseID='$courseID' ";
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
include("include/footer.php");
?>
