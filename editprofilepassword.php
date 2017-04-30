<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    require_once('includes/connection.php');

    $currentpassword = filter_input(INPUT_POST, 'currentpassword', FILTER_SANITIZE_STRING);
    $newpassword = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING);
    $confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

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
	    
	    $_SESSION['profilePasswordUpdated'] = 1;
	    
	    header("Location: profile");
	    exit();
	} else {
	    $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your new passwords does not match.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
	}
    } else {
	$message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your current password is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($message)) {
	include ("profile.php");
	exit();
    }
} else {
    header("Location: index");
    exit();
}