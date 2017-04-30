<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

$search = filter_input(INPUT_GET, 'query');

$query1 = "SELECT * FROM member_details WHERE (first_name LIKE '%$search%' OR last_name LIKE '%$search%') ORDER BY first_name";
$statement1 = $db->prepare($query1);
$statement1->execute();
$result_array1 = $statement1->fetchAll();
$statement1->closeCursor();

$query2 = "SELECT post_id, post_title, post_date, member_id FROM post WHERE post_date LIKE '%$search%' ORDER BY post_id DESC";
$statement2 = $db->prepare($query2);
$statement2->execute();
$result_array2 = $statement2->fetchAll();
$statement2->closeCursor();

$query3 = "SELECT post_id, post_title, post_date, member_id FROM post WHERE post_tags LIKE '%$search%' ORDER BY post_id DESC";
$statement3 = $db->prepare($query3);
$statement3->execute();
$result_array3 = $statement3->fetchAll();
$statement3->closeCursor();

$query4 = "SELECT post_id, post_title, post_date, member_id FROM post WHERE (post_content LIKE '%$search%' OR post_title LIKE '%$search%') ORDER BY post_id DESC";
$statement4 = $db->prepare($query4);
$statement4->execute();
$result_array4 = $statement4->fetchAll();
$statement4->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
        <title>Search - Bloggy</title>
        <link href="styles/search.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

        <div class='container main-content'>
            <div class="row">
		<div class="col-sm-8 posts">
		    <div class='post'>
			<h2>Results with "<?php echo htmlspecialchars($search); ?>"</h2>
		    </div>
		    <?php if (!empty($result_array1)) { ?>
    		    <div class="post">
    			<h4><i class="fa fa-users fa-fw margin-true" aria-hidden="true"></i>People Search</h4>
			    <?php
			    foreach ($result_array1 as $result):
				?>
				<div class='post-details person-search'>
				    <a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title = '<?php echo htmlspecialchars($result['first_name'] . " " . $result['last_name']); ?>'><img class = "post-author-pic" src = "images/profiles/<?php echo htmlspecialchars($result['profile_pic']); ?>" alt = "<?php echo htmlspecialchars($result['first_name'] . " " . $result['last_name']); ?> Photo"></a>
				    <h3 class='post-title'><a href="member?id=<?php echo htmlspecialchars($result['member_id']); ?>"><?php echo htmlspecialchars($result['first_name']) . " " . htmlspecialchars($result['last_name']); ?></a></h3>
				</div>
				<?php
			    endforeach;
			    ?>
    		    </div>
		    <?php } else {
			?>
    		    <div class="post">
    			<h4><i class="fa fa-users fa-fw margin-true" aria-hidden="true"></i>People Search</h4>
    			<h3>No results found.</h3>
    		    </div>
		    <?php } ?>
		    <?php if (!empty($result_array2)) { ?>
    		    <div class="post">
    			<h4><i class="fa fa-calendar fa-fw margin-true" aria-hidden="true"></i>Date Search</h4>
			    <?php
			    foreach ($result_array2 as $result):
				$author_id = $result["member_id"];

				$query5 = "SELECT first_name, last_name, profile_pic FROM member_details WHERE member_id=:member_id";
				$statement5 = $db->prepare($query5);
				$statement5->bindValue(":member_id", $author_id);
				$statement5->execute();
				$result_array5 = $statement5->fetchAll();
				$statement5->closeCursor();

				foreach ($result_array5 as $result2):
				    ?>

	    			<div class='post-details'>
	    			    <h3 class='post-title'><a href="post?id=<?php echo htmlspecialchars($result['post_id']); ?>"><?php echo htmlspecialchars($result['post_title']); ?></a></h3>
	    			    <a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title = '<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?>'><img class = "post-author-pic" src = "images/profiles/<?php echo htmlspecialchars($result2['profile_pic']); ?>" alt = "<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?> Photo"></a>
	    			    <div class = "post-author-name"><a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>'><?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']);
				    ?></a></div>
	    			    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
	    			</div>
				    <?php
				endforeach;
			    endforeach;
			    ?>
    		    </div>
		    <?php } else {
			?>
    		    <div class="post">
    			<h4><i class="fa fa-calendar fa-fw margin-true" aria-hidden="true"></i>Date Search</h4>
    			<h3>No results found.</h3>
    		    </div>
		    <?php } ?>
		    <?php if (!empty($result_array3)) { ?>
    		    <div class="post">
    			<h4><i class="fa fa-tags fa-fw margin-true" aria-hidden="true"></i>Tag Search</h4>
			    <?php
			    foreach ($result_array3 as $result):
				$author_id = $result["member_id"];

				$query5 = "SELECT first_name, last_name, profile_pic FROM member_details WHERE member_id=:member_id";
				$statement5 = $db->prepare($query5);
				$statement5->bindValue(":member_id", $author_id);
				$statement5->execute();
				$result_array5 = $statement5->fetchAll();
				$statement5->closeCursor();

				foreach ($result_array5 as $result2):
				    ?>

	    			<div class='post-details'>
	    			    <h3 class='post-title'><a href="post?id=<?php echo htmlspecialchars($result['post_id']); ?>"><?php echo htmlspecialchars($result['post_title']); ?></a></h3>
	    			    <a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title = '<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?>'><img class = "post-author-pic" src = "images/profiles/<?php echo htmlspecialchars($result2['profile_pic']); ?>" alt = "<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?> Photo"></a>
	    			    <div class = "post-author-name"><a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>'><?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']);
				    ?></a></div>
	    			    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
	    			</div>
				    <?php
				endforeach;
			    endforeach;
			    ?>
    		    </div>
		    <?php } else {
			?>
    		    <div class="post">
    			<h4><i class="fa fa-tags fa-fw margin-true" aria-hidden="true"></i>Tag Search</h4>
    			<h3>No results found.</h3>
    		    </div>
		    <?php } ?>
		    <?php if (!empty($result_array4)) { ?>
    		    <div class="post">
    			<h4><i class="fa fa-key fa-fw margin-true" aria-hidden="true"></i>Keyword Search</h4>
			    <?php
			    foreach ($result_array4 as $result):
				$author_id = $result["member_id"];

				$query5 = "SELECT first_name, last_name, profile_pic FROM member_details WHERE member_id=:member_id";
				$statement5 = $db->prepare($query5);
				$statement5->bindValue(":member_id", $author_id);
				$statement5->execute();
				$result_array5 = $statement5->fetchAll();
				$statement5->closeCursor();

				foreach ($result_array5 as $result2):
				    ?>

	    			<div class='post-details'>
	    			    <h3 class='post-title'><a href="post?id=<?php echo htmlspecialchars($result['post_id']); ?>"><?php echo htmlspecialchars($result['post_title']); ?></a></h3>
	    			    <a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title = '<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?>'><img class = "post-author-pic" src = "images/profiles/<?php echo htmlspecialchars($result2['profile_pic']); ?>" alt = "<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?> Photo"></a>
	    			    <div class = "post-author-name"><a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>'><?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']);
				    ?></a></div>
	    			    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
	    			</div>
				    <?php
				endforeach;
			    endforeach;
			    ?>
    		    </div>
		    <?php } else {
			?>
    		    <div class="post">
    			<h4><i class="fa fa-key fa-fw margin-true" aria-hidden="true"></i>Keyword Search</h4>
    			<h3>No results found.</h3>
    		    </div>
		    <?php } ?>
		</div>
		<?php include("includes/sidebar.php"); ?>
	    </div>
	</div>
    </div>

    <?php include("Includes/footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script>
	$(document).ready(function () {
	    $(".left:nth-child(1)").addClass("active");
	    $(".post").delay(100).animate({opacity: 1}, 300);
	    $(".sidebar").delay(200).animate({opacity: 1}, 300);
	    $('[data-toggle="tooltip"]').tooltip();
	});
    </script>
</body>
</html>
