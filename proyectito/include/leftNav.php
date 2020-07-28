<?php
if (session_status() === PHP_SESSION_NONE)
{
	session_start();
}
?>
<!--Left Navigation Bar Information -->
<div class="row">
	<div class="column side">
		<ul class="menu">
			<?php logInOut();
			selectMenu();?>
		</ul>
	</div>

<?php

function logInOut() {
//function to show either 'log in' or 'Log out' on side bar
	if (!isset($_SESSION['userType']))
	{
		echo "<li><a href='register.php'>Register</a></li>";
		echo "<li><a href='login.php'>Login</a></li>";
	}
	else
	{
		echo "<li><a href='logout.php'>Logout</a></li>";
	}
}

function selectMenu(){
//function to select what menu is displayed
	if (isset($_SESSION['userType']))
	{
		if($_SESSION['userType'] == "tutor")
		{
			tutorMenu();
		}
		else if ($_SESSION['userType'] == "student")
		{
			studentMenu();
		}
		else if ($_SESSION['userType'] == "administrator"){
			adminMenu();
		}
	}
}

function tutorMenu() {
//function for the tutor options
	echo "<li><a href='tutorHome.php'>Home</a></li>
		<li><a href='tutorUserGrades.php'>Student's Grades</a></li>
		<li><a href='tutorNewCourse.php'>Add New Course</a></li>
		<li><a href='tutorUpload.php'>Upload a Resource</a></li>
		<li><a href='tutorAuthoStud.php'>Authorize Student</a></li>
		<li><a href='tutorAddStud.php'>Add Student</a></li>";
}

function studentMenu() {
//function for student options
	echo "<li><a href='studentHome.php'>Home</a></li>
		<li><a href='studentEnroll.php'>Enroll on Course</a></li>
		<li><a href='studentCourses.php'>Courses</a></li>
		<li><a href='studentGrades.php'>Grades</a></li>";
}

function adminMenu() {
//function for the admin options
	echo "<li style='color:black; font-size:24px; font-weight:bold'>Admin Links</li>
		<li><a href='adminHome.php'>Home</a></li>
		<li><a href='adminAuthorize.php'>Authorize Users</a></li>
		<li><a href='adminDisplayTables.php'>Display Database Tables</a></li>
		<li><a href='adminCreateTables.php'>Create Database Tables</a></li>
		<li style='color:black; font-size:24px; font-weight:bold'>Tutor Links</li>
		<li><a href='tutorShowUsers.php'>Show Users</a></li>
		<li><a href='tutorAuthoStud.php'>Authorize Student</a></li>
		<li><a href='tutorAddStud.php'>Add Student</a></li>";
}
?>
