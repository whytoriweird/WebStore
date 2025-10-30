<?php
session_start();
require_once '../mySQL/database.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

try {
    $stmt = $pdo->query("SELECT * FROM saiti WHERE dostupnyi = TRUE");
    $websites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Помилка отримання даних: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Каталог сайтів</title>
    <link rel="stylesheet" href="../totalCSS/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav>
    <div class="logo">WebStore</div>

<ul>
    <li><a href="../index.php">Головна</a></li>
    <li><a href="catalog.php" class="active">Каталог</a></li>
    <li><a href="cart.php">Кошик</a></li>
    <li><a href="../about/devpage.php">Про нас</a></li>
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

<div class="header-text">
    <h2>Каталог сайтів</h2>
</div>

<div class="catalog-container">
    <?php foreach ($websites as $website): ?>
        <?php
        $img = '../img/landing.jpg';
        if ($website['nazva'] === 'Landing Page Pro') {
            $img = '../img/landing.jpg';
        } elseif ($website['nazva'] === 'E-commerce Starter') {
            $img = '../img/shop.jpg';
        } elseif ($website['nazva'] === 'Корпоративний сайт') {
            $img = '../img/corporate.jpg';
        }
        ?>
        <div class="card">
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($website['nazva']) ?>" style="width:100%;height:180px;object-fit:cover;border-radius:12px;margin-bottom:15px;">
            <h3><?= htmlspecialchars($website['nazva']) ?></h3>
            <p><?= htmlspecialchars($website['opis']) ?></p>
            <p class="price"><?= number_format($website['tsina'], 2) ?> грн</p>
            <a href="cart.php?add=<?= $website['id'] ?>" class="btn">Замовити</a>
        </div>
    <?php endforeach; ?>
</div>

<footer>
    <p>&copy; 2024 WebStore. Усі права захищені.</p>
</footer>

</body>
</html>