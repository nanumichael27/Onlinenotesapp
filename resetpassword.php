
<!--
//This file receives the user_id and key generated to create the new password

//This file displays a form to input new password
-->


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
    <title>Password reset</title>

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
            padding-bottom: 15px;
        }
    </style>
  </head>
  <body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactform">
        <h1>Reset password: </h1>
            <div id="resultmessage"></div>
            <?php
            
            //If user_id or activation key is missing show an error message
            if(!isset($_GET['user_id']) || !isset($_GET['key'])){

            echo "<div class='alert alert-warning'>There was an error activating your account, please click on the link you recieved by email <div>";

            exit;
            }
            //else
            //Store them in two variables
            $user_id = $_GET['user_id'];
            $key = $_GET['key'];
            //Define a time variable: now minus 24 hours
            $time = time()-86000;
            //Prepare variables for the query
            $user_id = mysqli_real_escape_string($link, $user_id);
            $key = mysqli_real_escape_string($link, $key);
            
          
    //Run Query: check combination of user_id & key exists and less than 24h old

            $sql = "SELECT user_id FROM forgotpassword WHERE rkey='$key' AND user_id='$user_id' AND time > '$time' AND status='pending'";
            
            
            $result = mysqli_query($link, $sql);
            
            
        if(!$result){
            echo '<div class="alert alert-danger"> Error running the query!</div>';
            echo mysqli_error($link);
            exit;
        }
             //If combination does not exist
        //Print error message
            
            $count = mysqli_num_rows($result);
            if($count !== 1){
                
                echo '<div class="alert alert-danger">Please try again</div>';
                exit;
            }
             //else
        //Print reser password form with hidden user_id and key fields
            
            echo "<form method='post' id='passwordreset'>
            
            <input type='hidden' name='key' value='$key'>
            <input type='hidden' name='user_id' value='$user_id'>
            <div class='form-group'>
                <label for='password'>Enter your new password</label>
                <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control'>
            </div>
            <div class='form-group'>
                <label for='password2'>Enter your new password</label>
                <input type='password' name='password2' id='password2' placeholder='Re-nter Password' class='form-control'>
            </div>
            
            <input type='submit' name='resetpassword' class='btn btn-lg btn-success' value='Reset Password'>
            
            </form>"
            

            ?>
            
        </div>
    </div>
    
</div>

    <script src="jquery-3.3.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script>
      
      //Script for AJAX Call to storeresetpassword.php which processes form data
        
$("#passwordreset").submit(function(event){
        //Prevent default php processing
    event.preventDefault();
        //Collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
        //Send them to signup.php using AJAX
    $.ajax({
        url: "storeresetpassword.php", 
        type: "POST",
        data: datatopost,
        success: function(data){
            $("#resultmessage").html(data);
            
        },
        
        error: function(){
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the ajax call. Please try again later.</div>");
        },
        
    });
    
//    $.post({}).done().fail();
});  
          
      </script>

  </body>
</html>

<!--

    
    //prepare variables for the query

   
   




-->

