CREATE DATABASE IF NOT EXISTS site1;
USE site1;

-- Таблиця користувачів
CREATE TABLE IF NOT EXISTS korystuvachi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Таблиця сайтів
CREATE TABLE saiti (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nazva VARCHAR(100) NOT NULL,
    opis TEXT,
    tsina DECIMAL(10,2) NOT NULL,
    dostupnyi BOOLEAN DEFAULT TRUE
);

-- Таблиця покупок (user_id напряму)
DROP TABLE IF EXISTS pokupki;
CREATE TABLE pokupki (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    sait_id INT NOT NULL,
    data_pokupky DATE NOT NULL,
    tsina_na_moment DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES korystuvachi(id),
    FOREIGN KEY (sait_id) REFERENCES saiti(id)
);

-- Вставка користувачів
INSERT INTO korystuvachi (login, password, role) VALUES
('admin', '12012007', 'admin'),
('user1', '2007', 'user'),
('user2', '1201', 'user');

-- Вставка сайтів
INSERT INTO saiti (nazva, opis, tsina, dostupnyi) VALUES
('Landing Page Pro', 'Сучасний лендинг для малого бізнесу', 5000.00, TRUE),
('E-commerce Starter', 'Магазин на 100 товарів', 15000.00, TRUE),
('Корпоративний сайт', 'Презентація компанії з блогом', 10000.00, TRUE);

-- Вставка покупок (user_id, sait_id, дата, ціна)
INSERT INTO pokupki (user_id, sait_id, data_pokupky, tsina_na_moment) VALUES
(2, 1, '2025-05-01', 5000.00),
(3, 3, '2025-05-05', 10000.00);

