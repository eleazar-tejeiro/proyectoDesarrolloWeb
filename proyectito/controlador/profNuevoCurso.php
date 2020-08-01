<?php
session_start();
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
<div class="row">
	<div class="column middle">
	<?php
    include("../modelo/revisaProfesor.php");

    if (isset($_POST['cursoNombre'])) {
        addCursoToDatabase();
    } else {
        showForm();
    }
    ?>
	</div>
</div>

<?php
function showForm()
    {
        //shows the form to create a new curso
        echo "<form name='Add Curso' method='post' action='profNuevoCurso.php'>
		Curso Name		  <input type='text' name='cursoNombre'/> <br />
		<input type='submit' onclick='submit' />
		</form>";
    }

function addCursoToDatabase()
{
    //adds the information entered by the user to the table
    $cursoNombre = $_POST['cursoNombre'];
    $cursoPropietario = $_SESSION['usuarioID'];

    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $sql = "INSERT INTO curso (cursoNombre, cursoPropietario)
			VALUES ('$cursoNombre', '$cursoPropietario')";

    //check if curso created successfully
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green'>Successfully Created Curso</p>";
        echo "<a href='profInicio.php'>Click here to return to Profesor Home</a>";
        echo "<br><br><a href='profNuevoCurso.php'>Click here to create another curso</a>";
    } else {
        echo"<p style='color:red'>Failed to Create Curso: <br/> ";
        echo(mysqli_error($conn));
        echo "<br/>Contact Network Admin</p>";
    }
    mysqli_close($conn);
}

include("../vista/include/piePagina.php");
?>
