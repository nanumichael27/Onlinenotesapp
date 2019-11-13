<?php
//start session and connect
session_start();
include('connection.php');

//get user_id and new email sent through Ajax
$user_id = $_SESSION['user_id'];
$newemail = $_POST['email'];

//check if new email exists in the users table
$sql = "SELECT * FROM users WHERE email = '$newemail'";
$result = mysqli_query($link, $sql);
$count = mysqli_num_rows($result);
if($count > 0){
   
    echo "<div class='alert alert-danger'>There is already a user registered with $newemail please choose another one</div>";
    exit;
}
//get the current email of our user
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $username = $row['username'];
    $email = $row['email'];
}else{
    echo"There was an error retrieving the email from the database";exit;
}

//create a unique activation code
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

//insert the new activation code in the users table
$sql = "UPDATE users SET activation2 = '$activationKey' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='alert alert-danger'>There was an error inserting the user details into the database.</div>";
    exit;
}


//send email with link to activatenewemail.php with current emai, new email and activation code
$message = "Please click on this link to to prove that you own this email:\n\n";
$message .= "http://localhost/onlinenotesapp/activatenewemail.php?email=".urlencode($email). "&newemail=".urlencode($newemail)."&key=$activationKey";

echo "<div class='alert alert-success'><a href='http://localhost/onlinenotesapp/activatenewemail.php?email=".urlencode($email). "&newemail=".urlencode($newemail)."&key=$activationKey'>Activate your accout now</a></div>";

$sendmail = mail($newemail, 'Email update from Online Notes app', $message, 'From: '.'nanumichael27@gmail.com');
 
if($sendmail){
    echo "<div class='alert alert-success'>Thank you for registering! confirmation email has been sent to $email. Please click on the activation link to prove you own that email address.  </div>";
}
    

?>