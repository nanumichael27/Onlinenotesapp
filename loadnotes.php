<?php
session_start();
include('connection.php');

//get the user_id using the session variables
$user_id = $_SESSION['user_id'];

//Delete empty notes in the users database
$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($link, $sql);

if(!$result){
    echo "<div class='alert alert-warning'>An error occured</div>";
    
    exit;
}



//run a query to look for notes corresponding to user_id
$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY TIME DESC";



//show notes or alert message

if($result = mysqli_query($link, $sql)){
    
    if($row = mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $note = $row['note'];
            $time = $row['time'];
            $time = date('F d, Y h:i:s A', $time);
            $note_id = $row['id'];
        
            echo "
            <div class='note'>
            <div class='col-xs-5 col-sm-3 delete'>
                <button class='btn btn-lg btn-danger' style='width: 100%'>Delete</button>
            </div>
            <div class='noteheader' id='$note_id'>
        <div class='text'>$note</div>
        <div class='timetext'>$time</div>

    </div>
    </div>
    ";
        }
        
    }else{
            echo "<div class='alert alert-warning'>You have not created any notes yet</div>";
    }
    
}else{
        echo "<div class='alert alert-warning'>An error occured</div>";
//    echo "ERROR unable to execute $sql. ". mysqli_error($link);
    exit;
}




?>