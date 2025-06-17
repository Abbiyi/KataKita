<?php
session_start();
include "../koneksi.php";
$id = intval($_GET['id']);
$sql = "SELECT a.id, a.date, a.title, a.content, a.picture, ac.category_id
        FROM article a
        JOIN article_category ac ON a.id=ac.article_id
        WHERE a.id=$id LIMIT 1";
$q = $koneksi->query($sql);
$data = $q->fetch_assoc();
header('Content-Type: application/json');
echo json_encode($data);