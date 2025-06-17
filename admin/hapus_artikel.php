<?php
session_start();
if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}

include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql1 = "DELETE FROM article_author WHERE article_id = $id";
    mysqli_query($koneksi, $sql1);
    $sql2 = "DELETE FROM article_category WHERE article_id = $id";
    mysqli_query($koneksi, $sql2);

    $sql3 = "DELETE FROM article WHERE id = $id";
    $result = mysqli_query($koneksi, $sql3);

    if ($result) {
        header("Location: kelola_artikel.php?hapus=success");
        exit;
    } else {
        echo "Gagal menghapus artikel: " . mysqli_error($koneksi);
    }
} else {
    echo "ID artikel tidak ditemukan.";
}
?>