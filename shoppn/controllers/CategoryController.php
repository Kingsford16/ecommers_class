<?php

require_once __DIR__ . '/../classes/CategoryClass.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryClass();
    }

    public function addCategory($name)
    {
        $name = trim($name);

        if ($name === '') {
            return [
                'success' => false,
                'error' => 'Category name cannot be empty.'
            ];
        }

        $created = $this->categoryModel->addCategory($name);

        if ($created) {
            return [
                'success' => true
            ];
        }

        return [
            'success' => false,
            'error' => 'Failed to add category.'
        ];
    }

    public function getAllCategories()
    {
        return $this->categoryModel->getAllCategories();
    }
}
