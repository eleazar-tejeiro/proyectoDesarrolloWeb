<?php
	include ("include/header.php");
	include ("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
	<?php
	session_destroy();
	echo ("You have successfully logged out. Redirecting you back to the home page...");
	header("Refresh: 3; url=index.php");
	 ?>
	</div>
</div>
<?php
	include ("include/footer.php");
?>
