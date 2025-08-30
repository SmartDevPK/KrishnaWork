<form id="resetPasswordForm" onsubmit="handleResetPassword(event)">
    <input type="hidden" id="token" value="<?php echo $_GET['token']; ?>">
    <div class="form-group">
        <label for="newPassword">New Password</label>
        <input type="password" id="newPassword" required>
    </div>
    <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" required>
    </div>
    <button type="submit">Reset Password</button>
</form>

<script>
    function handleResetPassword(event) {
        event.preventDefault();
        const password = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        const token = document.getElementById('token').value;

        if (password !== confirm) {
            alert("Passwords do not match!");
            return;
        }

        fetch('reset_password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `token=${token}&password=${password}`
        })
            .then(res => res.text())
            .then(msg => alert(msg));
    }
</script>