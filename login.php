<?php
session_start();

if (isset($_SESSION['login_user'])) {
    header("Location: index");
    exit();
}

require_once 'includes/connection.php';

$query = "SELECT * FROM countries";
$statement = $db->prepare($query);
$statement->execute();
$result_array = $statement->fetchAll();
$statement->closeCursor();
?>
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
			<form action="includes/loginprocess" method="post">
			    <?php
			    if (isset($login_message)) {
				echo "<div id='message' title='Click to Dismiss'>" . $login_message . "</div>";
			    }
			    ?>
			    <label for="inputEmail" class="sr-only">Email</label>
			    <input type="email" name="email" id="username" class="form-control no-border input" placeholder="Email" required autofocus>
			    <label for="inputPassword" class="sr-only">Password</label>
			    <input type="password" name="password" id="password" class="form-control no-border input" placeholder="Password" required>
			    <button class="btn btn-default no-border submit" type="submit">PROCEED</button>
			</form>
		    </div>
		</div>
		<div class="col-sm-6">
		    <div class='register-box'>
			<h3>Register</h3>
			<form action="includes/registerprocess" method="post">
			    <?php
			    if (isset($register_message)) {
				echo "<div id='message' title='Click to Dismiss'>" . $register_message . "</div>";
			    }
			    ?>
			    <label for="registeremail" class="sr-only">Email</label>
			    <input type="email" name="registeremail" id="username" class="form-control no-border input" placeholder="Email" required autofocus>
			    <label for="yourFirstName" class="sr-only">First Name</label>
			    <input type="text" name="yourFirstName" id="firstname" class="form-control no-border input" placeholder="First Name" required>
			    <label for="yourLastName" class="sr-only">Last Name</label>
			    <input type="text" name="yourLastName" id="lastname" class="form-control no-border input" placeholder="Last Name" required>
			    <label for="yourAge" class="sr-only">Age</label>
			    <input type="text" name="yourAge" id="age" class="form-control no-border input" placeholder="Age" required>
			    <label for="yourCountry" class="sr-only">Country</label>
			    <select class="form-control no-border input" id="category" name="yourCountry" required>
				<option value="" selected="selected">Select a Country</option>
				<?php foreach ($result_array as $countries) : ?>
    				<option value="<?php echo $countries['country_id']; ?>"><?php echo htmlspecialchars($countries['country_name']); ?></option>
				<?php endforeach; ?>
			    </select>
			    <label for="inputPassword" class="sr-only">Password</label>
			    <input type="password" name="registerpassword" id="password" class="form-control no-border input" placeholder="Password" required>
			    <label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
			    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control no-border input" placeholder="Confirm Password" required>
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
		$(".banner").delay(100).animate({opacity: 1}, 300);
		$(".login-box, .register-box").delay(250).animate({opacity: 1}, 300);
	    });
	</script>
    </body>
</html>
