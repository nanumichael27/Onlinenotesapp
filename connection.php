<?php

$link = mysqli_connect("localhost", "notes", "VHZvNTu2FHD3pH9k", "onlienotes");
if(mysqli_connect_error()){
    die("<div class='alert alert-warning'>ERROR: Unable to connect:". mysqli_connect_error() . "</div>");
}



?>