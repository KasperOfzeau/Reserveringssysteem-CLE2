<?php
// Check logged in
require_once "./includes/checkLogin.php";

// Check if form is submitted.
if (isset($_POST['submitNewTime'])) {

    $errors = [];

    $newTime = $_POST['newTime'];

    if($newTime == "") {
        $errors['newTime'] = "Please enter a valid date and time";
    }

    if(empty($errors)) {

        $sql = "INSERT INTO `available_times`(`available_time`, `planned`) 
        VALUES('$newTime', 0)";

        /** @var $db */
        if (mysqli_query($db, $sql)) {
            $success = "Time added!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    }
}