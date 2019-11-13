<?php
//<!--Start session-->
    session_start();
//<!--connect to the database-->

include ("connection.php");

//<!--Check user inputs-->
//    <!--Define error messages-->
$missingUsername = '<p><strong>Please fill in a userame</strong></p>';
$missingEmail = '<p><strong>Please fill in your email address</strong></p>';
$invalidEmail = '<p><strong>Invalid email address! please check the email and try again</strong></p>';
$missingPassword = '<p><strong>Please fill in your password</strong></p>';
$invalidPassword = '<p><strong>Your password should be at least six characters long and include one capital letter and one number!</strong></p>';
$differentPassword = '<p><strong>Passwords don\'t match</strong></p>';
$missingPassword2 = '<p><strong>Please confirm your password</strong></p>';

$errors = "";
$username = "";
$email = "";
$password = "";

//    <!--Get username, email, password, password2-->

//Get username
if(empty($_POST["username"])){
    $errors .= $missingUsername;
    
}else{
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
}

//Get email
if(empty($_POST["email"])){
    $errors .= $missingEmail;
}else{
    //filter the email
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    // Then check if its valid
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= $invalidEmail;
    }
}

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

//    <!--Store errors in the errors variable-->
//    <!--If there are any errors, diaplay all ther error messages-->


if($errors){
    $resultMessage = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a>' . $errors . '</div>';
    echo $resultMessage;
    exit;
    
}

//No errors
//Prepare variables for the queries
$username = mysqli_real_escape_string($link, $username);

$email = mysqli_real_escape_string($link, $email);

$password = mysqli_real_escape_string($link, $password);

//$password = md5($password);

$password  = hash('sha256', $password);
//128 bits long -> 32 characters
// 256 bits -> 64 charactrs

//If username exists in the users table print error
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>';
    
//    echo '<div class="alert alert-danger">'. mysqli_error($link) .'</div>';
    exit;
}

$results = mysqli_num_rows($result);
if($results){
    echo '<div class="alert alert-danger">That username is already registered. Do you want to log in?</div>'; 
    exit;
}


//    <!--else-->

//If email exists in users table print error
$sql =  "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div class="alert alert-danger"> Error running the query!</div>';
    exit;
}

$results = mysqli_num_rows($result);
if($results){
    echo '<div class="alert alert-danger">That email is already registered. Do you want to login?</div>';
    exit;
    
}

//Create a unique activation code

$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    //byte: unit of data which is 8 bits long
    //bit: o or 1
    //16 bytes = 16*8 =128 bits
    //(2*2*2*2)*2*2*2......*2
    //16*16*....16
    //32 characters

//Insert user details and activation code in the users table

$sql = "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password', '$activationKey')";
//run the query
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">There was an error inserting user details in the database!</div>';
    echo '<div class="alert alert-danger">'.mysqli_error($link).'</div>';
    
    exit;
}


//Send the user an email with a link to activate.php with their email and activation code
$message = "Please click on this link to activate your account:\n\n";
$message .= "http://localhost/onlinenotesapp/activate.php?email=".urlencode($email). "&key=$activationKey";

echo "<div class='alert alert-success'><a href='http://localhost/onlinenotesapp/activate.php?email=".urlencode($email). "&key=$activationKey'>Activate your accout now</a></div>";

$sendmail = mail($email, 'Confirm your registration', $message, 'From: '.'nanumichael27@gmail.com');
 
if($sendmail){
    echo "<div class='alert alert-success'>Thank you for registering! confirmation email has been sent to $email. Please click on the activation link to activate your account.  </div>";
}
    
            
?>