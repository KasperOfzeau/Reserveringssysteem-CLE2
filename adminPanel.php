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

// Load Carbon Library
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

// Database connection
/** @var $db */
require_once "includes/config.ini.php";

// Load available times
$query = "SELECT * FROM `available_times` WHERE available_time >= now() AND planned = 0";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$times = [];

while($row = mysqli_fetch_assoc($result))
{
    $times[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <meta charset="UTF-8">
    <title>Admin panel</title>
</head>
<body>
<h1>Available times:</h1>
<ul>
    <?php foreach ($times as  $key => $time) {
        $dt = new Carbon($time['available_time']); ?>
        <li><?= $dt->toDayDateTimeString()?></li>
    <?php } ?>
</ul>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewTimeModal">Add new time</button>

<!-- Modal -->
<div class="modal fade" id="addNewTimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add available time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="datetime-local" id="newTime" name="availableTime">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" name="submit">Add</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>

