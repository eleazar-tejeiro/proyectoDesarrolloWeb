<?php
include ("include/header.php");
include ("include/leftNav.php");
?>
<!--Create the Database for Tables to Be Stored -->
<div class="row">
	<div class="column middle">
	<?php
	$conn = mysqli_connect("localhost", "root", "root");
	$sql = "CREATE DATABASE IF NOT EXISTS classDatabase";

	//check if database was created
	if (mysqli_query($conn, $sql))
		{
		echo ("<p style='color:green'>SUCCESS</p>");
		}
	else{
		echo ("<p style='color:red'>FAIL: <br/>");
		echo (mysqli_error($conn) . "</p>");
		}
	mysqli_close($conn);
	?>
	</div>
</div>

<?php
include ("include/footer.php");
?>
