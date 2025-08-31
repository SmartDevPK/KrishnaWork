<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .header {
            background: linear-gradient(to right, #6e8efb, #a777e3);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .header h1 {
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .form-container {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 14px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6e8efb;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e6e6e6;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus {
            border-color: #6e8efb;
            box-shadow: 0 0 0 3px rgba(110, 142, 251, 0.2);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0a0a0;
            font-size: 16px;
        }

        .password-toggle:hover {
            color: #6e8efb;
        }

        .password-strength {
            height: 5px;
            margin-top: 8px;
            border-radius: 5px;
            background: #f0f0f0;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0;
            border-radius: 5px;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .password-criteria {
            margin-top: 8px;
            font-size: 12px;
            color: #777;
        }

        .password-criteria ul {
            padding-left: 20px;
        }

        .password-criteria li {
            margin-bottom: 4px;
            list-style-type: none;
            position: relative;
        }

        .password-criteria li:before {
            content: "•";
            color: #ddd;
            position: absolute;
            left: -15px;
        }

        .password-criteria li.valid {
            color: #2ecc71;
        }

        .password-criteria li.valid:before {
            content: "✓";
            color: #2ecc71;
            left: -18px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #6e8efb, #a777e3);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(110, 142, 251, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(110, 142, 251, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            display: none;
        }

        .message.success {
            background: rgba(46, 204, 113, 0.15);
            color: #27ae60;
            border: 1px solid #2ecc71;
        }

        .message.error {
            background: rgba(231, 76, 60, 0.15);
            color: #c0392b;
            border: 1px solid #e74c3c;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #777;
        }

        .footer a {
            color: #6e8efb;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                border-radius: 12px;
            }

            .header {
                padding: 20px;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reset Your Password</h1>
            <p>Create a new secure password for your account</p>
        </div>

        <div class="form-container">
            <form id="resetPasswordForm" onsubmit="handleResetPassword(event)">
                <input type="hidden" id="token" value="sample_token_12345">

                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="newPassword" required>
                        <span class="password-toggle" onclick="togglePassword('newPassword', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="password-strength">
                        <div class="strength-meter" id="passwordStrength"></div>
                    </div>
                    <div class="password-criteria">
                        <ul>
                            <li id="lengthCriteria">At least 8 characters</li>
                            <li id="uppercaseCriteria">One uppercase letter</li>
                            <li id="numberCriteria">One number</li>
                            <li id="specialCriteria">One special character</li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirmPassword" required>
                        <span class="password-toggle" onclick="togglePassword('confirmPassword', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit">Reset Password</button>
            </form>

            <div class="message" id="message"></div>

            <div class="footer">
                Remember your password? <a href="index.php">Sign in here</a>
            </div>
        </div>
    </div>

    <script>
        function handleResetPassword(event) {
            event.preventDefault();
            const password = document.getElementById('newPassword').value;
            const confirm = document.getElementById('confirmPassword').value;
            const token = document.getElementById('token').value;
            const messageEl = document.getElementById('message');

            if (password !== confirm) {
                showMessage("Passwords do not match!", "error");
                return;
            }

            // Simulate API call
            showMessage("Resetting your password...", "success");

            setTimeout(() => {
                // This would be your actual fetch call
                /*
                fetch('reset_password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `token=${token}&password=${password}`
                })
                .then(res => res.text())
                .then(msg => showMessage(msg, "success"))
                .catch(err => showMessage("Error resetting password. Please try again.", "error"));
                */

                // For demo purposes, we'll simulate a success response
                showMessage("Password successfully reset! You can now login with your new password.", "success");
            }, 1500);
        }

        function showMessage(text, type) {
            const messageEl = document.getElementById('message');
            messageEl.textContent = text;
            messageEl.className = `message ${type}`;
            messageEl.style.display = 'block';

            // Scroll to message
            messageEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function togglePassword(inputId, toggleElement) {
            const input = document.getElementById(inputId);
            const icon = toggleElement.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        document.getElementById('newPassword').addEventListener('input', function () {
            const password = this.value;
            const strengthMeter = document.getElementById('passwordStrength');
            const criteria = {
                length: document.getElementById('lengthCriteria'),
                uppercase: document.getElementById('uppercaseCriteria'),
                number: document.getElementById('numberCriteria'),
                special: document.getElementById('specialCriteria')
            };

            let strength = 0;
            let totalCriteria = 0;
            let passedCriteria = 0;

            // Check length
            if (password.length >= 8) {
                criteria.length.classList.add('valid');
                strength += 25;
                passedCriteria++;
            } else {
                criteria.length.classList.remove('valid');
            }
            totalCriteria++;

            // Check uppercase letters
            if (/[A-Z]/.test(password)) {
                criteria.uppercase.classList.add('valid');
                strength += 25;
                passedCriteria++;
            } else {
                criteria.uppercase.classList.remove('valid');
            }
            totalCriteria++;

            // Check numbers
            if (/[0-9]/.test(password)) {
                criteria.number.classList.add('valid');
                strength += 25;
                passedCriteria++;
            } else {
                criteria.number.classList.remove('valid');
            }
            totalCriteria++;

            // Check special characters
            if (/[^A-Za-z0-9]/.test(password)) {
                criteria.special.classList.add('valid');
                strength += 25;
                passedCriteria++;
            } else {
                criteria.special.classList.remove('valid');
            }
            totalCriteria++;

            // Update strength meter
            strengthMeter.style.width = strength + '%';

            // Set color based on strength
            if (strength < 50) {
                strengthMeter.style.background = '#e74c3c';
            } else if (strength < 100) {
                strengthMeter.style.background = '#f39c12';
            } else {
                strengthMeter.style.background = '#2ecc71';
            }
        });
    </script>
</body>

</html>