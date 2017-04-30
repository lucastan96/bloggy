<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

$tag_name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_URL);

if ($tag_name == "") {
    header("Location: index");
    exit();
} else {
    $query = "SELECT post_id, post_title, post_date, member_id FROM post WHERE post_tags LIKE '%$tag_name%' ORDER BY post_id DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result_array = $statement->fetchAll();
    $statement->closeCursor();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
        <title><?php echo htmlspecialchars($tag_name) ?> - Bloggy</title>
        <link href="styles/tag.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

        <div class='container main-content'>
            <div class="row">
		<div class="col-sm-8 posts">
		    <div class='post'>
			<h2><i class="fa fa-tag" aria-hidden="true"></i>Posts with Tag "<?php echo htmlspecialchars($tag_name); ?>"</h2>
		    </div>
		    <?php
		    if (!empty($result_array)) {
			foreach ($result_array as $result):
			    $author_id = $result["member_id"];

			    $query2 = "SELECT first_name, last_name, profile_pic FROM member_details WHERE member_id=:member_id";
			    $statement2 = $db->prepare($query2);
			    $statement2->bindValue(":member_id", $author_id);
			    $statement2->execute();
			    $result_array2 = $statement2->fetchAll();
			    $statement2->closeCursor();

			    foreach ($result_array2 as $result2):
				?>
	    		    <div class="post">
	    			<div class='post-details'>
	    			    <h2 class='post-title'><a href="post?id=<?php echo htmlspecialchars($result['post_id']); ?>"><?php echo htmlspecialchars($result['post_title']); ?></a></h2>
	    			    <a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title = '<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?>'><img class = "post-author-pic" src = "images/profiles/<?php echo htmlspecialchars($result2['profile_pic']); ?>" alt = "<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?> Photo"></a>
	    			    <div class = "post-author-name"><a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>'><?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']);
				?></a></div>
	    			    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
	    			</div>
	    		    </div>
				<?php
			    endforeach;
			endforeach;
		    } else {
			?>
    		    <div class="post">
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
	});
    </script>
</body>
</html>
