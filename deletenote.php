<?php
session_start();
include('connection.php');

//get the id of the note sent through the Ajax call
$id = $_POST['id'];
//Get the id of the user from the session variable for security purposes
$user_id = $_SESSION['user_id'];
//Run a query to delete the note from the notes table
$sql = "DELETE FROM notes WHERE id = '$id' AND user_id = '$user_id' ";

$result = mysqli_query($link, $sql);
if(!$result){
    echo "error";
    
}


?>
