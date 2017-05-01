<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    require_once('includes/connection.php');
    require_once('includes/constants.php');

    $target_dir = "images/profiles/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check == FALSE) {
	$message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is not an image.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($message)) {
	include 'profile.php';
	exit();
    }

    if ($_FILES["picture"]["size"] > IMG_SIZE) {
	$message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is too large.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($message)) {
	include 'profile.php';
	exit();
    }

    if ($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
	$message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Only JPG, JPEG, PNG & GIF files allowed.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($message)) {
	include 'profile.php';
	exit();
    } else {
	session_start();

	if (empty($_SESSION['login_user'])) {
	    header("Location: index");
	    exit;
	}

	$member_id = $_SESSION["id"];

	$query1 = "SELECT profile_pic FROM member_details WHERE member_id = :member_id";
	$statement1 = $db->prepare($query1);
	$statement1->bindValue(":member_id", $member_id);
	$statement1->execute();
	$result_array1 = $statement1->fetch();
	$statement1->closeCursor();
	$profile_pic_old = $result_array1['profile_pic'];

	if ($profile_pic_old != "default.png") {
	    unlink("images/profiles/" . $profile_pic_old);
	}

	$pic_name = $target_dir . "member_" . $member_id . ".png";

	if (move_uploaded_file($_FILES["picture"]["tmp_name"], $pic_name)) {
	    $profile_pic_new = "member_" . $member_id . ".png";

	    $query2 = "UPDATE member_details SET profile_pic = :profile_pic WHERE member_id = :member_id";
	    $statement2 = $db->prepare($query2);
	    $statement2->bindValue(":profile_pic", $profile_pic_new);
	    $statement2->bindValue(":member_id", $member_id);
	    $statement2->execute();
	    $statement2->closeCursor();

	    $_SESSION['profilePicUpdated'] = 1;

	    header("Location: profile");
	    exit();
	}
    }
} else {
    header("Location: index");
    exit();
}