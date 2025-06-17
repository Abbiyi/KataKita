<?php

session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}

include '../koneksi.php';
if (isset($_POST['btn_update'])) {
    $id = intval($_POST['edit_id']);
    $nama = $koneksi->real_escape_string($_POST['edit_nama_kategori']);
    $deskripsi = $koneksi->real_escape_string($_POST['edit_deskripsi_kategori']);
    $koneksi->query("UPDATE category SET name='$nama', description='$deskripsi' WHERE id=$id");
    echo "<script>location.href='kategori.php';</script>";
}
if (isset($_POST['btn_tambah'])) {
    $nama = $koneksi->real_escape_string($_POST['nama_kategori']);
    $deskripsi = $koneksi->real_escape_string($_POST['deskripsi_kategori']);
    $koneksi->query("INSERT INTO category (name, description) VALUES ('$nama', '$deskripsi')");
    echo "<script>location.href='kategori.php';</script>";
}

$where = '';
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $q = mysqli_real_escape_string($koneksi, $_GET['q']);
    $where = "WHERE name LIKE '%$q%'";
}

$sql = "SELECT id, name, description FROM category $where";
$result = $koneksi->query($sql);

if (!$result) {
    die("Query gagal: " . $koneksi->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kategori | Admin</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                    <li><a href="kelola_author.php" class="nav-link"><i class="bi bi-person"></i> Kelola Author</a></li>
                    <li><a href="kategori.php" class="nav-link active"><i class="bi bi-card-list"></i> Kategori</a></li>
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
                    <input class="form-control me-2" type="search" name="q" placeholder="Cari kategori..." aria-label="Search" style="min-width:180px;" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
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
        <main class="app-content p-4">
            <div class="app-card-table">
                <div class="main-title mb-3"><i class="bi bi-card-list"></i> Daftar Kategori</div>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                    Tambah Kategori
                </button>
                <div class="table-responsive">
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td>
                                            <span class="badge bg-success"><?php echo htmlspecialchars($row['name']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                                        <td>
                                            <a href="#"
                                                class="btn btn-sm btn-warning mb-1 btn-edit-kategori"
                                                data-id="<?php echo $row['id']; ?>"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="hapus_kategori.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Apakah Anda yakin ingin menghapus author ini?')"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data kategori ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 text-start">
                    <strong>Total Kategori: <?php echo $result ? $result->num_rows : 0; ?></strong>
                </div>
            </div>
        </main>
    </div>
    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_kategori" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_kategori" name="deskripsi_kategori" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="btn_tambah">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="formEditKategori">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditKategoriLabel">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="edit_id_kategori">
                        <div class="mb-3">
                            <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="edit_nama_kategori" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi_kategori" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi_kategori" name="edit_deskripsi_kategori" rows="3"></textarea>
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
        document.querySelectorAll('.btn-edit-kategori').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                fetch('edit_kategori.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_id_kategori').value = data.id;
                        document.getElementById('edit_nama_kategori').value = data.name;
                        document.getElementById('edit_deskripsi_kategori').value = data.description;
                        var modal = new bootstrap.Modal(document.getElementById('modalEditKategori'));
                        modal.show();
                    });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    <footer class="app-footer mt-5" style="background:#e9f7ef; padding:20px 0;">
        <div class="container-xl text-center">
            <p class="mb-0" style="color:#555;">&copy; 2025 KataKita.</p>
        </div>
</body>

</html>