<?php
// Database connection
require_once "includes/config.ini.php";

require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

$query = "SELECT * FROM anavilable_times WHERE planned = 0";

/** @var mysqli $db */
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$times = [];

while($row = mysqli_fetch_assoc($result))
{
    $times[] = $row;
}

// Check if form is submitted.
if (isset($_POST['submit'])) {

    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $adress = $_POST['adress'];
    $city = $_POST['city'];
    $postalCode = $_POST['postalCode'];
    $titleMessage = $_POST['titleMessage'];
    $message = $_POST['message'];
    $time_id = $_POST['appointmentTime'];

    $fullAdress = $adress . ', ' . $postalCode . ' ' . $city;

    $sql = "INSERT INTO `appointments`(`first_name`, `last_name`, `emailadress`, `telephone_number`, `adress`, `message_title`, `message_text`, `appointment_time`) 
    VALUES('$first_name', '$last_name', '$email', '$phoneNumber', '$fullAdress', '$titleMessage', '$message', '$time_id')";

    if (mysqli_query($db, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <!-- Bootstrap files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <meta charset="UTF-8">
    <title>Contact</title>
</head>
<body>
<form action="" method="post">
    <div class="form-group">
        <label for="firstName">First name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="">
    </div>
    <div class="form-group">
        <label for="lastName">Last name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email"  name="email" placeholder="">
    </div>
    <div class="form-group">
        <label for="phoneNumber">Phone number</label>
        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="">
    </div>
    <div class="form-group">
        <label for="adress">Address</label>
        <input type="text" class="form-control" id="adress" name="adress" placeholder="">
    </div>
    <div class="form-group">
        <label for="city">City & </label>
        <label for="postalCode">Postal code</label>
    <div class="input-group">
        <input type="text" id="city" name="city" class="form-control">
        <input type="text" id="postalCode" name="postalCode" class="form-control">
    </div>
    </div>
    <div class="form-group">
        <label for="titleMessage">Title message</label>
        <input type="text" class="form-control" id="titleMessage" name="titleMessage" placeholder="">
    </div>
    <div class="form-group">
        <label for="message">Describe your ideas</label>
        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="appointmentTime">Time & date for the introductory meeting</label>
        <select class="form-control" id="appointmentTime" name="appointmentTime">
            <option value="" disabled selected>Select your option</option>
            <?php
            foreach ($times as  $key => $time) {
               $dt = new Carbon($time['anavilable_time']); ?>
                <option value='<?= $time['time_id']?>'><?= $dt->toDayDateTimeString()?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" id="submit" name="submit" class="btn btn-primary">Send</button>
</form>
</body>
</html>
