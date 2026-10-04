
<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/category.php');
}

// Only administrators can update categories
require_admin();

// Get the submitted category ID
$cat_id = filter_input(INPUT_POST, 'cat_id', FILTER_VALIDATE_INT);

// Get the submitted category name
$name = trim(strip_tags($_POST['cat_name'] ?? ''));

// Validate category ID
if ($cat_id === false || $cat_id === null || $cat_id <= 0) {
    $_SESSION['error'] = 'Invalid category ID.';
    redirect('../views/admin/category.php');
}

// Validate category name
if ($name === '') {
    $_SESSION['error'] = 'Category name is required.';
    redirect('../views/admin/category.php');
}

if (strlen($name) > 100) {
    $_SESSION['error'] = 'Category name cannot be longer than 100 characters.';
    redirect('../views/admin/category.php');
}

// Send the data to the Controller
$controller = new ProductController();

$success = $controller->updateCategory($cat_id, $name);

// Store the result in the session
if ($success) {
    $_SESSION['success'] = 'Category updated.';
} else {
    $_SESSION['error'] = 'Unable to update category.';
}

// Return to the category page
redirect('../views/admin/category.php');
