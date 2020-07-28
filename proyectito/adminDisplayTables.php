<?php
	include ("include/header.php");
	include ("include/leftNav.php");
?>
<div class="row">
	<div class="column middle">
	<?php include ("adminCheck.php");
	if (!isset($_POST['table'])){
		showForm();
	}
	else{
		displayTable();
	}
	?>
	</div>
</div>
<?php
function showForm(){
//show the form to select which table to display
	echo "<form name='displayTables' method='post' action='adminDisplayTables.php'>
		<input type='radio' name='table' value='users'>Users<br>
		<input type='radio' name='table' value='courses'>Course<br>
		<input type='radio' name='table' value='resources'>Resources<br>
		<input type='radio' name='table' value='studentTaking'>Student Taking<br>
		<input type='radio' name='table' value='takenQuizzes'>Taken Quizzes<br>
		<input type='submit'>
		</form>";
}

function displayTable(){
	$selection = $_POST['table'];
	$conn = mysqli_connect("localhost","root","root","classDatabase");

	//based on selection, set the SQL and header to display
	if ($selection =='users') {
		$sql="SELECT * FROM users";
		$header = "<tr><th>User ID</th><th>Forename</th><th>Surname</th><th>Username</th><th>Password</th><th>User Type</th><th>Active</th></tr>";
	}
	else if ($selection =='courses') {
		$sql="SELECT * FROM course";
		$header = "<tr><th>Course ID</th><th>Name</th><th>Owner ID</th></tr>";
	}
	else if ($selection =='studentTaking') {
		$sql="SELECT * FROM studentTaking";
		$header = "<tr><th>Course ID</th><th>User ID</th><th>Date Registered</th><th>Authorized</th></tr>";
	}
	else if ($selection =='takenQuizzes') {
		$sql="SELECT * FROM takenQuizzes";
		$header = "<tr><th>Name</th><th>Filename</th><th>User ID</th><th>Score</th><th>Questions</th><th>Final Score</th><th>Course ID</th><th>Taken Date</th></tr>";
	}
	else{
		$sql="SELECT * FROM resources";
		$header = "<tr><th>ID</th><th>Name</th><th>Filename</th><th>Course ID</th><th>Owner ID</th><th>Upload Date</th></tr>";
	}

	$resource = mysqli_query($conn,$sql);

	echo "<table border='2'>";
	echo "$header";
	while ($currentLine = mysqli_fetch_array($resource, MYSQLI_NUM)) {
		echo "<tr>";
		foreach ($currentLine as $currentItem){
			echo "<td>$currentItem</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "<br><a href='adminDisplayTables.php'>Click here to choose another table</a><br>
			  <a href='adminHome.php'>Click here to return to the admin homepage</a>";

	mysqli_close($conn);
}
include ("include/footer.php");
?>
