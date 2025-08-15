<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'register') {
        // [Keep all your existing registration code exactly the same]
        // Only change the redirect after successful registration if you want
        header("Location: index.php"); // Or change to content.php if you want
        exit();

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

                // CHANGE THIS LINE TO REDIRECT TO content.php
                header("Location: content.php");
                exit();
            }
        }

        $_SESSION['login_error'] = "Invalid username or password";
        header("Location: index.php");
        exit();
    }
}

// Default redirect if someone accesses auth.php directly
header("Location: index.php");
exit();
?>