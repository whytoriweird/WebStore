<?php
session_start();
require_once '../mySQL/database.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    $confirm = $_POST['password_confirm'];

    if (empty($login) || empty($password) || empty($confirm)) {
        $error = 'Заповніть всі поля';
    } elseif (strlen($login) < 4) {
        $error = 'Логін має бути не менше 4 символів';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль має бути не менше 6 символів';
    } elseif ($password !== $confirm) {
        $error = 'Паролі не співпадають';
    } else {

// ...existing code...
    try {
         // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM korystuvachi WHERE login = ?");
         $stmt->execute([$login]);
    
         if ($stmt->fetch()) {
            $error = 'Такий логін вже існує';
        } else {
             // Create new user with properly hashed password
             $hash = password_hash($password, PASSWORD_DEFAULT);
             $stmt = $pdo->prepare("INSERT INTO korystuvachi (login, password, role) VALUES (?, ?, 'user')");
        
            if ($stmt->execute([$login, $hash])) {
                // Store the credentials in session temporarily for automatic login
                $_SESSION['temp_login'] = $login;
                $_SESSION['temp_password'] = $password;
                header('Location: auth.php?registered=true');
                exit;
            } else {
                $error = 'Помилка реєстрації';
            }
    }
} catch (PDOException $e) {
    $error = 'Помилка реєстрації: ' . $e->getMessage();
}
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація | WebStore</title>
    <link rel="stylesheet" href="../totalCSS/global.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="form">
                <h2>Реєстрація</h2>
                <div class="form-group">
                    <input type="text" name="login" placeholder="Логін" required 
                           minlength="4" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Пароль" 
                           required minlength="6">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirm" 
                           placeholder="Повторіть пароль" required minlength="6">
                </div>
                <button type="submit" class="btn">Зареєструватися/Увійти</button>
                <div class="form-footer">
                    <p>Вже є акаунт? <a href="auth.php">Увійти</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>