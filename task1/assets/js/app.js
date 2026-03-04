class ProductCatalog {
    constructor() {
        this.currentCategory = null;
        this.currentSort = 'date_desc';
        this.modal = null;
        
        this.init();
    }
    
    init() {
        const urlParams = new URLSearchParams(window.location.search);
        this.currentCategory = urlParams.get('category');
        this.currentSort = urlParams.get('sort') || 'date_desc';

        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.value = this.currentSort;
        }
        

        const modalElement = document.getElementById('productModal');
        if (modalElement && typeof bootstrap !== 'undefined') {
            this.modal = new bootstrap.Modal(modalElement);
        }

        this.loadProducts();

        this.highlightActiveCategory();

        this.attachEventListeners();
    }
    
    attachEventListeners() {
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const categoryId = item.dataset.categoryId;
                this.filterByCategory(categoryId);
            });
        });

        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.currentSort = e.target.value;
                this.loadProducts();
                this.updateUrl();
            });
        }
        
        // кнопки "купити"
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-buy')) {
                const productId = e.target.dataset.productId;
                this.showProductModal(productId);
            }
        });
    }

    filterByCategory(categoryId) {
        this.currentCategory = categoryId === 'all' ? null : categoryId;
        this.loadProducts();
        this.updateUrl();
        this.highlightActiveCategory();
    }

    async loadProducts() {
        const container = document.getElementById('productsContainer');
        if (!container) return;

        container.innerHTML = '<div class="text-center p-5"><div class="spinner-border" role="status"></div></div>';
        
        try {
            const params = new URLSearchParams({
                action: 'get_products',
                sort: this.currentSort
            });
            
            if (this.currentCategory) {
                params.append('category', this.currentCategory);
            }
            
            const response = await fetch(`api.php?${params}`);
            const result = await response.json();
            
            if (result.success) {
                this.renderProducts(result.data);
            } else {
                throw new Error(result.error || 'Unknown error');
            }
        } catch (error) {
            container.innerHTML = `<div class="alert alert-danger">Помилка завантаження: ${error.message}</div>`;
        }
    }

    renderProducts(products) {
        const container = document.getElementById('productsContainer');
        
        if (products.length === 0) {
            container.innerHTML = '<div class="alert alert-info">Товари не знайдено</div>';
            return;
        }
        
        const html = products.map(product => `
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">${this.escapeHtml(product.name)}</h5>
                        <p class="card-text text-muted small">${this.escapeHtml(product.category_name)}</p>
                        <p class="card-text">${this.escapeHtml(product.description || '')}</p>
                        <p class="card-text"><strong class="text-success">${parseFloat(product.price).toFixed(2)} грн</strong></p>
                        <p class="card-text"><small class="text-muted">Додано: ${this.formatDate(product.created_at)}</small></p>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-primary btn-buy w-100" data-product-id="${product.id}">
                            Купити
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
        
        container.innerHTML = `<div class="row">${html}</div>`;
    }

    async showProductModal(productId) {
        if (!this.modal) return;
        
        try {
            const response = await fetch(`api.php?action=get_product&id=${productId}`);
            const result = await response.json();
            
            if (result.success) {
                const product = result.data;

                document.getElementById('modalProductName').textContent = product.name;
                document.getElementById('modalProductCategory').textContent = product.category_name;
                document.getElementById('modalProductPrice').textContent = `${parseFloat(product.price).toFixed(2)} грн`;
                document.getElementById('modalProductDescription').textContent = product.description || 'Опис відсутній';
                document.getElementById('modalProductDate').textContent = this.formatDate(product.created_at);
                

                this.modal.show();
            } else {
                alert('Помилка завантаження товару');
            }
        } catch (error) {
            alert('Помилка: ' + error.message);
        }
    }
    
    updateUrl() {
        const params = new URLSearchParams();
        
        if (this.currentCategory) {
            params.append('category', this.currentCategory);
        }
        
        if (this.currentSort !== 'date_desc') {
            params.append('sort', this.currentSort);
        }
        
        const newUrl = params.toString() 
            ? `${window.location.pathname}?${params}` 
            : window.location.pathname;
        
        window.history.pushState({}, '', newUrl);
    }

    highlightActiveCategory() {
        document.querySelectorAll('.category-item').forEach(item => {
            const categoryId = item.dataset.categoryId;
            
            if (categoryId === 'all' && !this.currentCategory) {
                item.classList.add('active', 'fw-bold');
            } else if (categoryId === this.currentCategory) {
                item.classList.add('active', 'fw-bold');
            } else {
                item.classList.remove('active', 'fw-bold');
            }
        });
    }
    

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('uk-UA', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ProductCatalog();
});
