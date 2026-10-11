<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/admin/manage_products.php');
}

require_admin();

$controller = new ProductController();

$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$category = filter_input(INPUT_POST, 'product_cat', FILTER_VALIDATE_INT);
$brand = filter_input(INPUT_POST, 'product_brand', FILTER_VALIDATE_INT);

$title = trim(strip_tags($_POST['product_title'] ?? ''));
$price = trim($_POST['product_price'] ?? '');
$description = trim(strip_tags($_POST['product_desc'] ?? ''));
$keywords = trim(strip_tags($_POST['product_keywords'] ?? ''));

$editUrl = '../views/admin/edit_product.php?id=' . (int) $product_id;

// Confirm that the product exists.
$product = ($product_id && $product_id > 0)
    ? $controller->getProductById($product_id)
    : null;

if (!$product) {
    $_SESSION['error'] = 'Product not found.';
    redirect('../views/admin/manage_products.php');
}

// Validate the submitted fields.
if (
    !$category || !$brand ||
    $title === '' || $price === '' ||
    !is_numeric($price) || !is_finite((float) $price) ||
    (float) $price < 0 ||
    strlen($title) > 200 ||
    strlen($description) > 500 ||
    strlen($keywords) > 100
) {
    $_SESSION['error'] = 'Please check the product details and try again.';
    redirect($editUrl);
}

// Confirm that the category and brand exist.
$validCategory = false;
foreach ($controller->getAllCategories() as $item) {
    if ((int) $item['cat_id'] === (int) $category) {
        $validCategory = true;
        break;
    }
}

$validBrand = false;
foreach ($controller->getAllBrands() as $item) {
    if ((int) $item['brand_id'] === (int) $brand) {
        $validBrand = true;
        break;
    }
}

if (!$validCategory || !$validBrand) {
    $_SESSION['error'] = 'Please select a valid category and brand.';
    redirect($editUrl);
}

// Keep the existing image unless a replacement is uploaded.
$oldImageName = $product['product_image'] ?? null;
$imageName = $oldImageName;
$newImagePath = null;

if (
    isset($_FILES['product_image']) &&
    $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $file = $_FILES['product_image'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = 'There was a problem uploading the image.';
        redirect($editUrl);
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        $_SESSION['error'] = 'The image must be 5 MB or smaller.';
        redirect($editUrl);
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        $_SESSION['error'] = 'Invalid uploaded file.';
        redirect($editUrl);
    }

    $imageInfo = @getimagesize($file['tmp_name']);

    if ($imageInfo === false) {
        $_SESSION['error'] = 'The uploaded file is not a valid image.';
        redirect($editUrl);
    }

    $allowedTypes = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG  => 'png',
        IMAGETYPE_GIF  => 'gif',
        IMAGETYPE_WEBP => 'webp'
    ];

    $imageType = $imageInfo[2];

    if (!isset($allowedTypes[$imageType])) {
        $_SESSION['error'] = 'Only JPG, PNG, GIF, and WebP images are allowed.';
        redirect($editUrl);
    }

    $uploadDirectory = __DIR__ . '/../images/products/';

    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
            $_SESSION['error'] = 'Could not create the product image folder.';
            redirect($editUrl);
        }
    }

    if (!is_writable($uploadDirectory)) {
        $_SESSION['error'] = 'The product image folder is not writable.';
        redirect($editUrl);
    }

    try {
        $newImageName = bin2hex(random_bytes(16))
            . '.' . $allowedTypes[$imageType];
    } catch (Throwable $e) {
        $_SESSION['error'] = 'Unable to generate an image filename.';
        redirect($editUrl);
    }

    $newImagePath = $uploadDirectory . $newImageName;

    if (!move_uploaded_file($file['tmp_name'], $newImagePath)) {
        $_SESSION['error'] = 'Could not save the uploaded image.';
        redirect($editUrl);
    }

    $imageName = $newImageName;
}

// Update through the controller/model.
$success = $controller->updateProduct(
    (int) $product_id,
    (int) $category,
    (int) $brand,
    $title,
    (float) $price,
    $description,
    $imageName,
    $keywords
);

if ($success) {
    // Delete the previous image only after the database update succeeds.
    // Only delete files from the new images/products/ directory.
    if (
        $newImagePath !== null &&
        !empty($oldImageName) &&
        basename($oldImageName) === $oldImageName
    ) {
        $oldImagePath = __DIR__ . '/../images/products/' . $oldImageName;

        if (is_file($oldImagePath) && realpath($oldImagePath) !== realpath($newImagePath)) {
            @unlink($oldImagePath);
        }
    }

    $_SESSION['success'] = 'Product updated successfully.';
    redirect('../views/admin/manage_products.php');
}

// If saving the database changes failed, remove the new image and retain the old one.
if ($newImagePath !== null && is_file($newImagePath)) {
    @unlink($newImagePath);
}

$_SESSION['error'] = 'Unable to update the product.';
redirect($editUrl);