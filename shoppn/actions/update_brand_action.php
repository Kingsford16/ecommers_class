<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/brand.php');
}

// Only administrators can edit brands
require_admin();

// Get submitted values
$brand_id = (int) ($_POST['brand_id'] ?? 0);
$name = trim(strip_tags($_POST['brand_name'] ?? ''));

// Validate brand ID
if ($brand_id <= 0) {
    $_SESSION['error'] = 'Invalid brand.';
    redirect('../views/admin/brand.php');
}

// Validate brand name
if ($name === '') {
    $_SESSION['error'] = 'Brand name is required.';
    redirect('../views/admin/brand.php');
}

if (strlen($name) > 100) {
    $_SESSION['error'] = 'Brand name cannot be longer than 100 characters.';
    redirect('../views/admin/brand.php');
}

// Send the data to the Controller
$controller = new ProductController();

$success = $controller->updateBrand($brand_id, $name);

// Store the result in the session
if ($success) {
    $_SESSION['success'] = 'Brand updated.';
} else {
    $_SESSION['error'] = 'Unable to update brand.';
}

// Return to the brand page
redirect('../views/admin/brand.php');