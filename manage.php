<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

if (!isset($_SESSION['login_user'])) {
    header("Location: login");
    exit();
} else {
    if ($_SESSION['user_status'] != 2) {
	header("Location: index");
	exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title>Manage Users - Bloggy</title>
	<link href="styles/manage.css" rel="stylesheet">
	<link href="Scripts/JasnyBootstrap/css/jasny-bootstrap.min.css" rel="stylesheet" media="screen">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class="banner">
	    <h2>Manage Users</h2>
	    <p>Promote/demote user statuses here!</p>
	</div>

	<div class='container main-content'>
	    <?php
	    if (isset($message)) {
		echo "<div id='message' title='Click to Dismiss'>" . $message . "</div>";
	    }
	    ?>
	    <form>
		
	    </form>
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="scripts/JasnyBootstrap/js/jasny-bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".left:nth-child(2)").addClass("active");
		$(".banner").delay(100).animate({opacity: 1}, 300);
		$("form").delay(250).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>
