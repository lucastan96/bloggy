<?php

session_start();

if (empty($_SESSION['login_user'])) {
    header("Location: index");
    exit;
}

require_once('connection.php');

$email = $_SESSION['login_user'];
$id = $_SESSION['id'];

$first_name = filter_input(INPUT_POST, 'yourFirstName', FILTER_SANITIZE_STRING);
$last_name = filter_input(INPUT_POST, 'yourLastName', FILTER_SANITIZE_STRING);
$age = filter_input(INPUT_POST, 'yourAge', FILTER_SANITIZE_STRING);
$country_id = filter_input(INPUT_POST, 'yourCountry', FILTER_VALIDATE_INT);

$query3 = "UPDATE member_details SET first_name = :first_name , last_name = :last_name , age= :age, country_id=:country_id"
        . " WHERE member_id = :id";
$statement3 = $db->prepare($query3);
$statement3->bindValue(":first_name", $first_name);
$statement3->bindValue(":last_name", $last_name);
$statement3->bindValue(":age", $age);
$statement3->bindValue(":country_id", $country_id);
$statement3->bindValue(":id", $id);
$statement3->execute();
$statement3->closeCursor();


session_start();

$_SESSION['login_user'] = $email;

header("Location:../profile");

exit;

if (isset($message)) {
    include ("../profile.php");
    exit();
}