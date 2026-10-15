```php
<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartController = new CartController();
$ip = get_ip();

$cartItems = $cartController->getCartItems($ip);
$total = $cartController->getCartTotal($ip);

include __DIR__ . '/layout/header.php';
?>

<h2>Checkout</h2>

<?php if (empty($cartItems)): ?>
    <p>Your cart is empty.</p>
    <a href="../index.php">Continue Shopping</a>
<?php else: ?>

    <h3>Order Summary</h3>

    <table border="1" cellpadding="10">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($item['product_title']) ?>
                </td>
                <td>
                    <?= (int) $item['qty'] ?>
                </td>
                <td>
                    $<?= number_format((float) $item['product_price'], 2) ?>
                </td>
                <td>
                    $<?= number_format(
                        (int) $item['qty'] * (float) $item['product_price'],
                        2
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>
        Total: $<?= number_format((float) $total, 2) ?>
    </h3>

    <p>Checkout summary is ready. Payment processing has not been implemented yet.</p>

    <a href="cart.php">Back to Cart</a>

<?php endif; ?>
```
