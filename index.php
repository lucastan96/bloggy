<?php
session_start();

if (isset($_SESSION['first_login'])) {
    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Thank you for signing up for Bloggy!<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    $_SESSION['first_login'] = null;
} else if (isset($_SESSION['postAdded'])) {
    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your post has been published.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    $_SESSION['postAdded'] = null;
}

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

$get_page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_URL);

$query = "SELECT COUNT(*) FROM post";
$statement = $db->prepare($query);
$statement->execute();
$result_array = $statement->fetch(PDO::FETCH_NUM);
$post_count = $result_array[0];
$statement->closeCursor();

if ($get_page == "" || $get_page == 1) {
    $older = 2;
    $newer = 0;

    $query = "SELECT * FROM post ORDER BY post_id DESC LIMIT 5";
    $statement = $db->prepare($query);
    $statement->execute();
    $result_array = $statement->fetchAll();
    $statement->closeCursor();
} else {
    $page = $get_page * 5;
    $older = $get_page + 1;
    $newer = $get_page - 1;

    if (($older * 5 - 4) > $post_count) {
	$older = -1;
    }

    if ($page == 10) {
	$page = $page - 5;
    }

    $query = "SELECT * FROM post ORDER BY post_id DESC LIMIT 5,$page";
    $statement = $db->prepare($query);
    $statement->execute();
    $result_array = $statement->fetchAll();
    $statement->closeCursor();
}

function truncate($text, $chars = 25) {
    $text = $text . " ";
    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text . "...";
    return $text;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
        <title>Home - Bloggy</title>
        <link href="styles/index.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

        <div class='container main-content'>
            <div class="row">
		<?php if (!empty($result_array)) { ?>
    		<div class="col-sm-8 posts">
			<?php
			if (isset($message)) {
			    echo "<div id='message' title='Click to Dismiss'>" . $message . "</div>";
			}
			?>
			<?php
			foreach ($result_array as $result):
			    $author_id = $result['member_id'];
			    $post_id = $result['post_id'];

			    $query2 = "SELECT * FROM member_details WHERE member_id=:member_id";
			    $statement2 = $db->prepare($query2);
			    $statement2->bindValue(":member_id", $author_id);
			    $statement2->execute();
			    $result_array2 = $statement2->fetchAll();
			    $statement2->closeCursor();
                            
//                                                        for ($x = 0 ; $x<sizeof($result_array2) ; $x++){
//                                                            $post = new post_class($result_array2[$x]['post_id'], $result_array2[$x]['post_title'], $result_array2[$x]['post_content'], $result_array2[$x]['post_image'], $result_array2[$x]['post_date'], $result_array2[$x]['member_id']);
//                                                            $array_post[$x] = $post;
//                                                        }

			    foreach ($result_array2 as $result2):
				$tags_array = explode(",", $result["post_tags"]);
				?>
	    		    <div class='post'>
	    			<div class='post-details'>
	    			    <div class='row'>
	    				<div class="col-sm-10">
	    				    <h2 class='post-title'><a href="post?id=<?php echo htmlspecialchars($post_id); ?>"><?php echo htmlspecialchars($result['post_title']); ?></a></h2>
	    				    <div class='post-tags'>
						    <?php
						    $count = 0;
						    for ($i = 0; $i < sizeof($tags_array); $i++) {
							if ($count <= 3) {
							    ?>
		    					<span><a href='tag?name=<?php echo htmlspecialchars($tags_array[$i]); ?>'><?php echo htmlspecialchars($tags_array[$i]); ?></a></span>
							    <?php
							    $count++;
							}
						    }
						    ?>
	    				    </div>
	    				    <a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>' title = '<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?>'><img class = "post-author-pic" src = "images/profiles/<?php echo htmlspecialchars($result2['profile_pic']); ?>" alt = "<?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']); ?> Photo"></a>
	    				    <div class = "post-author-name"><a href = 'member?id=<?php echo htmlspecialchars($result['member_id']); ?>'><?php echo htmlspecialchars($result2['first_name'] . " " . $result2['last_name']);
						    ?></a></div>
	    				    <div class='post-date'><i class="fa fa-clock-o margin-true" aria-hidden="true"></i>Published on <?php echo htmlspecialchars($result['post_date']); ?></div>
	    				</div>
	    				<div class="col-sm-2">
	    				    <div class='post-stats'>
						    <?php
						    $query3 = "SELECT COUNT(*) FROM comment WHERE post_id = :post_id";
						    $statement3 = $db->prepare($query3);
						    $statement3->bindValue(":post_id", $post_id);
						    $statement3->execute();
						    $result_array3 = $statement3->fetch(PDO::FETCH_NUM);
						    $comment_count = $result_array3[0];
						    $statement3->closeCursor();
						    ?>
	    					<div class='post-votes-count' title='<?php echo htmlspecialchars($result["post_like"]); ?> Like(s)'><i class="fa fa-thumbs-up margin-true" aria-hidden="true"></i><?php echo htmlspecialchars($result["post_like"]); ?></div>
	    					<div class='post-comments-count' title='<?php echo $comment_count; ?> Comment(s)'><i class="fa fa-comments margin-true" aria-hidden="true"></i><?php echo $comment_count; ?></div>
	    				    </div>
	    				</div>
	    			    </div>
	    			</div>
				    <?php if ($result['post_image'] != "") { ?>
					<img class='post-image' src="images/uploads/<?php echo htmlspecialchars($result['post_image']); ?>" alt="Post Photo">
				    <?php } ?>
	    			<p class='post-content'><?php echo truncate(htmlspecialchars($result['post_content']), 200); ?></p>
	    			<a href="post?id=<?php echo htmlspecialchars($post_id); ?>" role="button" class="btn btn-default button no-border post-button"><i class="fa fa-arrow-right margin-true" aria-hidden="true"></i>Read More</a>
	    		    </div>
				<?php
			    endforeach;
			endforeach;
			?>
			<?php if ($older != -1) { ?>
			    <a href="index?page=<?php echo $older; ?>" role="button" class="btn btn-default no-border older"><i class="fa fa-arrow-circle-left margin-true" aria-hidden="true"></i>Older Posts</a>
			<?php } ?> 
			<?php if ($newer != 0) { ?>
			    <a href="index?page=<?php echo $newer; ?>" role="button" class="btn btn-default no-border newer"><i class="fa fa-arrow-circle-right margin-true" aria-hidden="true"></i>Newer Posts</a>
			<?php } ?>
    		</div>
		<?php } else {
		    ?>
    		<div class="col-sm-8 posts">
    		    <div class='post no-post'>
    			<h3><i class="fa fa-hand-paper-o margin-true" aria-hidden="true"></i>No posts yet, check back later!</h3>
    		    </div>
    		</div>
		    <?php
		}
		include("includes/sidebar.php");
		?>
	    </div>
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
	    $("#message").click(function () {
		$("#message").fadeOut();
	    });
	});
    </script>
</body>
</html>
