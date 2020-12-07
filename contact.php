<?php

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
        <input type="text" class="form-control" id="firstName" placeholder="">
    </div>
    <div class="form-group">
        <label for="lastName">Last name</label>
        <input type="text" class="form-control" id="lastName" placeholder="">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="">
    </div>
    <div class="form-group">
        <label for="phoneNumber">Phone number</label>
        <input type="tel" class="form-control" id="phoneNumber" placeholder="">
    </div>
    <div class="form-group">
        <label for="adress">Address</label>
        <input type="text" class="form-control" id="adress" placeholder="">
    </div>
    <div class="form-group">
        <label for="city">City & </label>
        <label for="postalCode">Postal code</label>
    <div class="input-group">
        <input type="text" id="city" class="form-control">
        <input type="text" id="postalCode" class="form-control">
    </div>
    </div>
    <div class="form-group">
        <label for="titleMessage">Title message</label>
        <input type="text" class="form-control" id="titleMessage" placeholder="">
    </div>
    <div class="form-group">
        <label for="message">Describe your ideas</label>
        <textarea class="form-control" id="message" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send</button>
</form>
</body>
</html>
