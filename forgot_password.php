<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

// PHPMailer namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

// Include database connection
include 'db.php';



// Set response type to JSON
header('Content-Type: application/json');

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the email safely from POST
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Check if email was provided
    if (empty($email)) {
        echo json_encode([
            "status" => "error",
            "message" => "Email is required!"
        ]);
        exit;
    }

    // Check if user exists in database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        // Generate secure token and expiry time
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save token and expiry to database
        $updateStmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $updateStmt->bind_param("sss", $token, $expiry, $email);
        $updateStmt->execute();

        // Generate reset link
        $resetLink = "http://localhost/KrishnaWork/reset_password.php?token=$token";

        // For local testing, log the email
        file_put_contents('emails.log', "To: $email\nLink: $resetLink\n\n", FILE_APPEND);

        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'emmanuelmichaelpk3@gmail.com';
            $mail->Password = 'vfav ycsh zccq lvrs';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Your Site Name');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = "Click this link to reset your password: <a href='$resetLink'>$resetLink</a>";

            $mail->send();

            // Success response
            echo json_encode([
                "status" => "success",
                "message" => "Reset link sent to your email!"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "Mailer Error: {$mail->ErrorInfo}"
            ]);
        }

    } else {
        // Email not found in database
        echo json_encode([
            "status" => "error",
            "message" => "Email not found!"
        ]);
    }

} else {
    // Invalid request method
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
}
?>