<?php
    include("vista/include/encabezado.php");
    include("vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php
    include("modelo/revisaProfesor.php");

    //gets grades of users in the courses of tutor
    $tutorID = $_SESSION['usuarioID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT u.nombreUsuario AS 'forename', u.usuarioApellido AS 'surname', c.cursoNombre AS 'course', SUM(t.score)/SUM(t.questions) AS 'finalScore'
			FROM users u, takenQuizzes t, course c
			WHERE u.usuarioID=t.usuarioID AND t.cursoID=c.cursoID AND c.cursoPropietario='$tutorID' ";
    $resource = mysqli_query($conn, $sql);
    echo "<h2>Your Students Grades</h2>";
    if (mysqli_num_rows($resource)<1) {
        echo "None of your students have grades yet";
    } else {
        echo "<table border='2'>
			<tr><th>Forename</th><th>Surname</th><th>Course</th><th>Grade</th></tr>";
        while ($row= mysqli_fetch_array($resource)) {
            $forename = $row['forename'];
            $surname = $row['surname'];
            $course = $row['course'];
            $grade = $row['finalScore'];
            $grade = $grade*100;
            echo "<tr><td>$forename</td><td>$surname</td><td>$course</td><td>$grade%</td></tr>";
        }
        echo "</table>";
    }

//this next section displays students in class without grades
    //correlated subquery to select students not in grades table
    $sql2 = "SELECT u.nombreUsuario AS 'forename', u.usuarioApellido AS 'surname', c.cursoNombre AS 'course'
			 FROM users u, studentTaking s, course c
			 WHERE u.usuarioID=s.usuarioID AND s.cursoID=c.cursoID AND c.cursoPropietario='$tutorID'
			 AND u.usuarioID NOT IN (SELECT u2.usuarioID FROM users u2, takenQuizzes t2, course c2
		 			WHERE u2.usuarioID=t2.usuarioID AND t2.cursoID=c2.cursoID AND c2.cursoPropietario='$tutorID' AND c2.cursoID=c.cursoID)";
    $resource2 = mysqli_query($conn, $sql2);
    echo "<br><h2>Student's Without Grades Yet</h2>";
    if (mysqli_num_rows($resource2)<1) {
        echo "No other students to display";
    } else {
        echo "<table border='2'>
			<tr><th>Forename</th><th>Surname</th><th>Course</th><th>Grade</th></tr>";
        while ($row= mysqli_fetch_array($resource2)) {
            $forename = $row['forename'];
            $surname = $row['surname'];
            $course = $row['course'];
            echo "<tr><td>$forename</td><td>$surname</td><td>$course</td><td>-</td></tr>";
        }
        echo "</table>";
    }
    mysqli_close($conn);
    ?>
	</div>
</div>

<?php
include("vista/include/piePagina.php");
?>
