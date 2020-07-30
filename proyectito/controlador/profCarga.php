<?php
session_start();
include("vista/include/encabezado.php.php");
include("vista/include/navegadorIzqui.phpqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
<div class="row">
	<div class="column middle">
	<?php
    include("modelo/revisaProfesor.php.php");

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
    $sql = "SELECT cursoID, cursoNombre FROM course WHERE cursoPropietario=$usuarioID";
    $resource = mysqli_query($conn, $sql);

    //displays all the potential courses
    echo " <form method='post' action='profCarga.php' enctype='multipart/form-data'>
		Resource Name: <input type='text' id='resourceName' name='resourceName'/><br>
		Upload file: <input type='file' id='resourceFile' name='resourceFile'/><br><br> Choose Course For File:<br>";
    while ($currentCourse = mysqli_fetch_array($resource)) {
        echo "<input type='checkbox' name='course[]' value='$currentCourse[cursoID]' />
		  $currentCourse[cursoNombre] <br>";
    }
    echo"<input type='submit' value='Upload Resource'/>
		</form>";
}

function addResourceToDatabase()
{
    //adds the uploaded resource to the database
    $resourceFile = $_FILES["resourceFile"];
    $resourceName = $resourceFile["name"];
    $tmp_name = $resourceFile["tmp_name"];
    $fileError = $resourceFile["error"];
    $resourceDisplayName = $_POST["resourceName"];
    $fechaSubida = date("Y-m-d H:i:s");
    $course = $_POST["course"];
    $loginusuarioApodo = $_SESSION["usuarioID"];

    if ($fileError == 0) {
        if (move_uploaded_file($tmp_name, "resource_uploads/$resourceName")) {
            $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
            foreach ($course as $currentCourse) {
                $sql = "INSERT INTO resources(name, nombreArchivo, propietario, cursoID, fechaSubida)
				VALUES('$resourceDisplayName', '$resourceName', '$loginusuarioApodo', $currentCourse, '$fechaSubida')";

                //check if course created successfully
                if (mysqli_query($conn, $sql)) {
                    echo "<p style='color:green'>Successfully Uploaded Resource</p>";
                    echo "<a href='profInicio.php'>Click here to return to Tutor Home</a>";
                    echo "<br><br><a href='profCarga.php'>Click here to upload another resource</a>";
                } else {
                    echo"<p style='color:red'>Failed to Upload Resource: <br/> ";
                    echo(mysqli_error($conn));
                    echo "<br/>Contact Network Admin</p>";
                }
            }
            mysqli_close($conn);
        } else {
            echo"There was an error writing the file to the database";
        }
    } else {
        echo"There was an error wirting the file to the database. Contact network admin.";
    }
}

include("vista/include/piePagina.phpphp");
?>
