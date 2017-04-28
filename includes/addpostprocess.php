<?php

session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit;
}

require_once('includes/connection.php');

$email = $_SESSION['login_user'];
$id = $_SESSION['id'];

$post_title = filter_input(INPUT_POST, 'post_title', FILTER_SANITIZE_STRING);
$post_text = filter_input(INPUT_POST, 'post_text', FILTER_SANITIZE_STRING);
$post_pic = filter_input(INPUT_POST, 'post_pic', FILTER_SANITIZE_STRING);
$post_time = filter_input(INPUT_POST, 'post_time', FILTER_SANITIZE_STRING);
$post_like = filter_input(INPUT_POST, 'post_like', FILTER_SANITIZE_INT);


$insertHashtag = "";
$array = explode(" ", $post_text);
$hashtag = array();



for ($x = 0; $x < sizeof($array); $x++) {
    $output = $array[$x];
    $length = strlen($output);
    $gg = array();
    $test = array();



    if (substr($output, 0, 1) != "#") {
        $gg = explode("#", $output);
        if (sizeof($gg) > 1) {
            for ($a = 1; $a < sizeof($gg); $a++) {
                $hashtag[] = $gg[$a];
            }
        }
    } else {

        $test = explode("#", $output);
        $size = sizeof($test);
        for ($y = 1; $y < $size; $y++) {
            $hashtag[] = $test[$y];
        }
    }
    unset($gg);
    unset($test);
}
for ($x = 0; $x < sizeof($hashtag); $x++) {
    $insertHashtag = $insertHashtag . $hashtag[$x] . ",";
}

$insert = substr($insertHashtag, 0, -1);
echo $insert;






$query1 = "INSERT INTO post (post_title, post_text, post_pic, post_time, post_like, hashtag, member_id) VALUES (:post_title , :post_text , :post_pic , :post_time , :post_like , :hashtag , :member_id )";
$statement1 = $db->prepare($query1);
$statement1->bindValue(":post_title", $post_title);
$statement1->bindValue(":post_text", $post_text);
$statement1->bindValue(":post_pic", $post_pic);
$statement1->bindValue(":post_time", $post_time);
$statement1->bindValue(":post_like", $post_like);
$statement1->bindValue(":hashtag", $insert);
$statement1->bindValue(":member_id", $id);
$statement1->execute();
$statement1->closeCursor();


    header("Location: men.php");
    exit();

