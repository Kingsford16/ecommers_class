
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

// Read the quantities and product IDs submitted by the form.
$quantities = $_POST['qty'] ?? [];
$product_ids = $_POST['update'] ?? [];

// Ensure both inputs are arrays.
if (!is_array($quantities) || !is_array($product_ids)) {
    $_SESSION['cart_message'] = 'Invalid cart update request.';
    header('Location: ../views/cart.php');
    exit();
}

$updated = 0;

// Update each submitted product.
foreach ($product_ids as $key => $id) {
    $product_id = filter_var($id, FILTER_VALIDATE_INT);
    $new_qty = filter_var(
        $quantities[$key] ?? null,
        FILTER_VALIDATE_INT
    );

    // Skip invalid product IDs or quantities.
    if (
        $product_id === false || $product_id < 1 ||
        $new_qty === false || $new_qty < 1
    ) {
        continue;
    }

    $success = $cartController->updateQty(
        $product_id,
        $new_qty,
        $ip
    );

    if ($success) {
        $updated++;
    }
}

if ($updated > 0) {
    $_SESSION['cart_message'] = 'Cart quantities updated successfully.';
} else {
    $_SESSION['cart_message'] = 'No valid cart quantities were updated.';
}

header('Location: ../views/cart.php');
exit();
