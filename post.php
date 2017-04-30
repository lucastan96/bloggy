<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

$post_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_URL);

if ($post_id == "") {
    header("Location: index");
    exit();
} else {
    $query = "SELECT * FROM post WHERE post_id = :post_id";
    $statement = $db->prepare($query);
    $statement->bindValue(":post_id", $post_id);
    $statement->execute();
    $result_array = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($result_array as $result):
	$post_title = $result["post_title"];
	$post_content = $result["post_content"];
	$post_image = $result["post_image"];
	$post_date = $result["post_date"];
	$post_tags = $result["post_tags"];
	$post_like = $result["post_like"];
	$allow_comments = $result["allow_comments"];
	$author_id = $result['member_id'];
    endforeach;

    $query3 = "SELECT * FROM comment WHERE post_id = :post_id ORDER BY comment_id DESC";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":post_id", $post_id);
    $statement3->execute();
    $result_array3 = $statement3->fetchAll();
    $statement3->closeCursor();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
        <title><?php echo htmlspecialchars($post_title) ?> - Bloggy</title>
        <link href="styles/post.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

        <div class='container main-content'>
            <div class="row">
		<div class="col-sm-8 posts">
		    <?php
		    if (!empty($result_array)) {
			foreach ($result_array as $result):
			    $query2 = "SELECT first_name, last_name, profile_pic FROM member_details WHERE member_id=:member_id";
			    $statement2 = $db->prepare($query2);
			    $statement2->bindValue(":member_id", $author_id);
			    $statement2->execute();
			    $result_array2 = $statement2->fetchAll();
			    $statement2->closeCursor();

			    foreach ($result_array2 as $result2):
				$tags_array = explode(",", $result["post_tags"]);
				?>
	    		    <div class='post'>
	    			<div class='post-details'>
	    			    <div class='row'>
	    				<div class="col-sm-10">
	    				    <h2 class='post-title'><?php echo htmlspecialchars($result['post_title']); ?></h2>
	    				    <a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title = '<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?>'><img class = "post-author-pic" src = "images/profiles/<?php echo htmlspecialchars($result2['profile_pic']); ?>" alt = "<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?> Photo"></a>
	    				    <div class = "post-author-name"><a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>'><?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']);
				?></a></div>
	    				    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
	    				</div>
	    				<div class="col-sm-2">
	    				    <div class='post-stats'>
	    					<div class='post-votes-count' title='103 Like(s)'><i class="fa fa-thumbs-up margin-true" aria-hidden="true"></i>0</div>
	    					<div class='post-comments-count' title='<?php echo sizeof($result_array3); ?> Comment(s)'><i class="fa fa-comments margin-true" aria-hidden="true"></i><?php echo sizeof($result_array3); ?></div>
	    				    </div>
	    				</div>
	    			    </div>
	    			</div>
				    <?php if ($result['post_image'] != "") { ?>
					<img class='post-image' src="images/uploads/<?php echo htmlspecialchars($result['post_image']); ?>" alt="Post Photo">
				    <?php } ?>
	    			<p class='post-content'><?php echo htmlspecialchars($result['post_content']); ?></p>
	    			<div class='post-tags'>
	    			    <strong>Tags:</strong>&nbsp;&nbsp;
					<?php
					for ($i = 0; $i < sizeof($tags_array); $i++) {
					    ?>
					    <span><a href='tag?name=<?php echo htmlspecialchars($tags_array[$i]); ?>'><?php echo htmlspecialchars($tags_array[$i]); ?></a></span>
					<?php } ?>
	    			    &nbsp;
	    			    &nbsp;
	    			</div>
				<div class="post-likes">
				    
				</div>
	    		    </div>
				<?php
			    endforeach;
			endforeach;
		    }
		    ?>
		    <div class='post'>
			<div class="post-comments">
			    <h3>Comments</h3>
			    <?php
			    if ($allow_comments == 1) {
				if (isset($_SESSION['login_user'])) {
				    ?>
				    <form action="includes/addcommentprocess" method="post">
					<div class="input-group">
					    <input type="text" class="form-control no-border search" placeholder="Post a comment as <?php echo htmlspecialchars($name); ?>" name="comment_text">
					    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
					    <span class="input-group-btn">
						<button class="btn btn-default no-border search" type="submit"><i class="fa fa-pencil" aria-hidden="true"></i></button>
					    </span>
					</div>
				    </form>
				<?php } else { ?>
				    <h4><a href='login'>Sign in or register</a> to post comments!</h4>
				    <?php
				}
			    }
			    ?>

			    <?php if ($allow_comments == 1) { ?>
				<?php
				if (!empty($result_array3)) {
				    foreach ($result_array3 as $results):
					$comment_text = $results["comment_text"];
					$comment_date = $results["comment_date"];
					$comment_member_id = $results["member_id"];

					$query4 = "SELECT first_name, last_name, profile_pic FROM member_details WHERE member_id = :member_id";
					$statement4 = $db->prepare($query4);
					$statement4->bindValue(":member_id", $author_id);
					$statement4->execute();
					$result_array4 = $statement4->fetch();
					$statement4->closeCursor();

					foreach ($result_array4 as $results):
					    $member_first_name = $result_array4["first_name"];
					    $member_last_name = $result_array4["last_name"];
					    $member_profile_pic = $result_array4["profile_pic"];
					endforeach;
					?>
	    			    <div class="comment">
	    				<img class="comment_profile_pic" src="images/profiles/<?php echo htmlspecialchars($member_profile_pic); ?>">
	    				<div class="comment_name"><?php echo htmlspecialchars($member_first_name) . " " . htmlspecialchars($member_last_name); ?></div>
	    				<div class="comment_date">Posted on <?php echo htmlspecialchars($comment_date); ?></div>
	    				<div class="comment_text"><?php echo htmlspecialchars($comment_text); ?></div>
	    			    </div>
					<?php
				    endforeach;
				} else {
				    ?>
				    <h4><i class="fa fa-hand-paper-o margin-true" aria-hidden="true"></i>No comments yet, Write one now!</h4>
				<?php } ?>
			    <?php } else { ?>
    			    <h4>Comments has been disabled for this post.</h4>
			    <?php } ?>
			</div>
		    </div>
		</div>
		<?php include("includes/sidebar.php"); ?>
	    </div>
	</div>

	<?php include("includes/footer.php"); ?>

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