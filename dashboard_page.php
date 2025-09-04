<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $companyName = htmlspecialchars(trim($_POST['companyName']));
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $tags = htmlspecialchars(trim($_POST['tags']));

    $stmt = $conn->prepare("INSERT INTO company_submissions (companyName, title, description, tags) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $companyName, $title, $description, $tags);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Message sent successfully ";
    } else {
        $_SESSION['error'] = "Failed to send message : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect to dashboard
    header("Location: dashboard.php");
    exit;
}
?>