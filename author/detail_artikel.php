<?php
session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Author') {
    header("location:../login.php");
    exit;
}

include '../koneksi.php';
$result_kat = $koneksi->query("SELECT id, name FROM category");

if (!isset($_GET['id'])) {
    die("ID artikel tidak ditemukan.");
}

$id = intval($_GET['id']); 

$sql = "SELECT 
    a.title AS judul_artikel,
    a.date AS tanggal_publikasi,
    au.nickname AS nama_penulis,
    c.name AS nama_kategori,
    a.picture AS gambar,
    a.content AS isi_artikel
FROM 
    article a
JOIN 
    article_author aa ON a.id = aa.article_id
JOIN 
    author au ON aa.author_id = au.id
JOIN 
    article_category ac ON a.id = ac.article_id
JOIN 
    category c ON ac.category_id = c.id
WHERE 
    a.id = $id";

$result = $koneksi->query($sql);

if ($result->num_rows == 0) {
    die("Artikel tidak ditemukan.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($row['judul_artikel']); ?> - KataKita</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="app" style="background:#f7f9fa;">

    <!-- Navbar Atas -->
    <header class="app-header d-flex align-items-center justify-content-between flex-column px-4"
        style="background:#fff; box-shadow:0 2px 8px 0 rgba(0,0,0,0.07); height:auto; position:fixed; top:0; left:0; right:0; z-index:100; padding-bottom:0;">
        <div class="w-100 d-flex align-items-center justify-content-between" style="height:80px;">
            <div class="d-flex align-items-center">
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
        <!-- Kategori Bar -->
        <div class="w-100" style="background:#e9f7ef;">
            <div class="w-100" style="background:#e9f7ef;">
                <div class="d-flex flex-wrap gap-5 py-6 justify-content-center align-items-center" style="overflow-x:auto;">
                    <?php if ($result_kat && $result_kat->num_rows > 0): ?>
                        <?php while ($kat = $result_kat->fetch_assoc()): ?>
                            <a href="home.php?kategori=<?php echo $kat['id']; ?>" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                <?php echo htmlspecialchars($kat['name']); ?>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <span class="text-muted">Tidak ada kategori</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <div class="app-wrapper center-content" style="margin-top:140px;">
        <div class="detail-card">
            <div class="detail-header">
                <h1><?php echo htmlspecialchars($row['judul_artikel']); ?></h1>
            </div>
            <div class="detail-meta mb-3">
                <span><i class="bi bi-calendar"></i> <?php echo htmlspecialchars($row['tanggal_publikasi']); ?></span>
                &nbsp;|&nbsp;
                <span><i class="bi bi-person"></i> <?php echo htmlspecialchars($row['nama_penulis']); ?></span>
                &nbsp;|&nbsp;
                <span class="badge bg-success"><?php echo htmlspecialchars($row['nama_kategori']); ?></span>
            </div>
            <?php if (!empty($row['gambar'])): ?>
                <div class="detail-image">
                    <img src="../picture/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Artikel">
                </div>
            <?php endif; ?>
            <div class="detail-content">
                <?php echo $row['isi_artikel']; ?>
            </div>
            <div class="detail-footer">
                <a href="home.php" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Artikel</a>
            </div>
        </div>
    </div>
    <footer class="app-footer mt-5" style="background:#e9f7ef; padding:20px 0;">
        <div class="container-xl text-center">
            <p class="mb-0" style="color:#555;">&copy; 2025 KataKita.</p>
        </div>
</body>
</html>