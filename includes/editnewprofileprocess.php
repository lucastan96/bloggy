<?php

session_start();

if (empty($_SESSION['login_user'])) {
    header("Location: index.php");
    exit;
}

require_once('includes/connection.php');



$member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT,FILTER_SANITIZE_NUMBER_INT);


$password = filter_input(INPUT_POST, 'registerpassword', FILTER_SANITIZE_STRING);
$confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, 'yourName', FILTER_SANITIZE_STRING);
$age = filter_input(INPUT_POST, 'yourAge', FILTER_SANITIZE_INT);
$mobile = filter_input(INPUT_POST, 'yourMobile', FILTER_SANITIZE_STRING);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
if ($password == $confirmpassword) {


    $query2 = "UPDATE member SET password= :password  WHERE member_id = :member_id";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":member_id", $member_id);
    $statement2->bindValue(":password", $hashed_password);
    $statement2->execute();
    $statement2->closeCursor();

    $query3 = "UPDATE member_details,member SET name = :name , age= :age, mobile=:mobile"
            . " WHERE member.member_id =:member_id   and member.member_id=member_details.member_id";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(":member_id", $member_id);
    $statement3->bindValue(":name", $name);
    $statement3->bindValue(":age", $age);
    $statement3->bindValue(":mobile", $mobile);
    $statement3->execute();
    $statement3->closeCursor();



    header("Location:userview.php");
} else {
    $message = "The password does't match. Try it again";
}

if (isset($message)) {
    include ("register.php");
    exit();
}