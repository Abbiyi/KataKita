<?php
$host = 'localhost'; 
$db = 'dbcms';
$user = 'root'; 
$pass = '22desember1965'; 

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>