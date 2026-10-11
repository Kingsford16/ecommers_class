
<?php

require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductClass();
    }

    //  BRAND METHODS

    // Add a brand
    public function addBrand($name)
    {
        return $this->productModel->addBrand($name);
    }

    // Get all brands
    public function getAllBrands()
    {
        return $this->productModel->getAllBrands();
    }

    // Get one brand by ID
    public function getBrandById($brand_id)
    {
        return $this->productModel->getBrandById($brand_id);
    }

    // Update a brand
    public function updateBrand($brand_id, $name)
    {
        return $this->productModel->updateBrand($brand_id, $name);
    }

    //  CATEGORY METHODS

    // Add a category
    public function addCategory($name)
    {
        return $this->productModel->addCategory($name);
    }

    // Get all categories
    public function getAllCategories()
    {
        return $this->productModel->getAllCategories();
    }

    // Get one category by ID
    public function getCategoryById($cat_id)
    {
        return $this->productModel->getCategoryById($cat_id);
    }

    // Update a category
    public function updateCategory($cat_id, $name)
    {
        return $this->productModel->updateCategory($cat_id, $name);
    }

    //  PRODUCT METHODS

    // Add a new product
    public function addProduct(
        $category,
        $brand,
        $title,
        $price,
        $description,
        $image,
        $keywords
    ) {
        return $this->productModel->addProduct(
            $category,
            $brand,
            $title,
            $price,
            $description,
            $image,
            $keywords
        );
    }

    // Get one product by ID
    public function getProductById($product_id)
    {
        return $this->productModel->getProductById($product_id);
    }

    // Update an existing product
    public function updateProduct(
        $product_id,
        $category,
        $brand,
        $title,
        $price,
        $description,
        $image,
        $keywords
    ) {
        return $this->productModel->updateProduct(
            $product_id,
            $category,
            $brand,
            $title,
            $price,
            $description,
            $image,
            $keywords
        );
    }

    // Get all products
    public function getAllProducts()
    {
        return $this->productModel->getAllProducts();
    }

    
    // Get featured products for the home page
    public function getFeaturedProducts($limit = 6)
    {
        return $this->productModel->getFeaturedProducts($limit);
    }

    // Get products by category
    public function getProductsByCategory($cat_id)
    {
        return $this->productModel->getProductsByCategory($cat_id);
    }

    // Get products by brand
    public function getProductsByBrand($brand_id)
    {
        return $this->productModel->getProductsByBrand($brand_id);
    }

    // Search products by title or keywords
    public function searchProducts($query)
    {
        return $this->productModel->searchProducts($query);
    }
}

