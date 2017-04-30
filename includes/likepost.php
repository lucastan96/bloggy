<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    $member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

    require_once('connection.php');

    $query1 = "SELECT post_like, post_likers FROM post WHERE post_id = :post_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":post_id", $post_id);
    $statement1->execute();
    $result_array1 = $statement1->fetchAll();
    $statement1->closeCursor();

    foreach ($result_array1 as $result1):
	$post_likes = $result1["post_like"];
	$post_likers = $result1["post_likers"];
    endforeach;

    $post_likers_array = explode(",", $post_likers);

    for ($i = 0; $i < sizeof($post_likers_array); $i++) {
	if ($post_likers_array[$i] == $member_id) {
	    $like_status = 1;
	    unset($post_likers_array[$i]);
	}
    }

    if ($like_status == 1) {
	$post_likers = implode(",", $post_likers_array);
	$post_likes--;
    } else {
	$post_likes++;
	if ($post_likers == "") {
	    $post_likers = $member_id;
	} else {
	    $post_likers = $post_likers . "," . $member_id;
	}
    }

    $query2 = "UPDATE post SET post_like = :post_likes, post_likers = :post_likers WHERE post_id = :post_id";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":post_likes", $post_likes);
    $statement2->bindValue(":post_likers", $post_likers);
    $statement2->bindValue(":post_id", $post_id);
    $statement2->execute();
    $statement2->closeCursor();

    header("Location: ../post?id=$post_id");
    exit();
} else {
    header("Location: ../index");
    exit();
}