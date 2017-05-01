<?php

require_once('connection.php');


$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

$query = "SELECT member_id FROM member where email =:email";
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$result = $statement->fetch();
$statement->closeCursor();

$id = $result['member_id'];

$query1 = "DELETE FROM comment where member_id =:id";
$statement1 = $db->prepare($query1);
$statement1->bindValue(':id', $id);
$statement1->execute();
$statement1->closeCursor();

$query2 = "DELETE FROM post where member_id =:id";
$statement2 = $db->prepare($query2);
$statement2->bindValue(':id', $id);
$statement2->execute();
$statement2->closeCursor();

$query3 = "DELETE FROM member_details where member_id =:id";
$statement3 = $db->prepare($query3);
$statement3->bindValue(':id', $id);
$statement3->execute();
$statement3->closeCursor();

$query4 = "DELETE FROM member where member_id =:id";
$statement4 = $db->prepare($query4);
$statement4->bindValue(':id', $id);
$statement4->execute();
$statement4->closeCursor();

session_start();
session_destroy();

header("Location: ../index");
exit;
