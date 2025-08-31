<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Sign In or Create Account</title>
    <style>
        /* Basic styling - you can expand this or keep your style.css */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation: float 15s ease-in-out infinite;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 75%;
            animation: float 18s ease-in-out infinite;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 80%;
            animation: float 12s ease-in-out infinite;
        }

        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 70%;
            left: 15%;
            animation: float 20s ease-in-out infinite;
        }

        .shape:nth-child(5) {
            width: 90px;
            height: 90px;
            top: 30%;
            left: 50%;
            animation: float 16s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-40px) translateX(40px);
            }
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 450px;
            padding: 30px;
            box-sizing: border-box;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            color: #764ba2;
            margin: 0;
            font-size: 28px;
        }

        .logo p {
            color: #6b7280;
            margin: 5px 0 0;
            font-size: 14px;
        }

        .form-container {
            position: relative;
        }

        .form {
            display: none;
        }

        .form.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-title {
            text-align: center;
            color: #4b5563;
            margin-top: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4b5563;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #764ba2;
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.2);
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-primary {
            background-color: #764ba2;
            color: white;
        }

        .btn-primary:hover {
            background-color: #667eea;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #e5e7eb;
            color: #4b5563;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .form-links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .form-links a {
            color: #764ba2;
            text-decoration: none;
            font-weight: 500;
        }

        .form-links a:hover {
            text-decoration: underline;
        }

        .success-message,
        .error-message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            display: none;
        }

        .success-message {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .error-message {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .password-strength {
            margin-top: 8px;
        }

        .strength-bar {
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background-color 0.3s;
        }

        .strength-weak .strength-fill {
            width: 33.33%;
            background-color: #ef4444;
        }

        .strength-medium .strength-fill {
            width: 66.66%;
            background-color: #f59e0b;
        }

        .strength-strong .strength-fill {
            width: 100%;
            background-color: #10b981;
        }

        #strengthText {
            font-size: 12px;
            color: #6b7280;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #6b7280;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #e5e7eb;
        }

        .divider span {
            padding: 0 12px;
        }

        .social-login {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            background-color: white;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .social-btn:hover {
            background-color: #f9fafb;
        }

        .message {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>

<body>

    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="container">
        <div class="logo">
            <h1>JOIN US</h1>
            <p>Your gateway to excellence</p>
        </div>

        <div class="form-container">
            <!-- Login Form -->
            <div class="form active" id="loginForm">
                <h2 class="form-title">Welcome Back</h2>

                <div id="loginTopMessage" class="message"></div>

                <div class="success-message" id="loginSuccess">
                    Welcome back! Redirecting to your dashboard...
                </div>

                <div class="error-message" id="loginError">
                    Invalid credentials. Please try again.
                </div>

                <?php
                // Display any messages from PHP
                if (isset($_SESSION['message'])):
                    ?>
                    <div class="message" style="display:block; color: green;">
                        <?php echo $_SESSION['message'];
                        unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Uncomment if you want social login options -->
                <!--
                <div class="social-login">
                    <button class="social-btn" onclick="socialLogin('google')">
                        <span>🔍</span> Google
                    </button>
                    <button class="social-btn" onclick="socialLogin('github')">
                        <span>📱</span> GitHub
                    </button>
                </div>

                <div class="divider">
                    <span>or continue with email</span>
                </div>
                -->

                <form id="loginFormElement">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" id="loginEmail" required>
                    </div>

                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Sign In</button>
                </form>

                <div class="form-links">
                    <a href="#" id="showForgotPassword">Forgot your password?</a>
                    <br><br>
                    Don't have an account?
                    <a href="#" id="showRegister">Create one now</a>
                </div>
            </div>

            <!-- Register Form -->
            <div class="form" id="registerForm">
                <h2 class="form-title">Create Account</h2>

                <div id="registerTopMessage" class="message"></div>

                <div class="success-message" id="registerSuccess">
                    Account created successfully! Please check your email to verify.
                </div>

                <div class="error-message" id="registerError">
                    Registration failed. Please try again.
                </div>

                <!-- Uncomment if you want social registration options -->
                <!--
                <div class="divider">
                    <span>or create with email</span>
                </div>
                -->

                <form id="registerFormElement">
                    <div class="form-group">
                        <label for="registerName">Full Name</label>
                        <input type="text" name="name" id="registerName" required>
                    </div>

                    <div class="form-group">
                        <label for="registerEmail">Email Address</label>
                        <input type="email" name="email" id="registerEmail" required>
                    </div>

                    <div class="form-group">
                        <label for="registerPassword">Password</label>
                        <input type="password" name="password" id="registerPassword" required
                            oninput="checkPasswordStrength(this.value)">
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <span id="strengthText">Enter a password</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" required oninput="checkPasswordMatch()">
                    </div>

                    <button type="submit" class="btn btn-primary">Create Account</button>
                </form>

                <div class="form-links">
                    Already have an account?
                    <a href="#" id="showLoginFromRegister">Sign in here</a>
                </div>
            </div>

            <!-- Forgot Password Form -->
            <div class="form" id="forgotForm">
                <h2 class="form-title">Reset Password</h2>

                <div id="forgotTopMessage" class="message"></div>

                <div class="success-message" id="forgotSuccess">
                    Reset link sent! Check your email for instructions.
                </div>

                <div class="error-message" id="forgotError">
                    Email not found. Please check your email address.
                </div>

                <p style="text-align: center; color: #6b7280; margin-bottom: 24px;">
                    Enter your email address and we'll send you a link to reset your password.
                </p>

                <form id="forgotFormElement">
                    <div class="form-group">
                        <label for="forgotEmail">Email Address</label>
                        <input type="email" name="email" id="forgotEmail" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                    <button type="button" class="btn btn-secondary" id="backToLogin">
                        Back to Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ===== Utility Functions =====
        function showForm(formId) {
            document.querySelectorAll('.form').forEach(f => f.classList.remove('active'));
            document.getElementById(formId).classList.add('active');
            hideAllMessages();
        }

        function hideAllMessages() {
            document.querySelectorAll('.success-message, .error-message, .message')
                .forEach(msg => msg.style.display = 'none');
        }

        function showMessage(elementId, text, isSuccess = true) {
            const el = document.getElementById(elementId);
            if (!el) return;
            el.style.display = 'block';
            el.textContent = text;
            el.style.color = isSuccess ? 'green' : 'red';
        }

        // ===== Password Strength Checker =====
        function checkPasswordStrength(password) {
            const strengthElement = document.getElementById('passwordStrength');
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');

            if (!password) {
                strengthElement.className = 'password-strength';
                strengthFill.style.width = '0%';
                strengthText.textContent = 'Enter a password';
                return;
            }

            const checks = [
                password.length >= 8,
                /[a-z]/.test(password),
                /[A-Z]/.test(password),
                /[0-9]/.test(password),
                /[^a-zA-Z0-9]/.test(password)
            ];

            const strength = checks.filter(Boolean).length;
            if (strength < 3) {
                strengthElement.className = 'password-strength strength-weak';
                strengthText.textContent = 'Weak password';
            } else if (strength < 5) {
                strengthElement.className = 'password-strength strength-medium';
                strengthText.textContent = 'Medium password';
            } else {
                strengthElement.className = 'password-strength strength-strong';
                strengthText.textContent = 'Strong password';
            }
        }

        // ===== Password Match Checker =====
        function checkPasswordMatch() {
            const pass = document.getElementById('registerPassword').value;
            const confirm = document.getElementById('confirmPassword');
            confirm.style.borderColor = confirm.value && pass === confirm.value ? '#10b981' : '#ef4444';
        }

        // ===== Form Submission Handlers =====
        async function handleLogin(event) {
            event.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            hideAllMessages();

            // Simple validation
            if (!email || !password) {
                showMessage('loginError', 'Please fill in all fields', false);
                return;
            }

            try {
                const formData = new FormData();
                formData.append('email', email);
                formData.append('password', password);

                const response = await fetch('login.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showMessage('loginSuccess', 'Login successful! Redirecting...', true);
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 1500);
                } else {
                    showMessage('loginError', result.message, false);
                }
            } catch (error) {
                showMessage('loginError', 'Error connecting to server', false);
            }
        }

        async function handleRegister(event) {
            event.preventDefault();
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const confirm = document.getElementById('confirmPassword').value;

            hideAllMessages();

            // Validation
            if (!name || !email || !password || !confirm) {
                showMessage('registerError', 'Please fill in all fields', false);
                return;
            }

            if (password !== confirm) {
                showMessage('registerError', 'Passwords do not match', false);
                return;
            }

            try {
                const formData = new FormData();
                formData.append('name', name);
                formData.append('email', email);
                formData.append('password', password);

                const response = await fetch('register.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showMessage('registerSuccess', result.message, true);

                    // Reset form
                    document.getElementById('registerFormElement').reset();
                    document.getElementById('passwordStrength').className = 'password-strength';
                    document.getElementById('strengthText').textContent = 'Enter a password';

                    // Redirect to login after delay
                    setTimeout(() => showForm('loginForm'), 2000);
                } else {
                    showMessage('registerError', result.message, false);
                }
            } catch (error) {
                showMessage('registerError', 'Error connecting to server', false);
            }
        }

        async function handleForgotPassword(event) {
            event.preventDefault();
            const email = document.getElementById('forgotEmail').value;

            hideAllMessages();

            if (!email) {
                showMessage('forgotError', 'Please enter your email address', false);
                return;
            }

            try {
                const formData = new FormData();
                formData.append('email', email);

                const response = await fetch('forgot_password.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showMessage('forgotSuccess', result.message, true);

                    // Reset form
                    document.getElementById('forgotFormElement').reset();
                } else {
                    showMessage('forgotError', result.message, false);
                }
            } catch (error) {
                showMessage('forgotError', 'Error connecting to server', false);
            }
        }

        // ===== Initialize the page =====
        document.addEventListener('DOMContentLoaded', function () {
            // Set up event listeners
            document.getElementById('showForgotPassword').addEventListener('click', function (e) {
                e.preventDefault();
                showForm('forgotForm');
            });

            document.getElementById('showRegister').addEventListener('click', function (e) {
                e.preventDefault();
                showForm('registerForm');
            });

            document.getElementById('showLoginFromRegister').addEventListener('click', function (e) {
                e.preventDefault();
                showForm('loginForm');
            });

            document.getElementById('backToLogin').addEventListener('click', function () {
                showForm('loginForm');
            });

            // Form submission handlers
            document.getElementById('loginFormElement').addEventListener('submit', handleLogin);
            document.getElementById('registerFormElement').addEventListener('submit', handleRegister);
            document.getElementById('forgotFormElement').addEventListener('submit', handleForgotPassword);

            // Input animation
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('focus', function () {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                input.addEventListener('blur', function () {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>

</body>

</html>