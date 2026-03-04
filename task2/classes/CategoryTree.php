<?php

class CategoryTree
{
    private $pdo;
    private $categories = [];

    public function __construct($host, $dbname, $user, $password)
    {
        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $this->pdo = new PDO($dsn, $user, $password, $options);
    }

    private function fetchCategories()
    {
        $sql = "SELECT SQL_NO_CACHE categories_id, parent_id FROM categories ORDER BY categories_id";
        $stmt = $this->pdo->query($sql);

        $this->categories = [];
        while ($row = $stmt->fetch()) {
            $this->categories[$row['categories_id']] = $row['parent_id'];
        }
    }

    private function buildBranch($parentId)
    {
        $result = [];

        foreach ($this->categories as $id => $parent) {
            if ($parent == $parentId) {
                $children = $this->buildBranch($id);

                if (empty($children)) {
                    $result[$id] = $id;
                } else {
                    $result[$id] = $children;
                }
            }
        }

        return $result;
    }

    public function build()
    {
        $startTime = microtime(true);

        $this->fetchCategories();

        $tree = $this->buildBranch(0);

        $executionTime = microtime(true) - $startTime;

        return [
            'tree' => $tree,
            'execution_time' => round($executionTime, 4),
            'total_categories' => count($this->categories)
        ];
    }
}