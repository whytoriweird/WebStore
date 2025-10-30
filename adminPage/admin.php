<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../authorization/auth.php');
    exit;
}
require_once '../mySQL/database.php';

// Отримати список користувачів
$users = [];
try {
    $stmt = $pdo->query("SELECT id, login FROM korystuvachi");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $users = [];
}

// Отримати покупки користувачів
$purchases = [];
try {
    $stmt = $pdo->query("SELECT p.id, k.login, s.nazva, p.data_pokupky, p.tsina_na_moment
        FROM pokupki p
        JOIN korystuvachi k ON p.user_id = k.id
        JOIN saiti s ON p.sait_id = s.id
        ORDER BY p.data_pokupky DESC");
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $purchases = [];
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Інформація про користувачів</title>
    <link rel="stylesheet" href="../totalCSS/global.css">
</head>
<body>
    <nav>
        <div class="logo">WebStore</div>
        <ul>
            <li><a href="../index.php">Головна</a></li>
            <li><a href="admin.php" class="active">Адмін панель</a></li>
            <li><a href="../authorization/authLogout.php" class="auth-btn">Вийти</a></li>
        </ul>
    </nav>
    <main>
        <div class="header-text">
            <h2>Користувачі та їх покупки</h2>
        </div>
        <div class="admin-panel">
            <h3>Список користувачів</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Логін</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['login']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <h3>Покупки користувачів</h3>
            <table>
                <tr>
                    <th>ID покупки</th>
                    <th>Користувач</th>
                    <th>Сайт</th>
                    <th>Дата</th>
                    <th>Ціна</th>
                </tr>
                <?php foreach ($purchases as $purchase): ?>
                    <tr>
                        <td><?= htmlspecialchars($purchase['id']) ?></td>
                        <td><?= htmlspecialchars($purchase['login']) ?></td>
                        <td><?= htmlspecialchars($purchase['nazva']) ?></td>
                        <td><?= htmlspecialchars($purchase['data_pokupky']) ?></td>
                        <td><?= htmlspecialchars($purchase['tsina_na_moment']) ?> грн</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>
</html>