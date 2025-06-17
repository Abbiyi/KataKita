<?php
session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}

include '../koneksi.php';

if (isset($_POST['btn_update'])) {
    $id = intval($_POST['edit_id']);
    $nickname = $_POST['edit_nickname'];
    $email = $_POST['edit_email'];
    $sql_update = "UPDATE author SET nickname='$nickname', email='$email' WHERE id=$id";
    $koneksi->query($sql_update);
    header("Location: kelola_author.php");
    exit;
}

$where = '';
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $q = mysqli_real_escape_string($koneksi, $_GET['q']);
    $where = "WHERE nickname LIKE '%$q%'";
}

$sql = "SELECT id, level, nickname, email FROM author $where";
$result = $koneksi->query($sql);

if (!$result) {
    die("Query gagal: " . $koneksi->error);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kelola Author | Admin</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="app">

    <!-- Sidebar Admin (Dekstop) -->
    <nav class="app-sidepanel" id="sidebarAdmin" style="width:250px;position:fixed;top:5px;left:0;bottom:0;background:#fff;box-shadow:0 2px 8px 0 rgba(0,0,0,0.07);z-index:99;transition:margin-left .3s;">
        <button class="btn btn-light" id="btnToggleSidebar" style="margin-top:100px;">
            <i class="bi bi-chevron-left" id="iconSidebar"></i>
        </button>
        <div class="sidebar-inner d-flex flex-column h-100" style="height:100%;">
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
                <!-- Nama Website -->
                <a href="home.php">
                    <img src="../assets/images/namawebsite.png" alt="KataKita" class="me-4" style="height:58px;">
                </a>
            </div>
            <div class="d-flex align-items-center">
                <!-- Form Search -->
                <form class="d-flex me-3" method="get">
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari author..." aria-label="Search" style="min-width:180px;" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
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
                        <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> <?php echo $_SESSION['nickname']; ?></a></li>
                        <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </header>

        </header>
        <main class="app-content p-4">
            <div class="app-card-table">
                <div class="main-title mb-3"><i class="bi bi-person"></i> Daftar Author</div>
                <div class="table-responsive">
                    <a href="status.php" class="btn btn-primary">
                        Status
                    </a>
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Level</th>
                                <th>Nickname</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td>
                                            <span class="badge bg-success"><?php echo htmlspecialchars($row['level']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['nickname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td>
                                            <a href="#"
                                                class="btn btn-sm btn-warning mb-1 btn-edit-author"
                                                data-id="<?php echo $row['id']; ?>"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="hapus_author.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus author ini?')"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data author ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-start">
                    <strong>Total Author: <?php echo $result ? $result->num_rows : 0; ?></strong>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Edit Author -->
    <div class="modal fade" id="modalEditAuthor" tabindex="-1" aria-labelledby="modalEditAuthorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditAuthor" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditAuthorLabel">Edit Author</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_nickname" class="form-label">Nickname</label>
                            <input type="text" class="form-control" id="edit_nickname" name="edit_nickname" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="edit_email" required>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="btn_update">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.btn-edit-author').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                fetch('edit_author.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_id').value = data.id;
                        document.getElementById('edit_nickname').value = data.nickname;
                        document.getElementById('edit_email').value = data.email;
                        var modal = new bootstrap.Modal(document.getElementById('modalEditAuthor'));
                        modal.show();
                    });
            });
        });
    </script>
    <script>
        // Sidebar toggle logic (Dekstop)
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
    <footer class="app-footer mt-5" style="background:#e9f7ef; padding:20px 0;">
        <div class="container-xl text-center">
            <p class="mb-0" style="color:#555;">&copy; 2025 KataKita.</p>
        </div>
</body>

</html>