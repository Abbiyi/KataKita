<?php
session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}

include '../koneksi.php';

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
<html>
<head>
    <title>Detail Artikel</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="app">
<nav class="app-sidepanel" id="sidebarAdmin" style="width:250px;position:fixed;top:5px;left:0;bottom:0;background:#fff;box-shadow:0 2px 8px 0 rgba(0,0,0,0.07);z-index:99;transition:margin-left .3s;">
    <button class="btn btn-light" id="btnToggleSidebar" style="margin-top:100px;">
        <i class="bi bi-chevron-left" id="iconSidebar"></i>
    </button>
    <div class="sidebar-inner d-flex flex-column h-100" style="height:100%;">
        <div class="kategori-panel flex-grow-1">
            <h6><i class="bi bi-list"></i> Menu Admin</h6>
            <ul class="kategori-list list-unstyled">
                <li><a href="home.php" class="nav-link"><i class="bi bi-house"></i> Dashboard</a></li>
                <li><a href="kelola_artikel.php" class="nav-link active"><i class="bi bi-file-earmark-text"></i> Kelola Artikel</a></li>
                <li><a href="kelola_author.php" class="nav-link"><i class="bi bi-person"></i> Kelola Author</a></li>
                <li><a href="kategori.php" class="nav-link"><i class="bi bi-card-list"></i> Kategori</a></li>
                <li><a href="../logout.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="app-header d-flex align-items-center justify-content-between px-4"
    style="background:#fff; box-shadow:0 2px 8px 0 rgba(0,0,0,0.07); height:80px; position:fixed; top:0; left:0; right:0; z-index:100;">
    <div class="d-flex align-items-center">
        <a href="home.php">
            <img src="../assets/images/namawebsite.png" alt="KataKita" class="me-4" style="height:58px;">
        </a>
    </div>
    <div class="d-flex align-items-center">
        <form class="d-flex me-3" method="get" action="cari.php">
            <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel..." aria-label="Search" style="min-width:180px;">
            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <!-- Tombol Artikel Saya -->
        <a href="kelola_artikel.php?author=<?php echo urlencode($_SESSION['nickname']); ?>" class="btn btn-primary me-2 d-none d-md-inline">
            <i class="bi bi-pencil-square"></i>Artikel Saya
        </a>
        <!-- Gambar Profile -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../assets/images/profile.png" alt="Profile" width="40" height="40" class="rounded-circle me-2" style="object-fit:cover;">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfile">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> <?php echo $_SESSION['nickname']; ?></a></li>
                <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="app-wrapper" style="margin-top:30px;">
    <main class="app-content p-4">
        <div class="detail-card">
            <div class="detail-header">
                <h1><?php echo htmlspecialchars($row['judul_artikel']); ?></h1>
                <div class="detail-meta">
                    <i class="bi bi-calendar-event"></i> <?php echo htmlspecialchars($row['tanggal_publikasi']); ?>
                    &nbsp;|&nbsp;
                    <i class="bi bi-person"></i> <?php echo htmlspecialchars($row['nama_penulis']); ?>
                    &nbsp;|&nbsp;
                    <i class="bi bi-tag"></i> <span class="badge bg-success"><?php echo htmlspecialchars($row['nama_kategori']); ?></span>
                </div>
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
                <a href="kelola_artikel.php" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali ke Kelola Artikel</a>
            </div>
        </div>
    </main>
</div>

<script>
    // Sidebar toggle logic 
    const sidebar = document.getElementById('sidebarAdmin');
    const btnToggle = document.getElementById('btnToggleSidebar');
    const iconSidebar = document.getElementById('iconSidebar');
    const appWrapper = document.querySelector('.app-wrapper');
    let sidebarOpen = true;

    btnToggle.addEventListener('click', function() {
        if (sidebarOpen) {
            sidebar.classList.add('closed');
            if(appWrapper) appWrapper.classList.add('center-content');
            iconSidebar.classList.remove('bi-chevron-left');
            iconSidebar.classList.add('bi-chevron-right');
            sidebarOpen = false;
        } else {
            sidebar.classList.remove('closed');
            if(appWrapper) appWrapper.classList.remove('center-content');
            iconSidebar.classList.remove('bi-chevron-right');
            iconSidebar.classList.add('bi-chevron-left');
            sidebarOpen = true;
        }
    });
</script>
<footer class="app-footer mt-5" style="background:#e9f7ef; padding:20px 0;">
        <div class="container-xl text-center">
            <p class="mb-0" style="color:#555;">&copy; 2025 KataKita.</p>
        </div>
</body>
</html>