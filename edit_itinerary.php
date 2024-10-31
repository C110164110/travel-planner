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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $itinerary_name = $_POST['itinerary_name'];
            $start_date = $_POST['start_date'];
            $destination = $_POST['destination'];

            $updateStmt = $conn->prepare("UPDATE itineraries SET itinerary_name = :itinerary_name, start_date = :start_date, destination = :destination WHERE id = :id AND user_id = :user_id");
            $updateStmt->bindParam(':itinerary_name', $itinerary_name);
            $updateStmt->bindParam(':start_date', $start_date);
            $updateStmt->bindParam(':destination', $destination);
            $updateStmt->bindParam(':id', $_GET['id']);
            $updateStmt->bindParam(':user_id', $_SESSION['user_id']);
            $updateStmt->execute();

            header("Location: dashboard.php");
            exit();
        }
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
    <title>編輯行程 - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>編輯行程</h2>
        <?php if ($itinerary): ?>
            <form method="POST" action="edit_itinerary.php?id=<?php echo $_GET['id']; ?>">
                <label for="itinerary_name">行程名稱</label>
                <input type="text" name="itinerary_name" id="itinerary_name" value="<?php echo htmlspecialchars($itinerary['itinerary_name']); ?>" required>
                
                <label for="start_date">出發日期</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($itinerary['start_date']); ?>" required>
                
                <label for="destination">目的地</label>
                <input type="text" name="destination" id="destination" value="<?php echo htmlspecialchars($itinerary['destination']); ?>" required>
                
                <button type="submit">儲存更改</button>
            </form>
        <?php else: ?>
            <p>行程不存在。</p>
        <?php endif; ?>
        <a href="dashboard.php">返回</a>
    </div>
</body>
</html>
