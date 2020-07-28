<?php
include("include/header.php");
include("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "classDatabase");
    $sql = "CREATE TABLE IF NOT EXISTS course (
			courseID 	 INT NOT NULL AUTO_INCREMENT,
			courseName   VARCHAR(50) NOT NULL,
			courseOwner  INT NOT NULL,
			PRIMARY KEY (courseID),
			FOREIGN KEY (courseOwner) REFERENCES users(userID)
			)";

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
