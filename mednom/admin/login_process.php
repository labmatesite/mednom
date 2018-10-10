<?php

require_once 'header_includes.php';
et_sec_session_start();
$mysqli = get_mysqli();

if (isset($_POST['username'], $_POST['p'])) {

    //$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['p']; // The hashed password.
    
    if (et_login($username, $password, $mysqli) == true) {
        // Login success 
        header("Location: index.php");
        exit();
    } else {
        // Login failed 
        header('Location: login.php?error=1');
        exit();
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: error.php?err=Could not process login');
    exit();
}