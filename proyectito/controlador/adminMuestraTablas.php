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
        echo "<form name='displayTables' method='post' action='adminMuestraTablas.php'>
		<input type='radio' name='table' value='usuarios'>Usuarios<br>
		<input type='radio' name='table' value='cursos'>Curso<br>
		<input type='radio' name='table' value='recursos'>Recursos<br>
		<input type='radio' name='table' value='estudianteCurso'>Estudiante<br>
		<input type='submit'>
		</form>";
    }

function displayTable()
{
    $selection = $_POST['table'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");

    // según la selección, configure el SQL y el encabezado para mostrar
    if ($selection =='usuarios') {
        $sql="SELECT * FROM usuarios";
        $header = "<tr><th>ID Usuario</th><th>Nombre</th><th>Apellido</th><th>Apodo</th><th>Contraseña</th><th>Tipo de Usuario</th><th>Estado</th></tr>";
    } elseif ($selection =='cursos') {
        $sql="SELECT * FROM curso";
        $header = "<tr><th>Curso ID</th><th>Nombre</th><th>Propietario ID</th></tr>";
    } elseif ($selection =='estudianteCurso') {
        $sql="SELECT * FROM estudianteCurso";
        $header = "<tr><th>Curso ID</th><th>ID Usuario</th><th>Fecha de registro</th><th>autorizado</th></tr>";
    } else {
        $sql="SELECT * FROM recursos";
        $header = "<tr><th>ID</th><th>Nombre</th><th>nombreArchivo</th><th>Curso ID</th><th>Propietario ID</th><th>Fecha de carga</th></tr>";
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
    echo "<br><a href='adminMuestraTablas.php'>Haga clic aquí para elegir otra tabla</a><br>
			  <a href='adminInicio.php'>Haga clic aquí para volver a la página de inicio de administración</a>";

    mysqli_close($conn);
}
include("../vista/include/piePagina.php");
?>
