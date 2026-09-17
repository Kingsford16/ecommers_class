<?php

require_once __DIR__ . '/../core/db_class.php';

class CategoryClass extends Database
{
    public function addCategory($name)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO categories (cat_name) VALUES (?)"
        );

        $stmt->bind_param("s", $name);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    }

    public function getAllCategories()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM categories ORDER BY cat_id DESC"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $categories = [];

        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        $stmt->close();

        return $categories;
    }
}
