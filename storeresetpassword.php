<!--This file receives: user_id, generated key to reset password, password1 and password2-->
<!--This file then resets password for user_id if all checks are correct-->

<?php
//start session and connect to the database
session_start();
include('connection.php');

// If user_id or key is missing
    //show error message
if(!isset($_POST['user_id']) || !isset($_POST['key'])){

            echo "<div class='alert alert-warning'>There was an error activating your account, please click on the link you recieved by email <div>";

            exit;
            }

 //else
            //Store them in two variables
            $user_id = $_POST['user_id'];
            $key = $_POST['key'];
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

        $missingPassword = '<p><strong>Please fill in your password</strong></p>';
        $invalidPassword = '<p><strong>Your password should be at least six characters long and include one capital letter and one number!</strong></p>';
        $differentPassword = '<p><strong>Passwords don\'t match</strong></p>';
        $missingPassword2 = '<p><strong>Please confirm your password</strong></p>';
        
        $errors ="";

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

//prepare variable for query
$password = mysqli_real_escape_string($link, $password);
$user_id = mysqli_real_escape_string($link, $user_id);

//$password = md5($password);

$password  = hash('sha256', $password);
//128 bits long -> 32 characters
// 256 bits -> 64 charactrs

//Run Query: Update users password in the users table
 
$sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";

$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div class="alert alert-danger">There was a problem storing the new password in the database!</div>';
    
//    echo '<div class="alert alert-danger">'. mysqli_error($link) .'</div>';
    exit;
}

// set the key status to  used in the forgotpassword table to prebent the key from being used twice
$sql = "UPDATE forgotpassword SET status='used' WHERE rkey='$key'";
$result = mysqli_query($link, $sql);

if(!$result){
    echo '<div class="alert alert-danger">Error running the query</div>';
    
//    echo '<div class="alert alert-danger">'. mysqli_error($link) .'</div>';
    exit;
}

echo '<div class="alert alert-success">Your password has been updated successfully! <a href="index.php">Login</a></div>';


?>