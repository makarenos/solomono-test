<?php

require_once __DIR__ . '/Database.php';

class Product
{
    private $db;
    private $id;
    private $categoryId;
    private $name;
    private $price;
    private $description;
    private $createdAt;
    
    // Допустимі варіанти сортування
    const SORT_PRICE_ASC = 'price_asc';
    const SORT_NAME_ASC = 'name_asc';
    const SORT_DATE_DESC = 'date_desc';
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    

    public function getProducts($categoryId = null, $sort = self::SORT_DATE_DESC)
    {
        $sql = "
            SELECT 
                p.*,
                c.name as category_name
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
        ";
        
        $params = [];
        

        if ($categoryId !== null) {
            $sql .= " WHERE p.category_id = ?";
            $params[] = $categoryId;
        }

        $sql .= $this->getSortClause($sort);
        
        return $this->db->query($sql, $params);
    }
    

    public function getById($id)
    {
        $sql = "
            SELECT 
                p.*,
                c.name as category_name
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ";
        
        return $this->db->fetchOne($sql, [$id]);
    }
    

    private function getSortClause($sort)
    {
        switch ($sort) {
            case self::SORT_PRICE_ASC:
                return " ORDER BY p.price ASC";
            
            case self::SORT_NAME_ASC:
                return " ORDER BY p.name ASC";
            
            case self::SORT_DATE_DESC:
            default:
                return " ORDER BY p.created_at DESC";
        }
    }
    

    public static function isValidSort($sort)
    {
        return in_array($sort, [
            self::SORT_PRICE_ASC,
            self::SORT_NAME_ASC,
            self::SORT_DATE_DESC
        ]);
    }
    
    // getters
    public function getId() { return $this->id; }
    public function getCategoryId() { return $this->categoryId; }
    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getDescription() { return $this->description; }
    public function getCreatedAt() { return $this->createdAt; }
    
    // setters
    public function setId($id) { $this->id = $id; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }
    public function setName($name) { $this->name = $name; }
    public function setPrice($price) { $this->price = $price; }
    public function setDescription($description) { $this->description = $description; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
}
