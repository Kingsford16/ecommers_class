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

    
    // Add a new product
    public function addProduct($category, $brand, $title, $price, $description, $image, $keywords)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO products
            (product_cat, product_brand, product_title, product_price,
             product_desc, product_image, product_keywords)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "iisdsss",
            $category,
            $brand,
            $title,
            $price,
            $description,
            $image,
            $keywords
        );

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Get one product by ID, including category and brand names
    public function getProductById($product_id)
    {
        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_id = ?"
        );

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $product_id);

        if (!$stmt->execute()) {
            $stmt->close();
            return null;
        }

        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        $stmt->close();

        return $product ?: null;
    }

    // Update an existing product
    public function updateProduct($product_id, $category, $brand, $title, $price, $description, $image, $keywords)
    {
        $stmt = $this->conn->prepare(
            "UPDATE products
             SET product_cat = ?,
                 product_brand = ?,
                 product_title = ?,
                 product_price = ?,
                 product_desc = ?,
                 product_image = ?,
                 product_keywords = ?
             WHERE product_id = ?"
        );

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "iisdsssi",
            $category,
            $brand,
            $title,
            $price,
            $description,
            $image,
            $keywords,
            $product_id
        );

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Get products with their category and brand names
    public function getAllProducts()
    {
        $result = $this->conn->query(
            "SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             ORDER BY p.product_id DESC"
        );

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    // Get featured products for the home page
    public function getFeaturedProducts($limit = 6)
    {
        $limit = (int) $limit;

        if ($limit < 1) {
            return [];
        }

        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             ORDER BY RAND()
             LIMIT ?"
        );

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("i", $limit);

        if (!$stmt->execute()) {
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();

        return $products;
    }

    // Get products belonging to a specific category
    public function getProductsByCategory($cat_id)
    {
        $cat_id = (int) $cat_id;

        if ($cat_id < 1) {
            return [];
        }

        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_cat = ?
             ORDER BY p.product_id DESC"
        );

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("i", $cat_id);

        if (!$stmt->execute()) {
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();

        return $products;
    }

    // Get products belonging to a specific brand
    public function getProductsByBrand($brand_id)
    {
        $brand_id = (int) $brand_id;

        if ($brand_id < 1) {
            return [];
        }

        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_brand = ?
             ORDER BY p.product_id DESC"
        );

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("i", $brand_id);

        if (!$stmt->execute()) {
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();

        return $products;
    }

    // Search products by title or keywords
    public function searchProducts($query)
    {
        $query = trim($query);

        if ($query === '') {
            return [];
        }

        $search_term = '%' . $query . '%';

        $stmt = $this->conn->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
             FROM products p
             LEFT JOIN categories c ON p.product_cat = c.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE p.product_title LIKE ?
                OR p.product_keywords LIKE ?
             ORDER BY p.product_id DESC"
        );

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param("ss", $search_term, $search_term);

        if (!$stmt->execute()) {
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        $products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();

        return $products;
    }

}