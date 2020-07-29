<?php
include("vista/include/encabezado.php");
include("vista/include/navegadorIzqui.php");
?>
<div class="row">
	<div class="column middle">
	<?php include("modelo/revisaAdmin.php");

    if (!isset($_POST['userID'])) {
        showTable();
    } else {
        authorizeUser();
    }
    ?>
	</div>
</div>
<?php
function showTable()
    {
        //get users waiting to be authorized from database
        $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
        $sql = "SELECT * FROM users WHERE userType!='administrator' AND userActive='0' ";
        $resource = mysqli_query($conn, $sql);
        if (mysqli_num_rows($resource)<1) {  //if none, display this
            echo "There are no users waiting to be authorized";
        } else {
            echo "<h2>Users Waiting To Be Authorized<br><table cellpadding='10px' border='2'>";
            echo "<tr><th>User ID</th><th>Forename</th><th>Surname</th><th>User Type</th><th>Authorize?</th></tr>";
            while ($row=mysqli_fetch_array($resource)) {
                $userID = $row['userID'];
                $userForename = $row['userForename'];
                $userSurname = $row['userSurname'];
                $userType = $row['userType'];

                echo "<tr><td>$userID</td><td>$userForename</td><td>$userSurname</td><td>$userType</td>";
                echo "<td><form name='authorize' method='post' action='adminAutoriza.php'>";
                echo "<input type='hidden' name='userID' value='$userID'/>";
                echo "<input type='submit' value='AUTHORIZE'/>";
                echo "</form></td></tr>";
            }
            echo "</table>";
        }
        mysqli_close($conn);
    }
function authorizeUser()
{
    //authorize the user
    $userID = $_POST['userID'];
    $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
    $sql = "UPDATE users SET userActive = 1 WHERE userID=$userID";
    if ($resource = mysqli_query($conn, $sql)) {
        echo "<p style='color:green'>Successfully authorized user</p>";
        header("Refresh:2;url='adminAutoriza.php' ");
    } else {
        echo "<p style='color:red'>Failed to authorized user. Contact Network Admin</p>";
    }
    mysqli_close($conn);
}
?>
<?php
include ("vista/include/piePagina.php");
?>
