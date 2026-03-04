<?php

require_once __DIR__ . '/classes/Category.php';


$categoryModel = new Category();
$categories = $categoryModel->getAllWithCount();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товарів - Тестове завдання</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .sidebar {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            position: sticky;
            top: 20px;
        }
        
        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            transition: all 0.2s;
        }
        
        .category-item:hover {
            background-color: #e9ecef;
            text-decoration: none;
            color: #333;
        }
        
        .category-item.active {
            background-color: #0d6efd;
            color: white;
        }
        
        .category-item.active:hover {
            background-color: #0b5ed7;
            color: white;
        }
        
        .category-badge {
            background-color: #dee2e6;
            color: #495057;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .category-item.active .category-badge {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }
        
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .controls-panel {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <h4 class="mb-3">Категорії</h4>

                    <a href="#" class="category-item" data-category-id="all">
                        <span>Всі товари</span>
                        <span class="category-badge">
                            <?php 
                            $total = array_sum(array_column($categories, 'product_count'));
                            echo $total;
                            ?>
                        </span>
                    </a>

                    <?php foreach ($categories as $category): ?>
                        <a href="#" class="category-item" data-category-id="<?= $category['id'] ?>">
                            <span><?= htmlspecialchars($category['name']) ?></span>
                            <span class="category-badge"><?= $category['product_count'] ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-md-9">
                <div class="controls-panel">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-0">Каталог товарів</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-end">
                                <label for="sortSelect" class="me-2 mb-0">Сортування:</label>
                                <select id="sortSelect" class="form-select" style="width: auto;">
                                    <option value="date_desc">Спочатку нові</option>
                                    <option value="price_asc">Спочатку дешевші</option>
                                    <option value="name_asc">По алфавіту</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="productsContainer">
                    <div class="text-center p-5">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Завантаження...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Деталі товару</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 id="modalProductName" class="mb-3"></h3>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Категорія:</strong></p>
                            <p id="modalProductCategory" class="text-muted"></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Ціна:</strong></p>
                            <p id="modalProductPrice" class="text-success fs-4 fw-bold"></p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-1"><strong>Опис:</strong></p>
                        <p id="modalProductDescription"></p>
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-1"><strong>Дата додавання:</strong></p>
                        <p id="modalProductDate" class="text-muted"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button type="button" class="btn btn-primary">Додати в кошик</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/app.js"></script>
</body>
</html>
