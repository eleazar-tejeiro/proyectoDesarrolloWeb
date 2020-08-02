<?php
session_start();
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<!--Muestra el formulario de registro o agrega al usuario a la base de datos-->
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
        // muestra el formulario para crear un nuevo curso
        echo "<form name='Add Curso' method='post' action='profNuevoCurso.php'>
		Nombre del curso		  <input type='text' name='cursoNombre'/> <br />
		<input type='submit' onclick='submit' />
		</form>";
    }

function addCursoToDatabase()
{
    // agrega la información ingresada por el usuario a la tabla
    $cursoNombre = $_POST['cursoNombre'];
    $cursoPropietario = $_SESSION['usuarioID'];

    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $sql = "INSERT INTO curso (cursoNombre, cursoPropietario)
            VALUES ('$cursoNombre', '$cursoPropietario')";

    // comprobar si el curso se creó con éxito
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green'>Curso creado con éxito</p>";
        echo "<a href='profInicio.php'>Haga clic aquí para regresar a Profesor a inicio</a>";
        echo "<br><br><a href='profNuevoCurso.php'>Haga clic aquí para crear otro curso.</a>";
    } else {
        echo"<p style='color:red'>Error al crear el curso: <br/> ";
        echo(mysqli_error($conn));
        echo "<br/>Póngase en contacto con el administrador de redp>";
    }
    mysqli_close($conn);
}


include("../vista/include/piePagina.php");
?>
