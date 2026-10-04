<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/brand.php');
}

// Only administrators can add brands
require_admin();

// Get the submitted brand name
$name = trim(strip_tags($_POST['brand_name'] ?? ''));

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

$success = $controller->addBrand($name);

// Store the result in the session
if ($success) {
    $_SESSION['success'] = 'Brand added.';
} else {
    $_SESSION['error'] = 'Unable to add brand.';
}

// Return to the brand page
redirect('../views/admin/brand.php');