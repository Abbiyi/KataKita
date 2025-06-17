<?php

include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT a.*, ac.category_id 
            FROM article a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE a.id = $id LIMIT 1";
    $result = mysqli_query($koneksi, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'id' => $row['id'],
            'date' => $row['date'],
            'title' => $row['title'],
            'content' => $row['content'],
            'category_id' => $row['category_id']
        ]);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID tidak ditemukan']);
}
?>