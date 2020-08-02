<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
		<?php include("../modelo/revisaProfesor.php");
        echo "<h2>Autoriza Estudiantes</h2>
		<p>Esta página le permite autorizar estudiantes en los cursos. Ver la tabla
        para la lista de estudiantes que esperan ser autorizados o agréguelos usted mismo<br></p>";

        if (!isset($_POST['estudianteID'])) {
            if (!isset($_POST['cursoID'])) {
                getCursos();
            } else {
                getEstudianteTakingCurso();
            }
        } else {
            enrollEstudiante();
        }
        ?>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");

function getCursos()
{
    // obtiene los cursos que imparten los profesores
    $usuarioID = $_SESSION['usuarioID'];
    $sql = "SELECT cursoID, cursoNombre FROM curso WHERE cursoPropietario = $usuarioID";
    if ($resource = doSQL($sql)) {
        showCursos($resource);
    }
}

function getEstudianteTakingCurso()
{
    // agarra a todos los estudiantes que esperan ser autorizados
    $cursoID = $_POST['cursoID'];
    $sql = "SELECT usuarioID FROM estudianteCurso WHERE cursoID = $cursoID AND autorizado = 0";
    if ($resource = doSQL($sql)) {
        getEstudianteDetails($resource);
    }
}

function getEstudianteDetails($resource)
{
    // obtiene la información del estudiante
    $sql = "SELECT usuarioID, nombreUsuario, usuarioApellido FROM usuarios WHERE ";
    while ($currentLine = mysqli_fetch_array($resource)) {
        $sql .= "usuarioID = '$currentLine[usuarioID]' OR ";
    }
    $sql = rtrim($sql, " OR ");
    if ($resource = doSQL($sql)) {
        showEstudiantes($resource);
    }
}

function showEstudiantes($resource)
{
    // muestra una forma de estudiantes al profesor
    $cursoID = $_POST['cursoID'];
    echo "<form name='showEstudiantes' method='post' action='profAutorizaEstudiante.php'>";
    echo "<input type='hidden' name='cursoID' value='$cursoID' /> ";
    echo "<table border='2'>
			<tr><th>Check</th><th>ID Usuario</th><th>Name</th>";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<tr><td><input type='checkbox' name='estudianteID[]' value='$currentLine[usuarioID]' /></td>";
        echo "<td>". $currentLine['usuarioID'] . "</td><td>" . $currentLine['nombreUsuario'] ." " . $currentLine['usuarioApellido'] . "</td></tr>";
    }
    echo "</table>";
    echo "<br><input type='submit' value='AUTORIZAR' onclick='submit' /> </form>";
}

function enrollEstudiante()
{
    // autoriza al estudiante a tomar curso
    $cursoID = $_POST['cursoID'];
    foreach ($_POST['estudianteID'] as $usuarioID) {
        $sql = "UPDATE estudianteCurso SET autorizado = 1
				WHERE usuarioID=$usuarioID AND cursoID = $cursoID";
        doSQL($sql);
        echo "Estudiante inscrito exitosamente<br>";
    }
}

function doSQL($sql)
{
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    if ($resource = mysqli_query($conn, $sql)) {
        return $resource;
    } else {
        echo("No hay estudiantes esperando ser autorizados");
        return false;
    }
    mysqli_close($conn);
}

function showCursos($resource)
{
    // muestra forma de cursos
    echo "<form name='showCursos' method='post' action='profAutorizaEstudiante.php'>
		  <select name='cursoID' required autofocus > ";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<option value='$currentLine[cursoID]'>$currentLine[cursoNombre]</option>";
    }
    echo "</select>
		  <input type='submit' onclick='submit' />
		  </form>";
}
include("../vista/include/piePagina.php");
?>
