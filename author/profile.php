<?php
session_start();
if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Author') {
    header("location:../login.php");
    exit;
}
include '../koneksi.php';

$nickname = mysqli_real_escape_string($koneksi, $_SESSION['nickname']);
$query = mysqli_query($koneksi, "SELECT nickname, email, password FROM author WHERE nickname='$nickname' LIMIT 1");
$user = mysqli_fetch_assoc($query);

if (isset($_POST['btn_update'])) {
    $new_nickname = mysqli_real_escape_string($koneksi, $_POST['nickname']);
    $new_email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $new_password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $update_password = "";
    if (!empty($new_password)) {
        $update_password = ", password='$new_password'";
    }

    $sql = "UPDATE author SET nickname='$new_nickname', email='$new_email' $update_password WHERE nickname='$nickname'";
    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['nickname'] = $new_nickname;
        echo "<script>alert('Profil berhasil diupdate!');window.location='profile.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update profil: " . mysqli_error($koneksi) . "');</script>";
    }
    $query = mysqli_query($koneksi, "SELECT nickname, email, password FROM author WHERE nickname='$new_nickname' LIMIT 1");
    $user = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile | KataKita</title>
    <link rel="stylesheet" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .profile-card {
            max-width: 500px;
            margin: 60px auto;
        }

        .profile-label {
            width: 120px;
        }
    </style>

</head>
<!-- Navbar Atas -->
<header class="app-header d-flex align-items-center justify-content-between flex-column px-4" style="background:#fff; box-shadow:0 2px 8px 0 rgba(0,0,0,0.07); height:auto; position:fixed; top:0; left:0; right:0; z-index:100; padding-bottom:0;">
    <div class="w-100 d-flex align-items-center justify-content-between" style="height:80px;">
        <div class="d-flex align-items-center">
            <!-- Nama Website -->
            <a href="home.php">
                <img src="../assets/images/namawebsite.png" alt="KataKita" class="me-4" style="height:58px;">
            </a>
        </div>
        <div class="d-flex align-items-center">
            <!-- Form Search -->
            <form class="d-flex me-3" method="get" action="home.php">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel..." aria-label="Search" style="min-width:180px;">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <!-- Tombol Artikel Saya -->
            <a href="kelola_artikel.php" class="btn btn-primary me-2 d-none d-md-inline"><i class="bi bi-pencil-square"></i>Artikel Saya</a>
            <!-- Gambar Profile -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../assets/images/profile.png" alt="Profile" width="40" height="40" class="rounded-circle me-2" style="object-fit:cover;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfile">
                    <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> <?php echo $_SESSION['nickname']; ?></a></li>
                    <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<body class="app" style="background:#f7f9fa;">
    <div class="container profile-card shadow-sm bg-white p-4 rounded">
        <h3 class="mb-4"><i class="bi bi-person"></i> Profil Saya</h3>
        <form method="POST">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label profile-label">Nickname</label>
                <div class="col-sm-8">
                    <input type="text" name="nickname" class="form-control" value="<?php echo htmlspecialchars($user['nickname']); ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label profile-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label profile-label">Password</label>
                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" name="btn_update" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</button>
                </div>
            </div>
        </form>
        <a href="home.php" class="btn btn-link mt-2"><i class="bi bi-arrow-left"></i> Kembali ke Home</a>
    </div>

</body>
</html>