<?php 

//start session and connect 
session_start();
include('connection.php');

//get user_id
$user_id = $_SESSION['user_id'];

//get username sent through ajax
$username = $_POST['username'];

//Run query and update username
$sql = "UPDATE `users` SET `username` = '$username' WHERE `user_id` = $user_id";
$result = mysqli_query($link, $sql);

if(!$result){
    echo "<div class='alert alert-danger'>There was an error updating the username in the database</div>";
}

?>