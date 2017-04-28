<?php

session_start();

require_once('connection.php');

$comment_text = $_POST['comment_text'];
$id = $_SESSION['id'];
$post_id = $_POST['post_id'];



$query2 = "INSERT INTO comment (comment_text , member_id , post_id) VALUES (:comment_text , :id , :post_id);";
$statement2 = $db->prepare($query2);
$statement2->bindValue(":comment_text", $comment_text);
$statement2->bindValue(":id", $id);
$statement2->bindValue(":post_id", $post_id);
$statement2->execute();
$statement2->closeCursor(); 

header('location: ../post.php?id='.$post_id);
