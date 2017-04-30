<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title>About - Bloggy</title>
	<link href="styles/about.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class="banner">
	    <h2>About Bloggy</h2>
	    <p>What is Bloggy and why is it created?</p>
	</div>

	<div class='container main-content'>
	    <div class="about-content">
		<h2><span>Bloggy</span> is a College Project!</h2>
		<h3>This website is made by Lucas & Alvin, students from Dundalk Institute of Technology, Dundalk, Ireland. This website is our final 2nd year assignment for Web Programming!</h3>
		<h3>We had a great time finishing this site!</h3>
		<img class="er-diagram" src="images/erdiagram.png" alt="ER Diagram">
	    </div>
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".left:nth-child(3)").addClass("active");
		$(".banner").delay(100).animate({opacity: 1}, 300);
		$(".about-content").delay(200).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>
