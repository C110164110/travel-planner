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

    $stmt = $conn->prepare("SELECT * FROM itineraries WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $itineraries = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "資料庫連線錯誤: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .dashboard-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            color: #333;
        }
        .logout-button {
            background-color: #ff6b6b;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
        }
        .add-itinerary-button {
            background-color: #4caf50;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f1f1f1;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }
        .view-button, .edit-button {
            background-color: #2196f3;
            color: #fff;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }
        .edit-button {
            background-color: #ff9800;
        }
    </style>
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
        <h2>歡迎來到 Travel Planner！</h2>
        <p>探索新的旅行目的地，並管理您的旅行行程。</p>
        <a href="logout.php" class="logout-button">登出</a>
        
        <h3>您的行程</h3>
        <?php if (count($itineraries) > 0): ?>
            <ul>
                <?php foreach ($itineraries as $itinerary): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($itinerary['itinerary_name']); ?></strong><br>
                        出發日期: <?php echo htmlspecialchars($itinerary['start_date']); ?><br>
                        目的地: <?php echo htmlspecialchars($itinerary['destination']); ?><br>
                        <a href="view_itinerary.php?id=<?php echo $itinerary['id']; ?>" class="view-button">查看行程</a>
                        <a href="edit_itinerary.php?id=<?php echo $itinerary['id']; ?>" class="edit-button">編輯行程</a>
                        <a href="delete_itinerary.php?id=<?php echo $itinerary['id']; ?>" class="delete-button" onclick="return confirm('確定要刪除這個行程嗎？');">刪除</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>目前沒有行程。</p>
        <?php endif; ?>
        
        <a href="add_itinerary.php" class="add-itinerary-button">新增行程</a>
    </div>
</body>
</html>
