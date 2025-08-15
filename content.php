<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $userId = $_SESSION['user_id'];

    if ($action === 'add' || $action === 'edit') {
        // Add or edit content
        $title = trim($_POST['title']);
        $body = trim($_POST['body']);
        $contentId = isset($_POST['content_id']) ? (int) $_POST['content_id'] : null;

        // Validate inputs
        if (empty($title) || empty($body)) {
            $_SESSION['content_error'] = "Title and content are required";
            header("Location: index.php");
            exit();
        }

        // Handle image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $filename = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;

            // Check if image file is actual image
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check !== false) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = $targetPath;

                    // Delete old image if editing
                    if ($action === 'edit' && !empty($_POST['old_image_path'])) {
                        if (file_exists($_POST['old_image_path'])) {
                            unlink($_POST['old_image_path']);
                        }
                    }
                }
            }
        } elseif ($action === 'edit' && !empty($_POST['old_image_path'])) {
            $imagePath = $_POST['old_image_path'];
        }

        if ($action === 'add') {
            // Insert new content
            $stmt = $conn->prepare("INSERT INTO contents (user_id, title, body, image_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $userId, $title, $body, $imagePath);
        } else {
            // Update existing content
            $stmt = $conn->prepare("UPDATE contents SET title = ?, body = ?, image_path = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
            $stmt->bind_param("sssii", $title, $body, $imagePath, $contentId, $userId);
        }

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['content_error'] = "Failed to save content";
            header("Location: index.php");
            exit();
        }
    } elseif ($action === 'delete') {
        // Delete content
        $contentId = (int) $_POST['content_id'];

        // Get image path first
        $stmt = $conn->prepare("SELECT image_path FROM contents WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $contentId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $content = $result->fetch_assoc();

            // Delete the content
            $stmt = $conn->prepare("DELETE FROM contents WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $contentId, $userId);

            if ($stmt->execute()) {
                // Delete associated image if exists
                if (!empty($content['image_path']) && file_exists($content['image_path'])) {
                    unlink($content['image_path']);
                }
            }
        }

        header("Location: index.php");
        exit();
    }
}

header("Location: index.php");
exit();
?>