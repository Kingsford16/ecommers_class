<?php

require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database
{
    // Add a new brand
    public function addBrand($name)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO brands (brand_name) VALUES (?)"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $name);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // Get all brands
    public function getAllBrands()
    {
        $result = $this->conn->query(
            "SELECT * FROM brands ORDER BY brand_name ASC"
        );

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get one brand by ID
    public function getBrandById($brand_id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM brands WHERE brand_id = ?"
        );

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $brand_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $brand = $result->fetch_assoc();

        $stmt->close();

        return $brand;
    }

    // Update a brand
    public function updateBrand($brand_id, $name)
    {
        $stmt = $this->conn->prepare(
            "UPDATE brands SET brand_name = ? WHERE brand_id = ?"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $name, $brand_id);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // Add a new category
    public function addCategory($name)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO categories (cat_name) VALUES (?)"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $name);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    // Get all categories
    public function getAllCategories()
    {
        $result = $this->conn->query(
            "SELECT * FROM categories ORDER BY cat_name ASC"
        );

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get one category by ID
    public function getCategoryById($cat_id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM categories WHERE cat_id = ?"
        );

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $cat_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $category = $result->fetch_assoc();

        $stmt->close();

        return $category;
    }

    // Update a category
    public function updateCategory($cat_id, $name)
    {
        $stmt = $this->conn->prepare(
            "UPDATE categories SET cat_name = ? WHERE cat_id = ?"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $name, $cat_id);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

}