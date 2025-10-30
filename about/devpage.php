<?php
session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Про нас</title>
    <link rel="stylesheet" href="../totalCSS/global.css">
</head>
<body>
<nav>
    <div class="logo">WebStore</div>
    <ul>
        <li><a href="../index.php">Головна</a></li>
        <li><a href="../catalog/catalog.php">Каталог</a></li>
        <li><a href="../catalog/cart.php">Кошик</a></li>
        <li><a href="devpage.php" class="active">Про нас</a></li>
        <?php if ($isAdmin): ?>
            <li><a href="../adminPage/admin.php">Адмін панель</a></li>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <li><a href="../authorization/authLogout.php" class="auth-btn">Вийти</a></li>
        <?php else: ?>
            <li><a href="../authorization/auth.php" class="auth-btn">Увійти</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="centered-text">
    <h2>Команда розробників</h2>
</div>

<div class="row">
    <?php
    $team = [
        [
            "name" => "Роман Симчич",
            "role" => "Full-stack розробник",
            "image" => "../img/developer.jpg",
        ]
    ];

    foreach ($team as $member) :
    ?>
        <div class="card">
            <img src="<?= $member["image"]; ?>" alt="<?= $member["name"]; ?>">
            <h1><?= $member["name"]; ?></h1>
            <p class="title"><?= $member["role"]; ?></p>
        </div>
    <?php endforeach; ?>
</div>

<footer>
    <p>&copy; 2024 WebStore. Усі права захищені.</p>
</footer>

</body>
</html>