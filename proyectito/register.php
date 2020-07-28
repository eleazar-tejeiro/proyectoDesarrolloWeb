<?php
include("include/header.php");
include("include/leftNav.php");
?>

<!--Either shows the registration form, or adds the user to the database -->
<div class="row">
	<div class="column middle">
	<?php
    if (isset($_POST['forename'])) {
        addUserToDatabase();
    } else {
        /* if adding an admin, comment out the showForm() function and remove '//' from addAdminToDatabase()
        To see admin credentials being added, go to function below. Change the 'Values' in SQL statement for a new admin*/
        //addAdminToDatabase();
        showForm();
    }
    ?>
	</div>
</div>

<?php
//shows the form to register to the user
function showForm()
{
    echo " <form name='register' method='post' action='register.php'>
		Forename		  <input type='text' name='forename'/> <br />
		Surname  		  <input type='text' name='surname'/> <br />
		Username 		  <input type='text' name='username'/> <br />
		Password		  <input type='password' name='password'/> <br />
		Confirm Password  <input type='password' name='cpassword'/> <br />
		Tutor / Student   <select name='type' />
							<option value='tutor'>Tutor</option>
							<option value='student'>Student</option> </select>
		<input type='submit' onclick='submit' />
		</form>";
}

function addUserToDatabase()
{
    //adds the information entered by the user to the table
    $forename = $_POST['forename'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $type = $_POST['type'];

    //check if username exists
    $conn = mysqli_connect('localhost', 'root', '', 'classDatabase');
    $sql = "SELECT username FROM users WHERE username='$username' ";
    $resource= mysqli_query($conn, $sql);

    if ($password!=$cpassword) {
        echo "<br>Passwords do not match, please enter info again";
        echo "<br>Refreshing in 3 seconds...";
        header("Refresh:3; url=register.php");
    } elseif (mysqli_num_rows($resource)>0) {
        echo "<br>Username already has been used, please select another.";
        echo "<br>Refreshing in 3 seconds...";
        header("Refresh:3; url=register.php");
    } else {
        $sql = "INSERT INTO users (userForename, userSurname, username, userPassword, userType, userActive)
				VALUES ('$forename', '$surname', '$username', '$password', '$type', 0)";

        //check if registered successfully
        if (mysqli_query($conn, $sql)) {
            echo("<p style='color:green'>Successfully Registered</p>");
            echo("<a href='login.php'>Click here to log in now</a>");
        } else {
            echo("<p style='color:red'>Failed to Register: <br/> ");
            echo(mysqli_error($conn));
            echo("<br/>Contact Network Admin</p>");
        }
    }
    mysqli_close($conn);
}

function addAdminToDatabase()
{
    //this is to hardcode administrators into the system; only change first 4 sql values to create a new admin, then call function line 16
    $conn = mysqli_connect('localhost', 'root', '', 'classDatabase');
    $sql = "INSERT INTO users (userForename, userSurname, username, userPassword, userType, userActive)
				VALUES ('Neil', 'Buckley', 'admin', 'password', 'administrator', 1)";
    if (mysqli_query($conn, $sql)) {
        echo("<p style='color:green'>Successfully Created Adminstrator</p>");
        echo("<a href='login.php'>Click here to log in now</a>");
    } else {
        echo("<p style='color:red'>Failed to Create Admin: <br/> ");
        echo(mysqli_error($conn));
        echo("<br/>Contact Network Admin for assistance</p>");
    }
    mysqli_close($conn);
}

include("include/footer.php");
?>
