<?php
session_start();

// 資料庫連線設置
$host = 'localhost';
$dbname = 'travel_planner';
$user = 'root';
$pass = '12333';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "帳號或密碼錯誤";
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
    <title>登入 - Travel Planner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>登入帳號</h2>
        <form action="login.php" method="post">
            <label for="email">電子郵件:</label>
            <input type="email" name="email" required>

            <label for="password">密碼:</label>
            <input type="password" name="password" required>

            <button type="submit">登入</button>
        </form>
        <p>還沒有帳號？ <a href="register.php">註冊</a></p>
    </div>
</body>
</html>
