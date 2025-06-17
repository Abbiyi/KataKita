<?php

session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Author') {
    header("location:../login.php");
    exit;
}
include '../koneksi.php';

$where = "";

if (isset($_GET['author'])) {
    $author = mysqli_real_escape_string($koneksi, $_GET['author']);
    $where = "WHERE au.nickname = '$author'";
} elseif (isset($_GET['kategori'])) {
    $kategori = intval($_GET['kategori']);
    $where = "WHERE c.id = $kategori";
}

if (isset($_GET['q']) && $_GET['q'] !== '') {
    $q = mysqli_real_escape_string($koneksi, $_GET['q']);
    if ($where) {
        $where .= " AND a.title LIKE '%$q%'";
    } else {
        $where = "WHERE a.title LIKE '%$q%'";
    }
}

$sql = "SELECT 
    a.id,
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
    $where
ORDER BY a.id DESC";
$result_artikel = $koneksi->query($sql);

$sql = "SELECT id, name FROM category";
$result_kat = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Beranda | KataKita</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="app">
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
                <form class="d-flex me-3" method="get">
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel..." aria-label="Search" style="min-width:180px;" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                </form>
                <!-- Tombol Mulai Menulis -->
                <a href="kelola_artikel.php?tambah=1" class="btn btn-primary me-2 d-none d-md-inline">
                    <i class="bi bi-pencil-square"></i> Mulai Menulis
                </a>
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

    <div class="app-wrapper center-content">
        <div class="app-content pt-5 p-md-3 p-lg-4">
            <div class="container-xl">
                <h1 class="text-center" style="margin-top: 120px; font-size:3rem; font-weight:bold; letter-spacing:1px; color:#222; margin-bottom:0;">
                    Blog KataKita!
                </h1>
                <h6 class="text-center" style="color:#555; font-weight:400; margin-top:8px;">
                    Lebih Dari Sekedar Kata
                </h6>
                <div style="height:50px;"></div>
                <div class="news-list">
                    <?php if ($result_artikel && $result_artikel->num_rows > 0): ?>
                        <?php while ($row = $result_artikel->fetch_assoc()): ?>
                            <div class="news-card">
                                <?php if (!empty($row['gambar'])): ?>
                                    <img src="../picture/<?php echo htmlspecialchars($row['gambar']); ?>" class="news-img" alt="Gambar Artikel">
                                <?php else: ?>
                                    <div class="news-img d-flex align-items-center justify-content-center text-muted" style="height:180px;">Tidak ada gambar</div>
                                <?php endif; ?>
                                <div class="news-body">
                                    <div class="news-title"><?php echo htmlspecialchars($row['judul_artikel']); ?></div>
                                    <div class="news-meta">
                                        <i class="bi bi-calendar"></i> <?php echo htmlspecialchars($row['tanggal_publikasi']); ?>
                                        &nbsp;|&nbsp;
                                        <i class="bi bi-person"></i> <?php echo htmlspecialchars($row['nama_penulis']); ?>
                                    </div>
                                    <div class="news-summary">
                                        <?php echo htmlspecialchars(mb_strimwidth(strip_tags($row['isi_artikel']), 0, 100, "...")); ?>
                                    </div>
                                    <div class="news-footer">
                                        <span class="badge bg-success"><?php echo htmlspecialchars($row['nama_kategori']); ?></span>
                                        <a href="detail_artikel.php?id=<?php echo $row['id']; ?>">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-10 text-center text-muted"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="app-footer mt-5" style="background:#e9f7ef; padding:20px 0;">
        <div class="container-xl text-center">
            <p class="mb-0" style="color:#555;">&copy; 2025 KataKita.</p>
        </div>
</body>
</html>