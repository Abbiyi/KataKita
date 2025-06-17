<?php
session_start();
include '../koneksi.php';
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}

if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $koneksi->query("UPDATE author SET level='Admin' WHERE id=$id AND level='AdminPending'");
    header("Location: status.php");
    exit;
}

$result = $koneksi->query("SELECT id, nickname, email FROM author WHERE level='AdminPending'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Persetujuan Admin Baru</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="app">
    <!-- Sidebar Admin -->
    <nav class="app-sidepanel" id="sidebarAdmin" style="width:250px;position:fixed;top:5px;left:0;bottom:0;background:#fff;box-shadow:0 2px 8px 0 rgba(0,0,0,0.07);z-index:99;">
        <button class="btn btn-light" id="btnToggleSidebar" style="margin-top:90px;">
            <i class="bi bi-chevron-left" id="iconSidebar"></i>
        </button>
        <div class="sidebar-inner d-flex flex-column h-100">
            <div class="kategori-panel flex-grow-1">
                <h6><i class="bi bi-list"></i> Menu Admin</h6>
                <ul class="kategori-list list-unstyled">
                    <li><a href="home.php" class="nav-link"><i class="bi bi-house"></i> Dashboard</a></li>
                    <li><a href="kelola_artikel.php" class="nav-link"><i class="bi bi-file-earmark-text"></i> Kelola Artikel</a></li>
                    <li><a href="kelola_author.php" class="nav-link active"><i class="bi bi-person"></i> Kelola Author</a></li>
                    <li><a href="kategori.php" class="nav-link"><i class="bi bi-card-list"></i> Kategori</a></li>
                    <li><a href="../logout.php" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="app-wrapper">
        <!-- Navbar Atas -->
        <header class="app-header d-flex align-items-center justify-content-between px-4" style="background:#fff; box-shadow:0 2px 8px 0 rgba(0,0,0,0.07); height:80px; position:fixed; top:0; left:0; right:0; z-index:100;">
            <div class="d-flex align-items-center">
                <a href="home.php">
                    <img src="../assets/images/namawebsite.png" alt="KataKita" class="me-4" style="height:58px;">
                </a>
            </div>
            <div class="d-flex align-items-center">
                <a href="kelola_artikel.php?author=<?php echo urlencode($_SESSION['nickname']); ?>" class="btn btn-primary me-2 d-none d-md-inline">
                    <i class="bi bi-pencil-square"></i> Artikel Saya
                </a>
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
        </header>
        <main class="app-content p-4" style="margin-top:90px;">
            <div class="container-fluid">
                <div class="app-card shadow-sm p-4">
                    <h4 class="mb-4"><i class="bi bi-person-check"></i> Persetujuan Admin Baru</h4>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nickname']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td>
                                        <a href="status.php?approve=<?= $row['id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Setujui admin ini?')">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php if ($result->num_rows == 0): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada admin yang menunggu persetujuan.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
</body>
</html>