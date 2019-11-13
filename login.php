<?php

//Start session
session_start();
//Connect to the database
include ("connection.php");
//Check user inputs
//    Define error messages
$missingEmail = '<p><strong>Please enter your email</strong></p>';
$missingPassword = '<p><strong>Please enter your password</strong></p>';
$errors = "";

//    Get email and password
//    Store errors in errors variable
if(empty($_POST["loginemail"])){
    $errors .= $missingEmail;
}else{
    //filter the email
    $email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL);
  
}

if(empty($_POST["loginpassword"])){
    $errors .= $missingPassword;
}else{
    //filter the email
    $password = filter_var($_POST["loginpassword"], FILTER_SANITIZE_STRING);
  
}


//    If there are any errors
if($errors){
    //        Print error message
    $resultMessage = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">&times;</a>' . $errors . '</div>';
    echo $resultMessage;
    exit;
}else{
    
    
    //    else: No errors
//        Prepare variables for the query
    $email = mysqli_real_escape_string($link, $email);

    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);
    
//        Run query: Check combination of email & password exists
    $sql = "SELECT * FROM users WHERE (email='$email' AND password='$password' AND activation='activated')";
    $result = mysqli_query($link,  $sql);
    if(!$result){
    echo '<div class="alert alert-danger"> Error running the query!</div>';
    exit;
}
//        If email & password don't match print error
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>&times;</a><strong> Wrong email or password</strong></div>";
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        
        if(empty($_POST['rememberme'])){
            //log the user in: Set sssion variables
            //Ifremember me is not checked
                //print  "success"
            echo"success";
            
        }else{
            //                Create two variables $authentificator1 and $authentificator2
            $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
            //2*2 .....*2
            
            $authentificator2 = openssl_random_pseudo_bytes(20);
            
            //store them in a cookie
            function f1($a, $b){
                $c= $a .",". bin2hex($b);
                return $c;
            }
            $cookieValue = f1($authentificator1, $authentificator2);
            setcookie(
            "rememberme", $cookieValue,
            time()+1296000
            );
            
            //                Run query to store them in rememberme table
            function f2($a){
                $b = hash('sha256', $a);
                return $b;
            }
            
            $f2authentificator2 = f2($authentificator2);
            $user_id = $_SESSION["user_id"];
            $expiration = date('y_m_d H:i:s',time()+1296000);
            
            $sql = "INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expires) VALUES ('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";
            //lets run the query
            $result = mysqli_query($link, $sql);
            if(!$result){
                
//                If query unsuccessful
//                    Print error
                        echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>&times;</a> There was an error storing data to remember you next time" . mysqli_error($link)."</div>";
            }else{
//                    print "success"
                echo "success";
            }
//                
        }
        
    }


//            else

//                Store them in a cookie


    
    
}


?>