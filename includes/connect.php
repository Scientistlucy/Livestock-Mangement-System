
<?php
// Connection parameters
$servername = 'localhost';
$username = 'root';
$password = ''; // Leave empty if no password, or put your actual password here
$dbname = 'livestock'; // Wrap the database name in backticks

// Create the connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check for connection errors
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

?>
