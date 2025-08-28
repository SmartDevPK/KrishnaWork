<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password, failed_attempts, account_locked_until FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $failed_attempts, $locked_until);
        $stmt->fetch();

        // Check if account is locked
        $current_time = new DateTime();
        if ($locked_until && $current_time < new DateTime($locked_until)) {
            $remaining = (new DateTime($locked_until))->getTimestamp() - $current_time->getTimestamp();
            echo json_encode(["status" => "error", "message" => "Account locked. Try again in $remaining seconds."]);
            exit;
        }

        if (password_verify($password, $hashed_password)) {
            // Reset failed attempts on successful login
            $stmt = $conn->prepare("UPDATE users SET failed_attempts = 0, account_locked_until = NULL WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $_SESSION['user_id'] = $id;
            echo json_encode(["status" => "success", "message" => "Login successful"]);
        } else {
            // Increment failed attempts
            $failed_attempts++;
            $lock_time = null;

            if ($failed_attempts >= 5) {
                $lock_duration = 15 * 60; // 15 minutes lock
                $lock_time = date('Y-m-d H:i:s', time() + $lock_duration);
                $failed_attempts = 0; // reset counter after lock
            }

            $stmt = $conn->prepare("UPDATE users SET failed_attempts = ?, account_locked_until = ? WHERE id = ?");
            $stmt->bind_param("isi", $failed_attempts, $lock_time, $id);
            $stmt->execute();

            $msg = $lock_time ? "Too many failed attempts. Account locked for 15 minutes." : "Incorrect password";
            echo json_encode(["status" => "error", "message" => $msg]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No account found"]);
    }
}
?>