<?php

session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit;
}

require_once('includes/connection.php');

$target_dir = "images/profilepic/";
$target_file = $target_dir . basename($_FILES["picture"]["name"]);
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$request_method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);

if ($request_method == 'POST') {
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check == FALSE) {
        $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is not an image.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
    }

    if ($_FILES["picture"]["size"] > 50000000) {
        $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Uploaded file is too large.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
    }

    if ($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message = "<i class='fa fa-info-circle' aria-hidden='true'></i>Only JPG, JPEG, PNG & GIF files are allowed.<div><i class'fa fa-times' aria-hidden='true'></i></div>";
    }

    if (isset($message)) {
        include 'userview.php';
        exit();
    } else {
        $member_id = filter_input(INPUT_POST, "member_id", FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);

        $query1 = "SELECT profile_pic FROM member_details WHERE member_id = :member_id";
        $statement1 = $db->prepare($query1);
        $statement1->bindValue(":member_id", $member_id);
        $statement1->execute();
        $result_array1 = $statement1->fetch();
        $statement1->closeCursor();
        $profile_pic_old = $result_array1['profile_pic'];

        if ($profile_pic_old != "profile_pic.jpg") {
            unlink("images/profile_pic/" . $profile_pic_old);
        }

        $pic_name = $target_dir . "member_" . $member_id . "." . $imageFileType;

        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $pic_name)) {
            $profile_pic_new = "member_" . $member_id . "." . $imageFileType;

            $query2 = "UPDATE member_details SET profile_pic = :profile_pic WHERE member_id = :member_id";
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(":profile_pic", $profile_pic_new);
            $statement2->bindValue(":member_id", $member_id);
            $statement2->execute();
            $statement2->closeCursor();

            $_SESSION['profilePicUpdated'] = 1;
            header("Location: userview.php");
            exit();
        }
    }
} else {
    header("Location: userview.php");
    exit();
}