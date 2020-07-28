<?php
include("include/header.php");
include("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("studentCheck.php");

        $userID=$_SESSION['userID'];
        $conn = mysqli_connect("localhost", "root", "", "classDatabase");
        $sql = "SELECT * FROM resources r, course c
				WHERE r.courseID=c.courseID AND filename NOT LIKE '%.txt'
				AND c.courseID IN (SELECT courseID FROM studentTaking WHERE userID=$userID)";

        $resource= mysqli_query($conn, $sql);

        if (mysqli_num_rows($resource)<1) { //check if student is enrolled
            echo "You are either not enrolled on any courses yet.
				<br>If you have enrolled on a course, please contact tutor/admin to authorize you on the course.";
        } else {
            echo "<h2>Uploaded Resources</h2>";
            echo "<table border='2'>";
            echo "<tr><th>Name</th><th>Download Link</th><th>Course</th><th>Upload Date</th></tr>";
            while ($row = mysqli_fetch_array($resource)) {
                $id = $row["id"];
                $name = $row["name"];
                $filename = $row["filename"];
                $course = $row["courseName"];
                $uploadDate = $row["uploadDate"];

                echo "<td>$name</td>";
                echo "<td><a href='resource_uploads/$filename'>$filename</a></td>";
                echo "<td>$course</td><td>$uploadDate</td>";
                echo "</tr>";
            }
            echo "</table><br>";

            $sql = "SELECT * FROM resources r, course c, users u
					WHERE r.courseID=c.courseID AND r.owner=u.userID AND filename LIKE '%.txt'
					AND r.courseID IN (SELECT courseID FROM studentTaking WHERE userID=$userID) ";
            $resource = mysqli_query($conn, $sql);
            echo "<h2>Quizzes</h2>";
            echo "<table border='2'>";
            echo "<tr><th>Name</th><th>Link to Quiz</th><th>Course</th><th>Upload Date</th></tr>";

            while ($row = mysqli_fetch_array($resource)) {
                $id = $row["id"];
                $name = $row["name"];
                $filename = $row["filename"];
                $course = $row["courseName"];
                $uploadDate = $row["uploadDate"];

                echo "<td>$name</td>";
                echo "<td><a href='studentTakeQuiz.php?quiz=$filename'>Take Quiz</a></td>";
                echo "<td>$course</td><td>$uploadDate</td>";
                echo "</tr>";
            }
            echo "</table><br>";
        }

        mysqli_close($conn);
        ?>
	</div>
</div>
<?php
include("include/footer.php");
?>
