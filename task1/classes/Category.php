<?php

require_once __DIR__ . '/Database.php';

class Category
{
    private $db;
    private $id;
    private $name;
    private $createdAt;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    /**
     * Отримати всі категорії з підрахунком товарів
     */
    public function getAllWithCount()
    {
        $sql = "
            SELECT 
                c.id,
                c.name,
                COUNT(p.id) as product_count
            FROM categories c
            LEFT JOIN products p ON c.id = p.category_id
            GROUP BY c.id, c.name
            ORDER BY c.name
        ";
        
        return $this->db->query($sql);
    }
    

    public function getById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }
    

    public function getAll()
    {
        $sql = "SELECT * FROM categories ORDER BY name";
        return $this->db->query($sql);
    }
    

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getCreatedAt() { return $this->createdAt; }
    

    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
}
