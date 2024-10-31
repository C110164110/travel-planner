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

    if (isset($_GET['id'])) {
        $stmt = $conn->prepare("SELECT * FROM itineraries WHERE id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        $itinerary = $stmt->fetch();
    } else {
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
    <title>查看行程 - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>查看行程</h2>
        <?php if ($itinerary): ?>
            <p><strong>行程名稱:</strong> <?php echo htmlspecialchars($itinerary['itinerary_name']); ?></p>
            <p><strong>出發日期:</strong> <?php echo htmlspecialchars($itinerary['start_date']); ?></p>
            <p><strong>目的地:</strong> <?php echo htmlspecialchars($itinerary['destination']); ?></p>
        <?php else: ?>
            <p>行程不存在。</p>
        <?php endif; ?>
        <a href="dashboard.php">返回</a>
    </div>
</body>
</html>
