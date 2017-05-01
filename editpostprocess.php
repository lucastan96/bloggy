<?php

require_once('includes/connection.php');

$member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
$post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
$post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING);
$post_content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_STRING);
$post_tags = filter_input(INPUT_POST, 'post_tags', FILTER_SANITIZE_STRING);
$allow_comments = filter_input(INPUT_POST, 'allow_comments', FILTER_VALIDATE_INT);

if (!empty($_FILES['picture']['name'])) {
    $target_dir = "images/uploads/";
    $target_name = basename($_FILES["picture"]["name"]);
    $target_file = $target_dir . $target_name;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    $request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

    if ($request_method == 'POST') {
	$check = getimagesize($_FILES["picture"]["tmp_name"]);
	if ($check == FALSE) {
	    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is not an image.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
	}

	if (isset($message)) {
	    include 'editpost.php';
	    exit();
	}

	if ($_FILES["picture"]["size"] > 50000000) {
	    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is too large.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
	}

	if (isset($message)) {
	    include 'editpost.php';
	    exit();
	}

	if ($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
	    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Only JPG, JPEG, PNG & GIF files allowed.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
	}

	if (isset($message)) {
	    include 'editpost.php';
	    exit();
	} else {
	    unlink("images/uploads/" . $target_file);
	    
	    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
		$replaced_post_tags = strtolower(str_replace(" ", "", $post_tags));

		$query3 = "UPDATE post SET post_title = :post_title, post_content = :post_content, post_image = :post_image, post_tags = :post_tags, allow_comments = :allow_comments, member_id = :member_id WHERE post_id = :post_id";
		$statement3 = $db->prepare($query3);
		$statement3->bindValue(":post_title", $post_title);
		$statement3->bindValue(":post_content", $post_content);
		$statement3->bindValue(":post_image", $target_name);
		$statement3->bindValue(":post_tags", $replaced_post_tags);
		$statement3->bindValue(":allow_comments", $allow_comments);
		$statement3->bindValue(":member_id", $member_id);
		$statement3->bindValue(":post_id", $post_id);
		$statement3->execute();
		$statement3->closeCursor();

		$_SESSION['postEdited'] = 1;

		header('Location: post?id=' . $post_id);
		exit();
	    }
	}
    } else {
	header("Location: index");
	exit();
    }
} else {
    $replaced_post_tags = strtolower(str_replace(" ", "", $post_tags));

    $query3 = "UPDATE post SET post_title = :post_title, post_content = :post_content, post_tags = :post_tags, allow_comments = :allow_comments, member_id = :member_id WHERE post_id = :post_id";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":post_title", $post_title);
    $statement3->bindValue(":post_content", $post_content);
    $statement3->bindValue(":post_tags", $replaced_post_tags);
    $statement3->bindValue(":allow_comments", $allow_comments);
    $statement3->bindValue(":member_id", $member_id);
    $statement3->bindValue(":post_id", $post_id);
    $statement3->execute();
    $statement3->closeCursor();

    $_SESSION['postEdited'] = 1;

    header('Location: post?id=' . $post_id);
    exit();
}