<?php
session_start();

require_once 'includes/connection.php';

if (!isset($_SESSION['login_user'])) {
    header("Location: login");
    exit();
} else {
    if ($_SESSION['user_status'] != 1 && $_SESSION['user_status'] != 2) {
	header("Location: index");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title>Create Post - Bloggy</title>
	<link href="styles/addpost.css" rel="stylesheet">
	<link href="Scripts/JasnyBootstrap/css/jasny-bootstrap.min.css" rel="stylesheet" media="screen">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class="banner">
	    <h2>Create Post</h2>
	    <p>You are great! You are awesome! Best post ever coming up!!</p>
	</div>

	<div class='container main-content'>
	    <form action="includes/addpostprocess" method="post">
		<?php
		if (isset($register_message)) {
		    echo "<div id='message' title='Click to Dismiss'>" . $register_message . "</div>";
		}
		?>
		<div class="form-group">
		    <label class="control-label col-sm-2" for="post_title">Title:</label>
		    <div class="col-sm-10">
			<input type="text" class="form-control input no-border" name="post_title" maxlength="100" placeholder="Enter post title" required autofocus>
		    </div>
		    <label class="control-label col-sm-2" for="post_content">Content:</label>
		    <div class="col-sm-10"> 
			<textarea class="form-control no-border" rows="20" maxlength="5000" name="post_content" id="letter" placeholder="Type your post. The maximum number of characters allowed is 5000." required></textarea>
		    </div>
		    <label class="control-label col-sm-2" for="post_tags">Tags:</label>
		    <div class="col-sm-10">
			<input type="text" class="form-control input no-border" name="post_tags" placeholder="Enter post tags, please separate tags using commas (,)." required>
		    </div>
		</div>
		<div class="form-group">
		    <label class="control-label col-sm-2" for="picture">Picture:</label>
		    <div class="col-sm-10"> 
			<div class="fileinput fileinput-new" data-provides="fileinput">
			    <div class="fileinput-preview thumbnail no-border" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
			    <div>
				<span class="btn btn-default btn-file no-border"><span class="fileinput-new">Choose Picture</span><span class="fileinput-exists">Change</span><input type="file" name="picture"></span>
				<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
			    </div>
			</div>
		    </div>
		</div>
		<div class="form-group">
		    <label class="control-label col-sm-2" for="allow_comments">Comments:</label>
		    <div class="col-sm-10 checkbox">
			<label class="checkbox-inline"><input type="checkbox" name="allow_comments" value="1" checked>Yes</label>
			<label class="checkbox-inline"><input type="checkbox" name="allow_comments" value="0">No</label>
		    </div>
		</div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
			<input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
			<button class="btn btn-default no-border submit" type="submit">PROCEED</button>
		    </div>
		</div>
	    </form>
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="scripts/JasnyBootstrap/js/jasny-bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".right:nth-child(1)").addClass("active");
		$(".banner").delay(100).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>