<?php
session_start();

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'register') {
        // Registration logic
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Validate inputs
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['register_error'] = "All fields are required";
            header("Location: index.php");
            exit();
        }

        // Check if user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['register_error'] = "Username or email already exists";
            header("Location: index.php");
            exit();
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['register_error'] = "Registration failed. Please try again.";
            header("Location: index.php");
            exit();
        }
    } elseif ($action === 'login') {
        // Login logic
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Validate inputs
        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = "Username and password are required";
            header("Location: index.php");
            exit();
        }

        // Get user from database
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: profile.php");
                exit();
            }
        }

        $_SESSION['login_error'] = "Invalid username or password";
        header("Location: index.php");
        exit();
    }
}

header("Location: content.php");
exit();
?>