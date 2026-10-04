<?php

require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductClass();
    }

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
}