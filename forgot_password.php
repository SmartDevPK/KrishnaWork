<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'db.php'; // Your database connection  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        echo json_encode([
            "status" => "error",
            "message" => "Email is required."
        ]);
        exit;
    }

    // Check if user exists     
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate token         
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $updateStmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $updateStmt->bind_param("sss", $token, $expiry, $email);
        $updateStmt->execute();

        $resetLink = "http://localhost/KrishnaWork/reset_password_form.php?token=$token";

        // Log locally for testing         
        file_put_contents('emails.log', "To: $email\nLink: $resetLink\n\n", FILE_APPEND);

        // Create styled email body
        $emailBody = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Password Reset</title>
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
            <div style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;'>
                <!-- Header -->
                <div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px; text-align: center;'>
                    <h1 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: 300; letter-spacing: 1px;'>
                        Krishna&Sons Limited
                    </h1>
                    <p style='color: #e8e8ff; margin: 10px 0 0 0; font-size: 16px;'>
                        Password Reset Request
                    </p>
                </div>
                
                <!-- Main Content -->
                <div style='padding: 40px 30px;'>
                    <div style='text-align: center; margin-bottom: 30px;'>
                        <div style='width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;'>
                            <span style='color: white; font-size: 32px;'>🔐</span>
                        </div>
                    </div>
                    
                    <h2 style='color: #333333; text-align: center; margin: 0 0 20px 0; font-size: 24px; font-weight: 400;'>
                        Reset Your Password
                    </h2>
                    
                    <p style='color: #666666; line-height: 1.6; margin: 0 0 25px 0; font-size: 16px; text-align: center;'>
                        We received a request to reset your password. Click the button below to create a new password for your account.
                    </p>
                    
                    <div style='text-align: center; margin: 35px 0;'>
                        <a href='$resetLink' 
                           style='display: inline-block; 
                                  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                  color: #ffffff; 
                                  text-decoration: none; 
                                  padding: 15px 40px; 
                                  border-radius: 50px; 
                                  font-weight: 600; 
                                  font-size: 16px; 
                                  letter-spacing: 0.5px;
                                  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
                                  transition: all 0.3s ease;'>
                            Reset My Password
                        </a>
                    </div>
                    
                    <div style='background-color: #f8f9ff; border-left: 4px solid #667eea; padding: 20px; margin: 30px 0; border-radius: 4px;'>
                        <p style='color: #555555; margin: 0; font-size: 14px; line-height: 1.5;'>
                            <strong>⚡ Quick Info:</strong><br>
                            • This link will expire in 1 hour<br>
                            • If you didn't request this reset, please ignore this email<br>
                            • For security, this link can only be used once
                        </p>
                    </div>
                    
                    <p style='color: #999999; font-size: 14px; line-height: 1.5; margin: 25px 0 0 0; text-align: center;'>
                        If the button doesn't work, copy and paste this link into your browser:<br>
                        <span style='color: #667eea; word-break: break-all; font-family: monospace; background-color: #f5f5f5; padding: 5px; border-radius: 3px; display: inline-block; margin-top: 5px;'>
                            $resetLink
                        </span>
                    </p>
                </div>
                
                <!-- Footer -->
                <div style='background-color: #f8f8f8; padding: 25px 30px; text-align: center; border-top: 1px solid #eeeeee;'>
                    <p style='color: #999999; margin: 0; font-size: 14px;'>
                        © 2024 Krishna&Sons Limited. All rights reserved.
                    </p>
                    <p style='color: #cccccc; margin: 10px 0 0 0; font-size: 12px;'>
                        This is an automated message, please do not reply to this email.
                    </p>
                </div>
            </div>
        </body>
        </html>";

        // Send email         
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'emmanuelmichaelpk3@gmail.com';
            $mail->Password = 'vfav ycsh zccq lvrs'; // Use app password             
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('emmanuelmichaelpk3@gmail.com', 'Krishna&Sons Limited');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = '🔐 Reset Your Password - Krishna&Sons Limited';
            $mail->Body = $emailBody;

            $mail->send();

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
        echo json_encode([
            "status" => "error",
            "message" => "Email not found!"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
}