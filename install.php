<?php

// Name of the file
$filename = 'rush00.sql';
// MySQL host
$mysql_host = 'localhost';
// MySQL username
$mysql_username = 'root';
// MySQL password
$mysql_password = '12345678';
// Database name
$mysql_database = 'rush00';

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
