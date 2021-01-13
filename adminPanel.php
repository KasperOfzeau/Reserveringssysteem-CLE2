<?php
// Check logged in
require_once "includes/checkLogin.php";

// Load Carbon Library
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

// Database connection
/** @var $db */
require_once "includes/config.ini.php";

// PHP form files
require_once "php/addNewTime.php";

// Load available times
$query = "SELECT * FROM `available_times` WHERE available_time >= now() AND planned = 0";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$times = [];

while($row = mysqli_fetch_assoc($result))
{
    $times[] = $row;
}

// Load scheduled introductory meetings
$query = "SELECT * FROM appointments
INNER JOIN available_times ON appointments.appointment_time=available_times.time_id 
WHERE available_times.available_time >= now()";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$appointments = [];

while($row = mysqli_fetch_assoc($result))
{
    $appointments[] = $row;
}

mysqli_close($db);
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
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <title>Admin panel</title>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="container">
            <img src="images/Logoluca.jpg" alt="" width="325" height="43">
        </div>
    </nav>
</header>
<div class="container" id="adminPanel">
    <div class="section1">
        <h2>Available times:</h2>
            <?php if(!empty($times)) {?>
            <ul>
            <?php foreach ($times as  $key => $time) {
                $dt = new Carbon($time['available_time']); ?>
                <li><?= $dt->toDayDateTimeString()?> <a class="deleteButton" href="php/deleteTime.php?id=<?= $time['time_id']?>">Delete</a> </li>
            <?php }  ?>
            </ul>
            <?php } else { ?>
                <p>No dates and times have been entered.</p>
            <?php }?>

        <form action="" method="post">
            <div class="form-group">
                <label for="newTime">Add available time</label>
                <?php if(isset($errors['newTime'])){ ?>
                    <p class="alert alert-danger" role="alert"><?= $errors['newTime']?></p>
                <?php } ?>
                <?php if(isset($success)){ ?>
                    <p class="alert alert-success" role="alert"><?= $success?></p>
                <?php } ?>
                <input type="datetime-local" class="form-control" id="newTime" name="newTime">
                <button type="submit" id="submitNewTime" name="submitNewTime" class="btn">Submit</button>
            </div>
        </form>
    </div>
    <div class="section2">
        <h2>Scheduled introductory meetings:</h2>
        <?php if(!empty($appointments)) { ?>
        <div class="row">
            <?php foreach ($appointments as  $key => $appointment) {
                $date = new Carbon($appointment['available_time']); ?>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Meeting with <?= $appointment['first_name'] . ' ' . $appointment['last_name'] ?></h5>
                            <p class="card-text"><small class="text-muted"><?= $date->toDayDateTimeString() ?></small></p>
                            <ul class="details">
                                <li><?= $appointment['emailadress'] ?></li>
                                <li><?= $appointment['telephone_number'] ?></li>
                                <li><?= $appointment['adress'] ?></li>
                            </ul>
                            <h6><?= $appointment['message_title'] ?></h6>
                            <p class="card-text"><?= $appointment['message_text'] ?></p>
                            <a href="editAppointment.php?id=<?= $appointment['appointment_id'] ?>" class="btn edit-btn">Edit</a>
                        </div>
                    </div>
                </div>
            <?php }  ?>
        </div>
        <?php } else { ?>
            <p>No meetings planned.</p>
        <?php }?>
    </div>
</div>
<footer class="sticky-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <img src="images/Logoluca.jpg" alt="" width="250">
            </div>
            <div class="col-sm" id="footertext">
                <span>© Luca Büdgen 2018 - 2020</span>
            </div>
            <div class="col-sm"></div>
        </div>
    </div>
</footer>
</body>
</html>

