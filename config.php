<?php
// Enable error reporting for debugging
// session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session

// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbName = "cms_db";
$port = 3307;

// Create a new MySQLi connection
$conn = new mysqli($host, $user, $pass, $dbName, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment to test connection
// echo "Connected successfully";
?>