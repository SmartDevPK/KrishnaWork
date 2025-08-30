<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2c3e50;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #2ecc71;
            --warning: #f39c12;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: var(--secondary);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        .section {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 25px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .section-title {
            color: var(--secondary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            color: var(--primary);
        }

        .container {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }

        .side-box {
            width: 150px;
            min-width: 150px;
            background: linear-gradient(135deg, var(--primary) 0%, #2980b9 100%);
            color: white;
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .side-box i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .side-box h3 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .side-box p {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .center-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group textarea {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .upload-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            padding: 20px;
            border: 2px dashed #ddd;
            border-radius: var(--radius);
            transition: all 0.3s ease;
        }

        .upload-section:hover {
            border-color: var(--primary);
            background-color: rgba(52, 152, 219, 0.05);
        }

        .upload-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--radius);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .submit-btn {
            background-color: var(--success);
            align-self: center;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #27ae60;
        }

        #imageUpload {
            display: none;
        }

        .image-preview {
            width: 100%;
            max-width: 300px;
            height: 200px;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .about-content {
            display: flex;
            gap: 30px;
        }

        .text-column {
            flex: 1;
        }

        .text-column h1 {
            color: var(--secondary);
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .text-column p {
            color: #555;
            margin-bottom: 15px;
            line-height: 1.7;
        }

        .image-column {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-column img {
            width: 100%;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .feature-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-img {
            height: 180px;
            overflow: hidden;
        }

        .feature-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .feature-card:hover .feature-img img {
            transform: scale(1.05);
        }

        .feature-content {
            padding: 20px;
        }

        .feature-content h3 {
            color: var(--secondary);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .feature-content p {
            color: #666;
            font-size: 0.95rem;
        }

        /* New styles for additional sections */
        .design-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .design-item {
            text-align: center;
            padding: 15px;
            background: var(--light);
            border-radius: var(--radius);
        }

        .design-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .text-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .text-item {
            padding: 20px;
            background: var(--light);
            border-radius: var(--radius);
            text-align: center;
        }

        .contact-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 30px;
        }

        .contact-info {
            padding: 20px;
            background: var(--light);
            border-radius: var(--radius);
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            font-size: 1rem;
        }

        .contact-form textarea {
            height: 100px;
            resize: vertical;
        }

        .comment-section {
            padding: 20px;
            background: var(--light);
            border-radius: var(--radius);
        }

        .comment-input {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .comment-input input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: var(--radius);
        }

        .btn {
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #2980b9;
        }

        @media (max-width: 900px) {
            .about-content {
                flex-direction: column;
            }

            .container {
                flex-wrap: wrap;
            }

            .side-box {
                width: 100%;
                flex-direction: row;
                justify-content: start;
                gap: 15px;
            }

            .side-box i {
                margin-bottom: 0;
                font-size: 1.5rem;
            }

            .design-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .text-grid {
                grid-template-columns: 1fr;
            }

            .contact-section {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .header h1 {
                font-size: 2rem;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .design-grid {
                grid-template-columns: 1fr;
            }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: var(--success);
            color: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .notification.show {
            transform: translateX(0);
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Company Dashboard</h1>
            <p>Manage your company profile and content</p>
        </div>

        <!-- Company Details Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-building"></i> Company Details</h2>
            <div class="container">
                <div class="side-box">
                    <i class="fas fa-info-circle"></i>
                    <h3>Company Info</h3>
                    <p>Fill in your details</p>
                </div>

                <div class="center-content">
                    <div class="form-section">
                        <div class="form-group">
                            <label for="companyName">Company Name</label>
                            <input type="text" id="companyName" placeholder="Enter your company name" required>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" placeholder="Enter title" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" placeholder="Enter description" required rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" id="tags" placeholder="e.g., tech, startup" required>
                        </div>
                    </div>
                </div>

                <div class="side-box">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Pro Tip</h3>
                    <p>Be specific with your tags</p>
                </div>
            </div>
        </div>

        <!-- Image Upload Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-upload"></i> Upload Company Image</h2>
            <div class="container">
                <div class="side-box">
                    <i class="fas fa-images"></i>
                    <h3>Image Upload</h3>
                    <p>JPG, PNG or GIF</p>
                </div>

                <div class="center-content">
                    <div class="upload-section">
                        <button type="button" class="upload-btn"
                            onclick="document.getElementById('imageUpload').click();">
                            <i class="fas fa-file-image"></i> Choose Image
                        </button>
                        <button type="button" class="upload-btn submit-btn" id="uploadSubmit">
                            <i class="fas fa-cloud-upload-alt"></i> Upload
                        </button>

                        <div class="image-preview">
                            <p id="previewText">Image preview will appear here</p>
                            <img id="previewImage" src="" alt="Preview" style="display: none;">
                        </div>

                        <form action="upload.php" method="POST" enctype="multipart/form-data" style="display: none;">
                            <input type="file" id="imageUpload" name="image" accept="image/*">
                        </form>
                    </div>
                </div>

                <div class="side-box">
                    <i class="fas fa-camera"></i>
                    <h3>Image Tips</h3>
                    <p>Use high-quality images</p>
                </div>
            </div>
        </div>

        <!-- Who We Are Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-users"></i> Who We Are</h2>
            <div class="container">
                <div class="side-box">
                    <i class="fas fa-question-circle"></i>
                    <h3>About Us</h3>
                    <p>Tell your story</p>
                </div>

                <div class="about-content">
                    <div class="text-column">
                        <h1>Who We Are?</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis corrupti doloremque fugiat quod
                            magni suscipit similique, magnam ea earum labore quasi beatae? Tenetur molestiae possimus
                            eum accusamus doloremque veritatis eveniet porro nisi incidunt.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores mollitia laborum saepe quo
                            nihil nostrum consectetur tempore! Ea dolore iure numquam temporibus nihil.</p>
                    </div>

                    <div class="image-column">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80"
                            alt="Company Image">
                    </div>
                </div>

                <div class="side-box">
                    <i class="fas fa-rocket"></i>
                    <h3>Our Mission</h3>
                    <p>Driving innovation</p>
                </div>
            </div>
        </div>

        <!-- The Amipi Way Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-star"></i> The Amipi Way</h2>
            <div class="container">
                <div class="side-box">
                    <i class="fas fa-gem"></i>
                    <h3>Our Values</h3>
                    <p>What drives us</p>
                </div>

                <div class="center-content">
                    <div class="features">
                        <div class="feature-card">
                            <div class="feature-img">
                                <img src="https://images.unsplash.com/photo-1568992687947-868a62a9f521?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80"
                                    alt="Innovation">
                            </div>
                            <div class="feature-content">
                                <h3>Innovation</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi dolores minus dicta
                                    repellendus quae voluptatum.</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-img">
                                <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80"
                                    alt="Quality">
                            </div>
                            <div class="feature-content">
                                <h3>Quality</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi dolores minus dicta
                                    repellendus quae voluptatum.</p>
                            </div>
                        </div>

                        <div class="feature-card">
                            <div class="feature-img">
                                <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80"
                                    alt="Teamwork">
                            </div>
                            <div class="feature-content">
                                <h3>Teamwork</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi dolores minus dicta
                                    repellendus quae voluptatum.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="side-box">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Excellence</h3>
                    <p>Always improving</p>
                </div>
            </div>
        </div>

        <!-- Design Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-paint-brush"></i> Design Excellence</h2>
            <div class="container">
                <div class="side-box">
                    <i class="fas fa-palette"></i>
                    <h3>Design</h3>
                    <p>Our approach</p>
                </div>

                <div class="center-content">
                    <div class="design-grid">
                        <div class="design-item">
                            <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                alt="Design">
                            <h3>Design</h3>
                        </div>
                        <div class="design-item">
                            <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                alt="Design">
                            <h3>Design</h3>
                        </div>
                        <div class="design-item">
                            <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                alt="Design">
                            <h3>Design</h3>
                        </div>
                        <div class="design-item">
                            <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80"
                                alt="Design">
                            <h3>Design</h3>
                        </div>
                    </div>
                </div>

                <div class="side-box">
                    <i class="fas fa-award"></i>
                    <h3>Quality</h3>
                    <p>Premium results</p>
                </div>
            </div>
        </div>

        <!-- Text Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-quote-left"></i> Our Philosophy</h2>
            <div class="container">
                <div class="side-box">
                    <i class="fas fa-brain"></i>
                    <h3>Thinking</h3>
                    <p>Our approach</p>
                </div>

                <div class="center-content">
                    <div class="text-grid">
                        <div class="text-item">
                            <h3>It is a long established fact that a reader will be</h3>
                        </div>
                        <div class="text-item">
                            <h3>It is a long established fact that a reader will be</h3>
                        </div>
                        <div class="text-item">
                            <h3>It is a long established fact that a reader will be</h3>
                        </div>
                    </div>
                </div>

                <div class="side-box">
                    <i class="fas fa-rocket"></i>
                    <h3>Innovation</h3>
                    <p>Forward thinking</p>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="section">
            <h2 class="section-title"><i class="fas fa-envelope"></i> Contact Us</h2>
            <div class="container">
                <div class="side-box">
                    <i class="fas fa-store"></i>
                    <h3>About Shop</h3>
                    <p>Visit us</p>
                </div>

                <div class="center-content">
                    <div class="contact-section">
                        <div class="contact-info">
                            <h1>About shop</h1>
                            <h2>Address</h2>
                            <p>123 Business Street, Commerce City</p>
                            <h3>+123456789</h3>
                            <h4>demo@gmail.com</h4>
                        </div>

                        <div class="contact-info">
                            <h1>Get in touch</h1>
                            <form class="contact-form">
                                <input type="text" placeholder="Full Name">
                                <input type="email" placeholder="Email">
                                <input type="text" placeholder="Subject">
                                <textarea placeholder="Message"></textarea>
                                <button type="submit" class="btn">Send</button>
                            </form>
                        </div>

                        <div class="contact-info comment-section">
                            <h2>Comments</h2>
                            <p>We value your feedback</p>
                            <div class="comment-input">
                                <input type="text" placeholder="Your comment">
                                <button type="submit" class="btn">Publish</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="side-box">
                    <i class="fas fa-comments"></i>
                    <h3>Feedback</h3>
                    <p>We're listening</p>
                </div>
            </div>
        </div>
    </div>

    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i> Your changes have been saved successfully!
    </div>

    <script>
        // Image preview functionality
        document.getElementById('imageUpload').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('previewImage').style.display = 'block';
                    document.getElementById('previewText').style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });

        // Simulate upload success
        document.getElementById('uploadSubmit').addEventListener('click', function () {
            const notification = document.getElementById('notification');
            notification.classList.add('show');

            setTimeout(function () {
                notification.classList.remove('show');
            }, 3000);
        });
    </script>
</body>

</html>