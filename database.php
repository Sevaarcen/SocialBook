<?php
$mysql_server = "localhost";
$mysql_username = "root";
$mysql_password = "CHANGEME";
$databasename = "SocialBook_DB";

// Create connection
$connection = mysqli_connect($mysql_server, $mysql_username, $mysql_password, $databasename);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . $connection->connect_error);
}
?>
