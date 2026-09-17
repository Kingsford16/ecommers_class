<?php

require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database
{
    // =========================
    // BRAND METHODS
    // =========================

    public function addBrand($name)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO brands (brand_name) VALUES (?)"
        );

        $stmt->bind_param("s", $name);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    public function getAllBrands()
    {
        $result = $this->conn->query(
            "SELECT * FROM brands ORDER BY brand_name ASC"
        );

        $brands = [];

        while ($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }

        return $brands;
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
        $stmt = $this->conn->prepare(
            "INSERT INTO products
            (
                product_cat,
                product_brand,
                product_title,
                product_price,
                product_desc,
                product_image,
                product_keywords
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

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

    public function getAllProducts()
    {
        $result = $this->conn->query(
            "SELECT
                p.product_id,
                p.product_cat,
                p.product_brand,
                p.product_title,
                p.product_price,
                p.product_desc,
                p.product_image,
                p.product_keywords,
                c.cat_name,
                b.brand_name
             FROM products p
             LEFT JOIN categories c
                ON p.product_cat = c.cat_id
             LEFT JOIN brands b
                ON p.product_brand = b.brand_id
             ORDER BY p.product_id DESC"
        );

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }
}
