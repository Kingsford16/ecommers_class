<?php

require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/products.php');
    exit;
}

$category = (int) ($_POST['product_cat'] ?? 0);
$brand = (int) ($_POST['product_brand'] ?? 0);
$title = trim($_POST['product_title'] ?? '');
$price = (float) ($_POST['product_price'] ?? 0);
$description = trim($_POST['product_desc'] ?? '');
$keywords = trim($_POST['product_keywords'] ?? '');

$image = null;

/*
 * Handle product image upload.
 */
if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {

    $uploadDirectory = __DIR__ . '/../images/products/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0775, true);
    }

    $originalName = basename($_FILES['product_image']['name']);

    $extension = strtolower(
        pathinfo($originalName, PATHINFO_EXTENSION)
    );

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($extension, $allowedExtensions, true)) {
        header('Location: ../views/products.php?error=Invalid+image+type');
        exit;
    }

    $image = uniqid('product_', true) . '.' . $extension;

    $destination = $uploadDirectory . $image;

    if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $destination)) {
        header('Location: ../views/products.php?error=Image+upload+failed');
        exit;
    }
}

/*
 * Basic validation.
 */
if ($category <= 0 || $brand <= 0 || $title === '' || $price < 0) {

    header('Location: ../views/products.php?error=Please+fill+in+all+required+fields');
    exit;
}

/*
 * Add the product.
 */
$success = $controller->addProduct(
    $category,
    $brand,
    $title,
    $price,
    $description,
    $image,
    $keywords
);

if ($success) {
    header('Location: ../views/products.php?success=1');
    exit;
}

header('Location: ../views/products.php?error=Product+could+not+be+added');
exit;
