<?php
session_start();

require_once('connection.php');

$comment_text = filter_input(INPUT_POST, 'comment_text', FILTER_SANITIZE_STRING);
$id = $_SESSION['id'];
$post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

$query2 = "INSERT INTO comment (comment_text , member_id , post_id) VALUES (:comment_text , :id , :post_id);";
$statement2 = $db->prepare($query2);
$statement2->bindValue(":comment_text", $comment_text);
$statement2->bindValue(":id", $id);
$statement2->bindValue(":post_id", $post_id);
$statement2->execute();
$statement2->closeCursor(); 

header('Location: ../post?id='.$post_id);
exit();