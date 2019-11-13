<?php

//If the user is not logged in & rememberme cookie exists
if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])){
//    array_key_exists('user_id', $_SESSION)
    //COOKIE = $a . "," . bin2hex($b)
    //$b = hash('sha256', $a);
    //    extract $authentificators 1&2 from the cookie
    list($authentificator1, $authentificator2)=explode(',', $_COOKIE['rememberme']);
    $authentificator2 = hex2bin($authentificator2);
    $f2authentificator2 = hash('sha256', $authentificator2);
    //    Look for authentificator1 in the rememberme table
    $sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1'";
    $result = mysqli_query($link, $sql);
    if(!$result){
         echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>&times;</a> There was an error running the query" . mysqli_error($link)."</div>";
    exit;
        
    }
    $count = mysqli_num_rows($result);
    if($count !== 1){
        echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>&times;</a><strong> Remember me process failed</strong></div>";
        exit;
        
}
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC );
    //    if authentificator2 does not match
//        print error
    if(!hash_equals($row['f2authentificator2'], $f2authentificator2)){echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>&times;</a> hash_equals returns false" . mysqli_error($link)."</div>";
        
    }else{
        //        generate new authentificators
//        store them in cookie and rememberme table
//        log the user in and redirect to notes page
            $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
            //2*2 .....*2
            
            $authentificator2 = openssl_random_pseudo_bytes(20);
            
            //store them in a cookie
            function f1($value1, $value2){
                $answer= $value1 .",". bin2hex($value2);
                return $answer;
            }
            
            $cookieValue = f1($authentificator1, $authentificator2);
            setcookie(
            "rememberme", $cookieValue,
            time()+1296000
            );
            
            //                Run query to store them in rememberme table
            function f2($value){
                $answer = hash('sha256', $value);
                return $answer;
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
            }
        
        //log the user in and redirect them to the notes page
        $_SESSION['user_id'] = $row['user_id'];
        header("location:mainpageloggedin.php");
    }
}
//else{
//    
//    echo "<div class='alert alert-danger' style='margin-top: 50px'><a class='close' data-dismiss='alert'>&times;</a> User_id: " .$_SESSION['user_id']. "</div>";
//    
//    echo "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>&times;</a> Cookie value: " .$_COOKIE['rememberme']. "</div>";
//}


        
        ?>