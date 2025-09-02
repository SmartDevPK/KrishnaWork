<?php
header('Content-Type: application/json');

$host = "localhost";
$port = 3307;
$user = "root";
$pass = "";
$db = "user_system";

// Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => "Error connecting to server: " . $conn->connect_error
    ]);
    exit;
}
?>