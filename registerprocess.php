<?php

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    $register_email = filter_input(INPUT_POST, 'registeremail', FILTER_SANITIZE_EMAIL);
    $regex_email = "/[a-z]"
	    . "[a-z0-9.-_]*"
	    . "[a-z0-9]+"
	    . "[@]"
	    . "[a-z0-9]+"
	    . "\."
	    . "("
	    . "([a-z]{2}\.[a-z]{2})"
	    . "|"
	    . "[a-z]{2,3})"
	    . "/";

    if (!preg_match($regex_email, $register_email)) {
	$register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>The email format is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";

	include ("login.php");
	exit();
    }

    $password = filter_input(INPUT_POST, 'registerpassword', FILTER_SANITIZE_STRING);
    $regex_password = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    if (!preg_match($regex_password, $password)) {
	$register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>The password format is incorrect.<div><i class='fa fa-times' aria-hidden='true'></i></div>";

	include ("login.php");
	exit();
    }

    $confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING);
    $firstname = filter_input(INPUT_POST, 'yourFirstName', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'yourLastName', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'yourAge', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
    $country_id = filter_input(INPUT_POST, 'yourCountry', FILTER_VALIDATE_INT);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($password == $confirmpassword) {
	require_once('includes/connection.php');

	$query1 = "SELECT * FROM member where email = :email";
	$statement1 = $db->prepare($query1);
	$statement1->bindValue(":email", $register_email);
	$statement1->execute();
	$result_array1 = $statement1->fetchAll();
	$statement1->closeCursor();

	if (!count($result_array1)) {
	    $query2 = "INSERT INTO member (email, password) VALUES (:email , :password )";
	    $statement2 = $db->prepare($query2);
	    $statement2->bindValue(":email", $register_email);
	    $statement2->bindValue(":password", $hashed_password);
	    $statement2->execute();
	    $statement2->closeCursor();

	    $query3 = "INSERT INTO member_details (member_id,first_name,last_name,age,country_id) VALUES ((SELECT member_id from member WHERE email = '$register_email'), :first_name, :last_name, :age, :country_id)";
	    $statement3 = $db->prepare($query3);
	    $statement3->bindValue(":first_name", $firstname);
	    $statement3->bindValue(":last_name", $lastname);
	    $statement3->bindValue(":age", $age);
	    $statement3->bindValue(":country_id", $country_id);
	    $statement3->execute();
	    $statement3->closeCursor();

	    $query4 = "SELECT member_id FROM member where email = :email";
	    $statement4 = $db->prepare($query4);
	    $statement4->bindValue(":email", $register_email);
	    $statement4->execute();
	    $result_array4 = $statement4->fetch();
	    $statement4->closeCursor();

	    session_start();

	    $_SESSION['id'] = $result_array4['member_id'];
	    $_SESSION['login_user'] = $register_email;
	    $_SESSION['user_status'] = 0;
	    $_SESSION['last_time'] = time();
	    $_SESSION['first_login'] = 1;

	    header("Location: index");
	    exit();
	} else {
	    $register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>This email is not available.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
	}
    } else {
	$register_message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Your passwords does not match.<div><i class='fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($register_message)) {
	include ("login.php");
	exit();
    }
} else {
    header("Location: index");
    exit();
}