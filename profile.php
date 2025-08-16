<?php


// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cms_db');
define('DB_PORT', 3307);


try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}



if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $body = trim(filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING));
    $content_id = filter_input(INPUT_POST, 'content_id', FILTER_VALIDATE_INT);
    $existing_image = filter_input(INPUT_POST, 'existing_image', FILTER_SANITIZE_STRING);

    $imagePath = $existing_image ?: '';

    if (!empty($_FILES['image']['name'])) {
        $uploadResult = handleFileUpload();
        if ($uploadResult['success']) {
            $imagePath = $uploadResult['path'];
        } else {
            $_SESSION['error'] = $uploadResult['message'];
        }
    }

    switch ($action) {
        case 'add':
            addContent($conn, $user_id, $title, $body, $imagePath);
            break;
        case 'edit':
            updateContent($conn, $content_id, $title, $body, $imagePath);
            break;
    }

    header("Location: " . filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_URL));
    exit();
}



if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        deleteContent($conn, $id);
        header("Location: " . filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_URL));
        exit();
    }
}



$contents = fetchAllContents($conn);



function handleFileUpload()
{
    $targetDir = "uploads/";
    $maxFileSize = 2 * 1024 * 1024;
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $file = $_FILES['image'];
    $fileType = mime_content_type($file['tmp_name']);
    $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $fileExt;
    $targetFilePath = $targetDir . $fileName;

    if ($file['size'] > $maxFileSize) {
        return ['success' => false, 'message' => 'File size exceeds 2MB limit'];
    }

    if (!in_array($fileType, $allowedTypes)) {
        return ['success' => false, 'message' => 'Only JPG, PNG & GIF files are allowed'];
    }

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        return ['success' => true, 'path' => $targetFilePath];
    }

    return ['success' => false, 'message' => 'File upload failed'];
}

function addContent($conn, $user_id, $title, $body, $imagePath)
{
    $stmt = $conn->prepare("INSERT INTO contents (user_id, title, body, image_path, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("isss", $user_id, $title, $body, $imagePath);

    if (!$stmt->execute()) {
        $_SESSION['error'] = "Failed to add content: " . $stmt->error;
    }

    $stmt->close();
}

function updateContent($conn, $id, $title, $body, $imagePath)
{
    $stmt = $conn->prepare("UPDATE contents SET title=?, body=?, image_path=?, updated_at=NOW() WHERE id=?");
    $stmt->bind_param("sssi", $title, $body, $imagePath, $id);

    if (!$stmt->execute()) {
        $_SESSION['error'] = "Failed to update content: " . $stmt->error;
    }

    $stmt->close();
}

function deleteContent($conn, $id)
{
    $stmt = $conn->prepare("SELECT image_path FROM contents WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && !empty($row['image_path']) && file_exists($row['image_path'])) {
        unlink($row['image_path']);
    }

    $stmt = $conn->prepare("DELETE FROM contents WHERE id = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        $_SESSION['error'] = "Failed to delete content: " . $stmt->error;
    }

    $stmt->close();
}

function fetchAllContents($conn)
{
    $contents = [];

    $stmt = $conn->prepare("SELECT * FROM contents WHERE user_id = ? ORDER BY updated_at DESC");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $contents[] = $row;
    }

    $stmt->close();
    return $contents;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Management</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }


        .content-section {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin: 0 auto;
            max-width: 1200px;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .header-title {
            color: #2c3e50;
            font-size: 1.8rem;
            margin: 0;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Controls Section */
        .content-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .btn {
            padding: 0.6rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .search-box {
            display: flex;
            flex-grow: 1;
            max-width: 400px;
        }

        .search-input {
            flex-grow: 1;
            padding: 0.6rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 0.9rem;
        }

        .btn-search {
            background-color: #2c3e50;
            color: white;
            border-radius: 0 4px 4px 0;
        }

        .btn-search:hover {
            background-color: #1a252f;
        }

        /* Content Form Styles */
        .content-form {
            background: #f9f9f9;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            border: 1px solid #eee;
            display: none;
        }

        .form-title {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-size: 1.4rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #34495e;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: #3498db;
            outline: none;
        }

        .form-textarea {
            min-height: 150px;
            resize: vertical;
        }

        /* Image Upload Styles */
        .image-upload {
            margin-bottom: 1.5rem;
        }

        .file-input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }

        .image-preview {
            margin: 1rem 0;
            max-width: 300px;
            max-height: 200px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
            border-radius: 4px;
            border: 1px dashed #ccc;
            padding: 1rem;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .preview-text {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .btn-remove {
            background-color: #95a5a6;
            color: white;
        }

        .btn-remove:hover {
            background-color: #7f8c8d;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-save {
            background-color: #27ae60;
            color: white;
        }

        .btn-save:hover {
            background-color: #219653;
        }

        .btn-cancel {
            background-color: #95a5a6;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #7f8c8d;
        }

        /* Content List Styles */
        .content-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .content-item {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #eee;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .content-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .item-header {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        .item-title {
            color: #2c3e50;
            margin: 0 0 0.5rem 0;
            font-size: 1.2rem;
        }

        .item-meta {
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        .item-body {
            padding: 1rem;
        }

        .item-content {
            color: #34495e;
            margin: 0 0 1rem 0;
            line-height: 1.6;
        }

        .item-image {
            margin-top: 1rem;
        }

        .item-image img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .item-actions {
            display: flex;
            gap: 0.5rem;
            padding: 0 1rem 1rem 1rem;
        }

        .btn-edit {
            background-color: #3498db;
            color: white;
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }

        .btn-edit:hover {
            background-color: #2980b9;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }

        .empty-state p {
            margin: 0;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .content-controls {
                flex-direction: column;
            }

            .search-box {
                max-width: 100%;
            }

            .content-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="content-section">
        <div class="header">
            <h1 class="header-title">Content Management</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="content-controls">
            <button class="btn btn-primary" onclick="showAddForm()">Add New Content</button>
            <div class="search-box">
                <input type="text" id="search-content" class="search-input" placeholder="Search content...">
                <button class="btn btn-search" onclick="searchContent()">Search</button>
            </div>
        </div>

        <div id="content-form" class="content-form">
            <h2 id="form-title" class="form-title">Add New Content</h2>
            <form id="content-form-data" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="form-action" value="add">
                <input type="hidden" name="content_id" id="content-id">
                <input type="hidden" name="existing_image" id="existing-image">

                <div class="form-group">
                    <label for="content-title">Title</label>
                    <input type="text" name="title" id="content-title" class="form-input" placeholder="Enter title"
                        required>
                </div>

                <div class="form-group">
                    <label for="content-body">Content</label>
                    <textarea name="body" id="content-body" class="form-textarea"
                        placeholder="Write your content here..." required></textarea>
                </div>

                <div class="form-group image-upload">
                    <label for="content-image">Image Upload</label>
                    <input type="file" name="image" id="content-image" class="file-input" accept="image/*">
                    <div id="image-preview" class="image-preview">
                        <span class="preview-text">No image selected</span>
                    </div>
                    <button type="button" class="btn btn-remove" onclick="removeImage()">Remove Image</button>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-save">Save</button>
                    <button type="button" class="btn btn-cancel" onclick="cancelEdit()">Cancel</button>
                </div>
            </form>
        </div>

        <div id="content-list" class="content-list">
            <?php if (!empty($contents)): ?>
                <?php foreach ($contents as $row): ?>
                    <div class="content-item">
                        <div class="item-header">
                            <h3 class="item-title"><?= htmlspecialchars($row['title']) ?></h3>
                            <div class="item-meta">
                                <span class="date">
                                    Created: <?= date('M j, Y', strtotime($row['created_at'])) ?> |
                                    Updated: <?= date('M j, Y', strtotime($row['updated_at'])) ?>
                                </span>
                            </div>
                        </div>

                        <div class="item-body">
                            <p class="item-content"><?= nl2br(htmlspecialchars($row['body'])) ?></p>
                            <?php if (!empty($row['image_path'])): ?>
                                <div class="item-image">
                                    <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Content Image">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="item-actions">
                            <button class="btn btn-edit"
                                onclick="editContent(<?= $row['id'] ?>, '<?= addslashes($row['title']) ?>', '<?= addslashes($row['body']) ?>', '<?= addslashes($row['image_path']) ?>')">
                                Edit
                            </button>
                            <button class="btn btn-delete" onclick="deleteContent(<?= $row['id'] ?>)">
                                Delete
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="icon-empty"></i>
                    <p>No content found. Add some content!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>


        function showAddForm() {
            document.getElementById("content-form").style.display = "block";
            document.getElementById("form-title").innerText = "Add New Content";
            document.getElementById("form-action").value = "add";
            document.getElementById("content-id").value = "";
            document.getElementById("content-title").value = "";
            document.getElementById("content-body").value = "";
            document.getElementById("existing-image").value = "";
            document.getElementById("image-preview").innerHTML = '<span class="preview-text">No image selected</span>';
        }

        function cancelEdit() {
            document.getElementById("content-form").style.display = "none";
        }

        function editContent(id, title, body, imagePath) {
            showAddForm();
            document.getElementById("form-title").innerText = "Edit Content";
            document.getElementById("form-action").value = "edit";
            document.getElementById("content-id").value = id;
            document.getElementById("content-title").value = title;
            document.getElementById("content-body").value = body;
            document.getElementById("existing-image").value = imagePath;

            if (imagePath) {
                document.getElementById("image-preview").innerHTML = '<img src="' + imagePath + '" alt="Image Preview">';
            } else {
                document.getElementById("image-preview").innerHTML = '<span class="preview-text">No image selected</span>';
            }
        }

        function removeImage() {
            document.getElementById("content-image").value = "";
            document.getElementById("existing-image").value = "";
            document.getElementById("image-preview").innerHTML = '<span class="preview-text">No image selected</span>';
        }



        function deleteContent(id) {
            if (confirm("Are you sure you want to delete this content?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?action=delete&id=" + id;
            }
        }

        function searchContent() {
            const query = document.getElementById("search-content").value.toLowerCase();
            const items = document.querySelectorAll(".content-item");

            items.forEach(item => {
                const title = item.querySelector(".item-title").textContent.toLowerCase();
                const body = item.querySelector(".item-content").textContent.toLowerCase();
                item.style.display = (title.includes(query) || body.includes(query)) ? "block" : "none";
            });
        }



        document.getElementById("content-image").addEventListener("change", function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById("image-preview");
            preview.innerHTML = "";

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Image Preview">';
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<span class="preview-text">No image selected</span>';
            }
        });
    </script>
</body>

</html>