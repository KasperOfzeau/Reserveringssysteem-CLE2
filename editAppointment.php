<?php
// Check logged in
require_once "includes/checkLogin.php";

// Database connection
/** @var $db */
require_once "includes/config.ini.php";

// Load Carbon Library
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;

// Get id appointment
$id = $_GET['id'];

// Load data form
$query = "SELECT * FROM appointments
INNER JOIN available_times ON appointments.appointment_time=available_times.time_id 
WHERE appointment_id = '$id'";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);
$row = mysqli_fetch_assoc($result);

// Check if form is submitted.
if (isset($_POST['submit'])) {

    $errors = [];

    $first_name = mysqli_escape_string($db ,$_POST['firstName']);
    $last_name = mysqli_escape_string($db ,$_POST['lastName']);
    $email = mysqli_escape_string($db ,$_POST['email']);
    $phoneNumber = mysqli_escape_string($db ,$_POST['phoneNumber']);
    $adress = mysqli_escape_string($db ,$_POST['adress']);
    $titleMessage = mysqli_escape_string($db ,$_POST['titleMessage']);
    $message = mysqli_escape_string($db ,$_POST['message']);
    $id = mysqli_escape_string($db ,$_POST['id']);

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

    if($titleMessage == ''){
        $errors['titleMessage'] = "Please enter a title";
    }

    if($message == ''){
        $errors['message'] = "Please enter a message";
    } else if(strlen($message) < 50) {
        $errors['message'] = "Please use at least 50 characters";
    }

    if(empty($errors)) {

        $sql = "UPDATE appointments
        SET first_name = '$first_name', last_name = '$last_name', emailadress = '$email', telephone_number = '$phoneNumber', adress = '$adress', message_title = '$titleMessage', message_text = '$message'
        WHERE appointment_id = '$id'";

        if (mysqli_query($db, $sql)) {
                $succes = "Your introductory meeting has been successfully updated!!";
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

    <meta charset="UTF-8">
    <title>Contact</title>
</head>
<body>

<a href="adminPanel.php">Go back</a>
<?php if(isset($succes)){ ?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Hooray!</h4>
        <?= $succes?>
    </div>
<?php } ?>
<form action="" method="post">
    <div class="form-group">
        <label for="firstName">First name</label>
        <?php if(isset($errors['first_name'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['first_name']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php if(isset($first_name) && !isset($succes)){ echo $first_name; }else{ echo $row['first_name'];}?>" >
    </div>
    <div class="form-group">
        <label for="lastName">Last name</label>
        <?php if(isset($errors['last_name'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['last_name']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php if(isset($last_name) && !isset($succes)){ echo $last_name; }else{ echo $row['last_name'];}?>">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <?php if(isset($errors['email'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['email']?></p>
        <?php } ?>
        <input type="email" class="form-control" id="email"  name="email" value="<?php if(isset($email) && !isset($succes)){ echo $email; }else{ echo $row['emailadress'];}?>">
    </div>
    <div class="form-group">
        <label for="phoneNumber">Phone number</label>
        <?php if(isset($errors['phoneNumber'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['phoneNumber']?></p>
        <?php } ?>
        <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php if(isset($email) && !isset($succes)){ echo $phoneNumber; }else{ echo $row['telephone_number'];}?>">
    </div>
    <div class="form-group">
        <label for="adress">Address</label>
        <?php if(isset($errors['adress'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['adress']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="adress" name="adress" value="<?php if(isset($adress) && !isset($succes)){ echo $adress; }else{ echo $row['adress'];}?>">
    </div>
    <div class="form-group">
        <label for="titleMessage">Title message</label>
        <?php if(isset($errors['titleMessage'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['titleMessage']?></p>
        <?php } ?>
        <input type="text" class="form-control" id="titleMessage" name="titleMessage" readonly value="<?php if(isset($titleMessage) && !isset($succes)){ echo $titleMessage; }else{ echo $row['message_title'];}?>">
    </div>
    <div class="form-group">
        <label for="message">Describe your ideas</label>
        <?php if(isset($errors['message'])){ ?>
            <p class="alert alert-danger" role="alert"><?= $errors['message']?></p>
        <?php } ?>
        <textarea class="form-control" id="message" name="message"  readonly rows="3"><?php if(isset($message) && !isset($succes)){ echo $message; }else{ echo $row['message_text'];}?></textarea>
    </div>
    <div class="form-group">
        <label for="appointmentTime">Time & date for the introductory meeting</label>
        <?php if(isset($errors['appointmentTime'])){ ?>
        <p class="alert alert-danger" role="alert"><?= $errors['appointmentTime']?></p>
        <?php } ?>
        <input type="text" value="<?php if(isset($appointmentTime) && !isset($succes)){ echo $appointmentTime; }else{ echo $row['available_time'];}?>" name="appointmentTime" id="appointmentTime" readonly>
    </div>
    <input type="text" hidden name="id" value="<?= $id?>">
    <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
</form>
</body>
</html>
