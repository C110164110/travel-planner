<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$dbname = 'travel_planner';
$user = 'root';
$pass = '12333';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $itinerary_name = $_POST['itinerary_name'];
        $start_date = $_POST['start_date'];
        $destination = $_POST['destination'];
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO itineraries (user_id, itinerary_name, start_date, destination) VALUES (:user_id, :itinerary_name, :start_date, :destination)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':itinerary_name', $itinerary_name);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':destination', $destination);
        $stmt->execute();

        header("Location: dashboard.php");
        exit();
    }
} catch (PDOException $e) {
    echo "資料庫連線錯誤: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增行程 - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
        <ul>
            <li><a href="dashboard.php">儀表板</a></li>
            <li><a href="add_itinerary.php">新增行程</a></li>
            <li><a href="local_attractions.php">當地景點推薦</a></li> <!-- 新的連結 -->
            <li><a href="logout.php">登出</a></li>
        </ul>
    </nav>
    <div class="dashboard-container">
        <h2>新增行程</h2>
        <form method="POST" action="add_itinerary.php">
            <label for="itinerary_name">行程名稱</label>
            <input type="text" name="itinerary_name" id="itinerary_name" required>
            
            <label for="start_date">出發日期</label>
            <input type="date" name="start_date" id="start_date" required>
            
            <label for="destination">目的地</label>
            <input type="text" name="destination" id="destination" required>
            
            <button type="submit">新增行程</button>
        </form>
    </div>
</body>
</html>
