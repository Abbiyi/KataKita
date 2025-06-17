<?php
session_start();
if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Author') {
    header("location:../login.php");
    exit;
}
include "../koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:kelola_artikel.php");
    exit;
}
$id = intval($_GET['id']);

$nickname = mysqli_real_escape_string($koneksi, $_SESSION['nickname']);
$q_author = mysqli_query($koneksi, "SELECT id FROM author WHERE nickname='$nickname' LIMIT 1");
$d_author = mysqli_fetch_assoc($q_author);
$author_id = $d_author['id'];

$cek = mysqli_query($koneksi, "SELECT a.id FROM article a 
    JOIN article_author aa ON a.id=aa.article_id 
    WHERE a.id=$id AND aa.author_id=$author_id");
if (mysqli_num_rows($cek) > 0) {
    mysqli_query($koneksi, "DELETE FROM article_author WHERE article_id=$id");
    mysqli_query($koneksi, "DELETE FROM article_category WHERE article_id=$id");
    mysqli_query($koneksi, "DELETE FROM article WHERE id=$id");
    echo "<script>alert('Artikel berhasil dihapus!');window.location='kelola_artikel.php';</script>";
    exit;
} else {
    echo "<script>alert('Gagal menghapus: Anda tidak berhak menghapus artikel ini!');window.location='kelola_artikel.php';</script>";
    exit;
}