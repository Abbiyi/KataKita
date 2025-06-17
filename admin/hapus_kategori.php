<?php

session_start();
if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    header("location:../login.php");
    exit;
}
include '../koneksi.php';
if (!isset($_GET['id'])) {
    header("location:kategori.php");
    exit;
}
$id = intval($_GET['id']);
$sql = "DELETE FROM category WHERE id = $id";
if ($koneksi->query($sql)) {
    header("location:kategori.php");
    exit;
} else {
    echo "<script>alert('Gagal menghapus author!');window.location='kategori.php';</script>";
}
?>