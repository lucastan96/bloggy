<?php
session_start();

require_once 'includes/connection.php';
require_once 'includes/checkinactivity.php';

if (!isset($_SESSION['login_user'])) {
    header("Location: login");
    exit();
} else {
    if (!isset($message)) {
	if (isset($_SESSION['profileUpdated'])) {
	    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your profile has been updated.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
	    $_SESSION['profileUpdated'] = null;
	} else if (isset($_SESSION['profilePasswordUpdated'])) {
	    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your profile password has been updated.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
	    $_SESSION['profilePasswordUpdated'] = null;
	} else if (isset($_SESSION['profilePicUpdated'])) {
	    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your profile picture has been updated.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
	    $_SESSION['profilePicUpdated'] = null;
	}
    }
}

$id = $_SESSION['id'];

$query = "SELECT * FROM member_details WHERE member_id = :id ";
$statement = $db->prepare($query);
$statement->bindValue(":id", $id);
$statement->execute();
$results_array = $statement->fetchAll();
$statement->closeCursor();

foreach ($results_array as $results):
    $first_name = $results["first_name"];
    $last_name = $results["last_name"];
    $profile_pic = $results["profile_pic"];
    $age = $results["age"];
    $country_id = $results["country_id"];
endforeach;

$query2 = "SELECT user_status, email FROM member WHERE member_id = :id";
$statement2 = $db->prepare($query2);
$statement2->bindValue(":id", $id);
$statement2->execute();
$results_array2 = $statement2->fetchAll();
$statement2->closeCursor();

foreach ($results_array2 as $results):
    $email = $results["email"];
    $user_status = $results["user_status"];
endforeach;

$query3 = "SELECT country_name FROM countries WHERE country_id = :country_id";
$statement3 = $db->prepare($query3);
$statement3->bindValue(":country_id", $country_id);
$statement3->execute();
$results_array3 = $statement3->fetch();
$country = $results_array3["country_name"];
$statement3->closeCursor();

$query4 = "SELECT * FROM countries";
$statement4 = $db->prepare($query4);
$statement4->execute();
$result_array4 = $statement4->fetchAll();
$statement4->closeCursor();

$query5 = "SELECT country_name FROM countries WHERE country_id = $country_id";
$statement5 = $db->prepare($query5);
$statement5->execute();
$result_array5 = $statement5->fetch();
$country_name = $result_array5['country_name'];
$statement5->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<?php include("Includes/head.php"); ?>
        <title>Profile - Bloggy</title>
        <link href="styles/profile.css" rel="stylesheet">
    </head>
    <body>
	<?php include("Includes/nav.php"); ?>

        <div class="banner">
            <h2>Profile</h2>
            <p>View and change your profile information and settings here!</p>
        </div>

        <div class='container main-content'>
	    <?php
	    if (isset($message)) {
		echo "<div id='message' title='Click to Dismiss'>" . $message . "</div>";
	    }
	    ?>
            <div class="profile-details">
                <div class='row'>
                    <div class='col-sm-6'>
                        <div class='profile-pic'><img src="images/profiles/<?php echo htmlspecialchars($profile_pic); ?>"></div>
                        <form method="post" class="profile-pic-update" action='profilePicUpdate' enctype="multipart/form-data">
                            <input id='file' type='file' class='btn btn-default profile-pic-button' name='picture' required>
                            <label class="btn btn-default no-border" for='file'>Choose</label>
                            <button type="submit" class="btn btn-default no-border">Update</button>
                        </form>
                    </div>
                    <div class='col-sm-6'>
                        <div class='profile-name'><?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?></div>
                        <div class='profile-status'>
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
                    </div>
                </div>

		<div class='profile-settings'>
                    <form class="form-horizontal" method="post" action="includes/editprofileprocess.php">
                        <h3>Personal Details</h3>
                        <p>Your personal details are displayed below, as well as an option to change your details.</p>
                        <br>
                        <div class="form-group">
                            <label class="control-label col-sm-1" for="yourFirstName">First name:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control no-border input" name="yourFirstName" value="<?php echo htmlspecialchars($first_name); ?>" title="First Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-1" for="yourLastName">Last Name:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control no-border input" name="yourLastName" value="<?php echo htmlspecialchars($last_name); ?>" title="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-1" for="yourAge">Age:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control no-border input" name="yourAge" value="<?php echo htmlspecialchars($age); ?>" title="Age" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="yourCountry" class="control-label col-sm-1">Country:</label>
                            <div class="col-sm-11">
                                <select class="form-control no-border input" id="category" name="yourCountry" required>
                                    <option value="<?php echo htmlspecialchars($country_id); ?>" selected="selected"><?php echo htmlspecialchars($country_name) ?></option>
				    <?php foreach ($result_array4 as $countries) : ?>
    				    <option value="<?php echo $countries['country_id']; ?>"><?php echo htmlspecialchars($countries['country_name']); ?></option>
				    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-default no-border submit" type="submit">UPDATE</button>
                        <br>
                    </form>
                </div>

                <div class='profile-settings'>
                    <form class="form-horizontal" method="post" action="editprofilepassword">
                        <h3>Account Details</h3>
                        <p>Your profile details are displayed below, as well as an option to change your password.</p>
                        <br>
                        <div class="form-group">
                            <label class="control-label col-sm-1" for="email">Email:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control no-border input" name="email" value="<?php echo htmlspecialchars($email); ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Please enter your email" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-1" for="currentpassword">Current Password:</label>
                            <div class="col-sm-11">
                                <input type="password" class="form-control no-border input" name="currentpassword" placeholder="Enter your current password" required>
                            </div>
                        </div>
			<div class="form-group">
                            <label class="control-label col-sm-1" for="newpassword">New Password:</label>
                            <div class="col-sm-11">
                                <input type="password" class="form-control no-border input" name="newpassword" placeholder="Enter your new password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-1" for="confirmpassword">Confirm Password:</label>
                            <div class="col-sm-11">
                                <input type="password" class="form-control no-border input" name="confirmpassword" placeholder="Confirm your new password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>
                        </div>
			<input type='hidden' name='email' value='<?php echo $email; ?>'>
                        <button class="btn btn-default no-border submit" type="submit">UPDATE</button>
                        <br>
                    </form>
                </div>
            </div>
        </div>

	<?php include("Includes/footer.php"); ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>');</script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="scripts/JasnyBootstrap/js/jasny-bootstrap.min.js"></script>
        <script>
	    $(document).ready(function () {
		$(".left:nth-child(4)").addClass("active");
		$(".banner").delay(100).animate({opacity: 1}, 300);
		$(".profile-details").delay(200).animate({opacity: 1}, 300);
		$("#message").click(function () {
		    $("#message").fadeOut();
		});
	    });
        </script>
    </body>
</html>
