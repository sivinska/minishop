<?php


/* Attempt to connect to MySQL database */
$connection = mysqli_connect("localhost", "root", "12345678", "rush00");
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
