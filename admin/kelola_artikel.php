<?php
session_start();

if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}
include '../koneksi.php';

if (isset($_POST['btn_simpan'])) {

    if (isset($_POST['edit_id'])) {
        $id = intval($_POST['edit_id']);
        $date = $_POST['date'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];

        if (!empty($_FILES["picture"]["name"])) {
            $target_dir = "../picture/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["picture"]["tmp_name"]);
            if ($check === false) $uploadOk = 0;

            if (file_exists($target_file)) $uploadOk = 0;
            if ($_FILES["picture"]["size"] > 500000) $uploadOk = 0;
            if (
                $imageFileType != "jpg" && $imageFileType != "png" &&
                $imageFileType != "jpeg" && $imageFileType != "gif"
            ) $uploadOk = 0;

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    $picture = basename($_FILES["picture"]["name"]);
                    $sql = "UPDATE article SET date='$date', title='$title', content='$content', picture='$picture' WHERE id=$id";
                } else {
                    echo "Gagal upload gambar baru.<br>";
                    $sql = "UPDATE article SET date='$date', title='$title', content='$content' WHERE id=$id";
                }
            } else {
                echo "Gagal upload gambar baru.<br>";
                $sql = "UPDATE article SET date='$date', title='$title', content='$content' WHERE id=$id";
            }
        } else {
            $sql = "UPDATE article SET date='$date', title='$title', content='$content' WHERE id=$id";
        }

        mysqli_query($koneksi, $sql);
        $sql_cat = "UPDATE article_category SET category_id='$category' WHERE article_id=$id";
        mysqli_query($koneksi, $sql_cat);
        echo "Artikel berhasil diupdate!";
    } else {
        $target_dir = "../picture/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check === false) $uploadOk = 0;

        if (file_exists($target_file)) $uploadOk = 0;
        if ($_FILES["picture"]["size"] > 500000) $uploadOk = 0;
        if (
            $imageFileType != "jpg" && $imageFileType != "png" &&
            $imageFileType != "jpeg" && $imageFileType != "gif"
        ) $uploadOk = 0;

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                $date = $_POST['date'];
                $title = $_POST['title'];
                $content = $_POST['content'];
                $data_id_category = $_POST['category'];
                $picture = basename($_FILES["picture"]["name"]);


                $nickname = $_SESSION['nickname'];
                $sql_author = "SELECT id FROM author WHERE nickname='$nickname' LIMIT 1";
                $result_author = mysqli_query($koneksi, $sql_author);
                $author_id = null;
                if ($row_author = mysqli_fetch_assoc($result_author)) {
                    $author_id = $row_author['id'];
                }

                $sql = "INSERT INTO article (date, title, content, picture) VALUES ('$date', '$title', '$content', '$picture')";
                if (mysqli_query($koneksi, $sql)) {
                    $article_id = mysqli_insert_id($koneksi);
                    if ($author_id) {
                        $sql_author_rel = "INSERT INTO article_author (article_id, author_id) VALUES ('$article_id', '$author_id')";
                        mysqli_query($koneksi, $sql_author_rel);
                    }

                    $sql_category = "INSERT INTO article_category (article_id, category_id) VALUES ('$article_id', '$data_id_category')";
                    mysqli_query($koneksi, $sql_category);

                    echo "Artikel berhasil disimpan!";
                } else {
                    echo "Gagal menyimpan artikel: " . mysqli_error($koneksi);
                }
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        } else {
            echo "Sorry, your file was not uploaded.<br>";
        }
    }
}

$where = "";
if (isset($_GET['author'])) {
    $author = mysqli_real_escape_string($koneksi, $_GET['author']);
    $where = "WHERE au.nickname = '$author'";
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
    ORDER BY a.id ASC";

$result = $koneksi->query($sql);

if (!$result) {
    die("Query gagal: " . $koneksi->error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kelola Artikel | Admin</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/portal.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .ck-editor__editable[role="textbox"] {
        
            min-height: 400px;
        }
    </style>
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
    <header class="app-header d-flex align-items-center justify-content-between px-4" style="background:#fff; box-shadow:0 2px 8px 0 rgba(0,0,0,0.07); height:80px; position:fixed; top:0; left:0; right:0; z-index:100;">
        <div class="d-flex align-items-center">
            <a href="home.php">
                <img src="../assets/images/namawebsite.png" alt="KataKita" class="me-4" style="height:58px;">
            </a>
        </div>
        <div class="d-flex align-items-center">
            <form class="d-flex me-3" method="get">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari artikel..." aria-label="Search" style="min-width:180px;" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <a href="kelola_artikel.php?author=<?php echo urlencode($_SESSION['nickname']); ?>" class="btn btn-primary me-2 d-none d-md-inline">
                <i class="bi bi-pencil-square"></i>Artikel Saya
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
    <div class="app-wrapper " style="margin-top:39px;">
        <main class="app-content p-4">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col">
                        <div class="app-card shadow-sm p-4">
                            <div class="main-title mb-3"><i class="bi bi-file-earmark-text"></i> Daftar Artikel</div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormArtikel">
                                Tambah Artikel
                            </button>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr style="position:relative;">
                                                    <td colspan="6" style="padding:0; border:none;">
                                                        <div class="app-card-body d-flex align-items-center" style="position:relative; padding:1rem;">
                                                            <div class="flex-grow-1">
                                                                <div class="fw-bold mb-1">
                                                                    <?php echo htmlspecialchars($row['judul_artikel']); ?>
                                                                </div>
                                                                <div class="small text-muted mb-1">
                                                                    <?php echo htmlspecialchars($row['tanggal_publikasi']); ?> |
                                                                    <?php echo htmlspecialchars($row['nama_penulis']); ?> |
                                                                    <span class="badge bg-success"><?php echo htmlspecialchars($row['nama_kategori']); ?></span>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <?php if (!empty($row['gambar'])): ?>
                                                                        <img src="../picture/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Gambar Artikel" class="img-thumbnail" style="max-width:80px;">
                                                                    <?php else: ?>
                                                                        <span class="text-muted">Tidak ada gambar</span>
                                                                    <?php endif; ?>
                                                                    <span><?php echo htmlspecialchars(mb_strimwidth(strip_tags($row['isi_artikel']), 0, 80, "...")); ?></span>
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
        </main>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- The Modal -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>

    <div class="modal fade" data-bs-backdrop="static" id="modalFormArtikel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3 mt-3">
                            <label for="date" class="form-label">Tanggal:</label>
                            <input type="text" class="form-control" id="date" name="date">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="title" class="form-label">Judul:</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="category" class="form-label">Kategori:</label>
                            <select class="form-select" id="category" name="category">
                                <?php
                                $sql = "SELECT id, name FROM category";
                                $result = mysqli_query($koneksi, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $data_id_category  = $row['id'];
                                        $data_name_category = $row['name'];
                                ?>
                                        <option value="<?php echo $data_id_category; ?>"><?php echo $data_name_category; ?></option>
                                <?php
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="isi">Isi Artikel</label>
                            <textarea class="form-control" rows="18" style="min-height:150px; font-size:1.1rem;" id="content" name="content"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="picture" class="form-label">Gambar</label>
                            <input class="form-control" type="file" id="picture" name="picture">
                        </div>
                        <div class="mb-3 mt-3 d-flex justify-content-end gap-2">
                            <div class="w-100 d-flex justify-content-end pe-4">
                                <button class="btn btn-primary me-2" name="btn_simpan">Simpan</button>
                                <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            CKEDITOR.ClassicEditor.create(document.getElementById("content"), {
                // ...config...

                // https://ckeditor.com/docs/ckeditor5/latest/getting-started/setup/toolbar/toolbar.html#extended-toolbar-configuration-format
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
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
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
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: 'Buat Artikel Disini',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
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
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: false
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
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
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [{
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }]
                },
                // The "superbuild" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    // 'ExportPdf',
                    // 'ExportWord',
                    'AIAssistant',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
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
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced',
                    'CaseChange'
                ]
            }).then(editor => {
                window.editor = editor;
            });
        </script>

        <script>
            document.querySelectorAll('.btn-edit-artikel').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var id = this.getAttribute('data-id');
                    fetch('edit_artikel.php?id=' + id)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('date').value = data.date;
                            document.getElementById('title').value = data.title;
                            document.getElementById('category').value = data.category_id;

                            if (window.editor) {
                                window.editor.setData(data.content);
                            }

                            let input = document.getElementById('edit_id');
                            if (!input) {
                                input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'edit_id';
                                input.id = 'edit_id';
                                document.querySelector('#modalFormArtikel form').appendChild(input);
                            }
                            input.value = id;

                            document.querySelector('#modalFormArtikel .modal-title').textContent = 'Edit Artikel';

                            document.querySelector('#modalFormArtikel button[name="btn_simpan"]').textContent = 'Update';
                        });
                });
            });
        </script>
        <script>
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
    </div>
        </div>
        <footer class="app-footer mt-5" style="background:#e9f7ef; padding:20px 0;">
        <div class="container-xl text-center">
            <p class="mb-0" style="color:#555;">&copy; 2025 KataKita.</p>
        </div>
    </footer>
</body>
</html>