<?php

session_start();
if (!isset($_SESSION['nickname']) || $_SESSION['level'] != 'Admin') {
    http_response_code(403);
    exit;
}
include '../koneksi.php';
if (!isset($_GET['id'])) {
    echo '{}';
    exit;
}
$id = intval($_GET['id']);
$sql = "SELECT id, nickname, email FROM author WHERE id=$id LIMIT 1";
$result = $koneksi->query($sql);
if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo '{}';
}