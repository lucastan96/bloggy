<?php

require_once('connection.php');

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

    $query1 = "DELETE FROM post where post_id =:post_id";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':post_id', $post_id);
    $statement1->execute();
    $statement1->closeCursor();

    $_SESSION['postDeleted'] = 1;

    header("Location:../myposts");
    exit;
} else {
    header("Location: ../index");
    exit();
}
