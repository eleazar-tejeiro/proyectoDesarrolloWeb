<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
		<?php include("../modelo/revisaProfesor.php");
        echo "<h2>Authorize Estudiantes</h2>
		<p>This page allows you to authorize estudiante(s) onto cursos. See the table
		   for the list of estudiantes waiting to be autorizado or add them yourself. <br></p>";

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
    //gets the cursos the profesors teach
    $usuarioID = $_SESSION['usuarioID'];
    $sql = "SELECT cursoID, cursoNombre FROM curso WHERE cursoPropietario = $usuarioID";
    if ($resource = doSQL($sql)) {
        showCursos($resource);
    }
}

function getEstudianteTakingCurso()
{
    //grabs all the estudiantes waiting to be autorizado
    $cursoID = $_POST['cursoID'];
    $sql = "SELECT usuarioID FROM estudianteTaking WHERE cursoID = $cursoID AND autorizado = 0";
    if ($resource = doSQL($sql)) {
        getEstudianteDetails($resource);
    }
}

function getEstudianteDetails($resource)
{
    //gets the estudiante's information
    $sql = "SELECT usuarioID, nombreUsuario, usuarioApellido FROM users WHERE ";
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
    //shows a form of estudiantes to the profesor
    $cursoID = $_POST['cursoID'];
    echo "<form name='showEstudiantes' method='post' action='profAutorizaEstudiante.php'>";
    echo "<input type='hidden' name='cursoID' value='$cursoID' /> ";
    echo "<table border='2'>
			<tr><th>Check</th><th>User ID</th><th>Name</th>";
    while ($currentLine = mysqli_fetch_array($resource)) {
        echo "<tr><td><input type='checkbox' name='estudianteID[]' value='$currentLine[usuarioID]' /></td>";
        echo "<td>". $currentLine['usuarioID'] . "</td><td>" . $currentLine['nombreUsuario'] ." " . $currentLine['usuarioApellido'] . "</td></tr>";
    }
    echo "</table>";
    echo "<br><input type='submit' value='Authorize' onclick='submit' /> </form>";
}

function enrollEstudiante()
{
    //authorizes estudiante to take curso
    $cursoID = $_POST['cursoID'];
    foreach ($_POST['estudianteID'] as $usuarioID) {
        $sql = "UPDATE estudianteTaking SET autorizado = 1
				WHERE usuarioID=$usuarioID AND cursoID = $cursoID";
        doSQL($sql);
        echo "Successfully Enrolled Estudiante<br>";
    }
}

function doSQL($sql)
{
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    if ($resource = mysqli_query($conn, $sql)) {
        return $resource;
    } else {
        echo("No Estudiantes waiting to be autorizado");
        return false;
    }
    mysqli_close($conn);
}

function showCursos($resource)
{
    //shows form of cursos
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
