<?php
require_once 'config.php';

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Management System</title>
    <style>
        /* CSS styles will go here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Auth Section */
        .auth-section {
            background: white;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .auth-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .auth-tab {
            padding: 10px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            color: #666;
        }

        .auth-tab.active {
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
        }

        .auth-form {
            padding: 20px 0;
        }

        .auth-form h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .auth-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .auth-form button {
            width: 100%;
            padding: 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Content Section */
        .content-section {
            display: none;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .header h1 {
            color: #2c3e50;
        }

        .logout-btn {
            padding: 8px 15px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .content-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .content-controls button {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-box {
            display: flex;
        }

        .search-box input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }

        .search-box button {
            padding: 10px 15px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }

        /* Content Form */
        .content-form {
            display: none;
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .content-form h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .content-form input,
        .content-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .content-form textarea {
            min-height: 150px;
        }

        .image-upload {
            margin-bottom: 15px;
        }

        .image-upload label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .image-preview {
            margin: 10px 0;
            max-width: 300px;
            max-height: 200px;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
        }

        .form-buttons {
            display: flex;
            gap: 10px;
        }

        .form-buttons button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-buttons button:first-child {
            background-color: #27ae60;
            color: white;
        }

        .form-buttons button:last-child {
            background-color: #95a5a6;
            color: white;
        }

        /* Content List */
        .content-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .content-item {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .content-item h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .content-item p {
            margin-bottom: 15px;
            color: #555;
        }

        .content-item img {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .content-item .item-actions {
            display: flex;
            gap: 10px;
        }

        .content-item .item-actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .content-item .item-actions button.edit-btn {
            background-color: #3498db;
            color: white;
        }

        .content-item .item-actions button.delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        @media (max-width: 768px) {
            .content-controls {
                flex-direction: column;
                gap: 10px;
            }

            .search-box {
                width: 100%;
            }

            .content-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (!$loggedIn): ?>
            <!-- Auth Section -->
            <div id="auth-section" class="auth-section">
                <div class="auth-tabs">
                    <button class="auth-tab active" onclick="switchAuthTab('login')">Login</button>
                    <button class="auth-tab" onclick="switchAuthTab('register')">Register</button>
                </div>

                <div id="login-form" class="auth-form">
                    <h2>Login</h2>
                    <form action="auth.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit">Login</button>
                    </form>
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <p class="error"><?php echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']); ?></p>
                    <?php endif; ?>
                </div>

                <div id="register-form" class="auth-form" style="display: none;">
                    <h2>Register</h2>
                    <form action="auth.php" method="POST">
                        <input type="hidden" name="action" value="register">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="submit">Register</button>
                    </form>
                    <?php if (isset($_SESSION['register_error'])): ?>
                        <p class="error"><?php echo $_SESSION['register_error'];
                        unset($_SESSION['register_error']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Content Management Section -->
            <div id="content-section" class="content-section">
                <div class="header">
                    <h1>Content Management</h1>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>

                <div class="content-controls">
                    <button onclick="showAddForm()">Add New Content</button>
                    <div class="search-box">
                        <input type="text" id="search-content" placeholder="Search content...">
                        <button onclick="searchContent()">Search</button>
                    </div>
                </div>

                <!-- Add/Edit Content Form -->
                <div id="content-form" class="content-form" style="display: none;">
                    <h2 id="form-title">Add New Content</h2>
                    <form id="content-form-data" action="content.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" id="form-action" value="add">
                        <input type="hidden" name="content_id" id="content-id">
                        <input type="text" name="title" id="content-title" placeholder="Title" required>
                        <textarea name="body" id="content-body" placeholder="Content body" required></textarea>

                        <div class="image-upload">
                            <label for="content-image">Image:</label>
                            <input type="file" name="image" id="content-image" accept="image/*">
                            <div id="image-preview" class="image-preview"></div>
                            <button type="button" onclick="removeImage()">Remove Image</button>
                        </div>

                        <div class="form-buttons">
                            <button type="submit">Save</button>
                            <button type="button" onclick="cancelEdit()">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Content List -->
                <div id="content-list" class="content-list">
                    <?php
                    // Fetch content from database
                    $stmt = $conn->prepare("SELECT * FROM contents WHERE user_id = ? ORDER BY updated_at DESC");
                    $stmt->bind_param("i", $_SESSION['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="content-item">';
                            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                            echo '<p>' . nl2br(htmlspecialchars($row['body'])) . '</p>';
                            if (!empty($row['image_path'])) {
                                echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Content Image">';
                            }
                            echo '<div class="item-actions">';
                            echo '<button class="edit-btn" onclick="editContent(' . $row['id'] . ', \'' . addslashes($row['title']) . '\', \'' . addslashes($row['body']) . '\', \'' . addslashes($row['image_path']) . '\')">Edit</button>';
                            echo '<button class="delete-btn" onclick="deleteContent(' . $row['id'] . ')">Delete</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No content found. Add some content to get started!</p>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // JavaScript functions
        function switchAuthTab(tab) {
            const tabs = document.querySelectorAll('.auth-tab');
            tabs.forEach(t => t.classList.remove('active'));

            if (tab === 'login') {
                document.querySelector('.auth-tab:first-child').classList.add('active');
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'none';
            } else {
                document.querySelector('.auth-tab:last-child').classList.add('active');
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'block';
            }
        }

        function showAddForm() {
            document.getElementById('form-title').textContent = 'Add New Content';
            document.getElementById('form-action').value = 'add';
            document.getElementById('content-id').value = '';
            document.getElementById('content-title').value = '';
            document.getElementById('content-body').value = '';
            document.getElementById('content-image').value = '';
            document.getElementById('image-preview').innerHTML = '';
            document.getElementById('content-form').style.display = 'block';
        }

        function editContent(id, title, body, imagePath) {
            document.getElementById('form-title').textContent = 'Edit Content';
            document.getElementById('form-action').value = 'edit';
            document.getElementById('content-id').value = id;
            document.getElementById('content-title').value = title;
            document.getElementById('content-body').value = body;
            document.getElementById('content-image').value = '';

            if (imagePath) {
                document.getElementById('image-preview').innerHTML = `<img src="${imagePath}" alt="Preview">`;
            } else {
                document.getElementById('image-preview').innerHTML = '';
            }

            document.getElementById('content-form').style.display = 'block';
        }

        function cancelEdit() {
            document.getElementById('content-form').style.display = 'none';
        }

        function removeImage() {
            document.getElementById('content-image').value = '';
            document.getElementById('image-preview').innerHTML = '';
        }

        function deleteContent(id) {
            if (confirm('Are you sure you want to delete this content?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'content.php';

                const inputAction = document.createElement('input');
                inputAction.type = 'hidden';
                inputAction.name = 'action';
                inputAction.value = 'delete';
                form.appendChild(inputAction);

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'content_id';
                inputId.value = id;
                form.appendChild(inputId);

                document.body.appendChild(form);
                form.submit();
            }
        }

        function searchContent() {
            const query = document.getElementById('search-content').value.toLowerCase();
            const items = document.querySelectorAll('.content-item');

            items.forEach(item => {
                const title = item.querySelector('h3').textContent.toLowerCase();
                const body = item.querySelector('p').textContent.toLowerCase();

                if (title.includes(query) || body.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Image preview functionality
        document.getElementById('content-image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('image-preview').innerHTML =
                        `<img src="${event.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>