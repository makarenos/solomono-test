CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categories (name) VALUES
('Електроніка'),
('Одяг'),
('Книги'),
('Спорт'),
('Дім і сад');

INSERT INTO products (category_id, name, price, description, created_at) VALUES
-- Електроніка
(1, 'iPhone 15 Pro', 45000.00, 'Смартфон Apple з titanium корпусом', '2024-01-15 10:00:00'),
(1, 'Samsung Galaxy S24', 38000.00, 'Флагманський смартфон Samsung', '2024-02-20 11:30:00'),
(1, 'MacBook Air M3', 52000.00, 'Ноутбук Apple з чіпом M3', '2024-01-10 09:00:00'),
(1, 'AirPods Pro 2', 8500.00, 'Бездротові навушники з ANC', '2024-03-01 14:00:00'),

-- Одяг
(2, 'Куртка Nike Sportswear', 3200.00, 'Чоловіча зимова куртка', '2024-02-05 12:00:00'),
(2, 'Джинси Levis 501', 2800.00, 'Класичні прямі джинси', '2024-01-25 10:30:00'),
(2, 'Кросівки Adidas Ultraboost', 4500.00, 'Бігові кросівки', '2024-02-28 15:00:00'),
(2, 'Футболка Tommy Hilfiger', 1200.00, 'Базова бавовняна футболка', '2024-03-05 11:00:00'),

-- Книги
(3, 'Чисті архітектури', 650.00, 'Роберт Мартін - Clean Architecture', '2024-01-05 08:00:00'),
(3, 'PHP для професіоналів', 890.00, 'Сучасна розробка на PHP', '2024-02-10 09:30:00'),
(3, 'JavaScript: повне керівництво', 1100.00, 'Девід Флаваган', '2024-01-20 10:00:00'),
(3, 'Алгоритми та структури даних', 720.00, 'Томас Кормен', '2024-02-15 12:00:00'),

-- Спорт
(4, 'Гантелі 2x10кг', 1800.00, 'Розбірні гантелі для дому', '2024-01-30 13:00:00'),
(4, 'Велосипед Trek Mountain', 18000.00, 'Гірський велосипед 29"', '2024-02-12 10:00:00'),
(4, 'Йога-мат', 650.00, 'Килимок для йоги 180x60см', '2024-03-02 14:30:00'),
(4, 'Фітнес-браслет Xiaomi', 1500.00, 'Mi Band 8 з моніторингом сну', '2024-02-25 11:00:00'),

-- Дім і сад
(5, 'Пилосос Dyson V15', 22000.00, 'Бездротовий пилосос', '2024-01-18 09:00:00'),
(5, 'Мультиварка Tefal', 3500.00, 'Мультиварка 6л', '2024-02-08 10:30:00'),
(5, 'Набір ножів', 2200.00, 'Професійні кухонні ножі 5шт', '2024-03-03 12:00:00'),
(5, 'Кавоварка Delonghi', 12000.00, 'Автоматична кавоварка', '2024-01-28 13:30:00');
