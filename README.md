# Тестове завдання SoloMono

Виконав: Макар, березень 2026

## Структура проекту

```
solomono-test/
├── task1/
│   ├── index.php
│   ├── api.php
│   ├── classes/
│   │   ├── Database.php
│   │   ├── Category.php
│   │   └── Product.php
│   ├── config/
│   │   └── database.php
│   ├── sql/
│   │   └── schema.sql
│   └── assets/js/
│       └── app.js
└── task2/
    ├── index.php
    ├── classes/
    │   └── CategoryTree.php
    └── sql/
        └── schema.sql
```

## Запуск

### Завдання 1

```sql
CREATE DATABASE solomono_catalog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
mysql -u root -p solomono_catalog < task1/sql/schema.sql
```

За потреби змінити дані підключення у `task1/config/database.php`, потім:

```bash
cd task1 && php -S localhost:8000
```

### Завдання 2

```sql
CREATE DATABASE solomono_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
mysql -u root -p solomono_test < task2/sql/schema.sql
```

Заповнити дані підключення у `task2/index.php`, потім відкрити в браузері.

## Вимоги

- PHP 7.1+
- MySQL 5.7+ або MariaDB 10.2+
- PDO