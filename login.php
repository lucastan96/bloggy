<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
	<title>Sign In - Bloggy</title>
	<link href="styles/login.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

	<div class="banner">
	    <h2>Sign In</h2>
	    <p>Sign in now to post comments and vote posts! Or, register for a free account today!</p>
	</div>
	
	<div class='container main-content'>
	    <div class='row'>
		<div class="col-sm-6">
		    <div class='login-box'>
			<h3>Sign In</h3>
			<form action="loginProcess" method="post">
			    <?php
			    if (isset($login_message)) {
				echo "<div id='message' title='Click to Dismiss'>" . $login_message . "</div>";
			    }
			    ?>
			    <label for="inputEmail" class="sr-only">Username</label>
			    <input type="text" name="username" id="username" class="form-control no-border input" placeholder="Username" required autofocus>
			    <label for="inputPassword" class="sr-only">Password</label>
			    <input type="password" name="password" id="password" class="form-control no-border input" placeholder="Password" required>
			    <button class="btn btn-default no-border submit" type="submit">PROCEED</button>
			</form>
		    </div>
		</div>
		<div class="col-sm-6">
		    <div class='register-box'>
			<h3>Register</h3>
			<form action="registerProcess" method="post">
			    <?php
			    if (isset($register_message)) {
				echo "<div id='message' title='Click to Dismiss'>" . $register_message . "</div>";
			    }
			    ?>
			    <label for="inputEmail" class="sr-only">Username</label>
			    <input type="text" name="username" id="username" class="form-control no-border input" placeholder="Username" required autofocus>
			    <label for="inputPassword" class="sr-only">Password</label>
			    <input type="password" name="password" id="password" class="form-control no-border input" placeholder="Password" required>
			    <button class="btn btn-default no-border submit" type="submit">PROCEED</button>
			</form>
		    </div>
		</div>
	    </div>
	</div>

	<?php include("Includes/footer.php"); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
	    $(document).ready(function () {
		$(".right:nth-child(1)").addClass("active");
		$(".container").delay(200).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>