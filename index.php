<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Sign In or Create Account</title>
    <link rel="stylesheet" href="style.css">

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

                <form id="registerFormElement" action="register.php" method="POST">
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