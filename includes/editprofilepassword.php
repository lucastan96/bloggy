<?php

session_start();

if (empty($_SESSION['login_user'])) {
    header("Location: index");
    exit;
}

require_once('connection.php');

$email = $_SESSION['login_user'];

$currentpassword = filter_input(INPUT_POST, 'currentpassword', FILTER_SANITIZE_STRING);
$newpassword = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING);
$confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING);

$query = "SELECT password FROM member WHERE email = :email";
$statement = $db->prepare($query);
$statement->bindValue(":email", $email);
$statement->execute();
$result_array = $statement->fetch();
$true_password = $result_array["password"];
$statement->closeCursor();

if (password_verify($currentpassword, $true_password)) {
    if ($newpassword == $confirmpassword) {
	$hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

	$query2 = "UPDATE member SET password = :password WHERE email = :email";
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
	$message = "Error: Your news password does not match.";
    }
} else {
    $message = "Error: Your current password is incorrect.";
}

if (isset($message)) {
    echo $message;
}