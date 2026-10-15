
<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartController = new CartController();
$ip = get_ip();

$cartItems = $cartController->getCartItems($ip);
$cartTotal = $cartController->getCartTotal($ip);

require_once __DIR__ . '/layout/header.php';
?>

<main>
    <h1>My Shopping Cart</h1>

    <?php if (isset($_SESSION['cart_message'])): ?>
        <p>
            <?= htmlspecialchars($_SESSION['cart_message']) ?>
        </p>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>

        <p>Your shopping cart is empty.</p>

        <p>
            <a
                href="../index.php"
                style="display: inline-block; background-color: #2563eb; color: white; padding: 10px 16px; text-decoration: none; border-radius: 5px;"
            >
                Continue Shopping
            </a>
        </p>

    <?php else: ?>

        <div style="margin: 12px 0; padding: 10px; background: #f2f2f2;">
            <strong>Shopping Cart Summary</strong>
            <p>Items: <?= (int) count($cartItems) ?></p>
            <p>Total: <?= number_format($cartTotal, 2) ?></p>
        </div>

        <form action="../actions/update_cart_action.php" method="POST">

            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['product_image'])): ?>
                                    <img
                                        src="../images/products/<?= rawurlencode(basename($item['product_image'])) ?>"
                                        alt="<?= htmlspecialchars($item['product_title']) ?>"
                                        style="width: 70px; height: 70px; object-fit: contain;"
                                    >
                                <?php else: ?>
                                    <span>No image available</span>
                                <?php endif; ?>

                                <br>
                                <?= htmlspecialchars($item['product_title']) ?>
                            </td>

                            <td>
                                <?= number_format(
                                    (float) $item['product_price'],
                                    2
                                ) ?>
                            </td>

                            <td>
                                <input
                                    type="number"
                                    name="qty[]"
                                    value="<?= (int) $item['qty'] ?>"
                                    min="1"
                                    required
                                >

                                <input
                                    type="hidden"
                                    name="update[]"
                                    value="<?= (int) $item['p_id'] ?>"
                                >
                            </td>

                            <td>
                                <?= number_format(
                                    (int) $item['qty']
                                    * (float) $item['product_price'],
                                    2
                                ) ?>
                            </td>

                            <td>
                                <input
                                    type="checkbox"
                                    name="remove[]"
                                    value="<?= (int) $item['p_id'] ?>"
                                    form="remove-form"
                                >
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p>
                <button type="submit">Update Quantities</button>
            </p>

        </form>

        <form
            id="remove-form"
            action="../actions/remove_from_cart_action.php"
            method="POST"
        >
            <button type="submit">Remove Selected</button>
        </form>

        <h3>Cart Total: <?= number_format($cartTotal, 2) ?></h3>

        <p style="display: flex; gap: 12px; flex-wrap: wrap;">

            <a
                href="../index.php"
                style="display: inline-block; background-color: #2563eb; color: white; padding: 10px 16px; text-decoration: none; border-radius: 5px;"
            >
                Continue Shopping
            </a>

            <a
                href="checkout.php"
                style="display: inline-block; background-color: #16a34a; color: white; padding: 10px 16px; text-decoration: none; border-radius: 5px;"
            >
                Checkout
            </a>

        </p>

    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
