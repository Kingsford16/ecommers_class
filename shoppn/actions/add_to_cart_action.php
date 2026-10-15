
<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartController = new CartController();

// Get the product ID from the URL.
$product_id = filter_input(INPUT_GET, 'add_cart', FILTER_VALIDATE_INT);

// Stop if the product ID is invalid.
if (!$product_id || $product_id < 1) {
    header('Location: ../index.php');
    exit();
}

// Identify this visitor's cart.
$ip = get_ip();

// Check whether this product is already in the cart.
if ($cartController->isInCart($product_id, $ip)) {
    $_SESSION['cart_message'] =
        'This item is already in your cart. Go to cart to update quantity.';

    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
    exit();
}

// Add the product with an initial quantity of 1.
$success = $cartController->addToCart($product_id, 1, $ip);

if ($success) {
    $_SESSION['cart_message'] = 'Product added to your cart.';
} else {
    $_SESSION['cart_message'] = 'Sorry, the product could not be added.';
}

// Return to the page the visitor came from.
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '../index.php'));
exit();
