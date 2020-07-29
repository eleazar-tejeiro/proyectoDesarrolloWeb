<?php
    include("include/header.php");
    include("include/leftNav.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("adminCheck.php");	?>
	<ul>
		<li><a href='createCourseTable.php'>Crear tabla de materias</a></li>
		<li><a href='createUserTable.php'>Crear tabla de usuarios</a></li>
		<li><a href='createResourcesTable.php'>Crear tabla de recursos</a></li>
		<li><a href='createStudentTakingTable.php'>Crear tabla de materias activas por alumnos</a></li>
		<li><a href='createTakenQuizzesTable.php'>Crear tabla de los quizzes tomados</a></li>
	</div>
</div>
<?php
    include("include/footer.php");
?>
