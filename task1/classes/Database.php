<?php

class Database
{
    private static $instance = null;
    private $pdo;
    
    private function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';
        
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=%s",
            $config['host'],
            $config['dbname'],
            $config['charset']
        );
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    

    public function getConnection()
    {
        return $this->pdo;
    }
    

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function __clone() {}
    public function __wakeup() {}
}
