<?php
include("include/header.php");
include("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
	<?php
    $conn = mysqli_connect("localhost", "root", "", "classDatabase");
    $sql = "CREATE TABLE IF NOT EXISTS resources (
				id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name VARCHAR(255),
				filename VARCHAR(255) NOT NULL,
				courseID VARCHAR(255) NOT NULL,
				owner VARCHAR(10) NOT NULL,
				uploadDate DATE NOT NULL)";

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
