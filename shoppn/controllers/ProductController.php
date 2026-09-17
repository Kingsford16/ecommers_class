<?php

require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductClass();
    }

    // =========================
    // BRAND METHODS
    // =========================

    public function addBrand($name)
    {
        return $this->productModel->addBrand($name);
    }

    public function getAllBrands()
    {
        return $this->productModel->getAllBrands();
    }


    // =========================
    // PRODUCT METHODS
    // =========================

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

    public function getAllProducts()
    {
        return $this->productModel->getAllProducts();
    }
}
