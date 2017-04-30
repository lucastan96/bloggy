<?php

session_start();

if (isset($_SESSION['login_user'])) {
    header("Location: ../index");
    exit;
}

require_once('connection.php');

$email = filter_input(INPUT_POST, 'registeremail', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'registerpassword', FILTER_SANITIZE_STRING);
$confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING);
$firstname = filter_input(INPUT_POST, 'yourFirstName', FILTER_SANITIZE_STRING);
$lastname = filter_input(INPUT_POST, 'yourLastName', FILTER_SANITIZE_STRING);
$age = filter_input(INPUT_POST, 'yourAge', FILTER_SANITIZE_STRING);
$country_id = filter_input(INPUT_POST, 'yourCountry', FILTER_VALIDATE_INT);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($password == $confirmpassword) {
    $query1 = "SELECT * FROM member where email = :email";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(":email", $email);
    $statement1->execute();
    $result_array1 = $statement1->fetchAll();
    $statement1->closeCursor();

    if (!count($result_array1)) {
	$query2 = "INSERT INTO member (email, password) VALUES (:email , :password )";
	$statement2 = $db->prepare($query2);
	$statement2->bindValue(":email", $email);
	$statement2->bindValue(":password", $hashed_password);
	$statement2->execute();
	$statement2->closeCursor();

	$query3 = "INSERT INTO member_details (member_id,first_name,last_name,age,country_id) VALUES ((SELECT member_id from member WHERE email = '$email'), :first_name, :last_name, :age, :country_id)";
	$statement3 = $db->prepare($query3);
	$statement3->bindValue(":first_name", $firstname);
	$statement3->bindValue(":last_name", $lastname);
	$statement3->bindValue(":age", $age);
	$statement3->bindValue(":country_id", $country_id);
	$statement3->execute();
	$statement3->closeCursor();

	$query4 = "SELECT member_id FROM member where email = :email";
	$statement4 = $db->prepare($query4);
	$statement4->bindValue(":email", $email);
	$statement4->execute();
	$result_array4 = $statement4->fetch();
	$statement4->closeCursor();

	session_start();

	$_SESSION['id'] = $result_array4['member_id'];
	$_SESSION['login_user'] = $email;
	$_SESSION['user_status'] = 0;
	$_SESSION['last_time'] = time();

	header("Location:../index");
	exit();
    } else {
	$message = "This email is not available.";
    }
} else {
    $message = "The password does't match. Try it again";
}

if (isset($message)) {
//    include ("login.php");
    exit();
}