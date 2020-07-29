<?php
include("include/header.php");
include("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS takenQuizzes (
				name VARCHAR(40) NOT NULL,
				filename VARCHAR(40) NOT NULL,
				userID INT NOT NULL,
				score INT NOT NULL,
				questions INT NOT NULL,
				finalScore FLOAT(10) NOT NULL,
				courseID VARCHAR(255) NOT NULL,
				takenDate DATE)";

    //check if table was created
    if (mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>SUCCESS</p>");
    } else {
        echo("<p style='color:red'>FAIL: <br/>");
        echo(mysqli_error($conn) . "</p>");
    }
    mysqli_close($conn);
    ?>
	</div>
</div>
<?php
include("include/footer.php");
?>
