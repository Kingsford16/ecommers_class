<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/brand.php');
}

// Make sure the user is an admin
require_admin();

// Get and clean the brand name
$name = trim(strip_tags($_POST['brand_name'] ?? ''));

// Server-side validation
if ($name === '') {
    $_SESSION['error'] = 'Brand name is required.';
    redirect('../views/admin/brand.php');
}

if (strlen($name) > 100) {
    $_SESSION['error'] = 'Brand name cannot be longer than 100 characters.';
    redirect('../views/admin/brand.php');
}

// Create the controller
$controller = new ProductController();

// Add the brand
$success = $controller->addBrand($name);

if ($success) {
    $_SESSION['success'] = 'Brand added successfully.';
} else {
    $_SESSION['error'] = 'Unable to add brand. Please try again.';
}

// Return to the brand page
redirect('../views/admin/brand.php');
