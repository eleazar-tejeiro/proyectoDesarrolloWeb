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

    if (isset($_FILES["resourceFile"])) {
        addResourceToDatabase();
    } else {
        showForm();
    }
    ?>
	</div>
</div>

<?php

function showForm()
{
    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $usuarioID = $_SESSION['usuarioID'];
    $sql = "SELECT cursoID, cursoNombre FROM curso WHERE cursoPropietario=$usuarioID";
    $resource = mysqli_query($conn, $sql);

    // muestra todos los cursos potenciales
    echo " <form method='post' action='profCarga.php' enctype='multipart/form-data'>
		Nombre del recurso: <input type='text' id='resourceName' name='resourceName'/><br>
		Subir archivo: <input type='file' id='resourceFile' name='resourceFile'/><br><br>Elija Curso para archivo:<br>";
    while ($currentCurso = mysqli_fetch_array($resource)) {
        echo "<input type='checkbox' name='curso[]' value='$currentCurso[cursoID]' />
		  $currentCurso[cursoNombre] <br>";
    }
    echo"<input type='submit' value='Subir Recurso'/>
		</form>";
}

function addResourceToDatabase()
{
    // agrega el recurso cargado a la base de datos
    $resourceFile = $_FILES["resourceFile"];
    $resourceName = $resourceFile["name"];
    $tmp_name = $resourceFile["tmp_name"];
    $fileError = $resourceFile["error"];
    $resourceDisplayName = $_POST["resourceName"];
    $fechaSubida = date("Y-m-d H:i:s");
    $curso = $_POST["curso"];
    $loginusuarioApodo = $_SESSION["usuarioID"];

    if ($fileError == 0) {
        if (move_uploaded_file($tmp_name, "recursos/$resourceName")) {
            $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
            foreach ($curso as $currentCurso) {
                $sql = "INSERT INTO recursos(name, nombreArchivo, propietario, cursoID, fechaSubida)
				VALUES('$resourceDisplayName', '$resourceName', '$loginusuarioApodo', $currentCurso, '$fechaSubida')";

                // comprobar si el curso se creó con éxito
                if (mysqli_query($conn, $sql)) {
                    echo "<p style='color:green'>Recurso cargado correctamente</p>";
                    echo "<a href='profInicio.php'>Haga clic aquí para regresar a Profesor Inicio</a>";
                    echo "<br><br><a href='profCarga.php'>Haga clic aquí para cargar otro recurso.</a>";
                } else {
                    echo"<p style='color:red'>Error al cargar el recurso: <br/> ";
                    echo(mysqli_error($conn));
                    echo "<br/>Póngase en contacto con el administrador de red</p>";
                }
            }
            mysqli_close($conn);
        } else {
            echo"Se produjo un error al escribir el archivo en la base de datos.";
        }
    } else {
        echo"Se produjo un error al conectar el archivo a la base de datos. Póngase en contacto con el administrador de la red";
    }
}

include("../vista/include/piePagina.php");
?>
