<?php
$date = new DateTime();
$format_date = $date->format('Y-m-d');

$sidebar_query = "SELECT COUNT(*) FROM post WHERE post_date LIKE '%$format_date%'";
$statement = $db->prepare($sidebar_query);
$statement->execute();
$sidebar_result_array = $statement->fetch(PDO::FETCH_NUM);
$post_count = $sidebar_result_array[0];
$statement->closeCursor();

$sidebar_query2 = "SELECT post_id, post_title, post_like, post_image FROM post ORDER BY post_like DESC LIMIT 5";
$statement2 = $db->prepare($sidebar_query2);
$statement2->execute();
$sidebar_result_array2 = $statement2->fetchAll();
$statement2->closeCursor();
?>
<div class="col-sm-4">
    <?php
    if (isset($_SESSION['user_status'])) {
	if ($_SESSION['user_status'] == 1 || $_SESSION['user_status'] == 2) {
	    ?>
	    <div class="writer-tools sidebar">
		<?php
		if ($_SESSION['user_status'] == 1) { ?>
		<h3><i class="fa fa-wrench margin-true" aria-hidden="true"></i>Writer Tools</h3>
		<?php } else { ?>
		<h3><i class="fa fa-wrench margin-true" aria-hidden="true"></i>Admin Tools</h3>
		<?php } ?>
		<a href="addpost" role="button" class="btn btn-default no-border"><i class="fa fa-pencil margin-true" aria-hidden="true"></i>Create Post</a>
		<a href="myposts" role="button" class="btn btn-default no-border"><i class="fa fa-pencil-square-o margin-true" aria-hidden="true"></i>My Posts</a>
		<?php if ($_SESSION['user_status'] == 2) { ?>
	    	<a href="manage" role="button" class="btn btn-default no-border"><i class="fa fa-users margin-true" aria-hidden="true"></i>Manage Users</a>
		<?php } ?>
	    </div>
	    <?php
	}
    }
    ?>
    <div class="post-today sidebar">
	<h3><i class="fa fa-heart margin-true" aria-hidden="true"></i>Howdy!</h3>
	<?php if ($post_count == 0) { ?>
    	<p>We don't have any new articles for you yet today. Check back soon!</p>
	<?php } else { ?>
    	<p>We have <strong><?php echo htmlspecialchars($post_count); ?> new articles</strong> for you today. Enjoy!</p>
	<?php } ?>
    </div>
    <div class="post-trending sidebar">
	<h3><i class="fa fa-thumbs-up margin-true" aria-hidden="true"></i>Most Likes</h3>
	<p>Below are the posts with the most likes.</p>
	<?php foreach ($sidebar_result_array2 as $result): ?>
    	<div class='post-trending-content'>
		<?php if ($result["post_image"] != "") { ?>
		    <a href="post?id=<?php echo htmlspecialchars($result["post_id"]); ?>"><img src="images/uploads/<?php echo htmlspecialchars($result["post_image"]); ?>" alt="Post Photo" title="<?php echo htmlspecialchars($result["post_title"]); ?>"></a>
		<?php } else { ?>
		    <a href="post?id=<?php echo htmlspecialchars($result["post_id"]); ?>" title="<?php echo htmlspecialchars($result["post_title"]); ?>"><div class="image-placeholder"></div></a>
		<?php } ?>
    	    <div class='post-trending-title'><a href='post?id=<?php echo htmlspecialchars($result["post_id"]); ?>'><?php echo htmlspecialchars($result["post_title"]); ?></a></div>
		<?php
		$sidebar_query3 = "SELECT COUNT(*) FROM comment WHERE post_id = :post_id";
		$statement3 = $db->prepare($sidebar_query3);
		$statement3->bindValue("post_id", $result["post_id"]);
		$statement3->execute();
		$sidebar_result_array3 = $statement3->fetch(PDO::FETCH_NUM);
		$comment_count = $sidebar_result_array3[0];
		$statement3->closeCursor();
		?>
    	    <div class='post-trending-stats'>
    		<i class="fa fa-thumbs-up " aria-hidden="true"></i><?php echo htmlspecialchars($result["post_like"]); ?>
    		<i class="fa fa-comments" aria-hidden="true"></i><?php echo htmlspecialchars($comment_count); ?>
    	    </div>
    	</div>
	<?php endforeach;
	?>
    </div>
    <div class="social sidebar">
	<h3><i class="fa fa-plus-circle margin-true" aria-hidden="true"></i>Follow Us!</h3>
	<a href='https://facebook.com/' target='_blank' title='Facebook'><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
	<a href='https://twitter.com/' target='_blank' title='Twitter'><i class="fa fa-twitter" aria-hidden="true"></i></a>
	<a href='https://plus.google.com/' target='_blank' title='Google+'><i class="fa fa-google-plus-official" aria-hidden="true"></i></a>
	<a href='https://instagram.com/' target='_blank' title='Instagram'><i class="fa fa-instagram" aria-hidden="true"></i></a>
    </div>
</div>