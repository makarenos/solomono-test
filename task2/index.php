<?php


require_once 'classes/CategoryTree.php';

$config = [
    'host' => 'localhost',
    'dbname' => 'solomono_test',
    'user' => 'root',
    'password' => ''
];

try {
    $builder = new CategoryTree(
        $config['host'],
        $config['dbname'],
        $config['user'],
        $config['password']
    );
    
    $result = $builder->build();
    
    echo "<h1>Завдання 2: Дерево категорій</h1>";
    echo "<p><strong>Час виконання:</strong> {$result['execution_time']} сек</p>";
    echo "<p><strong>Всього категорій:</strong> {$result['total_categories']}</p>";
    
    echo "<h2>Результат (структура дерева):</h2>";
    echo "<pre>";
    print_r($result['tree']);
    echo "</pre>";
    
    echo "<h2>JSON формат:</h2>";
    echo "<pre>";
    echo json_encode($result['tree'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "</pre>";
    
    
    if ($result['execution_time'] < 2) {
        echo "<p style='color: green; font-weight: bold;'>✓ Час виконання менше 2 секунд - ВИМОГА ВИКОНАНА</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>✗ Час виконання більше 2 секунд - потрібна оптимізація</p>";
    }
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Помилка:</h2>";
    echo "<p>{$e->getMessage()}</p>";
    echo "<p>Перевірте параметри підключення до БД та наявність таблиці categories</p>";
}
