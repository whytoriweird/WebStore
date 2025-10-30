<?php
session_start();
require_once '../mySQL/database.php';

$error = '';

// Handle automatic login after registration
if (isset($_SESSION['temp_login']) && isset($_SESSION['temp_password'])) {
    $login = $_SESSION['temp_login'];
    $password = $_SESSION['temp_password'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM korystuvachi WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            unset($_SESSION['temp_login']);
            unset($_SESSION['temp_password']);
            header('Location: ../index.php');
            exit;
        }
    } catch (PDOException $e) {
        $error = 'Помилка входу';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $error = 'Заповніть всі поля';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM korystuvachi WHERE login = ?");
            $stmt->execute([$login]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header('Location: ../index.php');
                exit;
            } else {
                $error = 'Невірний логін або пароль';
            }
        } catch (PDOException $e) {
            $error = 'Помилка входу: ' . $e->getMessage();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід | WebStore</title>
    <link rel="stylesheet" href="../totalCSS/global.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <?php if (isset($_GET['registered'])): ?>
                <div class="success">Реєстрація успішна! Тепер ви можете увійти.</div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="form">
                <h2>Вхід в систему</h2>
                <div class="form-group">
                    <input type="text" name="login" placeholder="Логін" required 
                           value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Пароль" required>
                </div>
                <button type="submit" class="btn">Увійти</button>
                <div class="form-footer">
                    <p>Немає акаунту? <a href="register.php">Зареєструватися</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>