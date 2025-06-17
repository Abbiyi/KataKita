<?php
session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}

include '../koneksi.php';
$chartLabels = [];
$chartData = [];
$qChart = $koneksi->query("
    SELECT au.nickname, COUNT(a.id) as total
    FROM article a
    JOIN article_author aa ON a.id = aa.article_id
    JOIN author au ON aa.author_id = au.id
    GROUP BY au.nickname
    ORDER BY total DESC
    LIMIT 7
");
while ($row = $qChart->fetch_assoc()) {
    $chartLabels[] = $row['nickname'];
    $chartData[] = $row['total'];
}
$chartKategoriLabels = [];
$chartKategoriData = [];
$qKategori = $koneksi->query("
    SELECT c.name, COUNT(ac.article_id) as total
    FROM category c
    JOIN article_category ac ON c.id = ac.category_id
    GROUP BY c.id
    ORDER BY total DESC
    LIMIT 5
");
while ($row = $qKategori->fetch_assoc()) {
    $chartKategoriLabels[] = $row['name'];
    $chartKategoriData[] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard | Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="theme-style" rel="stylesheet" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="app">

    <!-- Navbar Atas -->
    <header class="app-header d-flex align-items-center justify-content-between px-4" style="background:#fff; box-shadow:0 2px 8px 0 rgba(0,0,0,0.07); height:80px; position:fixed; top:0; left:0; right:0; z-index:100;">
        <div class="d-flex align-items-center">
            <!-- Nama Website -->
            <a href="home.php">
                <img src="../assets/images/namawebsite.png" alt="KataKita" class="me-4" style="height:58px;">
            </a>
        </div>
        <div class="d-flex align-items-center">
            <!-- Form Search -->
            <form class="d-flex me-3" method="get" action="kelola_artikel.php">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel..." aria-label="Search" style="min-width:180px;">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <!-- Tombol Artikel Saya -->
            <a href="kelola_artikel.php?author=<?php echo urlencode($_SESSION['nickname']); ?>" class="btn btn-primary me-2 d-none d-md-inline">
                <i class="bi bi-pencil-square"></i>Artikel Saya
            </a>
            <!-- Gambar Profile -->
            <div class="dropdown">
                <a href="" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../assets/images/profile.png" alt="Profile" width="40" height="40" class="rounded-circle me-2" style="object-fit:cover;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfile">
                    <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> <?php echo $_SESSION['nickname']; ?></a></li>
                    <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Sidebar Admin -->
    <nav class="app-sidepanel" id="sidebarAdmin" style="width:250px;position:fixed;top:5px;left:0;bottom:0;background:#fff;box-shadow:0 2px 8px 0 rgba(0,0,0,0.07);z-index:99;transition:margin-left .3s;">
        <button class="btn btn-light" id="btnToggleSidebar" style="margin-top:100px;">
            <i class="bi bi-chevron-left" id="iconSidebar"></i>
        </button>
        <div class="sidebar-inner d-flex flex-column h-100" style="height:100%;">
            <div class="kategori-panel flex-grow-1">
                <h6><i class="bi bi-list"></i> Menu Admin</h6>
                <ul class="kategori-list list-unstyled">
                    <li><a href="home.php" class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'home.php') echo 'active'; ?>"><i class="bi bi-house"></i> Dashboard</a></li>
                    <li><a href="kelola_artikel.php" class="nav-link"><i class="bi bi-file-earmark-text"></i> Kelola Artikel</a></li>
                    <li><a href="kelola_author.php" class="nav-link"><i class="bi bi-person"></i> Kelola Author</a></li>
                    <li><a href="kategori.php" class="nav-link"><i class="bi bi-card-list"></i> Kategori</a></li>
                    <li><a href="../logout.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="app-wrapper">
        <main class="app-content p-4" style="margin-top:35px;">
            <div class="container-fluid">
                <!-- Card Statistik Dashboard -->
                <div class="row g-4 mb-4">
                    <!-- Card 1: Total Artikel -->
                    <div class="col-md-4">
                        <div class="app-card app-card-body position-relative shadow-sm h-100 text-center border-0" style="background:linear-gradient(135deg,#e0f7fa 0%,#fff 100%);">
                            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                <div class="app-icon-holder icon-holder-mono mb-3" style="background:#00bcd4; color:#fff; border-radius:50%; width:56px; height:56px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-file-earmark-text fs-2"></i>
                                </div>
                                <div class="fs-2 fw-bold text-dark">
                                    <?php
                                    $totalArtikel = $koneksi->query("SELECT COUNT(*) as total FROM article")->fetch_assoc()['total'];
                                    echo $totalArtikel;
                                    ?>
                                </div>
                                <div class="text-muted">Total Artikel</div>
                            </div>
                            <a class="app-card-link-mask" href="kelola_artikel.php"></a>
                        </div>
                    </div>
                    <!-- Card 2: Total Author -->
                    <div class="col-md-4">
                        <div class="app-card app-card-body position-relative shadow-sm h-100 text-center border-0" style="background:linear-gradient(135deg,#fce4ec 0%,#fff 100%);">
                            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                <div class="app-icon-holder icon-holder-mono mb-3" style="background:#e91e63; color:#fff; border-radius:50%; width:56px; height:56px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-person fs-2"></i>
                                </div>
                                <div class="fs-2 fw-bold text-dark">
                                    <?php
                                    $totalAuthor = $koneksi->query("SELECT COUNT(*) as total FROM author")->fetch_assoc()['total'];
                                    echo $totalAuthor;
                                    ?>
                                </div>
                                <div class="text-muted">Total Author</div>
                            </div>
                            <a class="app-card-link-mask" href="kelola_author.php"></a>
                        </div>
                    </div>
                    <!-- Card 3: Total Kategori -->
                    <div class="col-md-4">
                        <div class="app-card app-card-body position-relative shadow-sm h-100 text-center border-0" style="background:linear-gradient(135deg,#e8f5e9 0%,#fff 100%);">
                            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                <div class="app-icon-holder icon-holder-mono mb-3" style="background:#43a047; color:#fff; border-radius:50%; width:56px; height:56px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-card-list fs-2"></i>
                                </div>
                                <div class="fs-2 fw-bold text-dark">
                                    <?php
                                    $totalKategori = $koneksi->query("SELECT COUNT(*) as total FROM category")->fetch_assoc()['total'];
                                    echo $totalKategori;
                                    ?>
                                </div>
                                <div class="text-muted">Total Kategori</div>
                            </div>
                            <a class="app-card-link-mask" href="kategori.php"></a>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-7">
                        <div class="app-card app-card-body shadow-sm h-100 text-center border-0">
                            <h5 class="mb-4 mt-1"><i class="bi bi-bar-chart"></i> Top 7 Author dengan Artikel Terbanyak</h5>
                            <canvas id="artikelAuthorChart" height="195"></canvas>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex align-items-center">
                        <div class="app-card app-card-body shadow-sm h-100 text-center border-0 w-100">
                            <h5 class="mb-4 mt-3"><i class="bi bi-pie-chart"></i> Top 5 Kategori Paling Banyak Dipakai</h5>
                            <canvas id="kategoriPieChart" height="110" width="110"></canvas>
                        </div>
                    </div>
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
                appWrapper.classList.add('center-content');
                iconSidebar.classList.remove('bi-chevron-left');
                iconSidebar.classList.add('bi-chevron-right');
                sidebarOpen = false;
            } else {
                sidebar.classList.remove('closed');
                appWrapper.classList.remove('center-content');
                iconSidebar.classList.remove('bi-chevron-right');
                iconSidebar.classList.add('bi-chevron-left');
                sidebarOpen = true;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/charts-demo.js"></script>
    <script>
        
        window.chartAuthorLabels = <?php echo json_encode($chartLabels); ?>;
        window.chartAuthorData = <?php echo json_encode($chartData); ?>;
        window.chartKategoriLabels = <?php echo json_encode($chartKategoriLabels); ?>;
        window.chartKategoriData = <?php echo json_encode($chartKategoriData); ?>;
        
        renderArtikelAuthorChart(window.chartAuthorLabels, window.chartAuthorData);
        renderKategoriPieChart(window.chartKategoriLabels, window.chartKategoriData);
    </script>
    <footer class="app-footer mt-5" style="background:#e9f7ef; padding:20px 0;">
        <div class="container-xl text-center">
            <p class="mb-0" style="color:#555;">&copy; 2025 KataKita.</p>
        </div>
</body>

</html>