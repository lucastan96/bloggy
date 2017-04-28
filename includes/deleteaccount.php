<?php

require_once('includes/connection.php');


$member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);

$query = "DELETE FROM comment where member_id =:member_id";
$statement = $db->prepare($query);
$statement->bindValue(':member_id', $member_id);
$statement->execute();
$statement->closeCursor();

$query1 = "DELETE FROM post where member_id =:member_id";
$statement1 = $db->prepare($query1);
$statement1->bindValue(':member_id', $member_id);
$statement1->execute();
$statement1->closeCursor();

$query2 = "DELETE FROM member,member_details where member_id =:member_id";
$statement2 = $db->prepare($query2);
$statement2->bindValue(':member_id', $member_id);
$statement2->execute();
$statement2->closeCursor();


header("Location:userview.php");
exit;
