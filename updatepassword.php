<?php
//start session and connect
session_start();
include('connection.php');

//define error messages
$missingCurrentPassword = "<p>Please enter your current password</p>";
$incorrectCurrentPassword = "<p>The password entered is incorrect</p>";
$missingPassword = "<p>Please enter a new password</p>";
$invalidPassword = "<p>Your password should contain at least 6 characters and include one capital letter and one number</p>";
$differentPassword = "<p>Passwords don\'t match</p>";
$missingPassword2 = "<p>Please confirm your password</p>";


$errors = "";
$username = "";
$email = "";
$password = "";

//check for errors
if(empty($_POST['currentpassword'])){
    $errors .= $missingCurrentPassword;
    
}else{
    $currentPassword = $_POST['currentpassword'];
    $currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
    
    $currentPassword = mysqli_real_escape_string($link, $currentPassword);
    $currentPassword = hash("sha256", $currentPassword);
    
    //check if the given password is correct
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT password FROM users WHERE user_id = '$user_id'";
    
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    if($count !== 1){
         echo "<div class='alert alert-danger'>There was a problem running the query</div>";
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        if($currentPassword != $row['password']){
          $errors .= $incorrectCurrentPassword;  
        }
    }
}

//lets write code for the new password and its confirmation weve done something very similar in ther signup file so let us fetch the codes from there
//Get passwords

if(empty($_POST["password"])){
    $errors .= $missingPassword;
}elseif(!(strlen($_POST["password"])>6 and preg_match('/[A-Z]/', $_POST["password"]) and preg_match('/[0-9]/', $_POST["password"])
        )
    ){
    //This means that the password must contain one capital letter and one number. it must also be longer than six digits
    
    $errors .= $invalidPassword;
}else{
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        //If the second password is missing
        
        if(empty($_POST["password2"])){
            $errors .= $missingPassword2;
        }else{
            $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
            //if the password is different from the confirmation this is what we will do
                if($password !== $password2){
                    $errors .= $differentPassword;
                }
        }
}


//if there is an error print error message
if($errors){
    $resultMessage = "<div class='alert alert-danger'>$errors</div>";
    echo $resultMessage;
    exit;
}

$password = mysqli_real_escape_string($link, $password);
$password = hash("sha256", $password);
//else run query and update password

$sql = "UPDATE users SET password= '$password' WHERE user_id='$user_id'";

$result = mysqli_query($link, $sql);

if(!$result){
    echo "<div class='alert alert-danger'>The password could not be reset please try again later</div>";
}else{
    echo "<div class='alert alert-success'>Success!!! Your password has been updated</div>";
}

?>