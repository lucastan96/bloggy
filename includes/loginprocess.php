<?php
if (isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit;
}

require_once('connection.php');

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$query = "SELECT * FROM member WHERE email=:email";
$statement = $db->prepare($query);
$statement->bindValue(":email", $email);
$statement->execute();
$result_array = $statement->fetchAll();
$statement->closeCursor();

if (count($result_array)) {
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    foreach ($result_array as $result):
	$true_password = $result['password'];
    endforeach;

    if (!password_verify($password, $true_password)) {
	echo "HELLO";
	$message = "Either the email or password is incorrect. Try it again.";
    } else {
	session_start();

	foreach ($result_array as $result):
	    $_SESSION['id'] = $result['member_id'];
	    $_SESSION['user_status'] = $result['user_status'];
	endforeach;

	$_SESSION['login_user'] = $email;

	header("Location: ../index");
	exit();
    }
} else {
    $message = "Either the email or password is incorrect. Try it again.";
}

if (isset($message)) {
//    include ("../index");
    exit();
}