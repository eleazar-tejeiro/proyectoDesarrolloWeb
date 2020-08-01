<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("../modelo/revisaEstudiante.php");

        $usuarioID=$_SESSION['usuarioID'];
        $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
        $sql = "SELECT * FROM resources r, curso c
				WHERE r.cursoID=c.cursoID AND nombreArchivo NOT LIKE '%.txt'
				AND c.cursoID IN (SELECT cursoID FROM estudianteTaking WHERE usuarioID=$usuarioID)";

        $resource= mysqli_query($conn, $sql);

        if (mysqli_num_rows($resource)<1) { //check if estudiante is enrolled
            echo "You are either not enrolled on any cursos yet.
				<br>If you have enrolled on a curso, please contact profesor/admin to authorize you on the curso.";
        } else {
            echo "<h2>Uploaded Resources</h2>";
            echo "<table border='2'>";
            echo "<tr><th>Name</th><th>Download Link</th><th>Curso</th><th>Upload Date</th></tr>";
            while ($row = mysqli_fetch_array($resource)) {
                $id = $row["id"];
                $name = $row["name"];
                $nombreArchivo = $row["nombreArchivo"];
                $curso = $row["cursoNombre"];
                $fechaSubida = $row["fechaSubida"];

                echo "<td>$name</td>";
                echo "<td><a href='resource_uploads/$nombreArchivo'>$nombreArchivo</a></td>";
                echo "<td>$curso</td><td>$fechaSubida</td>";
                echo "</tr>";
            }
            echo "</table><br>";

            $sql = "SELECT * FROM resources r, curso c, usuarios u
					WHERE r.cursoID=c.cursoID AND r.propietario=u.usuarioID AND nombreArchivo LIKE '%.txt'
					AND r.cursoID IN (SELECT cursoID FROM estudianteTaking WHERE usuarioID=$usuarioID) ";
            $resource = mysqli_query($conn, $sql);
            echo "<h2>Quizzes</h2>";
            echo "<table border='2'>";
            echo "<tr><th>Name</th><th>Link to Quiz</th><th>Curso</th><th>Upload Date</th></tr>";

            while ($row = mysqli_fetch_array($resource)) {
                $id = $row["id"];
                $name = $row["name"];
                $nombreArchivo = $row["nombreArchivo"];
                $curso = $row["cursoNombre"];
                $fechaSubida = $row["fechaSubida"];

                echo "<td>$name</td>";
                echo "<td><a href='estudianteTomaCuest.php?quiz=$nombreArchivo'>Take Quiz</a></td>";
                echo "<td>$curso</td><td>$fechaSubida</td>";
                echo "</tr>";
            }
            echo "</table><br>";
        }

        mysqli_close($conn);
        ?>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
