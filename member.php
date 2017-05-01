<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

$member_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_URL);

if ($member_id == "") {
    header("Location: writers");
    exit();
} else {
    $query1 = "SELECT email, user_status FROM member WHERE member_id = :member_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue("member_id", $member_id);
    $statement1->execute();
    $result_array1 = $statement1->fetchAll();
    $statement1->closeCursor();

    foreach ($result_array1 as $result):
	$user_status = $result["user_status"];
	$email = $result["email"];

	$query2 = "SELECT first_name, last_name, age, country_id, profile_pic FROM member_details WHERE member_id = :member_id";
	$statement2 = $db->prepare($query2);
	$statement2->bindValue("member_id", $member_id);
	$statement2->execute();
	$result_array2 = $statement2->fetchAll();
	$statement2->closeCursor();

	foreach ($result_array2 as $result):
	    $first_name = $result["first_name"];
	    $last_name = $result["last_name"];
	    $age = $result["age"];
	    $country_id = $result["country_id"];
	    $profile_pic = $result["profile_pic"];
	endforeach;

	$query3 = "SELECT country_name FROM countries WHERE country_id = :country_id";
	$statement3 = $db->prepare($query3);
	$statement3->bindValue("country_id", $country_id);
	$statement3->execute();
	$result_array3 = $statement3->fetch();
	$country = $result_array3["country_name"];
	$statement3->closeCursor();
    endforeach;

    if ($user_status != 0) {
	$query4 = "SELECT post_title, post_id, post_image, post_date FROM post WHERE member_id = :member_id ORDER BY post_id DESC";
	$statement4 = $db->prepare($query4);
	$statement4->bindValue("member_id", $member_id);
	$statement4->execute();
	$result_array4 = $statement4->fetchAll();
	$statement4->closeCursor();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title><?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?> - Bloggy</title>
	<link href="styles/member.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class='container main-content'>
	    <div class="row">
		<div class="col-sm-8 posts">
		    <div class='post'>
			<h2><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?></h2>
			<div class="member-pic"><img src="images/profiles/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture"></div>
			<div class='member-status'>
			    <?php
			    if ($user_status == 0) {
				$user_pos = "Member";
			    } else if ($user_status == 1) {
				$user_pos = "Writer";
			    } else if ($user_status == 2) {
				$user_pos = "Admin";
			    }
			    echo "<span>" . $user_pos . "</span>";
			    ?>
			</div>
			<div class="member-details">
			    <p>Email: <?php echo htmlspecialchars($email); ?></p>
			    <p>Country: <?php echo htmlspecialchars($country); ?></p>
			    <p>Age: <?php echo htmlspecialchars($age); ?></p>
			</div>
		    </div>
		    <?php if ($user_status != 0) { ?>
    		    <div class='post'>
    			<h2><i class="fa fa-pencil-square-o" aria-hidden="true"></i>All Posts</h2>
    		    </div>
			<?php foreach ($result_array4 as $result): ?>
			    <a href="post?id=<?php echo htmlspecialchars($result["post_id"]); ?>"><div class="post">
				    <h2 class="post-link">Post #<?php echo htmlspecialchars($result["post_id"]) . " - " . htmlspecialchars($result["post_title"]); ?></h2>
				    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
				    <?php if ($result['post_image'] != "") { ?>
	    			    <img class='post-image' src="images/uploads/<?php echo htmlspecialchars($result['post_image']); ?>" alt="Post Photo">
				    <?php } ?>
				</div></a>
			<?php endforeach; ?>
		    <?php } ?>
		</div>
		<?php include("includes/sidebar.php"); ?>
	    </div>
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".left:nth-child(2)").addClass("active");
		$(".post").delay(100).animate({opacity: 1}, 300);
		$(".sidebar").delay(200).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>
