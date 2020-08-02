<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("../modelo/revisaEstudiante.php");
        if (!isset($_POST['curso'])) {
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
            // seleccione el curso para ver el progreso / calificaciones
            $usuarioID = $_SESSION['usuarioID'];
            $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
            $sql = "SELECT c.cursoID, c.cursoNombre FROM curso c, estudianteCurso s WHERE c.cursoID=s.cursoID AND usuarioID='$usuarioID' ";
            $resource = mysqli_query($conn, $sql);
            // revisa para asegurarte de que estén inscritos en clases
            if (mysqli_num_rows($resource)<1) {
                echo "<p>Aún no estás inscrito en ninguna clase<p><a href='estudianteInicio.php'>Por favor regrese al inicio del estudiante</a>";
            } else {
                // muestra todos los cursos potenciales para tomar
                echo "Seleccione una clase para ver las calificaciones y el progreso<br>";
                echo "<form name='select' method='post' action='estudianteCalificaciones.php'>";
                while ($currentCurso = mysqli_fetch_array($resource)) {
                    echo "<input type='radio' name='curso[]' value='$currentCurso[cursoID]' />
			  $currentCurso[cursoNombre] <br>";
                }
                echo("<input type='submit' onclick='submit' />
			</form>");
            }
            mysqli_close($conn);
        }
function displayGrades()
{
    // muestra calificaciones al usuario en función de la selección del curso
    $curso = $_POST['curso'];
    foreach ($curso as $currentCurso) {
        $cursoID=$currentCurso;
    }

    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT * FROM takenQuizzes t, curso c WHERE c.cursoID=t.cursoID AND t.cursoID='$cursoID' ";
    $resource = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM recursos r, curso c
			 WHERE r.cursoID=c.cursoID AND r.cursoID='$cursoID' AND r.nombreArchivo LIKE '%.txt' AND r.name NOT IN
			(SELECT name FROM takenQuizzes t WHERE t.cursoID='$cursoID')";
    $resource2 = mysqli_query($conn, $sql2);
    // código de visualización del encabezado
    if (mysqli_num_rows($resource)<1 && mysqli_num_rows($resource2)<1) {  // evaluaciones cargadas?
        echo "
        Aún no hay tareas subidas en este curso<br>";
        echo "<a href='estudianteInicio.php'>Haga clic aquí para regresar al inicio del estudiante</a><br>";
        echo "<a href='estudianteCalificaciones.php'>Haga clic aquí para seleccionar otro curso</a>";
        die();
    }
    echo "<h2>Curso</h2>
		  <table border='2'>
		  <tr><th>Nombre</th><th>Curso</th><th>Fecha creada</th><th>Puntuacion</th><th>Curso</th></tr>";
    if (mysqli_num_rows($resource)>0) { // verifica si hay algún cuestionario tomado
        // muestra las calificaciones de cada tarea completada
        while ($row = mysqli_fetch_array($resource)) {
            $name = $row['name'];
            $score = $row['score'];
            $questions = $row['questions'];
            $grade = $row['finalScore'];
            $curso = $row['cursoNombre'];
            $takenDate = $row['takenDate'];

            echo"<tr><td>$name</td>
				 <td>$curso</td>
				 <td>$takenDate</td>
				 <td>$score / $questions</td>
				 <td>$grade%</td>
				 </tr>";
        }
    }
    // muestra cuestionarios no completados
    if (mysqli_num_rows($resource2)>0) { // verifica si hay algún cuestionario no completado
        while ($row = mysqli_fetch_array($resource2)) {
            $name = $row['name'];
            $curso = $row['cursoNombre'];
            echo"<tr><td>$name</td>
				 <td>$curso</td>
				 <td style='text-align:center'>-</td>
				 <td style='text-align:center'>-</td>
				 <td style='text-align:center'>-</td>
				 </tr>";
        }
    }
    // muestra la calificación total en la clase
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
    } else {  // si no hay pruebas tomadas se muestran a continuación
        echo "<th>-</th><th>-</th>";
    }
    echo "</tr></table><br>";
    echo "<a href='estudianteCalificaciones.php'>Haga clic aquí para seleccionar otro curso.</a><br>";
    echo "<a href='estudianteInicio.php'>Haga clic aquí para regresar a la casa del estudiante.</a>";
    mysqli_close($conn);
}
function showProgress()
{
    $curso = $_POST['curso'];
    foreach ($curso as $currentCurso) {
        $cursoID=$currentCurso;
    }
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "SELECT * FROM recursos WHERE cursoID='$cursoID' AND nombreArchivo LIKE '%.txt' ";
    $resource = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($resource);

    $sql = "SELECT * FROM takenQuizzes WHERE cursoID='$cursoID' ";
    $resource = mysqli_query($conn, $sql);
    $current = mysqli_num_rows($resource);
    $percent = ($current/$total) *100;
    $percent = round($percent, 2);

    echo "<br><br><h2>Progress</h2><p>Has terminado con $percent% de la clase<p>";
    echo "<div class='outter'>
		  <div class='inner'></div></div>"; ?>
	<!--Barra de estilo para el progreso (No se pudo encontrar la forma de obtener esto en un archivo externo) -->
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
include("../vista/include/piePagina.php");
?>
