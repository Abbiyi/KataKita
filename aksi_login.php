<?php
session_start();
include "koneksi.php";

$nick = $_POST['nickname'];
$psw = $_POST['password'];
$op = $_GET['op'];

if ($op == "in") {
    $sql = "SELECT * FROM author WHERE nickname='$nick' AND password='$psw'";
    $query = $koneksi->query($sql);
    if (mysqli_num_rows($query) == 1) {
        $data = $query->fetch_array();
        if ($data['level'] == 'Admin') {
            $_SESSION['nickname'] = $data['nickname'];
            $_SESSION['level'] = $data['level'];
            header("Location: admin/home.php");
            exit; 
        } else if ($data['level'] == 'Author') {
            $_SESSION['nickname'] = $data['nickname'];
            $_SESSION['level'] = $data['level'];
            header("Location: author/home.php"); 
            exit;
        } else if ($data['level'] == 'AdminPending') {
            header("Location: login.php?error=adminpending");
            exit;
        }
    } else {
        header("Location: login.php?error=invalid");
        exit;
    }
}
?>