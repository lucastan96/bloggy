<?php
session_start();

require_once 'includes/connection.php';

if (!isset($_SESSION['login_user'])) {
    header("Location: login");
    exit();
}

$id = $_SESSION['id'];

$query = "SELECT * FROM member_details WHERE member_id = :id";
$statement = $db->prepare($query);
$statement->bindValue(":id", $id);
$statement->execute();
$results_array = $statement->fetchAll();
$statement->closeCursor();

foreach($results_array as $results):
    $first_name = $results["first_name"];
    $last_name = $results["last_name"];
endforeach;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title>Profile - Bloggy</title>
	<link href="styles/profile.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class="banner">
	    <h2><?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?></h2>
	    <p>View and change your profile information and settings here!</p>
	</div>

	<div class='container main-content'>
	    
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="scripts/JasnyBootstrap/js/jasny-bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".left:nth-child(4)").addClass("active");
		$(".banner").delay(100).animate({opacity: 1}, 300);
		$("form").delay(200).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>
