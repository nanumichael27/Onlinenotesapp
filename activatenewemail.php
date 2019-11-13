<?php

//The user is re-directed to this file after clicking the link recieved by email to prove they own the new email address
//Signup link contains three GET parameters: email, new email and activation  key

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
    <title>New Email Activation</title>

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
        <h1>New Email Activation </h1>
            <?php
            
            //If email, new email or activation key is missing show an error
            if(!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])){

            echo "<div class='alert alert-warning'>There was an error activating your account, please click on the link you recieved in the email. <div>";

            exit;
            }


            $email = $_GET['email'];
            $newemail = $_GET['newemail'];
            $key = $_GET['key'];

            
            
            $email = mysqli_real_escape_string($link, $email);
            $newemail = mysqli_real_escape_string($link, $newemail);
            $key = mysqli_real_escape_string($link, $key);
            
            activateUser();
            
            function activateUser(){
                $sql = "UPDATE users SET email='$newemail', activation2='0' WHERE (email='$email' AND activation2='$key') LIMIT 1";
                $result = mysqli_query($link, $sql);
                //If query is successful, show success message and invite user to login
                if(mysqli_affected_rows($link) == 1){
                    session_destroy();
                    setcookie('rememberme', "", time()-3600);

                echo "<div class='alert alert-success'> Your account has been successfully updated!<div>";
                echo "<a href='index.php' type='button' class='btn btn-lg btn-success'>Log in?</a>";
                }else{
                //else
                //show error message
                echo "<div class='alert alert-danger'>Sorry your email could not be updated please try again later.<div>";
                }
            
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