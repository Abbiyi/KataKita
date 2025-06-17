<?php
session_start();
if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Author') {
    header("location:../login.php");
    exit;
}
include "../koneksi.php";
$nickname = mysqli_real_escape_string($koneksi, $_SESSION['nickname']);
$q_author = mysqli_query($koneksi, "SELECT id FROM author WHERE nickname='$nickname' LIMIT 1");
$d_author = mysqli_fetch_assoc($q_author);
$author_id = $d_author['id'];

if (isset($_POST['btn_simpan'])) {
}
if (isset($_POST['btn_simpan'])) {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $picture = '';

    if (!empty($_FILES["picture"]["name"])) {
        $target_dir = "../picture/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check === false) $uploadOk = 0;
        if ($_FILES["picture"]["size"] > 500000) $uploadOk = 0;
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) $uploadOk = 0;
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                $picture = basename($_FILES["picture"]["name"]);
            }
        }
    }
    if (empty($_POST['edit_id'])) {
        $sql = "INSERT INTO article (date, title, content, picture) VALUES ('$date', '$title', '$content', '$picture')";
        if (mysqli_query($koneksi, $sql)) {
            $article_id = mysqli_insert_id($koneksi);
            mysqli_query($koneksi, "INSERT INTO article_author (article_id, author_id) VALUES ('$article_id', '$author_id')");
            mysqli_query($koneksi, "INSERT INTO article_category (article_id, category_id) VALUES ('$article_id', '$category')");
            echo "<script>alert('Artikel berhasil disimpan!');window.location='kelola_artikel.php';</script>";
            exit;
        }
    }
    else {
        $id = intval($_POST['edit_id']);
        $sql = "UPDATE article SET date='$date', title='$title', content='$content'";
        if ($picture) $sql .= ", picture='$picture'";
        $sql .= " WHERE id=$id";
        mysqli_query($koneksi, $sql);
        mysqli_query($koneksi, "UPDATE article_category SET category_id='$category' WHERE article_id=$id");
        echo "<script>alert('Artikel berhasil diupdate!');window.location='kelola_artikel.php';</script>";
        exit;
    }
}

$nickname = mysqli_real_escape_string($koneksi, $_SESSION['nickname']);
$q_author = mysqli_query($koneksi, "SELECT id FROM author WHERE nickname='$nickname' LIMIT 1");
$d_author = mysqli_fetch_assoc($q_author);
$author_id = $d_author['id'];


$filter_kategori = '';
if (isset($_GET['kategori']) && is_numeric($_GET['kategori'])) {
    $kategori_id = intval($_GET['kategori']);
    $filter_kategori = " AND ac.category_id = $kategori_id";
}

$filter_judul = '';
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $q = mysqli_real_escape_string($koneksi, $_GET['q']);
    $filter_judul = " AND a.title LIKE '%$q%'";
}

$sql = "SELECT 
    a.id,
    a.title,
    a.date,
    a.picture,
    a.content,
    c.name AS kategori
FROM 
    article a
JOIN 
    article_author aa ON a.id = aa.article_id
JOIN 
    article_category ac ON a.id = ac.article_id
JOIN 
    category c ON ac.category_id = c.id
WHERE 
    aa.author_id = $author_id
    $filter_kategori
    $filter_judul
ORDER BY a.id DESC";
$result = $koneksi->query($sql);
$result_kat = $koneksi->query("SELECT id, name FROM category");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Artikel Saya | KataKita</title>
    <link rel="stylesheet" href="../assets/css/portal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 400px;
        }
        .table-hover tbody tr {
            cursor: pointer;
        }
    </style>
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
                            <a href="kelola_artikel.php?kategori=<?php echo $kat['id']; ?>" class="btn btn-outline-success btn-sm rounded-pill px-3">
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

    <div class="app-wrapper" style="margin-top:80px; margin-left:100px; max-width:1700px; margin-right:auto; margin-bottom:40px;">
        <main class="app-content p-4">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col">
                        <div class="app-card shadow-sm p-4">
                            <div class="main-title mb-3"><i class="bi bi-file-earmark-text"></i> Daftar Artikel Saya</div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormArtikel">
                                Tambah Artikel
                            </button>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <tbody>
                                        <?php if ($result && $result->num_rows > 0): ?>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr style="position:relative;">
                                                    <td colspan="6" style="padding:0; border:none;">
                                                        <div class="app-card-body d-flex align-items-center" style="position:relative; padding:1rem;">
                                                            <div class="flex-grow-1">
                                                                <div class="fw-bold mb-1">
                                                                    <?php echo htmlspecialchars($row['title']); ?>
                                                                </div>
                                                                <div class="small text-muted mb-1">
                                                                    <?php echo htmlspecialchars($row['date']); ?> |
                                                                    <?php echo htmlspecialchars($_SESSION['nickname']); ?> |
                                                                    <span class="badge bg-success"><?php echo htmlspecialchars($row['kategori']); ?></span>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <?php if (!empty($row['picture'])): ?>
                                                                        <img src="../picture/<?php echo htmlspecialchars($row['picture']); ?>" alt="Gambar Artikel" class="img-thumbnail" style="max-width:80px;">
                                                                    <?php else: ?>
                                                                        <span class="text-muted">Tidak ada gambar</span>
                                                                    <?php endif; ?>
                                                                    <span><?php echo htmlspecialchars(mb_strimwidth(strip_tags($row['content']), 0, 80, "...")); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="ms-3 d-flex flex-column align-items-end" style="z-index:3;">
                                                                <a href="#"
                                                                    class="btn btn-sm btn-warning mb-1 btn-edit-artikel"
                                                                    title="Edit"
                                                                    data-id="<?php echo $row['id']; ?>"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalFormArtikel">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <a href="hapus_artikel.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus artikel ini?');"><i class="bi bi-trash"></i></a>
                                                            </div>
                                                            <!-- Link mask -->
                                                            <a class="app-card-link-mask" href="detail_artikel.php?id=<?php echo $row['id']; ?>" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:2;"></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Tidak ada artikel ditemukan.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 text-start">
                                <strong>Total Artikel: <?php echo $result ? $result->num_rows : 0; ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </main>
    </div>

    <!-- Modal Tambah/Edit Artikel -->
    <div class="modal fade" data-bs-backdrop="static" id="modalFormArtikel" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="modalFormArtikelLabel">Tambah Artikel</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="formArtikel">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="mb-3 mt-3">
                            <label for="date" class="form-label">Tanggal:</label>
                            <input type="text" class="form-control" id="date" name="date">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="title" class="form-label">Judul:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="category" class="form-label">Kategori:</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                $kat_q = $koneksi->query("SELECT id, name FROM category");
                                while ($kat = $kat_q->fetch_assoc()):
                                ?>
                                    <option value="<?php echo $kat['id']; ?>"><?php echo htmlspecialchars($kat['name']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="content">Isi Artikel</label>
                            <textarea class="form-control" rows="18" style="min-height:150px; font-size:1.1rem;" id="content" name="content"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="picture" class="form-label">Gambar</label>
                            <input class="form-control" type="file" id="picture" name="picture">
                            <div id="preview_gambar" class="mt-2"></div>
                        </div>
                        <div class="mb-3 mt-3 d-flex justify-content-end gap-2">
                            <button class="btn btn-primary me-2" name="btn_simpan" id="btnSimpan">Simpan</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <script>
        let editorInstance = null;
        function initCKEditor() {
            if (!editorInstance) {
                CKEDITOR.ClassicEditor.create(document.getElementById("content"), {
                    toolbar: {
                        items: [
                            'exportPDF', 'exportWord', '|',
                            'findAndReplace', 'selectAll', '|',
                            'heading', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                            '-',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                            'alignment', '|',
                            'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                            'textPartLanguage', '|',
                            'sourceEditing'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            },
                            {
                                model: 'heading4',
                                view: 'h4',
                                title: 'Heading 4',
                                class: 'ck-heading_heading4'
                            },
                            {
                                model: 'heading5',
                                view: 'h5',
                                title: 'Heading 5',
                                class: 'ck-heading_heading5'
                            },
                            {
                                model: 'heading6',
                                view: 'h6',
                                title: 'Heading 6',
                                class: 'ck-heading_heading6'
                            }
                        ]
                    },
                    placeholder: 'Buat Artikel Disini',
                    fontFamily: {
                        options: [
                            'default',
                            'Arial, Helvetica, sans-serif',
                            'Courier New, Courier, monospace',
                            'Georgia, serif',
                            'Lucida Sans Unicode, Lucida Grande, sans-serif',
                            'Tahoma, Geneva, sans-serif',
                            'Times New Roman, Times, serif',
                            'Trebuchet MS, Helvetica, sans-serif',
                            'Verdana, Geneva, sans-serif'
                        ],
                        supportAllValues: true
                    },
                    fontSize: {
                        options: [10, 12, 14, 'default', 18, 20, 22],
                        supportAllValues: true
                    },
                    htmlSupport: {
                        allow: [{
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }]
                    },
                    htmlEmbed: {
                        showPreviews: false
                    },
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    mention: {
                        feeds: [{
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }]
                    },
                    removePlugins: [
                        // These two are commercial, but you can try them out without registering to a trial.
                        // 'ExportPdf',
                        // 'ExportWord',
                        'AIAssistant',
                        'CKBox',
                        'CKFinder',
                        'EasyImage',
                        // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                        // 'Base64UploadAdapter',
                        'MultiLevelList',
                        'RealTimeCollaborativeComments',
                        'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList',
                        'Comments',
                        'TrackChanges',
                        'TrackChangesData',
                        'RevisionHistory',
                        'Pagination',
                        'WProofreader',
                        'MathType',
                        'SlashCommand',
                        'Template',
                        'DocumentOutline',
                        'FormatPainter',
                        'TableOfContents',
                        'PasteFromOfficeEnhanced',
                        'CaseChange'
                    ]
                }).then(editor => {
                    editorInstance = editor;
                });
            }
        }
        // Inisialisasi CKEditor saat modal dibuka
        document.getElementById('modalFormArtikel').addEventListener('shown.bs.modal', function() {
            if (!editorInstance) {
                initCKEditor();
            }
        });
        // Reset modal saat ditutup
        document.getElementById('modalFormArtikel').addEventListener('hidden.bs.modal', function() {
            document.getElementById('formArtikel').reset();
            document.getElementById('edit_id').value = '';
            document.getElementById('modalFormArtikelLabel').textContent = 'Tambah Artikel';
            document.getElementById('btnSimpan').textContent = 'Simpan';
            document.getElementById('preview_gambar').innerHTML = '';
            if (editorInstance) editorInstance.setData('');
        });
        // Tombol Tambah Artikel
        document.querySelector('button[data-bs-target="#modalFormArtikel"]')?.addEventListener('click', function(e) {
            document.getElementById('modalFormArtikelLabel').textContent = 'Tambah Artikel';
            document.getElementById('btnSimpan').textContent = 'Simpan';
            document.getElementById('formArtikel').reset();
            document.getElementById('edit_id').value = '';
            if (editorInstance) editorInstance.setData('');
            document.getElementById('preview_gambar').innerHTML = '';
        });
        // Tombol Edit Artikel
        document.querySelectorAll('.btn-edit-artikel').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.getAttribute('data-id');
                fetch('edit_artikel.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_id').value = data.id;
                        document.getElementById('date').value = data.date;
                        document.getElementById('title').value = data.title;
                        document.getElementById('category').value = data.category_id;
                        document.getElementById('modalFormArtikelLabel').textContent = 'Edit Artikel';
                        document.getElementById('btnSimpan').textContent = 'Update';
                        if (data.picture) {
                            document.getElementById('preview_gambar').innerHTML = '<img src="../picture/' + data.picture + '" class="img-thumbnail" style="max-width:120px;">';
                        } else {
                            document.getElementById('preview_gambar').innerHTML = '';
                        }
                        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalFormArtikel'));
                        modal.show();
                        function setEditorContent() {
                            if (editorInstance) {
                                editorInstance.setData(data.content);
                            } else {
                                setTimeout(setEditorContent, 100);
                            }
                        }
                        setEditorContent();
                    });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tambah') === '1') {
                const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalFormArtikel'));
                modal.show();
            }
        });
    </script>
</div>
</body>
</html>