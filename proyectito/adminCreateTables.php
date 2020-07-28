<?php
	include ("include/header.php");
	include ("include/leftNav.php");
?>
<div class="row">
	<div class="column middle">
	<?php include ("adminCheck.php");	?>
	<ul>
		<li><a href='createCourseTable.php'>Create Course Table</a></li>
		<li><a href='createUserTable.php'>Create User Table</a></li>
		<li><a href='createResourcesTable.php'>Create Resources Table</a></li>
		<li><a href='createStudentTakingTable.php'>Create Student Taking Table</a></li>
		<li><a href='createTakenQuizzesTable.php'>Create Taken Quizzes Table</a></li>
	</div>
</div>
<?php
	include ("include/footer.php");
?>
