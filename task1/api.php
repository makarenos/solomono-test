<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/classes/Product.php';
require_once __DIR__ . '/classes/Category.php';

try {
    $action = $_GET['action'] ?? '';
    
    switch ($action) {
        case 'get_products':

            $categoryId = isset($_GET['category']) && $_GET['category'] !== '' 
                ? (int)$_GET['category'] 
                : null;
            
            $sort = $_GET['sort'] ?? Product::SORT_DATE_DESC;
            

            if (!Product::isValidSort($sort)) {
                $sort = Product::SORT_DATE_DESC;
            }
            
            $productModel = new Product();
            $products = $productModel->getProducts($categoryId, $sort);
            
            echo json_encode([
                'success' => true,
                'data' => $products,
                'filters' => [
                    'category_id' => $categoryId,
                    'sort' => $sort
                ]
            ], JSON_UNESCAPED_UNICODE);
            break;
            
        case 'get_product':

            $productId = (int)($_GET['id'] ?? 0);
            
            if ($productId <= 0) {
                throw new Exception('Invalid product ID');
            }
            
            $productModel = new Product();
            $product = $productModel->getById($productId);
            
            if (!$product) {
                throw new Exception('Product not found');
            }
            
            echo json_encode([
                'success' => true,
                'data' => $product
            ], JSON_UNESCAPED_UNICODE);
            break;
            
        case 'get_categories':

            $categoryModel = new Category();
            $categories = $categoryModel->getAllWithCount();
            
            echo json_encode([
                'success' => true,
                'data' => $categories
            ], JSON_UNESCAPED_UNICODE);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
