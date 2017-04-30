<?php

session_start();

if (empty($_SESSION['login_user'])) {
    header("Location: index");
    exit;
}

require_once('connection.php');

$email = $_SESSION['login_user'];

$password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);
$confirmpassword = filter_input(INPUT_POST, 'confirmpassword',FILTER_SANITIZE_STRING);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if($password == $confirmpassword) {
    
    $query2 = "UPDATE member SET password= :password  WHERE email = :email";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(":email", $email);
    $statement2->bindValue(":password", $hashed_password);
    $statement2->execute();
    $statement2->closeCursor();
    
    session_start();

    $_SESSION['login_user'] = $email;
    header("Location:../profile");
    exit();
} else {
  $message = "The password does't match.Try it again";
}

if (isset($message)) {
    include ("../profile.php");
    exit();
}