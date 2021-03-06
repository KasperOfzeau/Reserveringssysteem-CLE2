<?php
// Database connection
/** @var $db */
require_once "includes/config.ini.php";

// Load Composer libraries
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

// Load available times
$query = "SELECT * FROM `available_times` WHERE available_time >= now() AND planned = 0";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$times = [];

while($row = mysqli_fetch_assoc($result))
{
    $times[] = $row;
}

// Check if form is submitted.
if (isset($_POST['submit'])) {

    $errors = [];

    $first_name = htmlspecialchars(mysqli_escape_string($db ,$_POST['firstName']), ENT_QUOTES, 'UTF-8');
    $last_name = htmlspecialchars(mysqli_escape_string($db ,$_POST['lastName']), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars(mysqli_escape_string($db ,$_POST['email']));
    $phoneNumber = htmlspecialchars(mysqli_escape_string($db ,$_POST['phoneNumber']), ENT_QUOTES, 'UTF-8');
    $adress = htmlspecialchars(mysqli_escape_string($db ,$_POST['adress']), ENT_QUOTES, 'UTF-8');
    $city = htmlspecialchars(mysqli_escape_string($db ,$_POST['city']), ENT_QUOTES, 'UTF-8');
    $postalCode = htmlspecialchars(mysqli_escape_string($db ,$_POST['postalCode']), ENT_QUOTES, 'UTF-8');
    $titleMessage = htmlspecialchars(mysqli_escape_string($db ,$_POST['titleMessage']), ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars(mysqli_escape_string($db, $_POST['message']), ENT_QUOTES, 'UTF-8');
    if(isset($_POST['appointmentTime'])) {
        $time_id = htmlspecialchars(mysqli_escape_string($db, $_POST['appointmentTime']), ENT_QUOTES, 'UTF-8');
    } else {
        $time_id = '';
        $errors['time_id'] = "Please select a time & date";
    }

    // Check values
    if($first_name == ''){
        $errors['first_name'] = "Please enter a valid first name";
    }

    if($last_name == ''){
        $errors['last_name'] = "Please enter a valid last name";
    }

    if($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Please enter a valid email";
    }

    if($phoneNumber == ''){
        $errors['phoneNumber'] = "Please enter a valid phone number";
    }

    if($adress == ''){
        $errors['adress'] = "Please enter a valid adress";
    }

    if($city == ''){
        $errors['CityPostalCode'] = "Please enter a valid city or postal code";
    }

    if($postalCode == ''){
        $errors['CityPostalCode'] = "Please enter a valid city or postal code";
    }

    if($titleMessage == ''){
        $errors['titleMessage'] = "Please enter a title";
    }

    if($message == ''){
        $errors['message'] = "Please enter a message";
    } else if(strlen($message) < 50) {
        $errors['message'] = "Please use at least 50 characters";
    }

    if($time_id == ''){
        $errors['time_id'] = "Please select a time & date";
    }

    if(empty($errors)) {

        // Connect adress, postal code and city to full adress
        $fullAdress = $adress . ', ' . $postalCode . ' ' . $city;

        $sql = "INSERT INTO `appointments`(`first_name`, `last_name`, `emailadress`, `telephone_number`, `adress`, `message_title`, `message_text`, `appointment_time`) 
    VALUES('$first_name', '$last_name', '$email', '$phoneNumber', '$fullAdress', '$titleMessage', '$message', '$time_id')";

        if (mysqli_query($db, $sql)) {

            $sql2 = "UPDATE available_times SET planned = 1 WHERE time_id='$time_id'";

            if (mysqli_query($db, $sql2)) {
                $succes = "Your introductory meeting has been successfully scheduled!";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    }
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
    <title>Contact</title>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="container">
                <img src="images/Logoluca.jpg" alt="" width="325" height="43">
        </div>
    </nav>
</header>
<div class="container">
    <p id="contactQuote">Let's turn your ideas into appealing visuals</p>
    <h1 id="contactTitle">Schedule an introductory meeting</h1>
<?php if(isset($succes)){ ?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Hooray!</h4>
        <?= $succes?>
    </div>
<?php } ?>
<form action="" method="post" id="contactForm">
    <div class="form-group">
        <label for="firstName">First name</label>
        <?php if(isset($errors['first_name'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['first_name']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php if(isset($first_name) && !isset($succes)){ echo $first_name; }?>" placeholder="">
    </div>
    <div class="form-group">
        <label for="lastName">Last name</label>
        <?php if(isset($errors['last_name'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['last_name']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php if(isset($last_name) && !isset($succes)){ echo $last_name; }?>" placeholder="">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <?php if(isset($errors['email'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['email']?></p>
        <?php } ?>
        <input type="email" class="form-control" id="email"  name="email" value="<?php if(isset($email) && !isset($succes)){ echo $email; }?>" placeholder="">
    </div>
    <div class="form-group">
        <label for="phoneNumber">Phone number</label>
        <?php if(isset($errors['phoneNumber'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['phoneNumber']?></p>
        <?php } ?>
        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php if(isset($phoneNumber) && !isset($succes)){ echo $phoneNumber; }?>" placeholder="">
    </div>
    <div class="form-group">
        <label for="adress">Address</label>
        <?php if(isset($errors['adress'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['adress']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="adress" name="adress" value="<?php if(isset($adress) && !isset($succes)){ echo $adress; }?>" placeholder="">
    </div>
    <div class="form-group">
        <div class="row g-3">
            <?php if(isset($errors['CityPostalCode'])){ ?>
                <p class="alert alert-danger" role="alert"><?= $errors['CityPostalCode']?></p>
            <?php } ?>
            <div class="col">
                <label for="city">City</label>
                <input type="text" id="city" name="city" value="<?php if(isset($city) && !isset($succes)){ echo $city; }?>" class="form-control">
            </div>
            <div class="col">
                <label for="postalCode">Postal code</label>
                <input type="text" id="postalCode" name="postalCode" value="<?php if(isset($postalCode) && !isset($succes)){ echo $postalCode; }?>" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="titleMessage">Title message</label>
        <?php if(isset($errors['titleMessage'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['titleMessage']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="titleMessage" name="titleMessage" value="<?php if(isset($titleMessage) && !isset($succes)){ echo $titleMessage; }?>" placeholder="">
    </div>
    <div class="form-group">
        <label for="message">Describe your ideas</label>
        <?php if(isset($errors['message'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['message']?></p>
        <?php } ?>
        <textarea class="form-control" id="message" name="message" rows="3"><?php if(isset($message) && !isset($succes)){ echo $message; }?></textarea>
    </div>
    <div class="form-group">
        <label for="appointmentTime">Time & date for the introductory meeting</label>
        <?php if(isset($errors['time_id'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['time_id']?></p>
        <?php } ?>
        <select class="form-control" id="appointmentTime" name="appointmentTime">
            <option <?php if(isset($time_id) && !isset($succes) && $time_id == ''){ echo "selected";}elseif(!isset($time_id)){ echo "selected";}?> value="" disabled >Select your option</option>
            <?php
            foreach ($times as  $key => $time) {
               $dt = new Carbon($time['available_time']); ?>
                <option <?php if(isset($time_id) && !isset($succes) && $time_id == $time['time_id']){ echo "selected";}?> value='<?= $time['time_id']?>'><?= $dt->toDayDateTimeString()?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" id="submit" name="submit" class="btn">Send</button>
</form>
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
