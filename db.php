<?php
$host = "localhost";
$user = "root"; // 根據你的 MySQL 用戶設置
$password = "12333"; // 根據你的 MySQL 密碼設置
$database = "travel_planner";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("資料庫連接失敗: " . $conn->connect_error);
}
?>
