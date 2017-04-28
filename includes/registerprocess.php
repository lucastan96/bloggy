<?php

session_start();

if (isset($_SESSION['login_user'])) {
    header("Location: ../index");
    exit;
}

require_once('connection.php');
echo 'hi';


$email = filter_input(INPUT_POST, 'registeremail', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'registerpassword', FILTER_SANITIZE_STRING);
$confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, 'yourName', FILTER_SANITIZE_STRING);
$age = filter_input(INPUT_POST, 'yourAge', FILTER_SANITIZE_STRING);
$mobile = filter_input(INPUT_POST, 'yourMobile', FILTER_SANITIZE_STRING);

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



        $query3 = "INSERT INTO member_details (member_id,name,age,mobile) VALUES
				((SELECT member_id from member WHERE email = '$email') , :name ,  :age, :mobile)";
        $statement3 = $db->prepare($query3);
        $statement3->bindValue(":name", $name);
        $statement3->bindValue(":age", $age);
        $statement3->bindValue(":mobile", $mobile);
        $statement3->execute();
        $statement3->closeCursor();

        session_start();

        $_SESSION['login_user'] = $email;
        $_SESSION['user_status'] = 0;

        header("Location:../index");
        exit;
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