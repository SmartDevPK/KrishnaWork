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

                <div class="success-message" id="loginSuccess">
                    Welcome back! Redirecting to your dashboard...
                </div>

                <div class="error-message" id="loginError">
                    Invalid credentials. Please try again.
                </div>

                <!-- <div class="social-login">
                    <button class="social-btn" onclick="socialLogin('google')">
                        <span>🔍</span> Google
                    </button>
                    <button class="social-btn" onclick="socialLogin('github')">
                        <span>📱</span> GitHub
                    </button>
                </div> -->

                <!-- <div class="divider">
                    <span>or continue with email</span>
                </div> -->

                <form onsubmit="handleLogin(event)">
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
                    <a href="#" onclick="showForm('forgotForm')">Forgot your password?</a>
                    <br><br>
                    Don't have an account?
                    <a href="#" onclick="showForm('registerForm')">Create one now</a>
                </div>
            </div>

            <!-- Register Form -->
            <div class="form" id="registerForm">
                <h2 class="form-title">Create Account</h2>

                <div class="success-message" id="registerSuccess">
                    Account created successfully! Please check your email to verify.
                </div>

                <div class="error-message" id="registerError">
                    Registration failed. Please try again.
                </div>

                <form onsubmit="handleRegister(event)">

                    <!-- <div class="divider">
                        <span>or create with email</span>
                    </div> -->

                    <form onsubmit="handleRegister(event)">
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
                        <a href="#" onclick="showForm('loginForm')">Sign in here</a>
                    </div>
            </div>

            <!-- Forgot Password Form -->
            <div class="form" id="forgotForm">
                <h2 class="form-title">Reset Password</h2>

                <div class="success-message" id="forgotSuccess">
                    Reset link sent! Check your email for instructions.
                </div>

                <div class="error-message" id="forgotError">
                    Email not found. Please check your email address.
                </div>

                <p style="text-align: center; color: #6b7280; margin-bottom: 24px;">
                    Enter your email address and we'll send you a link to reset your password.
                </p>

                <form onsubmit="handleForgotPassword(event)">
                    <div class="form-group">
                        <label for="forgotEmail">Email Address</label>
                        <input type="email" id="forgotEmail" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                    <button type="button" class="btn btn-secondary" onclick="showForm('loginForm')">
                        Back to Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Form switching functionality
        function showForm(formId) {
            const forms = document.querySelectorAll('.form');
            forms.forEach(form => form.classList.remove('active'));

            document.getElementById(formId).classList.add('active');

            // Hide all messages
            hideAllMessages();
        }

        function hideAllMessages() {
            const messages = document.querySelectorAll('.success-message, .error-message');
            messages.forEach(msg => msg.style.display = 'none');
        }

        function showMessage(messageId, show = true) {
            document.getElementById(messageId).style.display = show ? 'block' : 'none';
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthElement = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');

            if (password.length === 0) {
                strengthElement.className = 'password-strength';
                strengthText.textContent = 'Enter a password';
                return;
            }

            let strength = 0;
            const checks = [
                password.length >= 8,
                /[a-z]/.test(password),
                /[A-Z]/.test(password),
                /[0-9]/.test(password),
                /[^a-zA-Z0-9]/.test(password)
            ];

            strength = checks.filter(check => check).length;

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

        function checkPasswordMatch() {
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const confirmInput = document.getElementById('confirmPassword');

            if (confirmPassword === '') {
                confirmInput.style.borderColor = '#e5e7eb';
                return;
            }

            if (password === confirmPassword) {
                confirmInput.style.borderColor = '#10b981';
            } else {
                confirmInput.style.borderColor = '#ef4444';
            }
        }

        // Form submission handlers
        function handleLogin(event) {
            event.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            hideAllMessages();

            // Simulate API call
            setTimeout(() => {
                if (email && password) {
                    showMessage('loginSuccess');
                    setTimeout(() => {
                        alert('Login successful! (This is a demo)');
                    }, 1500);
                } else {
                    showMessage('loginError');
                }
            }, 1000);
        }

        async function handleRegister(event) {
            event.preventDefault();

            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            hideAllMessages();

            if (password !== confirmPassword) {
                showMessage('registerError');
                document.getElementById('registerError').textContent = 'Passwords do not match';
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('action', 'register'); // important for PHP
            formData.append('name', name);
            formData.append('email', email);
            formData.append('password', password);

            try {
                const response = await fetch('register.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.text();

                if (result.includes('green')) { // success
                    showMessage('registerSuccess');
                    document.getElementById('registerSuccess').innerHTML = result;
                    document.getElementById('registerName').value = '';
                    document.getElementById('registerEmail').value = '';
                    document.getElementById('registerPassword').value = '';
                    document.getElementById('confirmPassword').value = '';
                    setTimeout(() => showForm('loginForm'), 2000);
                } else { // error
                    showMessage('registerError');
                    document.getElementById('registerError').innerHTML = result;
                }
            } catch (err) {
                showMessage('registerError');
                document.getElementById('registerError').textContent = 'Error submitting form.';
            }
        }


        function handleForgotPassword(event) {
            event.preventDefault();
            const email = document.getElementById('forgotEmail').value;

            hideAllMessages();

            // Simulate API call
            setTimeout(() => {
                if (email) {
                    showMessage('forgotSuccess');
                    setTimeout(() => {
                        showForm('loginForm');
                    }, 2000);
                } else {
                    showMessage('forgotError');
                }
            }, 1000);
        }

        function socialLogin(provider) {
            alert(`${provider.charAt(0).toUpperCase() + provider.slice(1)} login clicked! (This is a demo)`);
        }

        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function () {
            // Add subtle animations to form elements
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
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