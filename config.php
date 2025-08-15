<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$localhost = "localhost";
$username = "root";
$password = "";
$database = "cms_db";
$port = 3307;

// Create connection
$conn = new mysqli($localhost, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>