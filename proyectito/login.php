<?php
session_start();
include ("include/header.php");
include ("include/leftNav.php");
?>

<!--If username is set then login user, if not show login-->
<div class="row">
	<div class="column middle">
	<?php
	if (!isset($_POST['username'])) {
		showLogin();
	}
	else {
		doLogin();
	}
	?>
	</div>
</div>

<?php
function showLogin(){
//shows form for logging in
	echo("
	<form name='login' method='post' action='login.php' >
	Username <input type='text' name='username' /> <br />
	Password <input type='password' name='password' /> <br />
	<input type='submit' onclick='submit' />
	</form>
	");
}

function doLogin(){
//gets the posted variables to login
	$username = $_POST['username'];
	$password = $_POST['password'];

	$conn = mysqli_connect("localhost","root","root","classDatabase");
	$sql = "SELECT userID, userType FROM users
			WHERE username ='$username' AND userPassword ='$password' ";
	if ($resource = mysqli_query($conn,$sql)){
		checkLogin($resource);

	}
	else {
		echo ("<p style='color:red'>FAIL: Incorrect Username or Password... please try again />");
		header("Location: login.php");
	}
	mysqli_close($conn);
}

function checkLogin($resource) {
//check credentials entered
	if (mysqli_num_rows($resource) == 1) {
		$row = mysqli_fetch_array($resource);
		$_SESSION['userType'] = $row['userType'];
		$_SESSION['userID'] = $row['userID'];
		echo ("<p style='color:green'>LOGIN SUCCESS</p>");
		showLinkToUserPage();
	}
	else {
		echo ("<p style='color:red'>LOGIN FAIL: Incorrect Username or Password... please try again />");
	}
}

function showLinkToUserPage() {
//depending on user, show different link to their homepage
	if ($_SESSION['userType'] == "tutor"){
		echo ("<a href='tutorHome.php'>Click here for the tutor home page</a>");
	}
	else if ($_SESSION['userType'] == "student"){
		echo ("<a href='studentHome.php'>Click here for student home page</a>");
	}
	else if ($_SESSION['userType'] == "administrator"){
		echo ("<a href='adminHome.php'>Click here for administrator home page</a>");
	}
	else{
		echo("<a href='login.php'>Something went wrong... retry login or contact network admin</a>");
	}
}
include ("include/footer.php");
?>
