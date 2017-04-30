<?php
if (isset($_SESSION['login_user'])) {
    if ((time() - $_SESSION['last_time']) > 1800) { // 30 Minutes
	header("Location: logout");
    } else {
	$_SESSION['last_time'] = time();
    }
}