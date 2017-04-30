<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

$query1 = "SELECT member_id, email, user_status FROM member WHERE (user_status = 1 OR user_status = 2)";
$statement1 = $db->prepare($query1);
$statement1->execute();
$result_array1 = $statement1->fetchAll();
$statement1->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title>Writers - Bloggy</title>
	<link href="styles/writers.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class="banner">
	    <h2>Bloggy Writers</h2>
	    <p>Who are responsible for the awesome articles in Bloggy?</p>
	</div>

	<div class='container main-content'>
	    <?php foreach ($result_array1 as $result): ?>
		<?php
		$writer_user_status = $result["user_status"];
		$wrtier_member_id = $result["member_id"];
		$writer_email = $result["email"];
		
		$query2 = "SELECT first_name, last_name, age, country_id, profile_pic FROM member_details WHERE member_id = :member_id";
		$statement2 = $db->prepare($query2);
		$statement2->bindValue("member_id", $wrtier_member_id);
		$statement2->execute();
		$result_array2 = $statement2->fetchAll();
		$statement2->closeCursor();

		foreach ($result_array2 as $result):
		    $writer_first_name = $result["first_name"];
		    $writer_last_name = $result["last_name"];
		    $writer_age = $result["age"];
		    $writer_country_id = $result["country_id"];
		    $writer_profile_pic = $result["profile_pic"];
		endforeach;
		
		$query3 = "SELECT country_name FROM countries WHERE country_id = :country_id";
		$statement3 = $db->prepare($query3);
		$statement3->bindValue("country_id", $writer_country_id);
		$statement3->execute();
		$result_array3 = $statement3->fetch();
		$writer_country = $result_array3["country_name"];
		$statement3->closeCursor();
		?>
    	    <div class="writer">
		<div class="row">
		    <div class="col-sm-6">
			<div class="writer-pic"><img src="images/profiles/<?php echo htmlspecialchars($writer_profile_pic); ?>" alt="Profile Picture"></div>
		    </div>
		    <div class="col-sm-6">
			<h2><?php echo htmlspecialchars($writer_first_name) . " " . htmlspecialchars($writer_last_name); ?></h2>
			<div class='writer-status'>
			    <?php
			    if ($writer_user_status == 1) {
				$user_pos = "Writer";
			    } else if ($writer_user_status == 2) {
				$user_pos = "Admin";
			    }
			    echo "<span>" . $user_pos . "</span>";
			    ?>
                        </div>
			<div class="writer-details">
			    <p>Email: <?php echo htmlspecialchars($writer_email); ?></p>
			    <p>Country: <?php echo htmlspecialchars($writer_country); ?></p>
			    <p>Age: <?php echo htmlspecialchars($writer_age); ?></p>
			</div>
		    </div>
		</div>
    	    </div>
	    <?php endforeach ?>
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".left:nth-child(2)").addClass("active");
		$(".banner").delay(100).animate({opacity: 1}, 300);
		$(".writer").delay(200).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>
