<?php


/* Attempt to connect to MySQL database */
$connection = mysqli_connect("localhost", "root", "Katinukas", "rush00");
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
