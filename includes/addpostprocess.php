<?php

session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit;
}

require_once('connection.php');

$email = $_SESSION['login_user'];
$id = $_SESSION['id'];

$post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING);
$post_content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_STRING);
$post_tags = filter_input(INPUT_POST, 'post_tags', FILTER_SANITIZE_STRING);
$post_image = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);
$allow_comments = filter_input(INPUT_POST, 'allow_comments', FILTER_VALIDATE_INT);

$replaced_post_tags = str_replace(" ", "", $post_tags);

//$tags_array = explode(",", $replaced_post_tags);

$query1 = "INSERT INTO post (post_title, post_content, post_image, post_tags, allow_comments, member_id) VALUES (:post_title, :post_content, :post_image, :post_tags, :allow_comments, :member_id )";
$statement1 = $db->prepare($query1);
$statement1->bindValue(":post_title", $post_title);
$statement1->bindValue(":post_content", $post_content);
$statement1->bindValue(":post_image", $post_image);
$statement1->bindValue(":post_tags", $replaced_post_tags);
$statement1->bindValue(":allow_comments", $allow_comments);
$statement1->bindValue(":member_id", $id);
$statement1->execute();
$statement1->closeCursor();

header("Location: ../index");
exit();