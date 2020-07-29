<?php
session_start();
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
<div class="row">
	<div class="column middle">
	<?php
    include("modelo/revisaProfesor.php");

    if (isset($_POST['courseName'])) {
        addCourseToDatabase();
    } else {
        showForm();
    }
    ?>
	</div>
</div>

<?php
function showForm()
    {
        //shows the form to create a new course
        echo "<form name='Add Course' method='post' action='profNuevoCurso.php'>
		Course Name		  <input type='text' name='courseName'/> <br />
		<input type='submit' onclick='submit' />
		</form>";
    }

function addCourseToDatabase()
{
    //adds the information entered by the user to the table
    $courseName = $_POST['courseName'];
    $courseOwner = $_SESSION['userID'];

    $conn = mysqli_connect('localhost', 'root', '', 'BDClaseVirtual');
    $sql = "INSERT INTO course (courseName, courseOwner)
			VALUES ('$courseName', '$courseOwner')";

    //check if course created successfully
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green'>Successfully Created Course</p>";
        echo "<a href='profInicio.php'>Click here to return to Tutor Home</a>";
        echo "<br><br><a href='profNuevoCurso.php'>Click here to create another course</a>";
    } else {
        echo"<p style='color:red'>Failed to Create Course: <br/> ";
        echo(mysqli_error($conn));
        echo "<br/>Contact Network Admin</p>";
    }
    mysqli_close($conn);
}

include("vista/include/piePagina.php");
?>
