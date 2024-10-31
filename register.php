<?php
session_start();

// 資料庫連線設置
$host = 'localhost';
$dbname = 'travel_planner';
$user = 'root';  // 確認你的 MySQL 使用者名稱
$pass = '12333';      // 確認你的 MySQL 密碼

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "資料庫連線錯誤: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊 - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>註冊帳號</h2>
        <form action="register.php" method="post">
            <label for="username">使用者名稱:</label>
            <input type="text" name="username" required>

            <label for="email">電子郵件:</label>
            <input type="email" name="email" required>

            <label for="password">密碼:</label>
            <input type="password" name="password" required>

            <button type="submit">註冊</button>
        </form>
        <p>已經有帳號了？ <a href="login.php">登入</a></p>
    </div>
</body>
</html>
