<?php
session_start();
// If not logged in redirect to login page
if($_SESSION["loggedIn"] != true){
    header("Location: admin-login.php");
    exit;
}