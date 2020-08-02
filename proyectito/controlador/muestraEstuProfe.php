<?php
    include("../vista/include/encabezado.php");
    include("../vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("../modelo/revisaAdmin.php");
    if (!isset($_POST['table'])) {
        showForm();
    } else {
        displayTable();
    }
    ?>
	</div>
</div>
<?php
function showForm()
    {
        // muestra el formulario para seleccionar qué tabla mostrar
        echo "<form name='displayTables' method='post' action='muestraEstuProfe.php'>
		<input type='radio' name='table' value='estudiantes'>Estudiantes<br>
		<input type='radio' name='table' value='profesores'>Profesores<br>
		<input type='submit'>
		</form>";
    }

function displayTable()
{
    $selection = $_POST['table'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");

    // según la selección, configure el SQL y el encabezado para mostrar
    if ($selection =='estudiantes') {
        $sql="SELECT usuarioID as ID, nombreUsuario as Nombre, usuarioApellido as Apellido, usuarioApodo as Usuario, usuarioContra as Contraseña FROM usuarios WHERE usuarioTipo = 'estudiante'";
        $header = "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Usuario</th><th>Contraseña</th></tr>";
    } else {
        $sql="SELECT nombreUsuario as Nombre, usuarioApellido as Apellido, c.cursoNombre as Curso, COUNT(e.cursoID) as Cuenta FROM usuarios u, curso c, estudianteCurso e WHERE u.usuarioID=c.cursoPropietario and c.cursoID = e.cursoID AND u.usuarioTipo='profesor' GROUP BY e.cursoID";
        $header = "<tr><th>Nombre</th><th>Apellido</th><th>Curso</th><th>Cantidad Inscritos</th></tr>";
    }

    $resource = mysqli_query($conn, $sql);

    echo "<table border='2'>";
    echo "$header";
    while ($currentLine = mysqli_fetch_array($resource, MYSQLI_NUM)) {
        echo "<tr>";
        foreach ($currentLine as $currentItem) {
            echo "<td>$currentItem</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<br><a href='muestraEstuProfe.php'>Haga clic aquí para elegir otro reporte</a><br>
			  <a href='adminInicio.php'>Haga clic aquí para volver a la página de inicio de administración</a>";

    mysqli_close($conn);
}
include("../vista/include/piePagina.php");
?>
