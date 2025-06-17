<!DOCTYPE html>
<html>
<head>
    <title>Register | KataKita</title>
    <link rel="stylesheet" type="text/css" href="assets/css/portal.css">
</head>
<body class="app-signup">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="app-auth-wrapper shadow rounded p-4">
            <div class="app-logo text-center mb-4">
                <img src="assets/images/loginregister.png" alt="Logo" style="max-height: 35px;">
            </div>
            <h1 class="auth-heading text-center mb-2">Register</h1>
            <p class="auth-heading-desc text-center mb-4">Buat akun baru untuk melanjutkan</p>
            <form action="aksi_register.php" method="POST" class="app-auth-body">
                <div class="mb-3">
                    <label for="nickname" class="form-label">Username</label>
                    <input type="text" id="nickname" name="nickname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select id="level" name="level" class="form-select" required>
                        <option value="Admin">Admin</option>
                        <option value="Author">Author</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" name="register" class="btn app-btn-primary">Register</button>
                </div>
                <div class="extra text-center">
                    Sudah punya akun? <a href="login.php">Login</a>
                </div>
            </form>
            <footer class="app-auth-footer mt-4 text-center">
                <div class="copyright">© KataKita</div>
            </footer>
        </div>
    </div>
</body>
</html>