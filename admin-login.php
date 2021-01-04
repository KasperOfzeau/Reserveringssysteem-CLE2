<?php

// Check if form is submitted.
if(isset($_POST['submit'])) {

    // Database connection
    /** @var $db */
    require_once "includes/config.ini.php";

    $error = '';
    $userName = mysqli_escape_string($db, $_POST['inputUsername']);
    $password = mysqli_escape_string($db, $_POST['inputPassword']);

    if ($userName == '' || $password == '') {
        $error = "Please fill both the username and password fields!";
    } else {

        // Check username and password in database
        $query = "SELECT * FROM admin_users WHERE username ='$userName'";
        $select_data = mysqli_query($db, $query);

        if (mysqli_num_rows($select_data) == 1) {
            $row = mysqli_fetch_assoc($select_data);
            $hash = substr( $row['password'], 0, 60 );
            $pass = mysqli_escape_string($db, $_POST['inputPassword']);

            // Check if password is correct
            if(password_verify($pass, $hash)){
                // Successful login
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['loginTime'] = time();
                mysqli_close($db);
                header("Location: adminPanel.php");
                exit;
            } else {
                // Failed login
                $error = "You have entered an invalid username or password";
                mysqli_close($db);
            }
        } else {
            // Failed login
            $error = "You have entered an invalid username or password";
            mysqli_close($db);
        }
    }
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
    <link rel="stylesheet" href="css/signin.css">

    <meta charset="UTF-8">
    <title>Admin login</title>
</head>
<body class="text-center">
<form class="form-signin" method="post" action="">
    <h1 class="h3 mb-3 font-weight-normal">Admin log in</h1>
    <?php if(isset($error)){ ?>
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Oops!</h4>
            <?= $error?>
        </div>
    <?php } ?>
    <label for="inputUsername" class="sr-only">Username</label>
    <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" autofocus="" autocomplete="off">
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" autocomplete="off">
    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">© Luca Büdgen 2018 - 2020</p>
</form>
</body>
</html>
