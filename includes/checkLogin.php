<?php
session_start();
// If not logged in redirect to login page
if($_SESSION["loggedIn"] != true){
    header("Location: admin-login.php");
    exit;
}

// Check login tiem
if (time() - $_SESSION['loginTime'] > 300) {
    header("Location: admin-login.php");
    exit;
} else {
    $_SESSION['loginTime'] = time();
}