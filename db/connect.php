<?php
session_start();
/* Database credentials. */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'uba');
define('DB_PASSWORD', 'ogbonna123@');
define('DB_NAME', 'chowasa');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>