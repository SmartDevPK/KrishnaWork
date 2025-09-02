<?php
header('Content-Type: application/json');
include 'db.php';

$response = ["status" => "error", "message" => "Unknown error"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
        $response["message"] = "All fields are required!";
    } else {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $response = ["status" => "error", "message" => "Email already exists!"];
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);
            if ($stmt->execute()) {
                $response = ["status" => "success", "message" => "Account created successfully!"];
            } else {
                $response = ["status" => "error", "message" => "Registration failed!"];
            }
        }
    }
}

echo json_encode($response);
