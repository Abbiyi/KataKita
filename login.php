<!DOCTYPE html>
<html>

<head>
    <title>Login | KataKita</title>
    <link rel="stylesheet" type="text/css" href="assets/css/portal.css">
</head>

<body class="app-login">
    <div class="container d-flex align-items-center justify-content-center" style="min-height:unset; height:auto; padding-top:48px; padding-bottom:48px;">
        <div class="app-auth-wrapper shadow rounded p-4 position-relative" style="height:auto; min-height:unset;">
            <div class="app-logo text-center mb-4">
                <img src="assets/images/loginregister.png" alt="Logo" style="max-height: 35px;">
            </div>
            <h1 class="auth-heading text-center mb-2">Login</h1>
            <p class="auth-heading-desc text-center mb-4">Masuk ke akun Anda</p>
            <form action="aksi_login.php?op=in" method="POST" class="app-auth-body">
                <div class="mb-3">
                    <label for="nickname" class="form-label">Username</label>
                    <input type="text" id="nickname" name="nickname" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" name="login" class="btn app-btn-primary">Login</button>
                </div>
                <div class="extra text-center">
                    Belum punya akun? <a href="register.php">Register</a>
                </div>
                <div class="extra text-center">
                    Masuk tanpa akun <a href="index.php">Guest</a>
                </div>
            </form>
            <footer class="app-auth-footer mt-4 text-center">
                <div class="copyright">© KataKita</div>
            </footer>
        </div>
    </div>
</body>

</html>