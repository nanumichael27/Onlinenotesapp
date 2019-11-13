<?php


session_start();
include('connection.php');

//Error messages
$missingEmail = '<p><strong>Please fill in your email address</strong></p>';
$invalidEmail = '<p><strong>Invalid email address! please check the email and try again</strong></p>';
$errors ="";



//    Get email
if(empty($_POST["forgotemail"])){
    $errors .= $missingEmail;
}else{
    $email = filter_var($_POST["forgotemail"], FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}
if($errors){
    $resultMessage = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a>' . $errors . '</div>';
    echo $resultMessage;
    exit;
    
}


//        Prepare variables for the query
$email = mysqli_real_escape_string($link, $email);
//        Run query to check if the email exists in the users table
$sql =  "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger"> Error running the query!</div>';
    exit;
}



//        If the email does not exist
$count = mysqli_num_rows($result);
if($count != 1){
    echo '<div class="alert alert-danger">That email does not exist on our database</div>';
    exit;
    
}



$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$user_id = $row["user_id"];

//  Create a unique activation code
$key = bin2hex(openssl_random_pseudo_bytes(16));
//  Insert user details and activation code in the forgotpassword table
$time = time();
$status = 'pending';
$sql = "INSERT INTO forgotpassword (`user_id`, `rkey`, `time`, `status` ) VALUES ('$user_id', '$key', '$time', '$status')";


$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger"> 
    There was an error inserting the users details in the database </div>';
    exit;
}

//            send email with link to resetpassword.php with user id and activation code
$message = "Please click on this link to reset your password:\n\n";
$message .= "http://localhost/onlinenotesapp/resetpassword.php?user_id=$user_id&key=$key";

echo "<div class='alert alert-success'>A reset password link has been sent to your email...
<a href='http://localhost/onlinenotesapp/resetpassword.php?user_id=$user_id&key=$key'> 
click to reset your password</a></div>";
$sendmail = mail($email, 'Reset your password', $message, 'From: '.'nanumichael27@gmail.com');
if($sendmail){
    echo "<div class='alert alert-success'>An email has been sent to $email. 
    Please click on the link to reset your password.  </div>";
}



?>