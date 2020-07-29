<?php
include("include/header.php");
include("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "CREATE TABLE IF NOT EXISTS studentTaking (
			courseID 		INT NOT NULL,
			userID   		INT NOT NULL,
			dateRegistered  DATE NOT NULL,
			authorized 		BOOLEAN,
			FOREIGN KEY (courseID) REFERENCES course(courseID)
			ON UPDATE CASCADE ON DELETE RESTRICT,
			FOREIGN KEY (userID) REFERENCES users(userID)
			ON UPDATE CASCADE ON DELETE RESTRICT
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
