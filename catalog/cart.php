<?php
session_start();
require_once '../mySQL/database.php';

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../authorization/auth.php');
    exit;
}

// Додаємо сайт у кошик (через GET-параметр ?add=ID)
if (isset($_GET['add'])) {
    $siteId = intval($_GET['add']);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!in_array($siteId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $siteId;
    }
    header('Location: cart.php');
    exit;
}

// Видалення з кошика
if (isset($_GET['remove'])) {
    $siteId = intval($_GET['remove']);
    if (($key = array_search($siteId, $_SESSION['cart'] ?? [])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
    header('Location: cart.php');
    exit;
}

// Оформлення покупки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['cart'])) {
    $userId = $_SESSION['user_id'];
    $cart = $_SESSION['cart'];
    $stmt = $pdo->prepare("SELECT * FROM saiti WHERE id = ?");
    foreach ($cart as $siteId) {
        $stmt->execute([$siteId]);
        $site = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($site) {
            $pdo->prepare("INSERT INTO pokupki (user_id, sait_id, data_pokupky, tsina_na_moment) VALUES (?, ?, NOW(), ?)")
                ->execute([$userId, $siteId, $site['tsina']]);
        }
    }
    $_SESSION['cart'] = [];
    echo "<script>alert('Покупку оформлено!');window.location.href='cart.php';</script>";
    exit;
}

// Отримати сайти з кошика
$cartSites = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', $_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM saiti WHERE id IN ($ids)");
    $cartSites = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Кошик</title>
    <link rel="stylesheet" href="../totalCSS/global.css">
</head>
<body>
<nav>
    <div class="logo">WebStore</div>
    <ul>
        <li><a href="../index.php">Головна</a></li>
        <li><a href="catalog.php">Каталог</a></li>
        <li><a href="cart.php" class="active">Кошик</a></li>
        <li><a href="../about/devpage.php">Про нас</a></li>
        <?php if ($isAdmin): ?>
            <li><a href="../adminPage/admin.php">Адмін панель</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="../authorization/authLogout.php" class="auth-btn">Вийти</a></li>
        <?php else: ?>
            <li><a href="../authorization/auth.php" class="auth-btn">Увійти</a></li>
        <?php endif; ?>
    </ul>
</nav>
<div class="header-text">
    <h2>Ваш кошик</h2>
</div>
<div class="catalog-container">
    <?php if (empty($cartSites)): ?>
        <p>Кошик порожній.</p>
    <?php else: ?>
        <?php foreach ($cartSites as $site): ?>
            <div class="card">
                <h3><?= htmlspecialchars($site['nazva']) ?></h3>
                <p><?= htmlspecialchars($site['opis']) ?></p>
                <p class="price"><?= number_format($site['tsina'], 2) ?> грн</p>
                <a href="cart.php?remove=<?= $site['id'] ?>" class="btn" style="background:#dc3545;">Видалити</a>
            </div>
        <?php endforeach; ?>
<div class="center-btn">
    <form method="post" id="checkoutForm">
        <button type="submit" class="btn">Оформити покупку</button>
    </form>
</div>
    <?php endif; ?>
</div>
    <script>
        document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {});
    </script>  
</body>
</html>