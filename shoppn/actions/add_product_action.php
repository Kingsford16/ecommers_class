<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$redirectTo = '../views/admin/add_product.php';

// Only accept POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($redirectTo);
}

// Only administrators can add products.
require_admin();

$category = filter_input(INPUT_POST, 'product_cat', FILTER_VALIDATE_INT);
$brand = filter_input(INPUT_POST, 'product_brand', FILTER_VALIDATE_INT);

$title = trim(strip_tags($_POST['product_title'] ?? ''));
$price = trim($_POST['product_price'] ?? '');
$description = trim(strip_tags($_POST['product_desc'] ?? ''));
$keywords = trim(strip_tags($_POST['product_keywords'] ?? ''));

// Validate required fields and database limits.
if (
    !$category || !$brand ||
    $title === '' || $price === '' ||
    !is_numeric($price) || !is_finite((float) $price) ||
    (float) $price < 0 ||
    strlen($title) > 200 ||
    strlen($description) > 500 ||
    strlen($keywords) > 100
) {
    $_SESSION['error'] = 'Please check all product details and try again.';
    redirect($redirectTo);
}

$controller = new ProductController();

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
    redirect($redirectTo);
}

// An image is optional.
$imageName = null;
$savedImagePath = null;

if (
    isset($_FILES['product_image']) &&
    $_FILES['product_image']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $file = $_FILES['product_image'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = 'There was a problem uploading the image.';
        redirect($redirectTo);
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        $_SESSION['error'] = 'The image must be 5 MB or smaller.';
        redirect($redirectTo);
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        $_SESSION['error'] = 'Invalid uploaded file.';
        redirect($redirectTo);
    }

    $imageInfo = @getimagesize($file['tmp_name']);

    if ($imageInfo === false) {
        $_SESSION['error'] = 'Please upload a valid image.';
        redirect($redirectTo);
    }

    // Allowed image formats.
    $allowedTypes = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG  => 'png',
        IMAGETYPE_GIF  => 'gif',
        IMAGETYPE_WEBP => 'webp'
    ];

    $imageType = $imageInfo[2];

    if (!isset($allowedTypes[$imageType])) {
        $_SESSION['error'] = 'Only JPG, PNG, GIF, and WebP images are allowed.';
        redirect($redirectTo);
    }

    // Store product images in images/products/.
    $uploadDirectory = __DIR__ . '/../images/products/';

    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0755, true) && !is_dir($uploadDirectory)) {
            $_SESSION['error'] = 'Unable to create the product image folder.';
            redirect($redirectTo);
        }
    }

    if (!is_writable($uploadDirectory)) {
        $_SESSION['error'] = 'The product image folder is not writable.';
        redirect($redirectTo);
    }

    // Generate a unique filename using the verified image type.
    try {
        $imageName = bin2hex(random_bytes(16))
            . '.' . $allowedTypes[$imageType];
    } catch (Throwable $e) {
        $_SESSION['error'] = 'Unable to generate an image filename.';
        redirect($redirectTo);
    }

    $savedImagePath = $uploadDirectory . $imageName;

    if (!move_uploaded_file($file['tmp_name'], $savedImagePath)) {
        $_SESSION['error'] = 'Unable to save the uploaded image.';
        redirect($redirectTo);
    }
}

// Save through the controller/model.
$success = $controller->addProduct(
    (int) $category,
    (int) $brand,
    $title,
    (float) $price,
    $description,
    $imageName,
    $keywords
);

if ($success) {
    $_SESSION['success'] = 'Product added successfully.';
    redirect($redirectTo);
}

// Remove the new image if the database insert failed.
if ($savedImagePath !== null && is_file($savedImagePath)) {
    @unlink($savedImagePath);
}

$_SESSION['error'] = 'Unable to add product. Please check the submitted details.';
redirect($redirectTo);