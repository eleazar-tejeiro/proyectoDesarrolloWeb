<?php
    include("../vista/include/encabezado.php");
    include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php
    include("../modelo/revisaProfesor.php");

    //gets grades of users in the cursos of profesor
    $profesorID = $_SESSION['usuarioID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT u.nombreUsuario AS 'nombre', u.usuarioApellido AS 'apellido', c.cursoNombre AS 'curso', SUM(t.score)/SUM(t.questions) AS 'finalScore'
			FROM users u, takenQuizzes t, curso c
			WHERE u.usuarioID=t.usuarioID AND t.cursoID=c.cursoID AND c.cursoPropietario='$profesorID' ";
    $resource = mysqli_query($conn, $sql);
    echo "<h2>Your Estudiantes Grades</h2>";
    if (mysqli_num_rows($resource)<1) {
        echo "None of your estudiantes have grades yet";
    } else {
        echo "<table border='2'>
			<tr><th>Nombre</th><th>Apellido</th><th>Curso</th><th>Grade</th></tr>";
        while ($row= mysqli_fetch_array($resource)) {
            $nombre = $row['nombre'];
            $apellido = $row['apellido'];
            $curso = $row['curso'];
            $grade = $row['finalScore'];
            $grade = $grade*100;
            echo "<tr><td>$nombre</td><td>$apellido</td><td>$curso</td><td>$grade%</td></tr>";
        }
        echo "</table>";
    }

//this next section displays estudiantes in class without grades
    //correlated subquery to select estudiantes not in grades table
    $sql2 = "SELECT u.nombreUsuario AS 'nombre', u.usuarioApellido AS 'apellido', c.cursoNombre AS 'curso'
			 FROM users u, estudianteTaking s, curso c
			 WHERE u.usuarioID=s.usuarioID AND s.cursoID=c.cursoID AND c.cursoPropietario='$profesorID'
			 AND u.usuarioID NOT IN (SELECT u2.usuarioID FROM users u2, takenQuizzes t2, curso c2
		 			WHERE u2.usuarioID=t2.usuarioID AND t2.cursoID=c2.cursoID AND c2.cursoPropietario='$profesorID' AND c2.cursoID=c.cursoID)";
    $resource2 = mysqli_query($conn, $sql2);
    echo "<br><h2>Estudiante's Without Grades Yet</h2>";
    if (mysqli_num_rows($resource2)<1) {
        echo "No other estudiantes to display";
    } else {
        echo "<table border='2'>
			<tr><th>Nombre</th><th>Apellido</th><th>Curso</th><th>Grade</th></tr>";
        while ($row= mysqli_fetch_array($resource2)) {
            $nombre = $row['nombre'];
            $apellido = $row['apellido'];
            $curso = $row['curso'];
            echo "<tr><td>$nombre</td><td>$apellido</td><td>$curso</td><td>-</td></tr>";
        }
        echo "</table>";
    }
    mysqli_close($conn);
    ?>
	</div>
</div>

<?php
include("../vista/include/piePagina.php");
?>
