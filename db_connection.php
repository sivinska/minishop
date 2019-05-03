<?php


/* Attempt to connect to MySQL database */
$connection = mysqli_connect("gi6kn64hu98hy0b6.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306", "d5pemg5m2sv3lkuy", "gblaszkquv2fxruw", "otpz4163njjx6yae");
// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
