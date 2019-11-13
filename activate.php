<?php

//The user is re-directed to this file after clicking the activation link
//Signup link contains two GET parameters: email and activation  key

//start session and connect to the database
session_start();
include('connection.php');
    
        
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Email Activation</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1{
            color: purple;
        }
        
        .contactform{
            border: 1px solid #7c73f6;
            margin-top: 50px;
            border-radius: 15px;
            background-color:burlywood;
        }
    </style>
  </head>
  <body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactform">
        <h1>Activation </h1>
            <?php
            
            //If email or activation key is missing show an error
            if(!isset($_GET['email']) || !isset($_GET['key'])){
            echo "<div class='alert alert-warning'>There was an error activating your account, please click on the activation link you recieved in the email. <div>";
            exit;
            }

            
            
            $email = $_GET['email'];
            $key = $_GET['key'];
            $email = mysqli_real_escape_string($link, $email);
            $key = mysqli_real_escape_string($link, $key);
            $sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
            $result = mysqli_query($link, $sql);
            if(mysqli_affected_rows($link) == 1){

            echo "<div class='alert alert-success'>Congratulations!!! Your account has been activated!<div>";
            echo "<a href='index.php' type='button' class='btn btn-lg btn-success'>Log in?</a>";
            }else{
            //else
            //show error message
            echo "<div class='alert alert-danger'>Sorry your account could not be activated please try again later.<div>";

            }

            
            
            ?>
            
        </div>
    </div>
    
</div>

    <script src="jquery-3.3.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>