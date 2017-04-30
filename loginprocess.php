<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    require_once('includes/connection.php');

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
	    $login_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your email or password is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
	} else {
	    session_start();

	    foreach ($result_array as $result):
		$_SESSION['id'] = $result['member_id'];
		$_SESSION['user_status'] = $result['user_status'];
	    endforeach;

	    $_SESSION['login_user'] = $email;
	    $_SESSION['last_time'] = time();

	    header("Location: index");
	    exit();
	}
    } else {
	$login_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your email or password is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($login_message)) {
	include ("login.php");
	exit();
    }
} else {
    header("Location: index");
    exit();
}