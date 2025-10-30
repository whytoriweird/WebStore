<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=site1;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch (PDOException $e) {
    die("Помилка підключення до бази даних: " . $e->getMessage());
}