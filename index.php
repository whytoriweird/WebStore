<?php
session_start();
require_once 'mySQL/database.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

try {
    $stmt = $pdo->query("SELECT * FROM saiti WHERE dostupnyi = TRUE");
    $websites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Помилка підключення: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebStore - Магазин сайтів</title>
    <link rel="stylesheet" href="totalCSS/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
    <nav>
        <div class="logo">
            <span>WebStore</span>
        </div>
<ul>
    <li><a href="index.php" class="active">Головна</a></li>
    <li><a href="catalog/catalog.php">Каталог</a></li>
    <li><a href="catalog/cart.php">Кошик</a></li>
    <li><a href="about/devpage.php">Про нас</a></li>
    <?php if ($isAdmin): ?>
        <li><a href="adminPage/admin.php">Адмін панель</a></li>
    <?php endif; ?>
    <?php if ($isLoggedIn): ?>
        <li><a href="authorization/authLogout.php" class="auth-btn highlight-btn">Вийти</a></li>
    <?php else: ?>
        <li><a href="authorization/auth.php" class="auth-btn highlight-btn">Увійти</a></li>
    <?php endif; ?>
</ul>
    </nav>
</header>

<main>
        <section class="hero">
            <h1>Ваш майбутній сайт</h1>
            <p>Оберіть готове рішення для вашого бізнесу</p>
        </section>

    <section class="featured-websites">
        <h2>Популярні сайти</h2>
        <div class="websites-grid">
            <?php foreach (array_slice($websites, 0, 3) as $website): ?>
                <?php
                // Прив'язка картинки до конкретної назви
                $img = 'img/landing.jpg';
                if ($website['nazva'] === 'Landing Page Pro') {
                    $img = 'img/landing.jpg';
                } elseif ($website['nazva'] === 'E-commerce Starter') {
                    $img = 'img/shop.jpg';
                } elseif ($website['nazva'] === 'Корпоративний сайт') {
                    $img = 'img/corporate.jpg';
                }
                ?>
                <div class="website-card">
                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($website['nazva']) ?>">
                    <h3><?= htmlspecialchars($website['nazva']) ?></h3>
                    <p><?= htmlspecialchars($website['opis']) ?></p>
                    <div class="price"><?= number_format($website['tsina'], 2) ?> грн</div>
                    <?php if ($isLoggedIn): ?>
                        <a href="catalog/catalog.php" class="btn">Детальніше</a>
                    <?php else: ?>
                        <a href="authorization/auth.php" class="btn">Увійдіть для замовлення</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</main>

    <footer>
        <p>&copy; 2024 WebStore. Усі права захищені.</p>
    </footer>
    
    <script src="homePage/index.js"></script>
</body>
</html>