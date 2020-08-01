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
        //show the form to select which table to display
        echo "<form name='displayTables' method='post' action='adminMuestraTablas.php'>
		<input type='radio' name='table' value='usuarios'>Usuarios<br>
		<input type='radio' name='table' value='cursos'>Curso<br>
		<input type='radio' name='table' value='resources'>Resources<br>
		<input type='radio' name='table' value='estudianteTaking'>Estudiante Taking<br>
		<input type='radio' name='table' value='takenQuizzes'>Taken Quizzes<br>
		<input type='submit'>
		</form>";
    }

function displayTable()
{
    $selection = $_POST['table'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");

    //based on selection, set the SQL and header to display
    if ($selection =='usuarios') {
        $sql="SELECT * FROM usuarios";
        $header = "<tr><th>User ID</th><th>Nombre</th><th>Apellido</th><th>usuarioApodo</th><th>Password</th><th>User Type</th><th>Active</th></tr>";
    } elseif ($selection =='cursos') {
        $sql="SELECT * FROM curso";
        $header = "<tr><th>Curso ID</th><th>Name</th><th>Owner ID</th></tr>";
    } elseif ($selection =='estudianteTaking') {
        $sql="SELECT * FROM estudianteTaking";
        $header = "<tr><th>Curso ID</th><th>User ID</th><th>Date Registered</th><th>autorizado</th></tr>";
    } elseif ($selection =='takenQuizzes') {
        $sql="SELECT * FROM takenQuizzes";
        $header = "<tr><th>Name</th><th>nombreArchivo</th><th>User ID</th><th>Score</th><th>Questions</th><th>Final Score</th><th>Curso ID</th><th>Taken Date</th></tr>";
    } else {
        $sql="SELECT * FROM resources";
        $header = "<tr><th>ID</th><th>Name</th><th>nombreArchivo</th><th>Curso ID</th><th>Owner ID</th><th>Upload Date</th></tr>";
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
    echo "<br><a href='adminMuestraTablas.php'>Click here to choose another table</a><br>
			  <a href='adminInicio.php'>Click here to return to the admin homepage</a>";

    mysqli_close($conn);
}
include("../vista/include/piePagina.php");
?>
