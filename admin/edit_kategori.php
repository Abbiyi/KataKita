<?php
include '../koneksi.php';
$id = intval($_GET['id']);
$sql = "SELECT id, name, description FROM category WHERE id=$id LIMIT 1";
$result = $koneksi->query($sql);
if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo '{}';
}
?>