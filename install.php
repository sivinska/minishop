<?php

// Name of the file
$filename = 'rush00.sql';
// MySQL host
$mysql_host = 'gi6kn64hu98hy0b6.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306';
// MySQL username
$mysql_username = 'd5pemg5m2sv3lkuy';
// MySQL password
$mysql_password = 'gblaszkquv2fxruw';
// Database name
$mysql_database = 'otpz4163njjx6yae';

// Connect to MySQL server
$connection = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
		// Select database
mysqli_query($connection, "CREATE DATABASE IF NOT EXISTS ".$mysql_database);
mysqli_query($connection, "USE ".$mysql_database);
// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line)
{
	// Skip it if it's a comment
	if (substr($line, 0, 2) == '--' || $line == '')
    	continue;

	// Add this line to the current segment
	$templine .= $line;
	// If it has a semicolon at the end, it's the end of the query
	if (substr(trim($line), -1, 1) == ';')
	{
    	// Perform the query
    	mysqli_query($connection, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
    	// Reset temp variable to empty
    	$templine = '';
	}
}
echo "Tables imported successfully";
header('location: index.php');
?>
