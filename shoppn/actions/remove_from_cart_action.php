
<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

// Accept only POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/cart.php');
    exit();
}

$cartController = new CartController();
$ip = get_ip();

// Read the selected product IDs.
$remove_ids = $_POST['remove'] ?? [];

// Ensure the submitted value is an array.
if (!is_array($remove_ids) || empty($remove_ids)) {
    $_SESSION['cart_message'] = 'Please select at least one product to remove.';
    header('Location: ../views/cart.php');
    exit();
}

$removed = 0;

// Remove each selected product.
foreach ($remove_ids as $id) {
    $product_id = filter_var($id, FILTER_VALIDATE_INT);

    if ($product_id === false || $product_id < 1) {
        continue;
    }

    if ($cartController->removeFromCart($product_id, $ip)) {
        $removed++;
    }
}

if ($removed > 0) {
    $_SESSION['cart_message'] = 'Selected products removed from your cart.';
} else {
    $_SESSION['cart_message'] = 'No products were removed.';
}

header('Location: ../views/cart.php');
exit();
